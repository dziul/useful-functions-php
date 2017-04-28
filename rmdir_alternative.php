<?php

/**
 * Remover diretorio | Modo alternativo
 * Caso tenha subpastas, será removido também.
 * @param type $directory  Caminho do diretorio
 * @param bool $message_result TRUE: retorna a messagem do resultado (debug simples) | FALSE: retorna o resultado em boolean
 * @return mixed Pode retorna boolean /ou string
 */
function rmdir_alternative($directory, $message_result = false)
{
	$directory = $directory . DIRECTORY_SEPARATOR;

	if(is_dir($directory))
	{


		$recursiveDirIte = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
		$Iterator = new RecursiveIteratorIterator($recursiveDirIte, RecursiveIteratorIterator::CHILD_FIRST);

		foreach($Iterator as $file)
		{
			$file->isFile() ? unlink( $file->getPathname() ) : rmdir( $file->getPathname() );
		}
		
		$result_rmdir =  rmdir($directory);
		if(!$message_result) return $result_rmdir;

		echo 'deletado diretório '. $directory;
		
	}else{
		if(!$message_result) return false;
		echo '<strong>' .$directory. '</strong>, foi removido /ou não existe!';

	}
}
//perigoso usar esta versão ==== usar apenas se ter extremamente que o caminho está correto | caso ao contrário corre o risco de apagar o que não devia
// DELETE_DIR(realpath($_SERVER['CONTEXT_DOCUMENT_ROOT']) . '/paginas/jarvis');

//modo seguro
// rmdir_alternative('paaginas/jarvis');