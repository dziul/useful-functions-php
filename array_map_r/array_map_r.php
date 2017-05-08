<?php
/**
 * @author Luiz Carlos Wagner <luizcarloswagner@gmail.com>
 */


/**
 * Array Map Recursive|Multidimencional. Tambem Multi callback. Chave&Valor
 * @param type $callback unico ou array de callback
 * @param array $array Array base
 * @param type|bool $alsoTheKey TRUE ira afetar tambem a chaves
 * @return array Array modificada
 */
function array_map_r($callback, array $array, $alsoTheKey=false)
{
	$callback = (array)$callback; //force to array
	$result = [];
	foreach ($array as $key => $value) {

		if(is_array($callback)) {
			foreach ($callback as $fn) {
				if ($alsoTheKey) $key = $fn($key);
			}
		}

		if (is_array($value)) $result[$key] = array_map_r($callback, $value, $alsoTheKey);
		else {
			for ($i=0, $c = count($callback); $i < $c; $i++) { 
				$value = $callback[$i]($value);
			}
			$result[$key] = $value;
			
		}
	}
	return $result;
}