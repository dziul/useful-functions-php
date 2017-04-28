<?php
//function a_array_rand  [a_ = alternative]

/**
 * Retornar um ou mais elementos aleatórios de um array. Possibilidade de preservar a chave
 * @param array $array Array
 * @param type $limit Quantos itens deseja retornar 
 * @param type|bool $preserve_keys TRUE preserva a chave. FALSE é o padrão.
 * @return array 
 */
function a_array_rand(array $array , $limit = 1, $preserve_keys = false )
{
	if (!$preserve_keys) {
		shuffle($array);
	    $r = [];//init
	    for ($i = 0; $i < $limit; $i++) $r[] = $array[$i];
	    return $limit == 1 ? [$r[0]] : $r;
	}

	$keys = array_keys($array);
	shuffle($keys);	
	$new = [];
	foreach ($keys as $key) $new[$key] = $array[$key];
	return array_slice($new, 0, $limit, true);
}