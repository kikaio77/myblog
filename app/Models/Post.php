<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model 
{
    protected $primaryKey = 'id';
    protected $table = 'posts';
    protected $allowedFields = ['category_id', 'title', 'content', 'views'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $returnType = 'object';


    public function getPostCountByCategory()
    {   
        $sql = "SELECT
                    c.id, c.name, COUNT(p.id) AS count  
                FROM categories AS c
                LEFT JOIN posts AS p
                    ON c.id = p.category_id
                GROUP BY c.id, c.name";

        return $this->db->query($sql)->getResult();
    }

}
