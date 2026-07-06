<?php 

namespace App\Libraries;

use Override;

class NaverAuthHandler extends SocialAuthHandler
{
    protected string $service = 'naver';

    #[Override]
    public function getAccessToken(array $params): ?string
    {
        $params['client_id'] = $this->clientId;
        $params['client_secret'] = $this->clientSecret;

        $url = 'https://nid.naver.com/oauth2.0/token?' . http_build_query($params);

        $res = \Config\Services::curlrequest()->get($url);

        return $res->getStatusCode() === 200 ? json_decode($res->getBody())->access_token ?? null : null;
    }

    #[Override]
    public function getUserInfo(string $accessToken): ?object
    {
        $res = \Config\Services::curlrequest()->get(  'https://openapi.naver.com/v1/nid/me', ['headers' => ['Authorization' => 'Bearer ' . $accessToken]]);

        return $res->getStatusCode() === 200 
            ? json_decode($res->getBody())->response ?? null 
            : null;
    }
}