<?php

namespace App\Controllers;

class MyPage extends BaseController
{   
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }

    public function putNick()
    {
        $uid = $this->session->get('user')->id;
        $inputNick = $this->request->getPost('nick');

        $userModel = model('user');

        $dupNickUser = $userModel->where('nick', $inputNick)->first();

        if ($dupNickUser) {
            return $this->response->setJSON(['error' => true, 'message' => '해당 닉네임은 이미 사용중입니다.']);
        }

        $updateData = [ 'nick' => $inputNick ];

        if (! $userModel->update($uid, $updateData)) {
            return $this->response->setJSON(['error' => true, 'message' => '닉네임 변경에 실패했습니다.']);
        }
        
        $changeUser = $this->session->get('user');

        $changeUser->nick = $inputNick;

        $this->session->set('user', $changeUser);

        return $this->response->setJSON(['error' => false , 'message' => '정상적으로 닉네임이 변경되었습니다.']);
    }
}