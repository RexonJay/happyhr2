<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LeaveModel;
use CodeIgniter\Shield\Models\UserModel;

class Downloads extends BaseController
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
            return redirect()->to('login');
        }

        $keyword = $this->request->getPost('keyword') ?? '';

        $builder = $this->db->table('tbldownloads');
        $builder->select('*')
                ->where('IFNULL(IsActive, 0)', '1')
                ->like("CONCAT(Category, FileName)", $keyword)
                ->orderBy('Category, FileName', 'DESC')
                ->limit(300);
        $data['record'] = $builder->get()->getResult();
        
        // $data = [
        //     'mykeyword' => $keyword,
        //     'record' => $builder->get()->getResult(),
        //     'DownloadableForms' => true,
        //     'title' => 'Downloadable Forms',
        //     'subtitle' => 'List',
        //     'view_file' => 'downloadableforms' // Pass the view file name
        // ];

        $data['mykeyword'] = $keyword;
        $data['DownloadableForms'] = true;
        $data['Title'] = 'Downloadable Forms';
        $data['SubTitle'] = 'List';
        $data['view_file'] = 'downloadableforms';

        return view('main', $data); // Pass all data to the main view
    }

    public function public()
    {
        $builder = $this->db->table('tbldownloads');
        $query = $builder->where('IFNULL(IsActive, 0)', '1')
                        ->orderBy('Category, FileName')
                        ->get();

        return view('downloadableforms_public', ['record' => $query->getResult()]);
    }

    public function downloads_create()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $user = auth()->user();

        if ($user->meta['office_code'] != '200') {
            return redirect()->to('login');
        }

        $data = [
            'message' => $this->session->getFlashdata('message'),
            'DownloadableForms' => true,
            'Title' => 'Downloadable Forms',
            'SubTitle' => 'Create',
            'output' => null
        ];

        return view('main', array_merge($data, ['view_file' => 'downloadableforms_create']));
    }

    public function downloads_save()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $user = auth()->user();
        if ($user->meta['office_code'] != '200') {
            return redirect()->to('login');
        }

        $leaveModel = new LeaveModel();

        $rules = [
            'Category' => 'required',
            'FileName' => 'required',
            'Type' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $type = $this->request->getPost('Type');
        $filePath = '';
        $hasFileToUpload = false;
        $isUploadFileSuccess = false;

        if ($type == 'download') {
            $hasFileToUpload = true;
            $file = $this->request->getFile('userfile');

            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                
                if ($file->move(WRITEPATH . 'uploads/downloadableforms', $newName)) {
                    $filePath = $newName;
                    $isUploadFileSuccess = true;
                } else {
                    $error = $file->getError();
                    return redirect()->back()->with('error', $error);
                }
            }
        } else {
            $filePath = $this->request->getPost('FilePathLink');
        }

        $transaction = [
            'Type' => $this->request->getPost('Type'),
            'Category' => $this->request->getPost('Category'),
            'FileName' => $this->request->getPost('FileName'),
            'FilePath' => $filePath,
            'Remarks' => $this->request->getPost('Remarks'),
            'CreatedBy' => $leaveModel->getUseName2($user->id), // Assuming you'll update this to use Shield's user ID
            'CreatedWhen' => date('Y-m-d H:i:s'),
            'CreatedWhere' => $this->request->getIPAddress(),
            'IsActive' => 1,
        ];

        $this->db->table('tbldownloads')->insert($transaction);

        if (!$isUploadFileSuccess && $hasFileToUpload) {
            return redirect()->to('Downloads/downloads_create')->with('message', 'ERROR!');
        }

        return redirect()->to('Downloads')->with('message', 'Successfully Added!');
    }

    public function downloads_delete()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $user = auth()->user();
        if ($user->meta['office_code'] != '200') {
            return redirect()->to('login');
        }

        $leaveModel = new LeaveModel();

        $transaction = [
            'DeletedBy' => $leaveModel->getUserName2($user->id), // Assuming you'll update this to use Shield's user ID
            'DeletedWhen' => date('Y-m-d H:i:s'),
            'DeletedWhere' => $this->request->getIPAddress(),
            'IsActive' => 0,
        ];

        $this->db->table('tbldownloads')
                 ->where('id', $this->request->getPost('id'))
                 ->update($transaction);

        return redirect()->to('Downloads')->with('message', 'Successfully Removed!');
    }
}