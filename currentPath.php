<?php 
 /**
 * Definir caminho correto | caminhoLocal e caminhoServidor
 * @param string $localPath path do LocalHost  ex: /
 * @param string $serverPath path do Servidor
 * @param bool $isServer 
 * @param string $nameHost 
 * @param bool $dirRoot 
 * @return string
 */
 function currentPath( $localPath='', $serverPath='',  $isServer=true,  $nameHost='',  $dirRoot=true )
 {

 	$rootDirectory = $_SERVER['CONTEXT_DOCUMENT_ROOT']; // diretorio ROOT

 	$isLocalHost = $_SERVER['SERVER_NAME'] == 'localhost';

 	$path = $isLocalHost ? $localPath : $serverPath;


 	//caminho servidor ===
 	if($isServer)
 	{
 		if(!$dirRoot) return $path;
 		return $rootDirectory . $path;
 	}
 	//END caminho servidor ===
 	
 	//se não for será HOST "URL" ex: http://www.example.com/{{path}}
 	
 	if( empty($nameHost) ) $nameHost = $_SERVER['HTTP_HOST']; // pega o nameHost atual ex: www.example.com  || $_SERVER['SERVER_NAME'] => pega o nome real
 	$protocol = is_numeric(strrpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https')) ? 'https://':'http://'; // saber o protocolo atual
 	return $protocol . $nameHost . $path; // outset ex: http://www.example.com/path/hola_mundo


 }

/**
 * Saber a URI 
 * @subpackage subpackagename function::currentPath()
 * @param string $localPath 
 * @param string $serverPath 
 * @param string $nameHost 
 * @return string
 */
function currentURI( $localPath='',  $serverPath='',  $nameHost='')
{
	return currentPath($localPath, $serverPath, false, $nameHost);
}