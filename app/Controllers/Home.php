<?php

namespace App\Controllers;

use App\Models\Post;

class Home extends BaseController
{
    public function index(): string
    {   
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('tmddb1006');

        $todayVisitors = $redis->rawCommand('PFCOUNT', 'today:visitors');

        $page = $this->request->getGet('page') ?? 1;
        $postModel = model('post');

        $postsCnt = $postModel->countAll();

        $posts = $postModel->orderby('id', 'DESC')->paginate(1);
        
        $no = 1;

        foreach ($posts as $idx => &$row) {
            $row->no = $no;
            $no++;
        }
        
        log_message('error', print_r($posts, true));

        
        $data['posts'] = $posts;
        $data['postCnt'] = $postsCnt;
        $data['pager'] = $postModel->pager;
        $data['todayVisitors'] = $todayVisitors;
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
