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

$rules = [
    'email' => 'required|valid_email',
    'password' => 'required|min_length[8]|max_length[16]',
];

$messages = [
    'email' => [
        'required' => '이메일은 반드시 필수 값입니다.',
        'valid_email' => '형식이 올바르지 않습니다.'
    ],
    'password' => [
        'required' => '비밀번호를 입력해주세요.',
        'min_length' => '최소 8자이상 입니다.',
        'max_length' => '최대 16자 입니다.'
    ],
];

if (!$this->validateData($inputs, $rules, $messages)) {
    $firstErrKey =  array_key_first($this->validator->getErrors());
    return redirect()->back()->with('error', $this->validator->getErrors()[$firstErrKey]);
}
$validInputs = $this->validator->getValidated();

$user = $userModel->where('email', $validInputs['email'])->first();

        if (! $user) {
            return redirect()->back()->with('error', '아이디 혹은 비밀번호가 일치하지 않습니다.');
        }

        if (! password_verify($validInputs['password'], $user->password)) {
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