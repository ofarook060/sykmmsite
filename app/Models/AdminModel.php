<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'api_token'];

    protected $validationRules = [
        'username' => 'required|max_length[255]|is_unique[admins.username]',
        'password' => 'required|min_length[8]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'  => 'Username is required.',
            'is_unique' => 'This username is already taken.',
        ],
        'password' => [
            'required'   => 'Password is required.',
            'min_length' => 'Password must be at least 8 characters.',
        ],
    ];
}
