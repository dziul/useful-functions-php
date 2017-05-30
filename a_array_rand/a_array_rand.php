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

	$keys = array_keys($array);
	shuffle($keys);	
	$new = [];
	$i = 0;
	foreach ($keys as $key) {
		if($i >= $limit) {
			break;
		}

		if(!$preserve_keys) {
			$new[$i] = $array[$key];	
		} else {
			$new[$key] = $array[$key];	
		}
		
		$i++;
	}
	return $new;
}