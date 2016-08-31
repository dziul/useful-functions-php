<?php

/**
 * Shuffle alternativo | Mater as chaves
 * @param type &$array 
 * @return bool
 */
function shuffle_alternative(&$array)
{
    $keys = array_keys($array);

    shuffle($keys);

    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }

    $array = $new;

    return true;
}