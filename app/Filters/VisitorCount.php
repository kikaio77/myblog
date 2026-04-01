<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class VisitorCount implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('cookie');
        
        $redis = new  \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('tmddb1006');

        if (! has_cookie('today_visitor')) {
        
            $ip = $request->getIPAddress();

            $redis->rawCommand('PFADD', 'today:visitors', $ip);
            
            $now = new DateTime();
            $endTime = new DateTime($now->format('Y-m-d') . ' 23:59:59');
            $expired = $endTime->getTimestamp() - $now->getTimestamp();


            set_cookie('today_visitor', 'Y', $expired, $_SERVER['HTTP_HOST'], '/');
        }

        log_message('error', get_cookie('today_visitor'));

    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }

}
