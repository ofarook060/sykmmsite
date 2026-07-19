<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->is('post')) {
            $session = session();
            $model = new AdminModel();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $admin = $model->where('username', $username)->first();

            if ($admin && password_verify($password, $admin['password'])) {
                $session->set(['isAdminLoggedIn' => true, 'username' => $admin['username']]);
                return redirect()->to('/admin/dashboard');
            }
            return redirect()->back()->with('error', 'Invalid login details.');
        }
        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
