<?php

namespace App\Controllers;

class Search extends BaseController
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
		$ReferenceNumber=$this->request->getPost('ReferenceNumber');
		
		$query = $this->db->query("
			SELECT 
				Description AS Position,
				n.Candidate
			FROM tblvote v
			RIGHT JOIN tblvotemst m 
				ON v.votemstid = m.id
			LEFT JOIN tblvotetrn n 
				ON v.votetrnid = n.id
			WHERE ReferenceNumber = ?
		", [$ReferenceNumber]);

		$data['record'] = $query->getResult();

		return view('search',$data);
	}

}