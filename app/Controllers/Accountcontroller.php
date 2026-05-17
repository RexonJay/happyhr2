<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\Shield\Models\UserModel;

class Accountcontroller extends BaseController
{
    public function getChangepassword()
    {
        if (!auth()->loggedIn()) {return redirect()->to('/logout');}	
		if (!auth()->user()->inGroup('admin')) {return redirect()->to('/logout');}
		
		$data['Title'] = 'Change Password';
		$data['SubTitle'] = '';
		$data['output'] = null;
		$data['view_file'] = 'change_password';
		$data['device'] = TRUE;
		return view('main', $data);
    }

    public function postUpdatepassword()
    {
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $user = auth()->user();

        // Verify current password
        if (!password_verify(
            $this->request->getPost('current_password'),
            $user->password_hash
        )) {

            return redirect()->back()
                ->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->password = $this->request->getPost('new_password');

        $userModel = model(UserModel::class);
        $userModel->save($user);

        return redirect()->back()
            ->with('success', 'Password changed successfully.');
    }
}