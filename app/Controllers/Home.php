<?php

namespace App\Controllers;

use App\Models\Post;

class Home extends BaseController
{
    public function index(): string
    {   
        $page = $this->request->getGet('page') ?? 1;
        $postModel = model('post');

        $postsCnt = $postModel->countAll();

        $posts = $postModel->orderby('id', 'DESC')->paginate(10);
        
        $no = 1;

        foreach ($posts as $idx => &$row) {
            $row->no = $no;
            $row->title = empty($row->title) ? '제목없음' : $row->title;
            $no++;
        }
        
        $this->logger->debug('하이');
        $data['posts'] = $posts;
        $data['postCnt'] = $postsCnt;
        $data['pager'] = $postModel->pager;
        
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
