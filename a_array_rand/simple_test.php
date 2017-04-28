<?php


require_once 'a_array_rand.php'; // include function a_array_rand()


//essa versao ha uma taxa maior de repetições de valores
function array_value_rand_mode_2(array $array , $limit = 1 )
{
	$new = [];//init
	$shuffle = array_rand($array, $limit);
	foreach ($shuffle as $value) $new[] = $array[$value];
	return $new;
}



// retorna um item aleatorio
// é mais lento que 
function array_rand_only_one(array $array)
{
	$count = count($array) - 1;
	$key = mt_rand(0, $count);
	return $array[$key];
}




// simple test ===
// $arr = [
// 	'type' => 2,
// 	5,
// 	6,
// 	154,
// 	39,
// 	'test' => 'Okay'
// ];
// simple test ===


// var_dump(a_array_rand($arr, 3, true));

// TEST =============================
// ==================================


$loop = 1000;

$has = 1;
$index = 0;//index para saber repetições
$current;
$m = ''; //nom do item
$n = 0; //quantidade de repetição
$begin3 = microtime (true);
for ($i=0; $i < $loop; $i++) { 
	$result = array_rand(['a','b','c','d','e','f','g'], 3);

	if($has) {
		$current = $result[$index];
		$m = $current;
		$has=0;
	}

	if($current === $result[$index]) $n++;
}
$firstResult = $n; //para comparar com o a_array_rand
$end3 = microtime (true);
var_dump($result, $m, $n);
echo 'array_rand::: ' . ($end3-$begin3);



echo "\n\n";



$has = 1;
$index = 0;//index para saber repetições
$current;
$m = ''; //nom do item
$n = 0; //quantidade de repetição
$begin3 = microtime (true);
for ($i=0; $i < $loop; $i++) { 
	$result = array_rand_only_one(['a','b','c','d','e','f','g'], 3);

	if($has) {
		$current = $result[$index];
		$m = $current;
		$has=0;
	}

	if($current === $result[$index]) $n++;
}
$end3 = microtime (true);
var_dump($result, $m, $n);
echo 'array_rand_only_one::: ' . ($end3-$begin3);



echo "\n\n";



$has = 1;
$index = 0;//index para saber repetições
$current;
$m = ''; //nom do item
$n = 0; //quantidade de repetição
$begin3 = microtime (true);
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
var_dump($result, $m, $n);
echo 'array_value_rand_mode_2::: ' . ($end3-$begin3);



echo "\n\n";



$has = 1;
$index = 0;//index para saber repetições
$current;
$m = ''; //nom do item
$n = 0; //quantidade de repetição
$begin3 = microtime (true);
for ($i=0; $i < $loop; $i++) { 
	$result = a_array_rand(['a'=>'a','b','c','d','e','f','g'], 3);

	if(isset($result[$index]) && $has) {
		$current = $result[$index];
		$m = $current;
		$has=0;
	}

	if(isset($result[$index]) && $current === $result[$index]) $n++;
}
$end3 = microtime (true);
var_dump($result, $m, $n);
echo 'a_array_rand::: ' . ($end3-$begin3);


echo "<br><br>";


echo 'array_rand() há ', ($firstResult / $n * 100) - 100, '% a mais de repetições, comparado com a_array_rand()';
