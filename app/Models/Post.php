<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model 
{
    protected $primaryKey = 'id';
    protected $table = 'posts';
    protected $allowedFields = ['category_id', 'category_name', 'title', 'content'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $returnType = 'object';

}
