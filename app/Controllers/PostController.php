<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends BaseController
{
    public function list($id)
    {
        $postModel = model('post');

        $post = $postModel->find($id);

        $data['post'] = $post;

        return view('postDetail', $data);
    }
}