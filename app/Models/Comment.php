<?php

namespace App\Models;

use CodeIgniter\Model;

class Comment extends Model
{
    public $table = 'comments';
    public $primaryKey = 'id'; 
    public $allowedFields = ['post_id', 'parent_id', 'user_id', 'depth', 'text'];
    public $useSoftDeletes = true;
    public $useTimestamps = true;
 
    public function listByPost($postId) {
        return $this->db->table('comments AS c')
                    ->join('users AS u', 'u.id = c.user_id')
                    ->select('u.id AS uid, u.nick, c.parent_id, c.id AS cid, c.text, c.created_at, c.deleted_at')
                    ->where('post_id', $postId)
                    ->get()
                    ->getResultObject();
    }
}