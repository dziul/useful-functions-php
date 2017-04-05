<?php


function array_rand_alternative(array $array , $num = 1 )
{
	$new = []; //init
	$internal = [];//init
	$count = count($array)-1;
	
	for ($i=0; $i < $num; $i++) {		
		$internal = $array;


		$keyrand = mt_rand(0, $count);

		$new[] = $array[$keyrand];


		// var_dump($array, $keyrand);
		unset($array[$keyrand]);
		$array = $internal;

	}
    return $new;
}


function array_rand_alternative_2(array $array , $offset = 1 )
{
	shuffle($array);
	return array_slice($array, 0, $offset);
}


function array_rand_alternative_3(array $array , $offset = 1 )
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


$begin = microtime (true);
for ($i=0; $i < 10000; $i++) { 
	$result = array_rand_alternative(['a','b','c','d','e','f','g'], 3);
}
$end = microtime (true);
var_dump($result);
echo 'method 1::: ' . ($end-$begin);
echo '<br><br>';






$begin2 = microtime (true);
for ($i=0; $i < 10000; $i++) { 
	$result = array_rand_alternative_2(['a','b','c','d','e','f','g'], 3);
}
$end2 = microtime (true);
var_dump($result);
echo 'method 2::: ' . ($end2-$begin2);




echo '<br><br>';
$begin3 = microtime (true);
// var_dump(array_rand_alternative(['a','b','c','d','e','f','g'],5));
for ($i=0; $i < 10000; $i++) { 
	$result = array_rand_alternative_3(['a','b','c','d','e','f','g'], 3);
}
$end3 = microtime (true);
var_dump($result);
echo 'method 3::: ' . ($end3-$begin3);





echo '<br><br>';

echo 'method 1 [array_rand_alternative_1] is <b>' . ((($end-$begin)*100/($end2-$begin2))-100) . '% slow</b> Compared to method 2 [array_rand_alternative_2],<br><br>and is <b>' . ((($end-$begin)*100/($end3-$begin3))-100) .'% slow</b> compared to method 3 [array_rand]';