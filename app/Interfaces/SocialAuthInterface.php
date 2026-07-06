<?php

namespace App\Interfaces;

Interface SocialAuthInterface
{
    public function getAccessToken(array $params): ?string;
    public function getUserInfo(string $accessToken): ?object;
    public function loginOrRegister(string $serviceKey): array;
}