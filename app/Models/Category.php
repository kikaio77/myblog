<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name'];
    protected $useTimestamps = true;
    protected $returnType = 'object';
	

	protected $validationRules = [
		'id' => 'permit_empty|is_natural_no_zero',
		'name' => 'required|min_length[1]|max_length[15]|is_unique[categories.name,id,{id}]',
	];
	protected $validationMessages = [
		'name' => [
			'required' => '카테고리명은 필수 입니다.',
			'min_length' => '카테고리명은 최소 1자 이상입니다',
			'max_length' => '카테고리명은 최대 15자 이상입니다',
			'is_unique' => '이미 사용중인 카테고리명입니다.',
		]
	];
	
	public function get() {
		$sql = "SELECT 
					id, name, created_at
				FROM categories
				WHERE deleted_at IS NULL";
			
		return $this->db->query($sql)->getResult();
	}
}