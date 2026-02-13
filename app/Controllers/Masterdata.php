<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LeaveModel;
use CodeIgniter\Shield\Models\UserModel;

class Masterdata extends BaseController
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

    public function getSignatory()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }
        if(!auth()->user()->inGroup('payroll hr') && !auth()->user()->inGroup('payroll') && !auth()->user()->inGroup('admin')){ 
            return redirect()->to('login');
        }

        $user = $this->auth->user();
        $officeModel = new \App\Models\OfficeModel();
      
        $data['record_office'] = $officeModel->getOfficesByUser($user);
        $keyword = $this->request->getGet('keyword') ?? '';

        $builder = $this->db->table('tbllookup_signatory s');
        $builder->select("s.*,o.ShortName AS OfficeName");
        $builder->join('office o', 'o.OfficeCode = s.OfficeCode', 'inner');
        $builder->where('s.IsActive', 1);
        if (!auth()->user()->inGroup('payroll hr') && !auth()->user()->inGroup('admin')) {
            $builder->whereIn('s.OfficeCode', $officeModel->getOfficeCodeArray($user));
        }
        if ($keyword != '') {
            $builder->like("o.OfficeName", $keyword);
        }
        $builder->orderBy('o.ShortName', 'ASC');
        $builder->orderBy('s.Module', 'ASC');
        $data['record'] = $builder->get()->getResult();

        $data['mykeyword'] = $keyword;
        $data['masterdata'] = true;
        $data['masterdata_signatory'] = true;
        $data['Title'] = 'Signatory Master Data';
        $data['SubTitle'] = 'List';
        $data['view_file'] = 'masterdata_signatory'; // Specify the view file to be loaded

        return view('main', $data); // Pass all data to the main view
    }

    public function getSignatorylist()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }
        if(!auth()->user()->inGroup('payroll hr') && !auth()->user()->inGroup('payroll') && !auth()->user()->inGroup('admin')){ 
            return redirect()->to('login');
        }

        $user = $this->auth->user();
        $officeModel = new \App\Models\OfficeModel();
      
        $data['record_office'] = $officeModel->getOfficesByUser($user);
        $keyword = $this->request->getGet('keyword') ?? '';

        $builder = $this->db->table('tbllookup_signatory s');
        $builder->select("s.*,o.ShortName AS OfficeName");
        $builder->join('office o', 'o.OfficeCode = s.OfficeCode', 'inner');
        $builder->where('s.IsActive', 1);
        if (!auth()->user()->inGroup('payroll hr') && !auth()->user()->inGroup('admin')) {
            $builder->whereIn('s.OfficeCode', $officeModel->getOfficeCodeArray($user));
        }
        if ($keyword != '') {
            $builder->like("o.OfficeName", $keyword);
        }
        $data = $builder->get()->getResult();

        return $this->response->setJSON([
            'data' => $data
        ]);
    }

    public function postSignatoryedit()
    {
        if (!auth()->loggedIn()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }

        $data = $this->request->getPost();
        $this->db->transException(true)->transStart();

        $this->db->table('tbllookup_signatory')
            ->where('id', $data['id'])
            ->update([
                'PreparedBy' => $data['PreparedBy'],
                'PreparedByPosition' => $data['PreparedByPosition'],
                'CheckedBy' => $data['CheckedBy'],
                'CheckedByPosition' => $data['CheckedByPosition'],
                'NotedBy' => $data['NotedBy'],
                'NotedByPosition' => $data['NotedByPosition'],
                'ApprovedBy' => $data['ApprovedBy'],
                'ApprovedByPosition' => $data['ApprovedByPosition']
            ]);

        $this->db->table('tblactivity')->insert([
            'Module' => 'Signatory',
            'Description' => 'Changes on Signatory Master Data',
            'ActionType' => 'UPDATE',
            'ReferenceID' => $data['id'],
            'ReferenceTable' => 'tbllookup_signatory',
            'CreatedBy' => auth()->user()->id,
            'CreatedWhen' => date('Y-m-d H:i:s'),
            'CreatedWhere' => $this->request->getIPAddress(),
        ]);

        $this->db->transComplete();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Signatory updated successfully.'
        ]);
    }

    public function postSignatoryinsert()
    {
        if (!auth()->loggedIn()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ]);
        }

        if (
            !auth()->user()->inGroup('payroll hr') &&
            !auth()->user()->inGroup('payroll') &&
            !auth()->user()->inGroup('admin')
        ) {
            return redirect()->to('login');
        }

        $data = $this->request->getPost();
            $this->db->transException(true)->transStart();

            // 🔍 CHECK EXISTING ACTIVE RECORD (inside transaction for safety)
            $exists = $this->db->table('tbllookup_signatory')
                ->where('Module', $data['Module'])
                ->where('OfficeCode', $data['OfficeCode'])
                ->where('IsActive', 1)
                ->countAllResults();

            if ($exists > 0) {
                throw new \Exception('An active signatory for this Module already exists.');
            }

            // ✅ INSERT SIGNATORY
            $insertData = [
                'Module'              => $data['Module'],
                'PreparedBy'          => $data['PreparedBy'],
                'PreparedByPosition'  => $data['PreparedByPosition'],
                'CheckedBy'           => $data['CheckedBy'],
                'CheckedByPosition'   => $data['CheckedByPosition'],
                'NotedBy'             => $data['NotedBy'],
                'NotedByPosition'     => $data['NotedByPosition'],
                'ApprovedBy'          => $data['ApprovedBy'],
                'ApprovedByPosition'  => $data['ApprovedByPosition'],
                'OfficeCode'          => $data['OfficeCode'],
                'CreatedBy'           => auth()->user()->id,
                'CreatedWhen'         => date('Y-m-d H:i:s'),
                'CreatedWhere'        => $this->request->getIPAddress(),
                'IsActive'            => 1,
            ];

            $this->db->table('tbllookup_signatory')->insert($insertData);

            $insertID = $this->db->insertID();

            // 📝 ACTIVITY LOG
            $this->db->table('tblactivity')->insert([
                'Module'         => 'Signatory',
                'Description'    => 'Inserted new Signatory Master Data',
                'ActionType'     => 'INSERT',
                'ReferenceID'    => $insertID,
                'ReferenceTable' => 'tbllookup_signatory',
                'CreatedBy'      => auth()->user()->id,
                'CreatedWhen'    => date('Y-m-d H:i:s'),
                'CreatedWhere'   => $this->request->getIPAddress(),
            ]);

            $this->db->transComplete();

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Signatory inserted successfully.'
            ]);

    }

    public function postSignatorydelete()
    {
        if (!auth()->loggedIn()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ]);
        }

        if (
            !auth()->user()->inGroup('payroll hr') &&
            !auth()->user()->inGroup('payroll') &&
            !auth()->user()->inGroup('admin')
        ) {
            return redirect()->to('login');
        }

        $data = $this->request->getPost();

        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Invalid ID.'
            ]);
        }

        $this->db->transException(true)->transStart();

        // 🔎 Check if record exists and active
        $record = $this->db->table('tbllookup_signatory')
            ->where('id', $data['id'])
            ->where('IsActive', 1)
            ->get()
            ->getRow();

        if (!$record) {
            throw new \Exception('Signatory not found or already inactive.');
        }

        // 🗑 Soft delete
        $this->db->table('tbllookup_signatory')
            ->where('id', $data['id'])
            ->update([
                'IsActive'     => 0
            ]);

        // 📝 Activity log
        $this->db->table('tblactivity')->insert([
            'Module'         => 'Signatory',
            'Description'    => 'Deleted Signatory Master Data',
            'ActionType'     => 'DELETE',
            'ReferenceID'    => $data['id'],
            'ReferenceTable' => 'tbllookup_signatory',
            'CreatedBy'      => auth()->user()->id,
            'CreatedWhen'    => date('Y-m-d H:i:s'),
            'CreatedWhere'   => $this->request->getIPAddress(),
        ]);

        $this->db->transComplete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Signatory deleted successfully.'
        ]);
    }
}