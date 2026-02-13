<?php

namespace App\Controllers;

use CodeIgniter\Shield\Models\UserModel;
use App\Models\UserInfoModel;
use CodeIgniter\Shield\Authentication\Passwords;

class User extends BaseController
{
    protected $db;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
        $this->validation = \Config\Services::validation();
    }

    public function getIndex()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $user = auth()->user();
        

        // Get user profile data
        $builder = $this->db->table('users u')
            ->select('i.id, i.first_name, i.last_name, i.Office, i.email, i.phone, i.GSISBPNumber')
            ->join('users_info i', 'u.ecode = i.ecode', 'left')
            ->where('u.id', $user->id)
            ->limit(1);
        
        $data = [
            'userp' => $builder->get()->getResult(),
            'message' => $this->session->getFlashdata('message') ?? validation_errors(),
            'min_password_length' => config('Auth')->minimumPasswordLength,
            'old_password' => [
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            ],
            'new_password' => [
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . config('Auth')->minimumPasswordLength . '}.*$',
            ],
            'new_password_confirm' => [
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . config('Auth')->minimumPasswordLength . '}.*$',
            ],
            'user_id' => [
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            ],
            'Title' => 'USER PROFILE',
            'SubTitle' => 'Information'
        ];

        return view('main', ['view_file' => 'userprofile'] + $data);
    }

    public function save()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $user = auth()->user();
        $userModel = new UserModel();

        // Validate unique email
        $existingEmail = $this->db->table('users')
            ->where('email', $this->request->getPost('email'))
            ->where('id !=', $user->id)
            ->get()
            ->getRow();

        if ($existingEmail) {
            return redirect()->to('User')->with('message', 'Invalid/Duplicate Email Address!');
        }

        // Validate unique phone
        $existingPhone = $this->db->table('users')
            ->where('phone', $this->request->getPost('phone'))
            ->where('id !=', $user->id)
            ->get()
            ->getRow();

        if ($existingPhone) {
            return redirect()->to('User')->with('message', 'Invalid/Duplicate Phone Number!');
        }

        // Update user
        $userModel->update($user->id, [
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ]);

        // Log activity
        $activityData = [
            'ReferenceID' => $user->id,
            'Type' => 'UPDATE',
            'CreatedBy' => $user->id,
            'CreatedWhen' => date('Y-m-d H:i:s'),
            'CreatedWhere' => $this->request->getIPAddress()
        ];

        // Log phone update
        $this->db->table('activitylog')->insert($activityData + [
            'Description' => 'MOBILE NUMBER',
            'Col1' => $this->request->getPost('phone')
        ]);

        // Log email update
        $this->db->table('activitylog')->insert($activityData + [
            'Description' => 'EMAIL ADDRESS',
            'Col1' => $this->request->getPost('email')
        ]);

        return redirect()->to('User');
    }

    public function forgotPassword()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('dashboard');
        }

        return view('auth/forgot_password');
    }

    public function resetPassword()
    {
        $validation = $this->validation;
        $validation->setRules([
            'token' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $users = model(UserModel::class);
        $user = $users->where('email', $this->request->getPost('email'))
            ->first();

        if ($user === null) {
            return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
        }

        // Check token
        if (!$users->checkResetToken($user, $this->request->getPost('token'))) {
            return redirect()->back()->with('error', lang('Auth.resetTokenExpired'));
        }

        // Reset password
        $users->update($user->id, [
            'password_hash' => service('passwords')->hash($this->request->getPost('password')),
            'reset_hash' => null,
            'reset_at' => null,
            'reset_expires' => null,
        ]);

        return redirect()->to('login')->with('message', lang('Auth.passwordResetSuccess'));
    }

    public function check_positive($value)
    {
        if ($value < 0) {
            $this->validation->setError('check_positive', 'The field must not be negative.');
            return false;
        }
        return true;
    }
}