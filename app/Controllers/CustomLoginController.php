<?php

namespace App\Controllers;

use CodeIgniter\Shield\Controllers\LoginController;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Models\UserModel;

class CustomLoginController extends LoginController
{
    public function login()
    {
        $request = service('request');
        $email = $request->getPost('email');
        $password = $request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (! $user) {
            return $this->fail(['error' => 'Invalid email or password.']);
        }

        $hashedPassword = $user->password_hash;

        // 1️⃣ Try Shield's built-in verifier first
        if (Passwords::verify($password, $hashedPassword)) {
            return $this->successfulLogin($user);
        }

        // 2️⃣ Try old Ion Auth bcrypt hash
        if (password_verify($password, $hashedPassword)) {
            // ✅ Password matches Ion Auth hash → rehash using Shield's default (Argon2id)
            $newHash = password_hash($password, PASSWORD_ARGON2ID);
            $user->password_hash = $newHash;
            $userModel->update($user->id, ['password_hash' => $newHash]);

            return $this->successfulLogin($user);
        }

        // ❌ Invalid password
        return $this->fail(['error' => 'Invalid email or password.']);
    }

    /**
     * Handle successful login.
     */
    protected function successfulLogin($user)
    {
        auth()->login($user);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Login successful',
            'user'    => [
                'id'    => $user->id,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Handle failed login attempt.
     */
    protected function fail($data)
    {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => $data['error'],
        ]);
    }
}
?>