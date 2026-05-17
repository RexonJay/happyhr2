<?php

namespace App\Controllers;

class Securityquestion extends BaseController
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
        // Shield authentication check
        if (!auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        $user = auth()->user();

        // Login log
        $transaction = [
            'username'   => $user->username,
            'loginwhen'  => date('Y-m-d H:i:s'),
            'loginwhere' => $this->request->getIPAddress(),
            'remarks'    => 'Success',
        ];

        $this->db->table('login_log')->insert($transaction);

        // Check admin group
        if (auth()->user()->inGroup('admin')) {
            return redirect()->to('/main');
        }

        // User Agent Service (replacement for CI3 user_agent library)
        $agent = \Config\Services::request()->getUserAgent();

        if ($agent->isBrowser()) {
            $deviceAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isMobile()) {
            $deviceAgent = $agent->getMobile();
        } else {
            $deviceAgent = 'Unknown';
        }

        $MAC = $deviceAgent . $agent->getPlatform() . $this->request->getIPAddress();

        // Check authorized device
        $device = $this->db->table('tbldevice')
            ->select('id')
            ->where('DeviceMacAddress', $MAC)
            ->where('IsActive', 1)
            ->get()
            ->getRow();

        if ($device) {

            session()->set('DeviceID', $device->id);

            // Check precinct
            $precinct = $this->db->table('tblprecinct')
                ->select('id, PrecinctNumber')
                ->where('OfficeCode', $user->OfficeCode)
                ->where('DeviceID', $device->id)
                ->where('IsActive', 1)
                ->get()
                ->getRow();

            if (!$precinct) {

                // Get correct precinct numbers
                $correctPrecinct = $this->db->table('tblprecinct')
                    ->select("GROUP_CONCAT(PrecinctNumber SEPARATOR ', ') AS PrecinctNumbers", false)
                    ->where('OfficeCode', $user->OfficeCode)
                    ->where('IsActive', 1)
                    ->get()
                    ->getRow();

                $precinctNumbers = !empty($correctPrecinct->PrecinctNumbers)
                    ? $correctPrecinct->PrecinctNumbers
                    : '[UNAVAILABLE]';

                return view('vote_error', [
                    'Heading' => 'Unauthorized Precinct',
                    'Message' => "You are not authorized to vote in this precinct. Please vote to precinct number <b>{$precinctNumbers}</b>. Thank you."
                ]);
            }

            session()->set('PrecinctID', $precinct->id);

            // return redirect()->to('/securityquestion');
            return view('loginquestion');
        } else {

            // Reset security question attempts
            $transaction = [
                'IsSecurityQuestionsPassed' => 0,
                'SecurityQuestionsAttempts' => 0,
            ];

            $this->db->table('users')
                ->where('id', $user->id)
                ->update($transaction);

            return view('loginquestion');
        }
    }

	public function postConfirm()
	{
        if (!auth()->loggedIn()) {

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Session expired'
            ]);
        }

        $user = auth()->user();

        $validation = \Config\Services::validation();

        $id = $user->id;

        $MiddleName = $this->request->getPost('MiddleName');

        $Birthday = $this->request->getPost('Birthday');

        $validation->setRules([
            'Birthday' => 'required',
            'image'    => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $validation->listErrors()
            ]);
        }

        $query = $this->db->query(
            "
            SELECT 1
            FROM users
            WHERE IFNULL(middle_name,last_name) = ?
            AND BirthDate = ?
            AND id = ?
            LIMIT 1
            ",
            [$MiddleName, $Birthday, $id]
        );

        if ($query->getNumRows() > 0) {

            // ✅ SUCCESS
            $this->db->table('users')
                ->where('id', $id)
                ->update([
                    'IsSecurityQuestionsPassed' => 1
                ]);

            $img = $this->request->getPost('image');

            if (!empty($img)) {

                $image_parts = explode(";base64,", $img);

                $image_base64 = base64_decode($image_parts[1]);

                $query2 = $this->db->query(
                    "
                    SELECT 1
                    FROM tblusersvotephoto
                    WHERE ecode = ?
                    LIMIT 1
                    ",
                    [$user->ecode]
                );

                if ($query2->getNumRows() > 0) {

                    $this->db->table('tblusersvotephoto')
                        ->where('ecode', $user->ecode)
                        ->update([
                            'VotePhoto' => $image_base64
                        ]);

                } else {

                    $this->db->table('tblusersvotephoto')
                        ->insert([
                            'VotePhoto' => $image_base64,
                            'ecode'     => $user->ecode
                        ]);
                }
            }

            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Verification successful!',
                'redirect' => site_url('vote')
            ]);

        } else {

            $query = $this->db->query(
                "
                SELECT 1
                FROM users
                WHERE id = ?
                AND SecurityQuestionsAttempts >= 3
                ",
                [$id]
            );

            if ($query->getNumRows() > 0) {

                return $this->response->setJSON([
                    'status'   => 'locked',
                    'message'  => 'Maximum attempts reached!',
                    'redirect' => site_url('/logout')
                ]);

            } else {

                $this->db->table('users')
                    ->set(
                        'SecurityQuestionsAttempts',
                        'IFNULL(SecurityQuestionsAttempts,0)+1',
                        false
                    )
                    ->where('id', $id)
                    ->update();

                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Invalid Middle Name / Birth Date!'
                ]);
            }
        }
	}

	public function loginadmin()
	{
		$data['is_admin_login'] = true;
		$data['message'] = '';
        return view('login', $data);
	}
}
