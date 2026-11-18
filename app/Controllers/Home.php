<?php

namespace App\Controllers;

use App\Models\Post;

class Home extends BaseController
{
    public function index(): string
    {   
		helper('function');
		
		$session = session();
		
		$user = $session->get('user');
		
        $page = $this->request->getGet('page') ?? 1;
        $postModel = model('Post');
		$offset = $_ENV['app.pagination.offset'];
		
        $postModel->where('deleted_at IS NULL');
		
		$isAdmin = $user && $user->is_admin;
		
		if (!$isAdmin) {
			$postModel->where('is_secret', 0);
		}
		
		$postsCnt = $postModel->countAllResults(false);

        $posts = $postModel->orderby('id', 'DESC')->paginate($offset);
		$now = $_SERVER['REQUEST_TIME'];
		
        foreach ($posts as $idx => &$row) {
            $row->no = $postsCnt - (($page - 1) * $offset) - $idx;

			$row->created_at = timeAgoForTimeStamp(strtotime($row->created_at), $now);
			$row->title = empty($row->title) ? '제목없음' : $row->title;
        }
        
        $data['posts'] = $posts;
        $data['postCnt'] = $postsCnt;
        $data['pager'] = $postModel->pager;
        
        return view('main', $data);
    }

    public function profile(): string
    {	
		helper('function');
		
        return view('profile', [ 'birthDate' =>  $_ENV['profile.birthDate'], 'age' => calcAgeForKor($_ENV['profile.birthDate']) ]);
    }

    public function portfolio(): string
    {
        return view('portfolio');
    }

    
}
