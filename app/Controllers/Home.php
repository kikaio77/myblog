<?php

namespace App\Controllers;

use App\Models\Post;

class Home extends BaseController
{
    public function index(): string
    {
        $postModel = model('post');

        $posts = $postModel->orderby('id', 'DESC')->findAll();
        $postsCnt = $postModel->countAll();
        
        foreach ($posts as $idx => &$row) {
            $row->no = $postsCnt - $idx;
        }
        
        $data['posts'] = $posts;
        $data['postCnt'] = $postsCnt;

        return view('main', $data);
    }

    public function profile(): string
    {
        return view('profile');
    }

    public function portfolio(): string
    {
        return view('portfolio');
    }

    
}
