<?php

namespace App\Controllers;

class Reports extends BaseController
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
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$data['Title'] = 'Report';
		$data['SubTitle'] = '';
		$data['output'] = null;
		$data['view_file'] = 'report';
		$data['reports'] = TRUE;
		return view('main', $data);

	}

public function postGenerate()
{
    if (!auth()->loggedIn()) {
        return redirect()->to('/logout');
    }

    if (!auth()->user()->inGroup('admin')) {
        return redirect()->to('/logout');
    }

    if ($this->request->getPost('ReportType') == 'Vote Result') {

        return $this->report_generate();

    } else if ($this->request->getPost('ReportType') == 'Precinct Online') {

        return $this->report_precinct_online();
    }
}

	public function getReport()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$data['positions'] = $this->db->query("
			SELECT id, Description 
			FROM tblvotemst 
			ORDER BY id
		")->getResult();

		return view('report_selection', $data);
	}


	public function report_generate()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$query = $this->db->query("
			SELECT 
				m.Description as Position,
				tvn.Candidate,
				COUNT(tv.votetrnid) AS NumberOfVotes
			FROM tblvotetrn tvn
			JOIN tblvotemst m 
				ON m.id = tvn.votemstid
			LEFT JOIN tblvote tv 
				ON tv.votetrnid = tvn.id 
				AND IFNULL(tv.IsActive,0)=1
			GROUP BY m.Description, tvn.id, tvn.Candidate
			ORDER BY m.id, NumberOfVotes DESC
		");

		$result = $query->getResult();

		$data['grouped'] = [];

		foreach ($result as $row) {

			$data['grouped'][$row->Position][] = $row;
		}

		$data['records'] = $result;


		return view('report_result', $data);
	}

	public function report_precinct_online()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}
$query = $this->db->query("
    SELECT 
        PrecinctNumber,
        SUM(VotedPrecinct) as VotedPrecinct,
        SUM(VotedOnline) as VotedOnline,
        SUM(TotalRegistered) as TotalRegistered,
        SUM(NotVoted) as NotVoted
    FROM (
    
        SELECT 
            p.PrecinctNumber,

            COUNT(DISTINCT CASE 
                WHEN IFNULL(v.PrecinctID,'') <> '' 
                THEN v.userid 
            END) AS VotedPrecinct,

            COUNT(DISTINCT CASE 
                WHEN IFNULL(v.PrecinctID,'') = '' 
                AND v.userid IS NOT NULL 
                THEN v.userid 
            END) AS VotedOnline,

            COUNT(DISTINCT u.id) AS TotalRegistered,

            (
                COUNT(DISTINCT u.id) - 
                COUNT(DISTINCT v.userid)
            ) AS NotVoted,

            COUNT(DISTINCT u.id),
            COUNT(DISTINCT v.userid)

        FROM tblprecinct p

        RIGHT JOIN (
            SELECT *
            FROM users
            WHERE ecode <> 10000
        ) u ON u.OfficeCode = p.OfficeCode

        LEFT JOIN tblvote v
            ON v.userid = u.id
            AND v.IsActive = 1

        GROUP BY p.PrecinctNumber

    ) as x

    GROUP BY PrecinctNumber
");

$data['records'] = $query->getResult();

		return view('report_precinct_online', $data);
	}

}