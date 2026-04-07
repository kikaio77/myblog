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
            log_message('emergency', '없음');
            helper('cookie');

            $redis = service('redis');

            $now = new DateTime();
            $endTime = new DateTime($now->format('Y-m-d') . ' 23:59:59');

            $todayCount = $redis->get('day:' . $now->format('Y-m-d'));
            $monthCount = $redis->get('month:' . $now->format('Y-m'));
            
            if (! $todayCount) {
               $redis->set('day:' . $now->format('Y-m-d'), 1);
            } else {
                $redis->incr('day:' . $now->format('Y-m-d'));
            }

            if (! $monthCount) {
                $redis->set('month:' . $now->format('Y-m'), 1);
            } else {
                $redis->incr('month:' . $now->format('Y-m'));
            }

            $expired = $endTime->getTimestamp() - $now->getTimestamp();

           set_cookie('today_visitor', 'Y', $expired);
        }

    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }

}
