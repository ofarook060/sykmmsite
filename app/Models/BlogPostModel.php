<?php
namespace App\Models;
use CodeIgniter\Model;

class BlogPostModel extends Model {
    protected $table = 'blog_posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'images'];
}

