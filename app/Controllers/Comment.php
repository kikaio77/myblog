<?php

namespace App\Controllers;

class Comment extends BaseController 
{   
    public function list($postId)
    {
        $session = session();
        $userId = $session->has('user') ? $session->get('user')->id : null;
        
        $commentModel = model('comment');

        $commentsByPost = $commentModel->listByPost($postId);
    
        foreach ($commentsByPost as &$comment) {
            $comment->isWriter = $comment->uid === $userId;
            if ($comment->deleted_at) {
                $comment->text = '삭제된 덧글입니다.';
                $comment->nick = '';
            } else {
                $comment->text = esc($comment->text);
            }

        }

        return $this->response->setJSON(['error' => false, 'comments' => $commentsByPost]);
    }
    public function new()
    {
        $session = session();
        $inputs = $this->request->getJSON(true);

        $commentModel = model('comment');

        $result = ['error' => false, 'message' => '성공'];

        $data['post_id'] = $inputs['post_id'];
        $data['text'] = $inputs['text'];
        $data['user_id'] = $session->get('user')->id;
        
        if (! $commentModel->save($data)) {
            $result['error'] = true;
            $result['message'] = '실패';
            return $this->response->setJSON($result);
        }
      
        $comments = $commentModel->listByPost($data['post_id']);

        foreach ($comments as &$comment) {
            $comment->isWriter = $comment->uid === $data['user_id'] ? true : false;
            $comment->text = esc($comment->text);
        }
        $result['comments'] = $comments;
        return $this->response->setJSON($result);
    }

    public function drop()
    {
        $session = session();
        $inputs = $this->request->getJSON();

        $commentModel = model('comment');
        $result = ['error' => false, 'message' => '성공'];

        if (! $commentModel->delete($inputs->idx)) {
            $result['error'] = true;
            $result['message'] = '실패';
        }

        return $this->response->setJSON($result);
    }

    public function modify()
    {
        $session = session();
        $inputs = $this->request->getJSON();
        $commentModel = model('comment');
        
        $result = [ 'error' => false, 'message' => '성공!'];

        if (! $commentModel->update($inputs->idx, ['text' => $inputs->text])) {
            $result['error'] = true;
            $result['message'] = '실패';
            return $this->response->setJSON($result);
        }
        $result['text'] = esc($inputs->text);
        return $this->response->setJSON($result);
    }
}