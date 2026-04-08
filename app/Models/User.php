<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'users';
    protected $returnType = 'object';
    protected $allowedFields = ['email', 'password', 'nick', 'created_at', 'is_admin'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $beforeInsert = ['hashPassword'];

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]|max_length[16]',
        'password_verify' => 'required_with[password]|matches[password]',
    ];

    protected $validationMessages = [
        'email' => [
            'required' => '이메일은 필수값입니다.',
            'valid_email' => '이메일 형식이 아닙니다.',
            'is_unique' => '이미 가입된 이메일입니다.',
        ],
        'password' => [
            'required' => '비밀번호는 필수값입니다.',
            'min_length' => '비밀번호는 최소 8자 이상입니다.',
            'max_length' => '비밀번호는 최대 16자 이하입니다.'
        ],
        'password_verify' => [
            'required_with' => '비밀번호 확인 값이 존재하지 않습니다.',
            'matches' => '비밀번호와 동일한 값이 아닙니다.',
        ]
    ];

    protected function hashPassword(array $data)
    {   
        if (! isset($data['data']['password'])) {
            return $data;
        }
        
        $data['data']['password']  = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}