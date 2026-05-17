<?php

namespace App\Controllers;

class Office extends BaseController
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
		$keyword = '';

		$keyword = $this->request->getPost('keyword');

		$data['mykeyword'] = $keyword;

		$subquery = "
    SELECT 
        p.OfficeCode,
        p.PrecinctNumber,
        GROUP_CONCAT(d.Remarks SEPARATOR ', ') AS Remarks
    FROM tblprecinct p
    INNER JOIN tbldevice d 
        ON p.DeviceID = d.id
    WHERE p.IsActive = 1
    GROUP BY p.OfficeCode, p.PrecinctNumber
";

		$query = $this->db->table('tbloffice o')
			->select("
        o.OfficeCode,
        o.OfficeName,
        o.ShortName,
        GROUP_CONCAT(
            t.PrecinctNumber
            SEPARATOR ', '
        ) AS PrecinctNumber,
        GROUP_CONCAT(
            t.Remarks
            SEPARATOR ', '
        ) AS PrecinctDevices,
        (
            SELECT COUNT(1)
            FROM users u
            WHERE u.OfficeCode = o.OfficeCode
        ) AS VoterCount
    ", false)
			->join("($subquery) t", "t.OfficeCode = o.OfficeCode", "left", false)
			->groupBy([
				'o.OfficeCode',
				'o.OfficeName',
				'o.ShortName'
			])
			->orderBy('o.OfficeName', 'ASC')
			->get();

		$data['record'] = $query->getResult();

		$data['Title'] = 'Office Records';
		$data['SubTitle'] = 'List of Offices';
		$data['output'] = null;
		$data['view_file'] = 'office';
		$data['office_records'] = TRUE;
		return view('main', $data);
	}

}