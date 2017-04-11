<?php 
 /**
 * Fucntion
 * Definir caminho correto | caminhoLocal e caminhoServidor
 * @param string $localPath path do LocalHost  ex: /data/site  | /data/site/index.html
 * @param string $serverPath path do Servidor  ex: /server/test/site  | /server/test/site/index.html
 * @param bool $isServer //true: retorna o caminho do servidor |false: retorna o caminho versao URI
 * @param string $nameHost 
 * @param bool $dirRoot 
 * @return string
 */
 function current_path( $localPath='', $serverPath='',  $nameHost='', $isServer=true  ,  $dirRoot=true )
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
 * Fucntion
 * Saber a URI correta 
 * @subpackage subpackagename function::currentPath()
 * @param string $localPath path do LocalHost  ex: /data/site  | /data/site/index.html
 * @param string $serverPath path do Servidor  ex: /server/test/site  | /server/test/site/index.html
 * @param string $nameHost Nome do Host. default: $_SERVER[HTTP_HOST]  ex: www.edxample.com
 * @return string ex: http://www.example.com/data/site | http://www.example.com/data/site/index.html
 */
function current_uri( $localPath='',  $serverPath='',  $nameHost='')
{
	return currentPath($localPath, $serverPath, false, $nameHost);
}
