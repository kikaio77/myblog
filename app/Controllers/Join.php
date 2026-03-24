<?php

namespace App\Controllers;

class Join extends BaseController
{   
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }
    public function index()
    {
        if ($this->session->has('user')) {
            return redirect('/main');
        }
       return view('join');
    }

    public function submit()
    {   
        $data = $this->request->getPost();

        $userModel = model('user');

        if ($userModel->save($data) === false) {
            $firstErrKey = array_key_first($userModel->errors());
            return redirect()->back()->withInput()->with('error', $userModel->errors()[$firstErrKey]);
        }
        return redirect('/')->with('message', '회원가입이 완료되었습니다.');
    }
}