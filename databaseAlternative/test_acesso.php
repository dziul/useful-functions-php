<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acesso</title>
</head>

<body>


<?php


require_once 'class/database_by_php.php';



// $pattern //para ficar mais seguro poderia criar um pattner comparação entre array antes de salvar


// var_dump($array);


$nameFile = 'lista_funcionario.json';
$pathFile = 'json/';
$passWord = '~~!1a2b3C4d5E6#$';




$bbb = new databaseJSON($nameFile, $pathFile, $passWord);


// $array = array('code'=>microtime(),'nome'=>'ana');
// $array2 = array('code'=>microtime());
// $array3 = array('code'=>microtime());

// $bbb->bindValue($array);

// $bbb->attach($array);

// $bbb->bindValue($array3);
// $bbb->attach($array);
// $bbb->attach($array);

// var_dump($bbb->prepareCONTENT);
// // // // $bbb->bindValue($array2);
// $bbb->add();
// var_dump(); //quando usa o bindValue não precisa colocar argumento em add()

// var_dump($bbb->prepareArrayToJSON($array));


// var_dump($bbb->getJsonByArray());




// var_dump($departamento);

// var_dump($departamento);

// foreach ($departamento as $key => $value) {
// 	$bbb->bindValue($value);
// }



// // var_dump($bbb->searchByID('2993'));


// $chefe = $bbb->removeDuplicateArray('chefe');
// // var_dump($chefe);
// $bbb->save($chefe, $pathFile . '/chefe.json');

// $cargo = $bbb->removeDuplicateArray('cargo');
// // var_dump($cargo);
// $bbb->save($cargo, $pathFile . '/cargo.json');

// $departamento = $bbb->removeDuplicateArray('departamento');
// // var_dump($departamento);
// $bbb->save($departamento, $pathFile . '/departamento.json');


// var_dump($bbb->delete(array('test'), null, 'json/departamento.json'));


// $var_temp = array();
// foreach ($all as $key => $value) {
// 	$var_temp[] = array($value['cargo']);
// }



$orden = $bbb->orderBy('cargo');
echo $bbb->tablePreview($orden);


//==========================================================================================

// $all = $bbb->arrayAll();
// $allCargo = $bbb->arrayAll($pathFile . 'cargo.json'); //cargo
// $allDepartamento = $bbb->arrayAll($pathFile . 'departamento.json'); //departamento
// $allChefe = $bbb->arrayAll($pathFile . 'chefe.json'); //chefe

// // var_dump($allChefe);

// // $bbb->multiUpdate(array(3030 => array('nome_completo'=>'Joao')));
// // exit();

// $array_temp = array();
// foreach ($all as $keyMAIN => $valueMAIN)
// {
// 	// var_dump($keyMAIN);
// 	foreach ($allDepartamento as $key => $value) {
// 		if($valueMAIN['departamento'] == $value)
// 			{
// 				// var_dump($key,  $bbb->update($keyMAIN, array('departamento' => $key)) );
// 				$array_temp[$keyMAIN]['departamento'] = $key;
// 				continue;
// 			}

// 	}

// 	foreach ($allCargo as $key => $value) {
// 		if($valueMAIN['cargo'] == $value)
// 			{
// 				// $bbb->update($keyMAIN, array('cargo'=> $key));
// 				$array_temp[$keyMAIN]['cargo'] = $key;
// 				continue;
// 			}

// 	}

// 	foreach ($allChefe as $key => $value) {
// 		if($valueMAIN['chefe'] == $value)
// 			{
// 				// $bbb->update($keyMAIN, array('chefe' => $key));
// 				$array_temp[$keyMAIN]['chefe'] = $key;
// 				continue;
// 			}

// 	}
// }




// var_dump($bbb->multiUpdate($array_temp));

//==========================================================================================

// $bbb->save($all);


//var_dump($bbb->searchByID(195));

// var_dump($bbb->searchByID('1025'));



// var_dump($bbb->arrayOrderBy('name', $all));
// var_dump($all);
// var_dump($all);


?>

</body>
</html>
