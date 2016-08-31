<?php

/**
 * Pegar o IP* real do usuário
 * @param bool $encrypted  Criptografar ou não
 * @return string
 */
function user_ip($encrypted=false)
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip_user = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip_user = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip_user = $_SERVER['REMOTE_ADDR'];
		}

		if($encrypted) $ip_user = md5($ip_user); // criptografar
		return $ip_user;
	}