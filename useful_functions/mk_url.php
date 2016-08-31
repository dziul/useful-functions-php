<?php
/**
 * Montar uma URL
 * @uses $_SERVER['HTTP_HOST']
 * @link http://php.net/manual/pt_BR/reserved.variables.server.php Doc PHP ref: $_SERVER
 * @link http://php.net/manual/pt_BR/function.strrpos.php Doc PH`P ref: function.strrpos
 * @link http://php.net/manual/pt_BR/function.strtolower.php Doc PH`P ref: function.strtolower
 * @param string $localPath Pasta do arquivo no servidor local
 * @param string $serverPath Pasta do arquivo no servidor. default:null
 * @param string|null $nameHost O nome host do servidor onde o script atual é executado. default localServer => localhost/
 * @return string
 */
function mk_url($localPath, $serverPath=null, $nameHost=null)
{
	$path = $serverPath;
	if($_SERVER['SERVER_NAME'] == 'localhost') $path = $localPath;

	if( !$nameHost )
	{
			$protocol = is_numeric(strrpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https')) ? 'https://':'http://';
			$nameHost = $protocol . $_SERVER['HTTP_HOST']; // montar url
	}

	// if( !$path ) $path = '';
	return  $nameHost . $path;
}



//para projetos que precisam utilizar pasta distintas quando está local e quando está na web