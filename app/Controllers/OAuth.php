<?php

namespace App\Controllers;

use DateInterval;
use DateTime;

class OAuth extends BaseController
{   
	protected $session;

	public function __construct()
	{
		$this->session = session();
	}
	public function social($service)
	{   
		//
		// 로그인 키를 선언한다.
		//
		$clientId = $_ENV["$service.client.id"] ?? '';
		$clientSecret = $_ENV["$service.client.secret"] ?? '';

		if (! $clientId) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($_ENV['error.message.404']);
		}

		// 네이버 로그인 일때
		if ($service === 'naver') {

			if (isset($this->session->get('user')->service)) {
				return redirect()->to('/');
			}

			$client = \Config\Services::curlrequest();
			$now = time();
			
			// 액세스 토큰 있을때
			if (
				$this->session->has('access_token') 
				&& $this->session->get('expires_in') > $now
			) {
				$loginResult  = $client->get('https://openapi.naver.com/v1/nid/me', ['headers' => [ 'Authorization' => ['Bearer ' . $this->session->get('access_token') ]]]);
				
				if ($loginResult->getStatusCode() !== 200) {
					return redirect()->to('/login/form')->with('error', '로그인에 실패했습니다.');
				}

				$loginInfo = json_decode($loginResult->getBody())->response;
			
				$db = \Config\Database::connect();

				$builder = $db->table('social_linked_users AS su');
				$linked = $builder->select('uid AS id')
						->where('service', $service)
						->where('service_uniq_key', $loginInfo->id)
						->get()
						->getRow();

				// 로그인 처리
				if ($linked) {
					$user = $db->table('users')
								->select('id, nick, is_admin')
								->where('id', $linked->id)
								->get()
								->getRow();

					$user->service = $service;

					$this->session->set('user', $user);

					return redirect()->to('/');
				}
			

				$userData = ['nick' => $service . '_' . date('YmdHis')];

				//트랜잭션 시작
				$db->transBegin();

				$db->table('users')->insert($userData);

				$newUserId = $db->insertID();

				if (! $newUserId) {
					$db->transRollback();
					return redirect()->to('/login/form')->with('error', '소셜 아이디 회원가입에 실패했습니다.');

				}

				$socialData = ['uid' => $newUserId, 'service' => $service, 'service_uniq_key' => $loginInfo->id];

				if (! $db->table('social_linked_users')->insert($socialData)) {
					$db->transRollback();
					return redirect()->to('/login/form')->with('error', '소셜 아이디 회원가입에 실패했습니다.');
				}

				$db->transCommit();

				return redirect()->to('/');
				
			}

			$code = $this->request->getGet('code');
			$state = $this->request->getGet('state');
			$redirectURL = urlencode(config('App')->baseURL . 'oauth/social/naver');

			$querys = [
				'grant_type' => 'authorization_code',
				'client_id'	=> $clientId,
				'client_secret' => $clientSecret,
				'redirect_uri' => $redirectURL,
				'code' => $code,
				'state' => $state
			];

			$url = "https://nid.naver.com/oauth2.0/token?" . http_build_query($querys);


			$tokenResult = $client->get($url);

			if ($tokenResult->getStatusCode() !== 200) {
				return redirect()->to('/login/form')->with('error', '로그인에 실패했습니다.');
			}

			$basicInfo = json_decode($tokenResult->getBody());

			$this->session->set('access_token', $basicInfo->access_token);
			
			$this->session->set('expires_in', time() + $basicInfo->expires_in);

			return redirect()->to('/oauth/social/naver');
		}


	} 

}