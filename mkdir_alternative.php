<?php

/**
 * Criar um Diretório | Modo alternativo
 * @param type $pathname caminho do diretorio 
 * @param type|bool $recursive Ativar modo recursivo. Default:FALSE
 * @param type|int $mode Permissão de escrita/leitura, default: 0777 (acesso mais abrangente possível) mais detalhe: http://php.net/manual/pt_BR/function.chmod.php
 * @return bool Se tudo ocorrer bem, retorna TRUE, caso ao contrário FALSE
 */
function mkdir_alternative($pathname, $recursive=false, $mode=0777)
{
	if(is_dir($pathname)) return true; // ok é diretorio


		$parentPath = dirname($pathname);
		
		$return = false; //default
		if($recursive) $return =  mkdir_alternative($parentPath); //caso for true, opera em recursivo

		if(!$recursive && is_writable($parentPath) || $return && is_writable($parentPath))
		{

			mkdir($pathname);
			return chmod($pathname, $mode);
		}

		return false;

}

// Criar Diretorio caso não exista ===================================