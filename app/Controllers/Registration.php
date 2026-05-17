<?php

namespace App\Controllers;

class Registration extends BaseController
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


	// public function index()
	// {
	// 	return view('registration');
	// }

	// public function save()
	// {
	// 	$this->load->library('form_validation');

	// 	$validation = \Config\Services::validation();->set_rules('EmpNo', 'Employee Name', 'required');
	// 	$validation = \Config\Services::validation();->set_rules('FirstName', 'First ame', 'required');
	// 	$validation = \Config\Services::validation();->set_rules('MiddleName', 'Middle Name', 'required');
	// 	$validation = \Config\Services::validation();->set_rules('LastName', 'Last Name', 'required');
	// 	$validation = \Config\Services::validation();->set_rules('Position', 'Position', 'required');

	// 	 if ($validation = \Config\Services::validation();->run() == FALSE)
    //             {
    //                     $this->index();
    //             }
    //             else
    //             {
    //             		$EmpNo = $this->request->getPost('EmpNo');
	// 					$FirstName = $this->request->getPost('FirstName');
	// 					$MiddleName = $this->request->getPost('MiddleName');
	// 					$LastName = $this->request->getPost('LastName');
	// 					$Position = $this->request->getPost('Position');
	// 					$last_id = '';

	// 					$transaction = [ 
	// 										'EmpNo' => $EmpNo,
	// 										'FirstName' => $FirstName,
	// 										'MiddleName' => $MiddleName,
	// 										'LastName' => $LastName,
	// 										'Position' => $Position,
	// 										'CreatedWhen' => date('Y-m-d H:i:s'),
	// 										'CreatedWhere' => $this->request->getIPAddress(),
	// 										'Status' => "PENDING"
	// 											]; 
	// 					$this->db->insert( "tblregistration", $transaction);
	// 					$last_id = $this->db->insert_id();


    //                    //CHECK ATTACHMENT
	// 				    $number_of_files_uploaded = count($_FILES['upl_files']['name']);
	// 				    for ($i = 0; $i < $number_of_files_uploaded; $i++) :
	// 				    	  $_FILES['userfile']['name']     = $_FILES['upl_files']['name'][$i];
	// 					      $_FILES['userfile']['type']     = $_FILES['upl_files']['type'][$i];
	// 					      $_FILES['userfile']['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
	// 					      $_FILES['userfile']['error']    = $_FILES['upl_files']['error'][$i];
	// 					      $_FILES['userfile']['size']     = $_FILES['upl_files']['size'][$i];

	// 						  $config = array(
	// 							'upload_path' => "./uploads/candidates/",
	// 							'allowed_types' => "jpg|png|jpeg",
	// 							'max_size' => "5048000",
	// 							'overwrite' => FALSE,
	// 							);

	// 						  $this->load->library('upload', $config);

	// 						  if (!$this->upload->do_upload()) :
	// 					        $error = array('error' => $this->upload->display_errors());
	// 					      else :
	// 					        $final_files_data = $this->upload->data();
	// 					    	$transaction = [ 'ReferenceID' => $last_id,
	// 									 'Image' => $final_files_data['file_name'],
	// 									 'CreatedWhen' => date('Y-m-d H:i:s'),
	// 									 'FileExtension' => $final_files_data['file_ext']
	// 									]; 
	// 							$this->db->insert( "tblattachment", $transaction);$this->upload->data();
	// 					      endif;
	// 				    endfor;

	// 					$this->success();
	// 			}
	// }

	// public function success(){
	// 	return view('registration_success');
	// }
}