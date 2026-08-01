<?php

namespace App\Models;

class TemporaryPost extends \CodeIgniter\Model 
{
	protected $table = 'temporary_posts';
	protected $allowedFields = ['title', 'content'];
	protected $useSoftDeletes = true;
	protected $useTimestamps = true;
	protected $returnType = 'object';

}