<?php

if (! function_exists('timeAgoForTimeStamp')) {
	function timeAgoForTimeStamp($compareTimeStamp, $nowStamp = null) {
		$nowTimeStamp = $nowTimeStamp ?? time();
		
		$diff = $nowTimeStamp - $compareTimeStamp;
		
		if ($diff < 60) {
			return $diff . '초 전';
		} elseif ($diff < HOUR) {
			return ((int)($diff / 60)) . '분 전';
		} elseif ($diff < DAY) {
			return ((int)($diff / HOUR)) . '시간 전';
		} else {
			return ((int) ($diff / DAY)) . '일 전';
		}
	}
}