<?php

/**
 * Array Map Recursive|Multidimencional. Tambem Multi callback. Chave&Valor
 * @param type $callback unico ou array de callback
 * @param array $array Array base
 * @param type|bool $alsoTheKey TRUE ira afetar tambem a chaves
 * @return array Array modificada
 */
function array_map_recursive($callback, array $array, $alsoTheKey=false)
{
	$result = [];
	foreach ($array as $key => $value) {
		if (is_array($value)) $result[$key] = array_map_recursive($callback, $value);
		else {
			if (!is_array($callback)) {
				if ($alsoTheKey) $key = $callback($key);
				$result[$key] = $callback($value);
				continue;
			}

			for ($i=0, $c = count($callback); $i < $c; $i++) { 
				if ($alsoTheKey) $key = $callback[$i]($key);
				$value = $callback[$i]($value);
			}
			$result[$key] = $value;
			
		}
	}
	return $result;
}