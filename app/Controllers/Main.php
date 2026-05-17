<?php

namespace App\Controllers;

class Main extends BaseController
{
    protected $db;
    protected $session;
    protected $validation;
    protected $auth;

    public function __construct()
    {
		
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->auth = auth();
    }

    public function getIndex()
    {
        // Shield authentication
        if (!auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        // Admin only
        if (!auth()->user()->inGroup('admin')) {
            return redirect()->to('/login');
        }

        $data = [];

        // Employee Count
        $query = $this->db->query("
            SELECT COUNT(1) AS count
            FROM users
            WHERE ecode <> '10000'
        ");

        $data['EmployeeCount'] = $query->getRow()->count ?? 0;

        // Candidate Count
        $query = $this->db->query("
            SELECT COUNT(1) AS count
            FROM tblvotemst
            WHERE IFNULL(IsActive,1)=1
        ");

        $data['CandidateCount'] = $query->getRow()->count ?? 0;

        // Vote Count
        $query = $this->db->query("
            SELECT COUNT(1) AS count
            FROM (
                SELECT DISTINCT userid
                FROM tblvote
                WHERE IsActive=1
            ) AS x
        ");

        $data['VoteCount'] = $query->getRow()->count ?? 0;

        // No Vote Count
        $query = $this->db->query("
            SELECT COUNT(1) AS count
            FROM users
            WHERE id NOT IN (
                SELECT userid
                FROM tblvote
                WHERE IsActive=1
            )
            AND ecode <> '10000'
        ");

        $data['NoVoteCount'] = $query->getRow()->count ?? 0;

        $numberofvoters = $data['EmployeeCount'];

        // Positions
        $positions = [
            1 => 'recordPresident',
            2 => 'recordVicePresident',
            3 => 'recordSecretary',
            4 => 'recordTreasurer',
            5 => 'recordAuditor',
            6 => 'recordBusinessManager',
            7 => 'recordPublicInformationOfficer',
            8 => 'recordBoardOfTrustees',
        ];

        foreach ($positions as $positionID => $key) {

            $query = $this->db->query("
                SELECT 
                    tvn.Candidate,
                    tvn.CandidateImage,
                    COUNT(tv.id) AS NumberOfVotes,
                    (COUNT(tv.id) / ?) * 100 AS NumberOfVotesPercent
                FROM tblvotetrn tvn
                LEFT JOIN tblvote tv 
                    ON tv.votetrnid = tvn.id
                    AND tv.IsActive = 1
                WHERE tvn.votemstid = ?
                GROUP BY tvn.id, tvn.Candidate, tvn.CandidateImage
                ORDER BY NumberOfVotes DESC
            ", [$numberofvoters, $positionID]);

            $data[$key] = $query->getResult();
        }

        // Turnout %
        $turnoutPercent = 0;

        if ($data['EmployeeCount'] > 0) {
            $turnoutPercent = (
                $data['VoteCount'] / $data['EmployeeCount']
            ) * 100;
        }

        $data['TurnoutPercent'] = number_format($turnoutPercent, 2);

        // GET parameter
        $widescreen = $this->request->getGet('widescreen');

        $data['widescreen'] = $widescreen;

        if ($widescreen == 'true') {

            return view('dashboard_wide', $data);

        } else {

            $data['Title']      = 'Dashboard';
            $data['SubTitle']   = 'Overview';
            $data['output']     = null;
            $data['view_file']  = 'dashboard';
            $data['dashboard']  = true;

            return view('main', $data);
        }
    }

    public function getDashboarddata()
{
    if (!auth()->loggedIn()) {
        return $this->response->setJSON([
            'status' => 'error'
        ]);
    }
    
    if (!auth()->user()->inGroup('admin')) {
        return $this->response->setJSON([
            'status' => 'error'
        ]);
    }

    // Employee count
    $query = $this->db->query("
        SELECT COUNT(1) AS count
        FROM users
        WHERE ecode <> '10000'
    ");

    $EmployeeCount = $query->getRow()->count ?? 0;

        $query = $this->db->query("
            SELECT 
                tvn.Candidate,
                tvn.CandidateImage,
            tvm.Description as PositionName,
                COUNT(tv.votetrnid) AS NumberOfVotes,
                (COUNT(tv.votetrnid)/?) * 100 AS NumberOfVotesPercent
            FROM tblvotetrn tvn
            LEFT JOIN tblvote tv 
                ON tv.votetrnid = tvn.id
                AND IFNULL(tv.IsActive,0)=1
        LEFT JOIN tblvotemst tvm
            ON tvm.id = tvn.votemstid
            WHERE tvn.votemstid = 1
            GROUP BY tvn.id, tvn.Candidate, tvn.CandidateImage
            ORDER BY NumberOfVotes DESC
        ", [$EmployeeCount]);

    $results = $query->getResult();

    $grouped = [];

    foreach ($results as $row) {

        $position = $row->PositionName;

        if (!isset($grouped[$position])) {
            $grouped[$position] = [];
        }

        $grouped[$position][] = $row;
    }

    return $this->response->setJSON([
        'status' => 'success',
        'data'   => $grouped
    ]);
}

}