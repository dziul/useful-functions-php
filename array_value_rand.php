<?php



// essa versao ha uma taxa menor de repetições de valores
function array_value_rand(array $array , $limit = 1 )
{
	shuffle($array);
    
    $r = [];//init
    for ($i = 0; $i < $limit; $i++) {
        $r[] = $array[$i];
    }
    return $limit == 1 ? $r[0] : $r;
}

//essa versao ha uma taxa maior de repetições de valores
function array_value_rand_mode_2(array $array , $offset = 1 )
{
	$new = [];//init
	$shuffle = array_rand($array, $offset);

	foreach ($shuffle as $value)
	{
		$new[] = $array[$value];
	}

	return $new;
}




// TEST =============================
// ==================================


$loop = 1000;


$has = 1;
$current;
$index =1; //index para saber repetições
$m = ''; //nom do item
$n = 0; //quantidade de repetição

$begin2 = microtime (true);
for ($i=0; $i < $loop; $i++) { 
	$result = array_value_rand(['a','b','c','d','e','f','g'], 3);

	if($has) {
		$current = $result[$index];
		$m = $current;
		$has=0;
	}

	if($current === $result[$index]) $n++;
}
$end2 = microtime (true);
var_dump($m, $n, $result);
echo 'array_value_rand::: ' . ($end2-$begin2);




echo '<br><br>';

$has = 1;
$index = 0;//index para saber repetições
$current;
$m = ''; //nom do item
$n = 0; //quantidade de repetição
$begin3 = microtime (true);
// var_dump(array_rand_alternative(['a','b','c','d','e','f','g'],5));
for ($i=0; $i < $loop; $i++) { 
	$result = array_value_rand_mode_2(['a','b','c','d','e','f','g'], 3);

	if($has) {
		$current = $result[$index];
		$m = $current;
		$has=0;
	}

	if($current === $result[$index]) $n++;
}
$end3 = microtime (true);
var_dump($m, $n, $result);
echo 'array_value_rand_mode_2::: ' . ($end3-$begin3);
