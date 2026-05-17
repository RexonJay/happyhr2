<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;

class Device extends BaseController
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
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		
		$keyword='';
		$keyword = $this->request->getPost('keyword');
		$data['mykeyword'] = $keyword;

        $trade1 = $this->db->table('tbldevice')
            ->select('*', false)
            ->orderBy('id', 'DESC')
            ->get();

        $data['record'] = $trade1->getResult();

		$data['Title'] = 'Device';
		$data['SubTitle'] = 'kiosk';
		$data['output'] = null;
		$data['view_file'] = 'device';
		$data['device'] = TRUE;
		return view('main', $data);
	}


	public function postAdd_device()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$user = auth()->user();

        $transaction = [
            'DeviceMacAddress' => $this->request->getPost('DeviceMacAddress'),
            'IsActive'         => 1,
            'CreatedBy'        => $user->id,
            'CreatedWhen'      => date('Y-m-d H:i:s'),
            'CreatedWhere'     => $this->request->getIPAddress(),
            'Remarks'          => $this->request->getPost('Remarks'),
        ];

        $this->db->table('tbldevice')->insert($transaction);

		redirect()->to('/device');
	}

	// public function postSet_devicestatus()
	// {
	// 	if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
	// 	if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

    //     $transaction = [
    //         'IsActive' => $this->request->getPost('Status'),
    //     ];

    //     $this->db->table('tbldevice')
    //         ->where('id', $this->request->getPost('id'))
    //         ->update($transaction);

	// 	redirect()->to('/device');
	// }

public function postDevicerecord()
{
    if (!auth()->loggedIn()) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }
    if (!auth()->user()->inGroup('admin')) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }
    $query = $this->db->table('tbldevice')
        ->select('*')
        ->orderBy('id', 'DESC')
        ->get()
        ->getResult();

    $data = [];

    foreach($query as $r)
    {
        $statusBtn = '';

        if($r->IsActive == 1)
        {
            $statusBtn = '
                <button class="btn btn-danger btn-sm"
                    onclick="setStatus('.$r->id.',0)">
                    <i class="fa fa-ban"></i> Disable
                </button>
            ';
        }
        else
        {
            $statusBtn = '
                <button class="btn btn-success btn-sm"
                    onclick="setStatus('.$r->id.',1)">
                    <i class="fa fa-check"></i> Enable
                </button>
            ';
        }


        $editBtn = '
            <button class="btn btn-primary btn-sm"
                onclick="editDevice('.$r->id.')">
                <i class="fa fa-edit"></i> Edit
            </button>
        ';

        $data[] = [
            $r->DeviceMacAddress,
            $r->Remarks,
            $r->CreatedBy,
            $r->CreatedWhen,
            $r->CreatedWhere,
            ($r->IsActive == 1 ? 'Yes' : 'No'),
            $editBtn . ' ' . $statusBtn
        ];
    }

    echo json_encode([
        "data" => $data
    ]);
}

public function postSave()
{
    if (!auth()->loggedIn()) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }
    if (!auth()->user()->inGroup('admin')) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }

    $user = auth()->user();

    $id = $this->request->getPost('id');

    $data = [
        'Remarks' => $this->request->getPost('Remarks'),
        'DeviceMacAddress' => $this->request->getPost('DeviceMacAddress')
    ];

    if ($id == '')
    {
        $data['IsActive'] = 1;
        $data['CreatedBy'] = $user->id;
        $data['CreatedWhen'] = date('Y-m-d H:i:s');
        $data['CreatedWhere'] = $this->request->getIPAddress();

        $this->db->table('tbldevice')->insert($data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Device added successfully'
        ]);
    }
    else
    {
        $this->db->table('tbldevice')
            ->where('id', $id)
            ->update($data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Device updated successfully'
        ]);
    }
}

public function postDevicebyid()
{
    if (!auth()->loggedIn()) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }
    if (!auth()->user()->inGroup('admin')) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }
    $id = $this->request->getPost('id');

    $row = $this->db->table('tbldevice')
        ->where('id', $id)
        ->get()
        ->getRow();

    if($row)
    {
        echo json_encode([
            'status'=>'success',
            'data'=>$row
        ]);
    }
    else
    {
        echo json_encode([
            'status'=>'error',
            'message'=>'Device not found'
        ]);
    }
}

public function postSet_devicestatus_ajax()
{
    if (!auth()->loggedIn()) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }
    if (!auth()->user()->inGroup('admin')) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Unauthorized'
        ]);
        return;
    }
    $status = $this->request->getPost('Status');
    $this->db->table('tbldevice')
        ->set('IsActive', $status, false)
        ->where('id', $this->request->getPost('id'))
        ->update();
    
    // $lastQuery = $this->db->getLastQuery();

    echo json_encode([
        'status'=>'success',
        'message'=>'Device status updated',
    ]);
}

}