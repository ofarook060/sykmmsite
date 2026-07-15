<?php

namespace App\Controllers\Api;

use App\Models\AdminModel;

class AdminAuth extends BaseApiController
{
    public function login()
    {
        $model = new AdminModel();
        $input = $this->request->getJSON(true);
        
        $username = $input['username'] ?? null;
        $password = $input['password'] ?? null;

        $admin = $model->where('username', $username)->first();

        if ($admin && password_verify($password, $admin['password'])) {
            // NOTE: Replace 'dummy-token-for-now' with a proper JWT implementation
            return $this->respond([
                'status' => 'success',
                'data' => [
                    'username' => $admin['username'],
                    'token' => 'dummy-token-for-now'
                ]
            ]);
        }

        return $this->failUnauthorized('Invalid credentials');
    }
}
