<?php
/**
 * @author Luiz Carlos Wagner <luizcarloswagner@gmail.com>
 */

/**
 * Checar se um valor existe em uma array (multidimensional).
 * Procura em $haystack o valor $needle
 * Caso $needle um conjunto de valores (array), caso na consulta um dos valores nao existir, deixa de continuar a consulta e retorna FALSE
 * @param mixed $needle Valor a procurar. pode ser uma array @example 'ok' ou array('ok', 'list', 'news')
 * @param type $haystack Array base
 * @param type|bool $caseInsensitive  TRUE não diferencia maiúsculas e minúsculas
 * @param type|bool $strict TRUE checa o tipo de $needle também
 * @return bool
 */
function in_array_recursive($needle, array $haystack, $caseInsensitive=false, $strict=false) 
{
	if (is_array($needle) && (bool)$needle) {
		foreach ($needle as $value) {
			if(!in_array_recursive($value, $haystack, $caseInsensitive, $strict)) return false;
		}
		return true;
	}

	foreach ($haystack as $item) {
		
		if (($strict ? $item === $needle : $item == $needle) ||
			$caseInsensitive && !$strict && !is_array($item) && strcasecmp($needle, $item) === 0 ||
			is_array($item) && in_array_recursive($needle, $item, $caseInsensitive, $strict))  return true;
	}
	return false;		
}