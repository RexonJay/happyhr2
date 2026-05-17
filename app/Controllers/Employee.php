<?php

namespace App\Controllers;

class Employee extends BaseController
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

$keyword = $this->request->getPost('keyword') ?? '';

$data['mykeyword'] = $keyword;

$trade1 = $this->db->table('users u')
    ->select("
        id,
        ecode,
        first_name,
        middle_name,
        last_name,
        birthdate,
        Office,
        OfficeCode,
        CASE 
            WHEN (
                SELECT 1 
                FROM tblvote v 
                WHERE v.userid = u.id 
                AND IFNULL(IsActive,0)=1 
                LIMIT 1
            ) = 1 
            THEN 'Yes' 
            ELSE 'No' 
        END AS IsAlreadyVoted,
        active
    ", false)
    ->like("CONCAT(last_name, ', ', first_name, middle_name)",
        $keyword
    )
    ->where('ecode <>', 10000)
    ->orderBy('last_name', 'ASC')
    ->get();

$data['record'] = $trade1->getResult();

$data['Title'] = 'Dashboard';
$data['SubTitle'] = 'Overview';
$data['output'] = null;
$data['view_file'] = 'employee';
$data['employee_records'] = true;

return view('main', $data);
	}


	public function postAccount_disable()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}
		$user = auth()->user();

		// $transaction = [ 'IsActive'   => 0 ]; 
		// $this->db->where( "userid", $this->request->getPost('id'));
		// $this->db->update( "tblvote", $transaction);
		$transaction = [ 'active'   => 0 ]; 
		$this->db->table('users')
			->where('id', $this->request->getPost('id'))
			->update($transaction);
		return redirect()->to('/employee');
	}

	public function postAccount_enable()
	{
		if (!auth()->loggedIn()) {
			return redirect()->to('/logout');
		}
		if (!auth()->user()->inGroup('admin')) {
			return redirect()->to('/logout');
		}
		$user = auth()->user();

		$transaction = [ 'active'   => 1 ]; 
		$this->db->table('users')
			->where('id', $this->request->getPost('id'))
			->update($transaction);

		return redirect()->to('/employee');
	}

	public function getVote_imagepreview(){
		if(!auth()->loggedIn()){return redirect()->to('/logout');}
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		$ecode = $this->request->getPost('ecode');

		$trade1 = $this->db->table('tblusersvotephoto')
			->select('VotePhoto', false)
			->where('ecode', $ecode)
			->get();

		foreach ($trade1->getResult() as $row) {
			$data['content'] = $row->VotePhoto;
			$data['ecode'] = $ecode;
		}

		return view('vote_imagepreview', $data);
	}
}