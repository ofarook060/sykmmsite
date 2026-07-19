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
            $token = bin2hex(random_bytes(32));

            $model->update($admin['id'], ['api_token' => $token]);

            return $this->respond([
                'status' => 'success',
                'data' => [
                    'username' => $admin['username'],
                    'token'    => $token,
                ],
            ]);
        }

        return $this->failUnauthorized('Invalid credentials');
    }
}
