<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'blog_posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'images'];

    protected $validationRules = [
        'title'   => 'required|max_length[255]',
        'content' => 'permit_empty',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Post title is required.',
        ],
    ];
}
