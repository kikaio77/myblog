<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model 
{
    protected $primaryKey = 'id';
    protected $table = 'posts';
    protected $allowedFields = ['category_id', 'title', 'content', 'views', 'is_secret'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $returnType = 'object';


    public function getPostCountByCategory($isAdmin)
    {   
		$addWhere = '';
		$bindValues = [];
		
		if (!$isAdmin) {
			$addWhere = "AND c.is_secret = ?";
			$bindValues[] = 0;
		}
		
        $sql = "SELECT 
					c.id, c.name, COUNT(p.id) AS count
				FROM categories AS c 
					LEFT JOIN posts AS p 
						ON c.id = p.category_id
							AND p.deleted_at IS NULL
				WHERE c.deleted_at IS NULL
					{$addWhere}
				GROUP BY c.id, c.name
				ORDER BY c.name ASC";

        return $this->db->query($sql, $bindValues)->getResult();
    }

}
