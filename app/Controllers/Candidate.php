<?php

namespace App\Controllers;

class Candidate extends BaseController
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


	public function index()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		
		$user = auth()->user();
		$keyword='';
		$keyword = $this->request->getPost('keyword');
		$data['mykeyword'] = $keyword;

		$query = $this->db->query("select * from tblregistration where ifnull(ApprovedBy,'')='' and ifnull(DisapprovedBy,'')=''");
		$data['record'] = $query->getResult();

		$query = $this->db->query("select * from tblregistration where (ifnull(ApprovedBy,'')<>'' or ifnull(DisapprovedBy,'')<>'')");
		$data['recordaction'] = $query->getResult();
		
		$data['Title'] = 'Candidate';
		$data['SubTitle'] = 'Record';
		$data['output'] = null;
		$data['candidate'] = TRUE;
		$data['view_file'] = 'candidate';
		return view('main', $data);
	}

	public function registration_approved()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$user = auth()->user();
		$position = $this->request->getPost('Position');
		$votemstid = 0;

		if ($position == 'President'){ $votemstid=1; }
		elseif ($position == 'Vice-President'){ $votemstid=2; }
		elseif ($position == 'Secretary'){ $votemstid=3; }
		elseif ($position == 'Treasurer'){ $votemstid=4; }
		elseif ($position == 'Auditor'){ $votemstid=5; }
		elseif ($position == 'Business Manager'){ $votemstid=6; }
		elseif ($position == 'Public Information Officer'){ $votemstid=7; }
		elseif ($position == 'Board of Trustees'){ $votemstid=8; }

		$this->load->model("Rx_model");

		$query = $this->db->query("SELECT * FROM users WHERE ecode = '". $this->request->getPost('EmpNo') ."' LIMIT 1");
		if ($query->getNumRows() > 0) { 
		    $transaction = [ 'Status' => 'APPROVED',
						 'ApprovedBy' => $this->Rx_model->getUseName2($user->ecode),
						 'ApprovedWhen' => date('Y-m-d H:i:s'),
						 'ApprovedWhere' => $this->request->getIPAddress(),
						]; 
			$this->db->where("id", $this->request->getPost('id'));
			$this->db->update("tblregistration", $transaction);

				$transaction = [ 'votemstid'   =>$votemstid, 
								 'Candidate' => $query->getRow()->last_name . ', ' . $query->getRow()->first_name . ' ' . $query->getRow()->middle_name ,
								 'CandidateImage' => 'user.png',
								 'CreatedBy' => $user->id,
								 'CreatedWhen' => date('Y-m-d H:i:s'),
								 'CreatedWhere' => $this->request->getIPAddress(),
								 'EmpNo' => $query->getRow()->ecode
							]; 
				$this->db->insert( "tblvotetrn", $transaction);

			return redirect()->to('/candidate');
		}

	}

	public function registration_disapproved()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$user = auth()->user();

		$this->load->model("Rx_model");

		$transaction = [ 'Status' => 'DISAPPROVED',
						 'DisapprovedBy' => $this->Rx_model->getUseName2($user->ecode),
						 'ApprovedWhen' => date('Y-m-d H:i:s'),
						 'ApprovedWhere' => $this->request->getIPAddress(),
						]; 
		$this->db->where("id", $this->request->getPost('id'));
		$this->db->update("tblregistration", $transaction);

		return redirect()->to('/candidate');
	}


	public function registration_cancelaction()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$transaction = [ 'Status' => 'PENDING',
						 'ApprovedBy' => NULL,
						 'DisapprovedBy' => NULL,
						 'ApprovedWhen' => NULL,
						 'ApprovedWhere' => NULL,
						]; 
		$this->db->where("id", $this->request->getPost('id'));
		$this->db->update("tblregistration", $transaction);

		$position = $this->request->getPost('Position');
		$votemstid = 0;

		if ($position == 'President'){ $votemstid=1; }
		elseif ($position == 'Vice-President'){ $votemstid=2; }
		elseif ($position == 'Secretary'){ $votemstid=3; }
		elseif ($position == 'Treasurer'){ $votemstid=4; }
		elseif ($position == 'Auditor'){ $votemstid=5; }
		elseif ($position == 'Business Manager'){ $votemstid=6; }
		elseif ($position == 'Public Information Officer'){ $votemstid=7; }
		elseif ($position == 'Board of Trustees'){ $votemstid=8; }

		$transaction = [ 'EmpNo' => $this->request->getPost('EmpNo'),
						 'votemstid' => $votemstid
						]; 
		$this->db->delete("tblvotetrn", $transaction);

		return redirect()->to('/candidate');
	}
}