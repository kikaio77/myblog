<?php

namespace App\Cells;

use DateTime;

class VisitorCountCell
{
    public function view(): string
    {
        $redis = service('redis');
        $redis = \Config\Services::redis(true);

        $now = new DateTime();

        $todayVisitors = (int) $redis->get('day:' . $now->format('Y-m-d')) ?? 0; 
        $monthVisitors = (int) $redis->get('month:' . $now->format('Y-m')) ?? 0;

        return "<li class='visitor-views row d-grid gap-1 mb-3 px-2'>
                    <div class='d-flex'>
                        <span>Today: </span><span class='ms-auto'>" . number_format($todayVisitors) ."</span>
                    </div>
                    <div class='d-flex'>
                        <span>Month: </span><span class='ms-auto'>" . number_format($monthVisitors) . "</span>
                    </div>
                </li>";

    }
}