<?php

namespace App\Controllers;

use App\Models\Post;

class Category extends BaseController
{
    public function list($categoryName = null) 
    {
        $db = db_connect();

        $builder = $db->table('posts');

        $builder->select('posts.id, posts.category_id, posts.title, posts.content, posts.views, posts.created_at, categories.id as category_id, categories.name')
                ->join('categories', 'posts.category_id = categories.id');

        if ($categoryName) {
            $builder->where('categories.name', $categoryName);
        }
        $builder->where('posts.deleted_at IS NULL')
                ->orderBy('posts.id', 'DESC');
        $postCnt = $builder->countAllResults(false);

        $query = $builder->get()->getResult();

        log_message('error', (string) $db->getLastQuery());

        $data['title'] = $categoryName;

        $data['count'] = $postCnt;
        $data['posts'] = $query;

        return view('posts', $data);
    }
}