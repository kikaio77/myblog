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

            $redis = new \Redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->auth('tmddb1006');
            
            $views = $redis->hget("$uuid:blog_views", $id);
            
            $data['post'] = $postModel->find($id);
            $data['pager'] = null;
            if (! $views) {
                $redis->hset("{$uuid}:blog_views", $id, 1);
                $postModel->update($id, ['views' => $data['post']->views + 1]);
            }

            $returnView = 'postDetail';
        } else {
           log_message('error', $postModel->pager);
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

        $data['content'] = $purifier->purify($data['content']);
        
        $postModel = model('post');

        $postModel->save($data);

        return redirect()->route("posts.list", [$id]);

    }

    public function new()
    {
        $purifier = new HTMLPurifier();

        $data = $this->request->getPost();

        $data['content'] = $purifier->purify($data['content']);

        $postModel = model('post');

        $postModel->insert($data);

        return redirect()->to('/main');

    }
}