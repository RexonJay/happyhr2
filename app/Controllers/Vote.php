<?php

namespace App\Controllers;

class Vote extends BaseController
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

		$user = auth()->user();

		$query = $this->db->query("
			SELECT IsVoteLock
			FROM tblsettings
			WHERE IFNULL(IsVoteLock,0)=1
		");

		if ($query->getNumRows() > 0) {
			// return redirect()->to('/logout');
			return view('vote_error', [
				'Heading' => 'Election Closed',
				'Message' => 'Voting is now closed. The election period has ended. Thank you for participating.'
			]);
		}

		//CHECK IF NAKAPASA SA SECURITY QUESTION
		$query = $this->db->query("
			SELECT 1
			FROM users
			WHERE IFNULL(IsSecurityQuestionsPassed,0) <> 1
			AND id = ?
			LIMIT 1
		", [$user->id]);

		if ($query->getNumRows() > 0) {
			return redirect()->to('//logout');
		}

		//CHECK IF NAKAVOTE NA
		$query = $this->db->query("
			SELECT 1
			FROM tblvote
			WHERE userid = ?
			AND IFNULL(IsActive,0)=1
			LIMIT 1
		", [$user->id]);

		if ($query->getNumRows() > 0) {
			return redirect()->to('/vote/message');
		}

		// PRESIDENT
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 1)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordPresident'] = $trade1->getResult();

		// VICE PRESIDENT
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 2)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordVicePresident'] = $trade1->getResult();

		// SECRETARY
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 3)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordSecretary'] = $trade1->getResult();

		// TREASURER
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 4)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordTreasurer'] = $trade1->getResult();

		// AUDITOR
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 5)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordAuditor'] = $trade1->getResult();

		// BUSINESS MANAGER
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 6)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordBusinessManager'] = $trade1->getResult();

		// PIO
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 7)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordPIO'] = $trade1->getResult();

		// BOARD OF TRUSTEES
		$trade1 = $this->db->table('tblvotetrn trn')
			->select("
				id as votetrnid,
				votemstid,
				Candidate,
				CandidateImage,
				IFNULL(Partylist,'') Partylist
			", false)
			->where('votemstid', 8)
			->orderBy('Candidate', 'ASC')
			->get();

		$data['RecordBoardOfTrustees'] = $trade1->getResult();

		$data['message'] = session()->getFlashdata('message');

		return view('voting', $data);
	}

	public function valid()
    {	
        $num = (!empty($this->request->getPost('BoardOfTrustees'))) ? count($this->request->getPost('BoardOfTrustees')) : 0;
        if ($num > 10) {
            return false;
        } else {
            return true;
        }
    }
	public function postVote_submit()
	{
		if (!auth()->loggedIn()) {
			echo json_encode(['status' => 'error', 'message' => 'Session expired']);
			return;
		}

		$user = auth()->user();

		// CHECK IF VOTE LOCK
		$query = $this->db->query("SELECT IsVoteLock FROM tblsettings where ifnull(IsVoteLock,0)=1");
		if ($query->getNumRows() > 0) {
			echo json_encode(['status' => 'error', 'message' => 'Voting is now closed. The election period has ended. Thank you for participating.']);
			return;
		}

		// CHECK IF ALREADY VOTED
		$query = $this->db->query("SELECT 1 FROM tblvote WHERE userid = ? and ifnull(IsActive,0)=1 LIMIT 1", [$user->id]);
		if ($query->getNumRows() > 0) {
			echo json_encode(['status' => 'error', 'message' => 'You already voted']);
			return;
		}
		
		$agentService = \Config\Services::request()->getUserAgent();

		$agent = $agentService->isBrowser()
			? $agentService->getBrowser() . ' ' . $agentService->getVersion()
			: (
				$agentService->isMobile()
					? $agentService->getMobile()
					: 'Unknown'
			);

		$MAC = $agent .
			$agentService->getPlatform() .
			$this->request->getIPAddress();

		$PrecinctID = session()->get('PrecinctID');

		$ReferenceNumber = str_replace(
			' ',
			'',
			$user->ecode . $this->generateRandomString()
		);

		// FUNCTION to insert vote
		function insertVote($db, $data)
		{
			// If no selection → force 0
			if (empty($data['votetrnid'])) {

				$data['votetrnid'] = 0;
			}

			$db->table('tblvote')->insert($data);
		}
		$base = [
			'userid' => $user->id,
			'ecode' => $user->ecode,
			'CreatedBy' => $user->id,
			'CreatedWhen' => date('Y-m-d H:i:s'),
			'CreatedWhere' => $this->request->getIPAddress(),
			'ReferenceNumber' => $ReferenceNumber,
			'DeviceMacAddress' => $MAC,
			'PrecinctID' => $PrecinctID,
			'OfficeCode' => $user->OfficeCode,
			'IsActive' => 1
		];
		$this->db->transStart();

		// SINGLE POSITIONS
		insertVote($this->db, array_merge($base, ['votemstid' => 1, 'votetrnid' => $this->request->getPost('President')]));
		insertVote($this->db, array_merge($base, ['votemstid' => 2, 'votetrnid' => $this->request->getPost('VicePresident')]));
		insertVote($this->db, array_merge($base, ['votemstid' => 3, 'votetrnid' => $this->request->getPost('Secretary')]));
		insertVote($this->db, array_merge($base, ['votemstid' => 4, 'votetrnid' => $this->request->getPost('Treasurer')]));
		insertVote($this->db, array_merge($base, ['votemstid' => 5, 'votetrnid' => $this->request->getPost('Auditor')]));
		insertVote($this->db, array_merge($base, ['votemstid' => 6, 'votetrnid' => $this->request->getPost('BusinessManager')]));
		insertVote($this->db, array_merge($base, ['votemstid' => 7, 'votetrnid' => $this->request->getPost('PublicInformationOfficer')]));

		// BOARD OF TRUSTEES
		$bot = $this->request->getPost('BoardOfTrustees');

		if (!empty($bot)) {

			foreach ($bot as $row) {

				insertVote($this->db, array_merge($base, [
					'votemstid' => 8,
					'votetrnid' => $row
				]));
			}

		} else {

			// No selection → insert one record with 0
			insertVote($this->db, array_merge($base, [
				'votemstid' => 8,
				'votetrnid' => 0
			]));
		}

		$this->db->transComplete();

		if ($this->db->transStatus() === false) {

			return $this->response->setJSON([
				'status'  => 'error',
				'message' => 'Database error'
			]);

		} else {

			return $this->response->setJSON([
				'status'   => 'success',
				'message'  => 'Vote submitted successfully',
				'redirect' => site_url('vote/votingsuccess?ref=' . $ReferenceNumber)
			]);
		}

	}

	public function getVotingsuccess()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		$ref = $this->request->getGet('ref');
		if (empty($ref)) {
			return redirect()->to('/logout');
		}
		$data['ReferenceNumber'] = $ref;

		$query = $this->db->query("SELECT 1 FROM tblvote v where ReferenceNumber=? and ifnull(v.IsActive,0)=1", [$ref]	);
		if ($query->getNumRows() == 0) {
			return redirect()->to('/logout');
		}else{
			$data['ReferenceNumber'] = $ref;
			return view('votingsuccess', $data);
		}
	}	

	public function generateRandomString($length = 3) {

	    return  str_replace(' ', '', substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length));;

	}

	public function getGet_vote_result_president()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='1'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='1'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}

	public function getGet_vote_result_vicepresident()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='2'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='2'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}


	public function getGet_vote_result_secretary()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='3'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='3'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}


	public function getGet_vote_result_treasurer()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='4'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='4'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}


	public function getGet_vote_result_auditor()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='5'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='5'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}


	public function getGet_vote_result_businessmanager()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='6'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='6'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}


	public function getGet_vote_result_publicinformationofficer()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='7'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='7'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}

	public function getGet_vote_result_boardoftrustees()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$votemstid = $this->request->getPost('votemstid');
		$IsShowCandidateName = $this->request->getPost('IsShowCandidateName');

		if($IsShowCandidateName==0){
			$query = $this->db->query("
				select tvn.CandidateAlias 'Candidate',
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='8'
				order by tvn.Candidate
				");
		}else{
			$query = $this->db->query("
				select tvn.Candidate,
				(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'Rank'
				from tblvotetrn tvn  
				where tvn.votemstid='8'
				order by tvn.Candidate
				");
		}
		$data['record'] = $query->getResult();
		return $this->response->setJSON($data);
	}

	// public function success(){
	// 	return view('votingsuccess');
	// }

	public function getMessage(){
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		return view('votingalready');
	}

	public function getVotelist()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$trade1 = $this->db->table('tblvotemst')
			->select("
				id,
				Description,
				Result,
				CreatedWhen,
				IFNULL(isactive,0) as isactive
			", false)
			->where('Type', 'VOTE')
			->where('IFNULL(isactive,1)', '1', false)
			->orderBy('RowIndex', 'ASC')
			->get();

		$data['record'] = $trade1->getResult();

		$data['Title'] = 'Voting System';
		$data['SubTitle'] = 'List';
		$data['output'] = null;
		$data['view_file'] = 'vote';
		$data['vote_list'] = true;

		return view('main', $data);
	}


	public function getVotemst_create()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		
		$data['Title'] = 'Voting System';
		$data['SubTitle'] = 'create';
		$data['output'] = null;
		$data['view_file'] = 'votemst_create';
		$data['vote_list'] = TRUE;
		return view('main', $data);
	}

	public function getVotemst_save()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$user = auth()->user();

		$transaction = [ 'Description'   => $this->request->getPost('Description'), 
						 'Type' => 'VOTE',
						 'CreatedBy' => $user->id,
						 'CreatedWhen' => date('Y-m-d H:i:s'),
						 'CreatedWhere' => $this->request->getIPAddress()
						]; 
		$this->db->insert( "tblvotemst", $transaction);
		$last_id = $this->db->insert_id();

		session()->set('Description', $this->request->getPost('Description'));
		session()->set('votemstid', $last_id);
		return redirect()->to('/vote/votetrn_create');
	}

	public function getVotetrn_create($votemstid = null, $description = null)
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		if ($votemstid != null) {
			$data['Description'] = $description;
		} else {
			$votemstid = session()->get('votemstid');
			$data['Description'] = session()->get('Description');
		}

		$data['votemstid'] = $votemstid;

		$trade1 = $this->db->table('tblvotetrn')
			->select("
				id,
				Candidate,
				CandidateImage,
				Partylist
			", false)
			->where('votemstid', $votemstid)
			->orderBy('CreatedWhen', 'DESC')
			->get();

		$data['record'] = $trade1->getResult();

		$data['Title'] = 'Voting System';
		$data['SubTitle'] = 'create';
		$data['output'] = null;
		$data['view_file'] = 'votetrn_create';
		$data['vote_list'] = true;

		return view('main', $data);
	}

	public function postVotetrn_save()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		$user = auth()->user();

		$file = $this->request->getFile('userfile');

		if ($file && $file->isValid() && !$file->hasMoved()) {

			// allowed file types
			$allowedExtensions = ['gif', 'jpg', 'png', 'jpeg', 'pdf'];

			$extension = strtolower($file->getExtension());

			if (!in_array($extension, $allowedExtensions)) {

				return redirect()->back()->with('error', 'Invalid file type.');
			}

			// keep original filename
			$newName = $file->getRandomName();

			// move upload
			$file->move(ROOTPATH . 'public/uploads/candidates', $newName);

			$transaction = [
				'votemstid'     => $this->request->getPost('votemstid'),
				'Candidate'     => $this->request->getPost('Candidate'),
				'Partylist'     => $this->request->getPost('Partylist'),
				'CandidateImage'=> $newName,
				'CreatedBy'     => $user->id,
				'CreatedWhen'   => date('Y-m-d H:i:s'),
				'CreatedWhere'  => $this->request->getIPAddress()
			];

			$this->db->table('tblvotetrn')->insert($transaction);

			session()->set('Description', $this->request->getPost('Description'));

			session()->set('votemstid', $this->request->getPost('votemstid'));

			return redirect()->to('/vote/votetrn_create');

		} else {

			echo $file ? $file->getErrorString() : 'No file uploaded.';
		}
	}

	public function postVote_candidate_edit()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}

		$query = $this->db->query("
			select tvn.Candidate, tvn.CandidateImage,Partylist
			from tblvotetrn tvn  
			where tvn.id='" . $this->request->getPost('id') . "'
			order by tvn.Candidate desc
			");
		$data['record'] = $query->getResult();

		$data['id'] = $this->request->getPost('id');
		$data['Description'] = $this->request->getPost('Description');
		$data['votemstid'] = $this->request->getPost('votemstid');
		$data['Title'] = 'Voting System';
		$data['SubTitle'] = 'edit';
		$data['output'] = null;
		$data['view_file'] = 'vote_candidate_edit';
		$data['vote_list'] = TRUE;
		return view('main', $data);
	}

	public function postVote_candidate_edit_save()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$user = auth()->user();

		$file = $this->request->getFile('userfile');

		if ($file && $file->isValid() && !$file->hasMoved()) {

			$allowedExtensions = ['gif', 'jpg', 'png', 'jpeg', 'pdf'];

			$extension = strtolower($file->getExtension());

			if (!in_array($extension, $allowedExtensions)) {

				return redirect()->back()->with('error', 'Invalid file type.');
			}

			// generate random filename
			$newName = $file->getRandomName();

			// move upload
			$file->move(ROOTPATH . 'public/uploads/candidates/', $newName);

			$transaction = [
				'Candidate'      => $this->request->getPost('Candidate'),
				'Partylist'      => $this->request->getPost('Partylist'),
				'CandidateImage' => $newName
			];

			$this->db->table('tblvotetrn')
				->where('id', $this->request->getPost('id'))
				->update($transaction);

			session()->set('Description', $this->request->getPost('Description'));

			session()->set('votemstid', $this->request->getPost('votemstid'));

			return redirect()->to('/vote/votetrn_create');

		} else {

			// no uploaded image, update text fields only
			$transaction = [
				'Candidate' => $this->request->getPost('Candidate'),
				'Partylist' => $this->request->getPost('Partylist')
			];

			$this->db->table('tblvotetrn')
				->where('id', $this->request->getPost('id'))
				->update($transaction);

			session()->set('Description', $this->request->getPost('Description'));

			session()->set('votemstid', $this->request->getPost('votemstid'));

			return redirect()->to('/vote/votetrn_create');
		}
	}

	public function postVotemst_delete()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$user = auth()->user();

		$id = $this->uri->segment(3);

		$transaction = [ 'IsActive' => 0 ]; 
		$this->db->where( "id", $id);
		$this->db->update( "tblvotemst", $transaction);
		return redirect()->to('/vote/vote_list');
	}

	public function getVoted_list()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		$keyword = $this->request->getPost('keyword') ?? '';

		$data['mykeyword'] = $keyword;

		$sql = "
			SELECT 
				u.id,
				u.ecode,
				u.first_name,
				u.middle_name,
				u.last_name,
				MAX(DATE_FORMAT(tv.CreatedWhen, '%Y-%m-%d %H:%i')) AS CreatedWhen,
				MAX(tv.ReferenceNumber) AS ReferenceNumber
			FROM users u
			INNER JOIN tblvote tv 
				ON u.id = tv.userid
				AND tv.IsActive = 1
		";

		$params = [];

		if (!empty($keyword)) {

			$sql .= "
				WHERE CONCAT(
					u.last_name,
					', ',
					u.first_name,
					' ',
					u.middle_name
				) LIKE ?
			";

			$params[] = '%' . $keyword . '%';
		}

		$sql .= "
			GROUP BY 
				u.id,
				u.ecode,
				u.first_name,
				u.middle_name,
				u.last_name
		";

		$query = $this->db->query($sql, $params);

		// ,concat(last_name,', ',first_name,' ',middle_name) 'Name',Office

		$data['record'] = $query->getResult();

		$data['Title'] = 'Dashboard';
		$data['SubTitle'] = 'Voted List';
		$data['output'] = null;
		$data['view_file'] = 'voted_list';
		$data['employee_records'] = true;

		return view('main', $data);
	}

	public function getVotednot_list()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}

		$keyword = $this->request->getPost('keyword') ?? '';

		$data['mykeyword'] = $keyword;

		$sql = "
			SELECT 
				u.id,
				ecode,
				last_name,
				first_name,
				middle_name,
				Office
			FROM users u
			WHERE id NOT IN (
				SELECT userid
				FROM tblvote tv
				WHERE tv.IsActive = 1
			)
			AND ecode <> '10000'
		";

		$params = [];

		if (!empty($keyword)) {

			$sql .= "
				AND CONCAT(
					last_name,
					', ',
					first_name,
					' ',
					middle_name
				) LIKE ?
			";

			$params[] = '%' . $keyword . '%';
		}

		$query = $this->db->query($sql, $params);

		$data['record'] = $query->getResult();

		$data['Title'] = 'Dashboard';
		$data['SubTitle'] = 'Not Voted List';
		$data['output'] = null;
		$data['view_file'] = 'votednot_list';
		$data['employee_records'] = true;

		return view('main', $data);
	}


	public function postVote_lock()
	{
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$transaction = [
			'IsVoteLock' => 1
		];
		$this->db->table('tblsettings')->update($transaction);

		return redirect()->to('/main');
	}

	public function postVote_unlock()
	{
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}

		$transaction = [ 'IsVoteLock' => 0 ]; 
		$this->db->table('tblsettings')->update($transaction);

		return redirect()->to('/main');
	}


	public function postVote_reset()
	{
		if (!auth()->loggedIn()) {return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$user = auth()->user();

		$transaction = [ 'IsActive'   => 0 ]; 
		$this->db->table('tblvote')
			->where('userid', $this->request->getPost('id'))
			->update($transaction);

		return redirect()->to('/employee');
	}

	public function postVote_cancelvotelogin()
	{
		if (!auth()->loggedIn()) {
			echo json_encode(['status' => 'error', 'message' => 'Session expired']);
			return;
		}
		$user = auth()->user();

		$transaction = [
			'IsSecurityQuestionsPassed' => 0
		];

		$this->db->table('users')
			->where('id', $user->id)
			->update($transaction);

		    echo json_encode([
        'status' => 'success',
        'message' => 'Voting has been cancelled successfully.'
    ]);
	}

}
