<?php

namespace App\Controllers;

class Login extends BaseController
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

        return view('login');
    }

    public function in()
    {
        if ($this->session->has('user')) {
            return redirect('/');
        }

        $inputs = $this->request->getPost();

        $userModel = model('user');

        $user = $userModel->where('email', $inputs['email'])->first();

        if (! $user) {
            return redirect()->back()->with('error', '아이디 혹은 비밀번호가 일치하지 않습니다.');
        }

       
        if (! password_verify($inputs['password'], $user->password)) {
            return redirect()->back()->with('error', '아이디 혹은 비밀번호가 일치하지 않습니다.');
        }

        $this->session->set('user', $user);

        return redirect('/');
    }

    public function out()
    {
        log_message('error', '이거탐?');
        $this->session->destroy();

        return redirect('/');
    }
}