<?php

/**
 * Diretorio Raiz correto!
 * Caso precise trabalhar offline
 * @example root + path :  C:/www  + /tets/test
 * @param string $localPath  caminho como será/ ou usado local ( localhost )  ex: /teste/2015
 * @param string|null $serverPath caminho como será/ ou usado no servidor   ex: /out/2015. Se não for definido será usado $localPath
 * @param bool $addDirRoot  TRUE é padão. Define se a saida será DIR_ROOT + PATH ou apenas PATH.
 * @return string  saida DIR_ROOT + PATH ou apenas PATH.
 */
function correct_dir_root($localPath, $serverPath=null, $addDirRoot=true)
{

	$dir_root = $_SERVER['CONTEXT_DOCUMENT_ROOT'];
	$dir_root = substr($dir_root , -1) == '/' ? substr($dir_root , 0, -1) : $dir_root; // caso tenha / no final; é removido
	$isLocalHost = $_SERVER['SERVER_NAME'] == 'localhost'; // saber se é localhost 	--> 	true | false
	$serverPath = !$serverPath ?  $localPath : $serverPath; // se for vazio|null 		-->		$localPath | $serverPath
	$dir_root = $isLocalHost ? $dir_root : realpath($dir_root); // saber real path  --> 	localhost | server
	$path = $isLocalHost ? $localPath : $serverPath; // definir path correto   	-->  	localhost | server
	return $addDirRoot ? $dir_root . $path : $path;  //retorna o diretorio completo 	-->		root+path | path
}