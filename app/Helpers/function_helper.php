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

if (! function_exists('ipWhiteListIpAddr')) {
	function isWhiteListIpAddr(string $ip, array $whiteListIps) {
		return in_array($ip, $whiteListIps);
	}
}

if (! function_exists('calcAgeForKor')) {
	function calcAgeForKor(string $birthDate) {
		$birthDate = new DateTime($birthDate);
		
		$now = new DateTime();
		$birthYear = $birthDate->format('Y');
		
		$thisBirthDate = new DateTime($now->format('Y') . '-' . $birthDate->format('m-d'));
		
		return (int)$now->format('Y') - (int)$birthYear + ((bool) ( $now->getTimeStamp() >= $thisBirthDate->getTimeStamp() ));
	}
}
