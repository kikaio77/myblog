<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Category;
use HTMLPurifier;
use stdClass;

class PostController extends BaseController
{
    public function list($id = null)
    {   
        $postModel = model('post');

        $session = session();
        $data = [];
        if ($id) {
            
            $uuid = session_id();

            $redis = \Config\Services::redis();
            
            $views = $redis->hget("$uuid:blog_views", $id);
            
            $data['post'] = $postModel->find($id);
            $data['pager'] = null;
            if (! $views) {
                $redis->hset("{$uuid}:blog_views", $id, 1);
                $postModel->update($id, ['views' => $data['post']->views + 1]);
            }

            $commentModel = model('comment');

            $data['comments'] = $commentModel->listByPost($id);

            $returnView = 'postDetail';
        } else {
            $data['posts'] = $postModel->paginate(10, 'posts');
            $data['pager'] = $postModel->pager;

           

            $returnView = 'main'; 
        }

        return view($returnView, $data);
    }


    public function form($id = '')
    {   
        $categoryModel = model('category');
        $postModel = model('post');

        $columns = ['id', 'category_id', 'title', 'content', 'views', 'created_at'];

        $data = [];

        if ($id) {
            $data['post'] = $postModel->select($columns)->find($id); 
            $data['form']['method'] = 'PUT';
            $data['form']['action'] = "/posts/{$id}";

        } else {
            $data['post'] = new stdClass();
            foreach ($columns as $column) 
                $data['post']->{$column} = '';
            
            $data['form']['method'] = 'POST';
            $data['form']['action'] = "/posts";
        }

        $data['categories'] = $categoryModel->findAll();
        
        return view('writeForm', $data);
    }

    public function update($id)
    {
        $purifier = new HTMLPurifier();

        $data = $this->request->getVar();
        $data['title'] = empty($data['title']) ? '제목없음' : $data['title'];
        $data['content'] = str_replace('<img ', '<img class="img-fluid" ', $data['content']);
        $data['content'] = $purifier->purify($data['content']);
        
        $postModel = model('post');

        $postModel->save($data);

        return redirect()->route("posts.list", [$id]);

    }

    public function new()
    {
        $rules = [
            'title' => 'required|max_length[40]',
            'content' => 'required',
            'category_id' => 'required|integer'
        ];

        $messages = [
            'title' => [
                'required' => '제목을 입력해주세요.',
                'max' => '제목은 최대 40자 까지 입니다.'
            ],
            'content' => ['required' => '내용은 반드시 입력해야합니다.'],
            'category_id' => [
                'required' => '카테고리를 반드시 선택해주세요.',
                'integer' => '반드시 숫자여야 합니다.'
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            echo print_r($this->validator->getErrors(), true);
            exit;
        }
        $purifier = new HTMLPurifier();

        $data = $this->request->getPost();

        $data['content'] = $purifier->purify($data['content']);

        $postModel = model('post');

        $postModel->insert($data);

        return redirect()->to('/main');

    }
}