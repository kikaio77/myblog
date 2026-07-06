<?php

namespace App\Controllers;

use App\Libraries\NaverAuthHandler;
use DateInterval;
use DateTime;

class OAuth extends BaseController
{   
	private $session;

	private array $handler = [
		'naver' => NaverAuthHandler::class,
	];

	public function __construct()
	{
		$this->session = session();
	}
	public function social($service)
	{   
		if (! isset($this->handler[$service])) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($_ENV['error.message.404']);
		}

		$handler = new $this->handler[$service]($_ENV["{$service}.client.id"], $_ENV["{$service}.client.secret"]);

		switch ($service) {
			case 'naver':
				$params = [
					'grant_type'    => 'authorization_code',
					'redirect_uri'  => urlencode(config('App')->baseURL . 'oauth/social/naver'),
					'code'          => $this->request->getGet('code') ?? '',
					'state'         => $this->request->getGet('state') ?? '',
				];
				break;
		}

		$accessToken = $handler->getAccessToken($params);
		
		$userInfo = $handler->getUserInfo($accessToken);
	
		$attemptRes =  $handler->loginOrRegister($userInfo->id);

		log_message('error', print_r($attemptRes, true));
		if (! $attemptRes['success']) {
			return redirect()->to($attemptRes['redirect'])->with('error', $attemptRes['message']);
		}

		$this->session->set('user', $attemptRes['user']);

		return redirect()->to($attemptRes['redirect']);
	} 

}