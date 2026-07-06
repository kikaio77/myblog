<?php

namespace App\Libraries;

use App\Interfaces\SocialAuthInterface;
use Override;

abstract class SocialAuthHandler implements SocialAuthInterface
{
	protected string $service;
	protected string $clientId;
	protected string $clientSecret;

	public function __construct($clientId, $clientSecret) 
	{
		$this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
	}

	#[Override]
	public function loginOrRegister(string $serviceKey): array
	{	
		$result = ['success' => true, 'redirect' => '/', 'user' => null , 'message' => ''];

		$db = \Config\Database::connect();

		$linked = $db->table('social_linked_users AS su')
					->select('uid AS id')
					->where('service', $this->service)
					->where('service_uniq_key', $serviceKey)
					->get()
					->getRow();

		// 로그인 처리
		if ($linked) {
			$user = $db->table('users')
						->select('id, nick, is_admin')
						->where('id', $linked->id)
						->get()
						->getRow();

			$user->service = $this->service;

			$result['redirect'] = '/';
			$result['user'] = $user;
			
			return $result;
		}

		$userData = ['nick' => $this->service . '_' . date('YmdHis')];

		//트랜잭션 시작
		$db->transBegin();

		$db->table('users')->insert($userData);

		$newUserId = $db->insertID();

		if (! $newUserId) {
			$db->transRollback();
			$result['success'] = false;
			$result['redirect'] = '/login/form';
			$result['message'] = '소셜 아이디 회원가입에 실패했습니다.';

			return $result;
		}

		$socialData = ['uid' => $newUserId, 'service' => $this->service, 'service_uniq_key' => $serviceKey];

		if (! $db->table('social_linked_users')->insert($socialData)) {
			$db->transRollback();

			$result['success'] = false;
			$result['redirect'] = '/login/form';
			$result['message'] = '소셜 아이디 회원가입에 실패했습니다.';

			return $result;
		}

		$db->transCommit();

		return $result;
	}
}