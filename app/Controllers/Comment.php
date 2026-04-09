<?php

namespace App\Controllers;

class Comment extends BaseController 
{
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

        return $this->response->setJSON($result);
    }
}