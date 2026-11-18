<?php

namespace App\Models;

use CodeIgniter\Model;

class SynIp extends Model
{	
	protected $table = 'syn_ips';
	protected $allowedFields = ['ip', 'memo'];
	protected $useTimestamps = true;
	protected $useSoftDeletes =  true;
	protected $returnType = 'object';
	
}