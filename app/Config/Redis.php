<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Redis extends BaseConfig
{
    public string $host = '127.0.0.1';
    public int $port = 6379;
    public string $password = 'tmddb1006';
    public int $timeout = 0;
}