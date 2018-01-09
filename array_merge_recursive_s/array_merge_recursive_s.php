<?php
/**
 * @author http://php.net/manual/pt_BR/function.array-merge-recursive.php#104145
 * @coauthor Luiz Carlos Wagner
 */

function array_merge_recursive_s() {

    $arrays = func_get_args();
    $base = array_shift($arrays);

    foreach ($arrays as $array) {
        if(!is_array($array) || !is_array($base)) {
            trigger_error(__FUNCTION__ .' encountered a non array argument', E_USER_WARNING);
            return;
        }
        reset($base); //important

        while (list($key, $value) = each($array)) {
            if (is_array($value) && isset($base[$key]) && is_array($base[$key])) {
                $base[$key] = array_merge_recursive_new($base[$key], $value);
            } else {
                $base[$key] = $value;
            }
        }
    }

    return $base;
}