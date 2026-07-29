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

        if (! $request->getCookie('today_visitor')) {
            helper('cookie');

            $redis = service('redis');
	
			$now = new DateTime();
			
            $endTime = new DateTime('tomorrow midnight');
			
			$endTime->modify('+3 minutes');
			
            $todayCount = $redis->get('day:' . $now->format('Y-m-d'));
            
            if (! $todayCount) {
               $redis->set('day:' . $now->format('Y-m-d'), 1);
            } else {
               $redis->incr('day:' . $now->format('Y-m-d'));
            }
			
            $expired = $endTime->getTimestamp() - $_SERVER['REQUEST_TIME'];

            set_cookie('today_visitor', 'Y', $expired);
        }

    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }

}
