<?php

namespace App\Controllers;

class Precinct extends BaseController
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

$trade1 = $this->db->table('tbloffice o')
    ->select('OfficeCode, OfficeName', false)
    ->orderBy('OfficeName', 'ASC')
    ->get();

$data['record_office'] = $trade1->getResult();

$trade1 = $this->db->table('tbldevice d')
    ->select('id, Remarks', false)
    ->orderBy('Remarks', 'ASC')
    ->get();

$data['record_device'] = $trade1->getResult();

		$data['Title'] = 'Precinct Records';
		$data['SubTitle'] = 'List of Precincts';
		$data['output'] = null;
		$data['view_file'] = 'precinct';
		$data['precinct_records'] = TRUE;
		return view('main', $data);
	}

	public function postSave()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}
		$user = auth()->user();

		$PrecinctNumber = $this->request->getPost('PrecinctNumber');
		$DeviceID = $this->request->getPost('DeviceID');
		$OfficeCode = $this->request->getPost('OfficeCode');
		$precinct_id = $this->request->getPost('precinct_id');

		// VALIDATION
		if (!$PrecinctNumber || !$DeviceID || !$OfficeCode) {
			echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
			return;
		}

		$data = [
			'PrecinctNumber' => $PrecinctNumber,
			'DeviceID' => $DeviceID,
			'OfficeCode' => $OfficeCode,
			'IsActive' => 1
		];

		try {

			if (!empty($precinct_id)) {

				// UPDATE
				$transaction = [
					'PrecinctNumber' => $PrecinctNumber,
					'DeviceID'       => $DeviceID,
					'OfficeCode'     => $OfficeCode,
					'IsActive'       => 1
				];

				$this->db->table('tblprecinct')
					->where('id', $precinct_id)
					->update($transaction);

				$query = $this->db->getLastQuery();

				if ($this->db->affectedRows() > 0) {

					return $this->response->setJSON([
						'status'  => 'success',
						'message' => 'Precinct updated successfully'
					]);

				} else {

					return $this->response->setJSON([
						'status'  => 'warning',
						'message' => 'No changes made or invalid ID'
					]);
				}

			} else {

				// INSERT
				$data['CreatedBy'] = $user->id; // adjust
				$data['CreatedWhen'] = date('Y-m-d H:i:s');
				$data['CreatedWhere'] = $this->request->getIPAddress();

				$this->db->table('tblprecinct')->insert($data);

				return $this->response->setJSON([
					'status'  => 'success',
					'message' => 'Precinct added successfully'
				]);
			}

		} catch (\Exception $e) {

			return $this->response->setJSON([
				'status'  => 'error',
				'message' => $e->getMessage()
			]);
		}
	}

	public function getPrecinctrecord()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$keyword = $this->request->getPost('search')['value'] ?? '';

		$builder = $this->db->table('tblprecinct p')
			->select("
				p.id,
				p.PrecinctNumber,
				o.OfficeName,
				d.Remarks as DeviceName
			", false)
			->join('tbloffice o', 'o.OfficeCode = p.OfficeCode')
			->join('tbldevice d', 'd.id = p.DeviceID')
			->where('p.IsActive', 1);

		if (!empty($keyword)) {

			$builder->groupStart()
				->like('p.PrecinctNumber', $keyword)
				->orLike('o.OfficeName', $keyword)
				->orLike('d.Remarks', $keyword)
			->groupEnd();
		}

		$query = $builder
			->orderBy('p.PrecinctNumber', 'ASC')
			->get()
			->getResult();

		$data = [];
		foreach ($query as $r) {
			$data[] = [
				$r->PrecinctNumber,
				$r->OfficeName,
				$r->DeviceName,
				'
				<button class="btn btn-sm btn-primary" onclick="editPrecinct(\'' . $r->id . '\')">
					<i class="fa fa-edit"></i> Edit
				</button>
				<button class="btn btn-sm btn-danger" onclick="deletePrecinct(\'' . $r->id . '\')">
					<i class="fa fa-trash"></i> Delete
				</button>
				'
			];
		}

		echo json_encode([
			"data" => $data
		]);
	}

	public function getPrecinctbyid()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}
		$id = $this->request->getGet('id');

		$query = $this->db->table('tblprecinct')
			->where('id', $id)
			->get()
			->getRow();

		if ($query) {
			echo json_encode([
				'status' => 'success',
				'data' => $query
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Record not found'
			]);
		}
	}

	public function postDelete()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$user = auth()->user();

		$id = $this->request->getPost('id');

		$this->db->table('tblprecinct')
			->where('id', $id)
			->update([
				'IsActive'     => 0,
				'DeletedBy'    => $user->id,
				'DeletedWhen'  => date('Y-m-d H:i:s'),
				'DeletedWhere' => $this->request->getIPAddress()
			]);
		echo json_encode([
			'status' => 'success',
			'message' => 'Precinct deleted successfully'
		]);
	}


	public function getRecords2()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$data['Title'] = 'Precinct Records 2';
		$data['SubTitle'] = 'List of Precincts - Version 2';
		$data['output'] = null;
		$data['view_file'] = 'precinct2';
		$data['precinct_records2'] = TRUE;
		return view('main', $data);
	}

	public function postGetprecinctrecord2()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}
$keyword = $this->request->getPost('search')['value'] ?? '';

$builder = $this->db->table('tblprecinct p')
    ->select("
        p.id,
        p.OfficeCode,
        p.PrecinctNumber,
        o.OfficeName,

        (
            SELECT COUNT(1)
            FROM users u
            WHERE u.officecode = p.OfficeCode
            AND u.id NOT IN (
                SELECT tv.userid
                FROM tblvote tv
                WHERE tv.IsActive = 1
            )
        ) AS NotVoted
    ", false)
    ->join('tbloffice o', 'o.OfficeCode = p.OfficeCode')
    ->join('tbldevice d', 'd.id = p.DeviceID')
    ->where('p.IsActive', 1);

if (!empty($keyword)) {

    $builder->groupStart()
        ->like('p.PrecinctNumber', $keyword)
        ->orLike('o.OfficeName', $keyword)
        ->orLike('d.Remarks', $keyword)
    ->groupEnd();
}

$query = $builder
    ->orderBy('p.PrecinctNumber', 'ASC')
    ->get()
    ->getResult();

	
		$data = [];
		foreach ($query as $r) {

			$btn = '
				<button 
					class="btn btn-primary btn-sm btnView"
					data-officecode="'.$r->OfficeCode.'"
					data-officename="'.$r->OfficeName.'">
					View Employee/s Who Did Not Vote
				</button>
			';

			$data[] = [
				$r->PrecinctNumber,
				$r->OfficeName,
				$r->NotVoted,
				$btn
			];
		}

		echo json_encode([
			"data" => $data
		]);
	}

public function postNotvotedemployees()
{
    if (!auth()->loggedIn()) {
        return redirect()->to('/logout');
    }

    if (!auth()->user()->inGroup('admin')) {
        return redirect()->to('/logout');
    }

    $officecode = $this->request->getPost('officecode');

    $query = $this->db->query("
        SELECT 
            u.id,
            u.ecode,
            u.last_name,
            u.first_name,
            u.middle_name,
            u.Office
        FROM users u
        WHERE u.id NOT IN (
            SELECT tv.userid 
            FROM tblvote tv 
            WHERE tv.IsActive = 1
        )
        AND u.ecode <> '10000'
        AND u.officecode = ?
        ORDER BY u.last_name ASC
    ", [$officecode]);

    echo json_encode($query->getResult());
}
}