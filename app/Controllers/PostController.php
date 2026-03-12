<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Category;

class PostController extends BaseController
{
    public function list($id = null)
    {
        $postModel = model('post');

        if ($id) {
            $data['post'] = $postModel->find($id);
            $returnView = 'postDetail';
        } else {
            $data['posts'] = $postModel->findAll();
            $returnView = 'main'; 
        }

        return view($returnView, $data);
    }


    public function form($id = '')
    {   
        $categoryModel = model('category');
        $postModel = model('post');

        log_message('error', print_r($id, true));

        if ($id) {
            $data['post'] = $postModel->find($id); 
            $data['form']['method'] = 'PUT';
            $data['form']['action'] = "/posts/{$id}";

        } else {
            $data['form']['method'] = 'POST';
            $data['form']['action'] = "/posts";
        }

        $data['categories'] = $categoryModel->findAll();
        
        return view('writeForm', $data);
    }

    public function update($id)
    {
        log_message('error', print_r($this->request->getPost(), true));
        
    }
}