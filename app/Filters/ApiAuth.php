<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = $request->getHeaderLine('Authorization');

        if (empty($token) || !str_starts_with($token, 'Bearer ')) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['status' => 'error', 'message' => 'Missing or invalid authorization header.']);
        }

        $token = substr($token, 7);

        $db = db_connect();
        $admin = $db->table('admins')->where('api_token', $token)->get()->getRowArray();

        if (!$admin) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['status' => 'error', 'message' => 'Invalid API token.']);
        }

        $request->admin = $admin;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after
    }
}
