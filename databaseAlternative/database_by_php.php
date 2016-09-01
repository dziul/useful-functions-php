<?php 

require_once 'class.error.php';

class databaseJSON extends errorArray{

public $nameFILE;
public $pathFILE;
// public $arrayALL;
public $isSetKey=false; // se foi setado ou não
public $prepareCONTENT = array();
protected $NAMETOKEN = 'password'; //nome para a key para proteção
protected $TOKEN; 

/**
 * Construção da Class
 * @param string $nameFILE nome do arquivo que será usado. Será o Default
 * @param string $pathFILE caminho do arquivo. serpa o Default
 * @return void
 */
	public function __construct($nameFILE, $pathFILE='', $token)
	{

		$this->nameFILE = $nameFILE;
		$this->pathFILE = $pathFILE .'/';
		$this->TOKEN = $token;
	}

//complemento ===============
/**
 * Gerar o codigo para proteção do arquivo
 * @param string $token senha para proteção
 * @param string $queryNameKey nome da chave
 * @return string Codigo (php) com o token.
 */
	protected function buildCodeProtection($token=null, $queryNameKey=null)
	{
		if(empty($token)) $token = $this->TOKEN;
		if(empty($queryNameKey)) $queryNameKey = $this->NAMETOKEN;
		$content = '<?php function notFound(){ return header("HTTP/1.0 404 Not Found");} if(!isset($_GET["' . $queryNameKey . '"])) return notFound(); if($_GET["'. $queryNameKey .'"] !== "'. $token .'") return notFound(); header("Content-type: application/json"); function addQuote($buffer) { return "{" . $buffer . "}";} ob_start("addQuote"); ?>' . "\n";

		return $content;
	}

//complemento ===============



//complemento ===============
/**
 * Saber se existe uma chave com valor 'error'
 * @param array $array Array para pesquisa
 * @return boolean TRUE: Caso tenha a chave | FALSE: caso não tenha;
 */
	public function isError(array $array)
	{
		return array_key_exists('error', $array);
	}
//complemento ===============

//complemento ===============
	public function file_put($content, $pathFile, $flag_append=false)
	{

		$isExtensionPHP = substr(strrchr($pathFile, '.'), 1 );
		// var_dump($isExtensionPHP);

		if(!empty($flag_append))
		{
			

			if(!@file_put_contents($pathFile, $content, FILE_APPEND | LOCK_EX)) return $this->error('Não foi possível salvar.');
			return true;
		}


		//====================================================================================
		if($isExtensionPHP === 'php')
		{
			$content = $this->buildCodeProtection() . $content; //adicionar a parte da proteção
		}
		//====================================================================================
		if(!@file_put_contents($pathFile, $content, LOCK_EX)) return $this->error('Não foi possível salvar.');

		return true;


	}
//complemento ===============






//complemento ===============
/**
 * função para definir o caminho do arquivo ex: path/some.json
 * @param string $pathfile  REQUEST_URI ou URI do arquivo
 * @return string
 */
	public function str_request_uri($pathfile='')
	{
		if(empty($pathfile)) $pathfile = $this->pathFILE . $this->nameFILE; // arquivo

		return $pathfile;
	}
//complemento ===============




//complemento ===============
/**
 * Description
 * @param array $content array a ser convertido
 * @param boolean $insetKey  Caso for mensionar a Key manualmente
 * @return string JSON
 */
	public function removeTagsToConvertJsonString(array $content){





		if(!is_array($content)) return $this->error('Precisa ser uma array!');


		// var_dump($content);//test

		//salvar em textos caixa baixa =============================================
		//garantir que será tudo salvo em lowercase ================================
		//==========================================================================
		// function strtolower_arr(&$value, &$key)
		// {
		// 	var_dump($value, $key);//test
		// 	$value =  is_numeric($value) || empty($value) ? $value : mb_strtolower($value, 'UTF-8');
		// 	$key = is_numeric($key) || empty($key) ? $key : mb_strtolower($key, 'UTF-8');

		// }
		 // array_walk_recursive($content, 'strtolower_arr');
		array_walk_recursive($content, function(&$value, &$key){

			$value 	= trim($value); //retirar espaço no inicio e fim
			$key 	= trim($key);

			$value 	=  preg_match('~^$|[\D]~', $value) ? $value : (int) $value; //encontra vazio ou caracteres
			$key 	=  preg_match('~^$|[\D]~', $key) ? $key : (int) $key;  //encontra vazio ou caracteres


			$value =  is_numeric($value) || empty($value) ? $value : mb_strtolower($value, 'UTF-8');
			$key = is_numeric($key) || empty($key) ? $key : mb_strtolower($key, 'UTF-8');
		});
		//salvar em textos caixa baixa =============================================
		//==========================================================================


		$json_encode = json_encode($content, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE); // gera o string JSON

		// var_dump($json_encode);//test
		// exit();
		// var_dump($json_encode);

			$order = array('~^\{~','~\"\}$~', '~\}\}$~');
			$replace = array('','"','}');
			$content = preg_replace($order, $replace, $json_encode);

		// var_dump($content);

		return $content;

	}
//complemento ===============

//complemento ===============





/**
 * Savar Array em Json
 * @param array $array Array a ser consultado
 * @param string $pathFile caminho do arquivo. Caso ao contrário usará $pathFile setado em __construct
 * @param bool $flag_append TRUE: adicionar a baixo do conteudo existente.  FALSE: reescreve o arquivo completo 'substitui'
 * @return array|bool Array de erro ou TRUE|FASE
 */
	public function save_arrayToStringJSON(array $array, $pathFile='', $flag_append=false)
	{
		$content = $this->removeTagsToConvertJsonString($array);

		return $this->file_put($content, $pathFile, $flag_append);
	}
//complemento ===============







/**
 * Remover valores duplicados
 * @param string|number|null $key chave para consulta ex: key:email =>  remove tdos os elementos que
 * @param array|null $array  array a ser consultada
 * @param string $pathFile caminho do arquivo. Default: caminho usado no __construct
 * @return array Nova Array
 */
	public function removeDuplicate($key=null, $array=null, $pathFile='')
	{


		if(!$array) $array = $this->arrayAll($pathFile);


		//caso não seja mencionado o Key
		if(!$key) return array_unique($array);

		$temp_array = array();
		$temp_keys = array();
		// $i= 1; //começa no numero 1
		foreach ($array as $index => $content)
		{
			// var_dump($index);
			
			
			if(!in_array($content[$key], $temp_array))
			{

				if(is_array($content))
				{
					$temp_array[] = $content[$key];

					// var_dump($content[$key]);
					
				}else{
					$temp_array[] = $content;
				}	
			}

		}

		return $temp_array;
		
		// return array_unique($array);
	}

/**
 * Remover Valores Duplicados na array metodo Multidimensional. DocPHP:http://php.net/manual/pt_BR/function.array-unique.php
 * @param array $array Array para consultar
 * @param string|number|bool $key  chave de comparação
 * @return array retorna array sem duplicação | caso tenha
 */
	public function removeDuplicateMultiDimensional($key, $array=null, $pathFile='')
	{ 
		if(!$array) $array = $this->arrayAll($pathFile);

	    $temp_array = array();
	    // $i = 1;  // começa no numero 1
	    $key_array = array(); 
	    
	    foreach($array as $keySS => $valueSS) {
	    	//var_dump($value);

	        if (!in_array($valueSS[$key], $key_array)) {
	            $key_array[] = $valueSS[$key]; 
	            $temp_array[$keySS] = $valueSS; 
	        } 
	        $i++; 
	    }
	    return $temp_array; 
	} 


/**
 * Deletar conteudo
 * @param string|number $id  Necesário setar. ID da array a ser deletado
 * @param array|null $setArray array a ser consultado. Caso não for setado será usado $arrayAll
 * @param type|string $pathFile caminho do arquivo. Caso não for setado será usado $pathFile setado no __construct
 * @param bool $autoSave True: Auto salva o conteudo de volta.  false: retorna a array modificada
 * @return array|boolean  
 */
	public function delete($id,  $setArray=null, $pathFile='', $autoSave=true)
	{

		if(is_array($id))
		{
			return $this->multiDelete($id, $setArray, $pathFile, $autoSave);
		}

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		$array = $setArray;
		if(!$array) $array = $this->arrayAll($pathFile);

		
		
		if(isset($array[$id]))
		{
			unset($array[$id]);
			if($autoSave) return $this->save_arrayToStringJSON($array, $pathFile);
			return $array;
		}

		return $this->error('Não existe <code>array['. $id .']</code>');
	}


/**
 * Deletar grupo 
 * @param array $arrayID Array com os IDs que serão deletados
 * @param type|null $setArray Array para consulta
 * @param type|string $pathFile caminho do arquivo. defautl: Caminho setado no __construct
 * @param bool $autoSave True: Auto salva o conteudo de volta.  false: retorna a array modificada
 * @return bool 
 */
	public function multiDelete(array $arrayID,  $setArray=null, $pathFile='',$autoSave=true)
	{

		$array = $setArray;
		if(!$array) $array = $this->arrayAll($pathFile);

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		if( !is_array($arrayID) ) return $this->error('Não existe uma array dos IDs para consulta.');
		if( !is_array($array) ) return $this->error('Não existe array para consulta.');


		foreach ($arrayID as $key)
		{

			if(isset($array[$key]))
			{
				unset($array[$key]);
			}

		}

		if($autoSave) return $this->save_arrayToStringJSON($array, $pathFile);
		return $array;

	}

/**
 * Deletar por Key e Value ex:  email => exeplo@bol.com.br === deleta todos key:email; value: exeplo@bol.com.br
 * @param int|bool|string $v_key Nome da chave para consulta
 * @param bool|string $v_value Valor para casar a consulta
 * @param array|null $setArray Array para ser consultado
 * @param string $pathFile Caminho do arquivo. Default: caminho setado em __construct
 * @param bool $autoSave True: Auto salva o conteudo de volta.  false: retorna a array modificada
 * @return bool|array  Array se tiver erro
 */
	public function deleteBy($v_key='', $v_value='', $setArray=null, $pathFile='', $autoSave=true)
	{
		$array = $setArray;
		if(empty($array)) $array = $this->arrayAll($pathFile);

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão


		$v_value = is_number($v_value) || empty($v_value) ? $v_value : mb_strtolower(trim($v_value),'UTF-8'); // deixar em lowerCase
		$v_key = is_number($v_key) || empty($v_key) ? $v_key : mb_strtolower(trim($v_key),'UTF-8'); // deixar em lowerCase


		if(!is_array($array)) return $this->error('Não existe uma array para consulta');

		

		// selectBy($keyName='',$valueName='', $setArray=null, $pathFile='', $outAll=false, $selectByWord=false)
		// var_dump($this->selectBy($v_key, $v_value, $setArray, $pathFile));

		
		$statusFind = false; // init //saber o status do encontro

		foreach ($array as $index=>$content)
		{

			if(isset($content[$v_key]) && $content[$v_key] == $v_value)
			{
				// var_dump($array[$index]);//test
				unset($array[$index]); //remover
				$statusFind = true; // ativastatus do encontro = TRUE
			}

			
		}


		if($statusFind)
		{
			//auto save ===============
				if($autoSave)
				{
					//var_dump($array);//test
					return $this->save_arrayToStringJSON($array, $pathFile);	
				}
				//auto save ===============
				return $array;
		}

				

		return $this->error('Não existe <code>array[???]['. $v_key .']</code> com <code>value: "'. $v_value .'"</code>');
	}



/**
 * Atualiza conteudo
 * @param string|number $id ID da array a ser atualizada
 * @param array $updateKeyValue Array com o conteudo que tem que ser atualizdo  ex:  array('code'=>'1458', [...])  atualizar o campo 'code' por '1458'
 * @param type|null $setArray Array a ser consultado. Caso não seja setado, usará $arrayAll
 * @param type|string $pathFile caminho do arquivo. Se não for setado, será usado $pathFile setado no __construct
 * @param bool $autoSave FALSE: retorna a array
 * @return array|boolean  Array de erro ou TRUE|FALSE
 */
	public function update($id, array $updateKeyValue, $setArray=null, $pathFile='', $autoSave=true)
	{
		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão


		$array = $setArray; //init array
		if(!$array) $array = $this->arrayAll($pathFile);


		if(isset($array[$id]))
		{
			//verifica se existe a chave

			foreach($updateKeyValue as $key=>$value)
			{


				if( isset($array[$id][$key]) )
				{
					$array[$id][$key] = $value;
					continue;
				}
				return $this->error('Não existe key: "' . $key . '" =  <code>$array['.$id.']['.$key.']</code>.');



			}


			//autosave =============
			if($autoSave) return $this->save_arrayToStringJSON($array, $pathFile);
			//apenas retorna a array sem salvar ===========
			return $array;
			


		}else{
			return $this->error('Não existe array "' . $id  . '" ( $array['.$id.'] )');
		}



	}

/**
 * Atualizar vários
 * @param array $arrayIDandKEYandVALUE array com todos os elementos e valores para atualizar @example array(ID => array(key=>NEWvalue), [...]) ::: array(15 => array('email'=>'test@examples.com'))
 * @param type|null $setArray 
 * @param type|string $pathFile 
 * @param bool $autoSave FALSE: retorna a array
 * @return type
 */
	function multiUpdate($arrayIDandKEYandVALUE, $setArray=null, $pathFile='', $autoSave=true)
	{

		//verificar se arrayIDandKEYandVALUE
		if(!is_array($arrayIDandKEYandVALUE)) return $this->error('argumento <code>$arrayIDandKEYandVALUE</code> tem que ser uma array. ex: <code>array(12=>array("key"=>"test1"), 521=> array("email"=>"test@test.com"))</code>.');

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		$array = $setArray; //init array
		if( !is_array($array) ) $array = $this->arrayAll($pathFile); //verifica se tem uma array


		foreach ($arrayIDandKEYandVALUE as $key => $value) {

			foreach ($value as $keyChild => $valueChild) {

				if( isset($array[$key][$keyChild]) )
				{
					$array[$key][$keyChild] = $valueChild;
					continue;
				}
				return $this->error('Não existe <code>Array['.$key.']['.$keyChild.']</code>.');
			}

		}


		//auto save ===================================
		if($autoSave) return $this->save_arrayToStringJSON($array, $pathFile);
		//apenas retorna a array sem salvar ===========
		return $array;

	}


/**
 * Vincular/Adicionar/Anexar/atribuir Array
 * @param Array $bindArrayOrString  ex:  array('Estado'=>'SP', 'nome'=>'Joao')  ou array( 25 => array( 'Estado'=>'SP', 'nome'=>'Joao') )
 * @param String $indexName  Vincula a array com o Key (ID)
 * @return void 
 */
	public function attach($bindArrayOrString, $indexName=null) // montar a string
	{
		//caso no seja array
		// if(!is_array($bindArrayOrString)) return $this->error('precisa ser uma array');


		if(empty($indexName))
		{
			$this->isSetKey = false;
			$this->prepareCONTENT[] = $bindArrayOrString;
		}else{
			$this->isSetKey = true;
			$this->prepareCONTENT[$indexName] = $bindArrayOrString;
		}
		

		return;
	} 

/**
 * Vincular/Adicionar/Anexar/atribuir via string
 * @param string|int $value Valor
 * @param string|int|null $nameArray Caso preciso definir o nome que da criação
 * @return array retorna a array  ex:  array( $nameArray => $value) | array('mensagem' => 'test')
 */
	// public function createArrayAndAttach($value, $nameArray=null)
	// {
	// 	if( empty($value) ) return  $this->error('É obrigatório adicionar valor ao atributo $value.');

	// 	$array = array($value);

	// 	return $this->attach($array, $nameArray);

	// }



/**
 * Preparação da array para salvar em JSON
 * @param array $prepareArray Array a ser preparada
 * @param string $pathFile caminho do arquivo
 * @return type
 */
	public function prepareArrayToJSON(array $prepareArray, $pathFile='', $file_append=true)
	{


		//setar
		$pathFile = $pathFile;
		if(empty($pathFile)) $pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão



		//retorna o valor ou false
		$lastKey = $this->lastKey(null, $pathFile);


		//=========================================================
		//=========================================================
		$countPrepareArray = count($prepareArray) -1; // saber quantidade, depois -1 para saver o index verdadeiro
		$arrayOut = array(); //init array de saida
		$i=0;
		//auto incrementação
		//
		//
		//
		// var_dump($prepareArray);//test
		// exit();
		
		// var_dump($file_append);//test

		//caso seja array
		if(!$this->isSetKey && !empty($lastKey) && $file_append)
			{


				

				while($countPrepareArray >= $i)
				{
					
					$content = $prepareArray[$i]; // $i = 0
					$i++;// somar $i +1

					$arrayOut[$lastKey + $i ] = $content;

				}

				return $arrayOut;

			}
			elseif (!$this->isSetKey && empty($lastKey) && $file_append)
				{
					while($countPrepareArray >= $i)
					{
						$content = ( isset($prepareArray[$i]) ) ? $prepareArray[$i] : $prepareArray[$i+1]; // $i = 0
						$i++;// somar $i +1

						$arrayOut[ $i ] = $content;

					}

					return $arrayOut;
		//auto incremente			
				}

		return $prepareArray;
		//else

	}

/**
 * Ordernar array por X key
 * @param string|number $by nome da chave
 * @param array|null $setArray Array a ser pesquisada caso tenha. Ao contrário será buscado automaticamente
 * @param string|string $pathFile caminho do arquivo. Caso não tenha será setado automatico
 * @return array
 */
	public function orderBy($by, $setArray=null, $pathFile='')
	{

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		$array = $setArray;
		if(!$array) $array = $this->arrayAll($pathFile); // pega a variavel arrayALL


		$this->orderBY = $by; //init
		$this->orderBY_is_true = true; //init

			@uasort($array, function($a,$b){
				$by = $this->orderBY;

				if(!isset($a[$by])) $this->orderBY_is_true = false;
				return strnatcmp($a[$by], $b[$by]);
			});

			if($this->orderBY_is_true) return $array;

			return $this->error('Indefinido $array[' . $this->orderBY .']');
			

	}



/**
 * Adicionar
 * @param type $KEY  se for preciso mencionar o nome da CHAVE
 * @param array $content  conteudo para ser adicinado
 * @param tring|string $pathFile caminho do arquivo. Caso não tenha será setado automatico
 * @param type|bool $file_append TRUE: Adiciona abaixo do conteudo existente FALSE: sub escreve o conteudo
 * @return bool TRUE:Sucesso
 */
public function add( $content, $KEY=null,  $pathFile='', $file_append=true)
{
	$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

	
	
		$this->attach($content, $KEY); //adicionar
		return $this->save(null, $pathFile, $file_append);	
	


	
}





/**
 * Salvar === importante ter atençao aos argumento. e sempre salvar um bk dos arquivos gerados
 * @param type|null $array  se não for setado, por default pega a array preparada por attach()  | caso for setar usar: exemplo: array(12=>array(conteudo), 5478=>array(conteudo))
 * @param tring|string $pathFile caminho do arquivo. Caso não tenha será setado automatico
 * @param type|bool $file_append TRUE: Adiciona abaixo do conteudo existente
 * @return bool
 */
	public function save($array=null, $pathFile='', $file_append=true)
	{
		$file_append;
		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		//caso seja null|false $array
		if(empty($array)) $array = $this->prepareCONTENT;

		// return $array;//test
		// 
		// var_dump($array);

		$arrayFormat = $this->prepareArrayToJSON($array, $pathFile, $file_append);

		// return $arrayFormat ;//test

		//verificar se foi passado algum elemento;
		if(empty($arrayFormat)) return $this->error('Não foi vinculado nenhum dado.');

		$content = $this->removeTagsToConvertJsonString($arrayFormat);

		
		// var_dump($content);//test

		// caso não exista o arquivo ou seja vazio
		
		if(is_file($pathFile) && filesize($pathFile) > 0 && $file_append)
		{
			$content = ',' . $content;//",\n" . $content;
			//$file_append = $file_append; //volta o real
		}

		if(!is_file($pathFile) || filesize($pathFile) <= 0)
		{
			$file_append = false; // setar para subescrever o arquivo caso for a primeira vez
		}



		$this->prepareCONTENT = array(); // reseta a variavel


		return $this->file_put($content, $pathFile, $file_append);

	// 	// $fOpen = fopen($pathfile, 'a');
	// 	// fwrite($fOpen, $content);
	// 	// fclose($fOpen);


	}







	public function getJsonByArray($pathFile='')
	{

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		if($content = @file_get_contents($pathFile))
		{
			//====================================================================================
			$pattern_codeProtect = $this->buildCodeProtection();

			$content = str_replace($pattern_codeProtect, '', $content); // retira o codigo da proteção

			//var_dump($content);

			//====================================================================================


			if ($content[0] !== '"') return $this->error('Algum erro encontrado. Pode ser que não comece com " (aspas dupla).');

			$content = '{' . $content. '}'; // gera a array do string JSON obj (quando está setado a KEY)
			

			$json_decode = json_decode($content, true);




			// var_dump($json_decode);

			return $json_decode; // saida sem filtro
			// return array_unique($json_decode, SORT_REGULAR);
		}

		// return $this->error(); //return false

		return false; // caso tenha error

	}







/**
 * Pegar todas as Array
 * @param string $pathFile  caminho do arquivo  relativo ou absoluto
 * @return array|false 
 */
	public function arrayAll($pathFile='')
	{

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		return $this->getJsonByArray($pathFile);
		
	}






/**
 * Encontra/Selecionar a Array especifica pelo ID
 * @param string|number $id  Id da busca
 * @param array|null $setArray a ser pesquisa caso seja setado
 * @param string $pathFile  Caminho do arquivo JSON
 * @return array retorna a Array do ID buscado
 */
	public function select($id='', $setArray=null, $pathFile='') //buscar por ID
	{
		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão

		//
		if(!$setArray) $setArray = $this->arrayAll($pathFile); // pega a variavel arrayALL
		

		if(isset($setArray[$id]))
		{
			return $setArray[$id];
		}

		return $this->error('Não existe nenhum elemento  key: ' . $id);


	}





/**
 * Encontrar/Selecionar por Key|ValoValue
 * @param string $keyName Nome da chave
 * @param string $valueName  Valor
 * @param array|null $setArray a ser pesquisada
 * @param bool $outAll  TRUE: retorna  todos os resultados em uma array numerada | FALSE: retorna apenas um resultado em uma array
 * @param type|string $pathFile caminho do arquivo
 * @param bool $selectByWord Ativar busca por palavra ex:  'Ana Silva'  => busca todas os valors que tenha estas duas palavras
 * @return array
 */
	public function selectBy($keyName='',$valueName='', $setArray=null, $pathFile='', $outAll=false, $selectByWord=false)
	{
		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão


		if(!$setArray) $setArray = $this->arrayAll($pathFile); // pega a variavel arrayALL
		

		if(!is_array($setArray)) return $this->error('A saída não é array.'); //verificar se é array


		$arrayOut = array(); //setar uma array de saida caso tenha setado o $outAll

		
		// selecionar por palavra ==================================
		if($selectByWord)
		{
			$needle = explode(' ', strtolower($valueName)); // valores para consultar 
			$count_needle = count($needle);
		}
		// var_dump($count_needle); //test

		// selecionar por palavra ==================================


		foreach ($setArray as $key => $array)
		{
			
			if(!isset($array[$keyName])) return $this->error('Nao existe Key ' . $keyName);



			// selecionar por palavra ==================================
			if($selectByWord)
			{
				$haystack =  explode(' ', $array[$keyName]); 
				$count_in_array = 0; // contagem de valor encontrado na array

				foreach ($needle as $aaa => $sss) {
					
					if(in_array($sss, $haystack)) $count_in_array++;
					
				}
				// var_dump($count_in_array);//test
				// var_dump( $count_needle !==  $count_in_array );//test
				if( $count_needle !==  $count_in_array ) continue; //
				// if(!$in_array) continue;
			}else
			{


			// selecionar por palavra ==================================


			if($array[$keyName] !== $valueName) continue;
			}





			//caso precise mostrar todas as buscas
			if($outAll)
			{
				$arrayOut[$key] = $setArray[$key];
				continue;
			} 


			$arrayOut = $setArray[$key];
			break;


		}

		//caso a array seja vazia
		if(empty($arrayOut)) return false;

		return $arrayOut;

	}


/**
 * Description
 * @param string $keyName 
 * @param string $valueName 
 * @param array|null $setArray array a ser consultada. se não for mencionado, será usado a função arrayAll()
 * @param string $pathFile caminho do arquivo. caso não for mencionado, será usado o caminho setado em __contruct
 * @param boll $outAll TRUE: buscas todos os resultados
 * @return array
 */
	public function fetchAllBy($keyName='',$valueName='', $setArray=null, $pathFile='')
	{
		return $this->selectBy($keyName, $valueName, $setArray, $pathFile, true, false);
	}

/**
 * Buscas todos por palavra
 * @param type|string $keyName  
 * @param type|string $valueName 
 * @param array|null $setArray array a ser consultada. se não for mencionado, será usado a função arrayAll()
 * @param type|string $pathFile 
 * @return array
 */
	public function featchAllByWord($keyName='',$valueName='', $setArray=null, $pathFile='')
	{
		return $this->selectBy($keyName, $valueName, $setArray, $pathFile, true, true);
	}



	public function fetchAllByColumn($nameColumn='', $setArray=false, $pathFile='', $indexReal=false )
	{

		$pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão


		if(!$setArray)  $setArray = $this->arrayAll($pathFile); // pega a variavel arrayALL


		

		if(!is_array($setArray)) return $this->error('A saída não é array.'); //verificar se é array


		$arrayOut = array(); //init
		foreach ($setArray as $key => $value) {

			//verificar se existe a chave
			if(!isset($value[$nameColumn])) return $this->error('Não existe $array[ ' .$nameColumn.' ]');
			
			//Se for falso seta com o index|key real
			if($indexReal)
			{
				$arrayOut[$key] = $value[$nameColumn];
				continue; // mata o loop | novo loop
			}

			$arrayOut[] = $value[$nameColumn];

		}

		return $arrayOut;
	}


/**
 * Retorna ultima chave da array
 * @param string $pathFile  caminho do arquivo
 * @return bool|string|number
 */
	public function lastKey($array=null, $pathFile='')
	{
		if(!is_array($array)) $array = $this->arrayALL($pathFile);


		if(empty($array)) return false;

		end($array); //setar para ultimo chave|elemento da array
		$lastKey = key($array);

		return $lastKey;
	}



	public function tablePreview($array=null, $pathFile='')
	{

		if(empty($pathFile)) $pathFile = $this->str_request_uri($pathFile); // verifica se existe uma URL, se não retorna a URL padrão
		if(empty($array)) $array = $this->arrayALL($pathFile);
		return $this->createHtmlTable($array);
	}

	private function createHtmlTable(array $content, $contentSecond='', $tableTag=false, $trTag=false)
		{
			$html = '';


			$active = 1;

			$innerHTML='';
			$i=1;

			//foreach ===========================================
			foreach ($content as $key => $value)
			{
				// var_dump($value);
				
				if(is_array($value))
				{

					$innerHTML = '<tr><td valign="middle"  align="center">#</td>'. $this->createHtmlTable($value, false, true, true) .'</tr>';

					$html.= $innerHTML . '<tr><td valign="middle"  align="center">'.$i++.'</td>'. $this->createHtmlTable($value, $key, true, true) .'</tr>';
					continue;
				}



				$td=''; // init TD

				$innerText = $contentSecond;
				if(empty($contentSecond)) $innerText = 'id';

				if($active)
				{
					$td ='<td valign="middle">' . $innerText . '</td>';
					$active=0;
				}


				if(!empty($contentSecond))
				{
					if(is_bool($value))
					{
						$value = $value ? '<strong>true</strong>':'false';
					}
					$html.= $td. '<td valign="middle" align="center">' .$value. '</td>';
				}else{
					$html.=  $td. '<td valign="middle"  align="center">' .$key. '</td>';
				}
				

			}
			//foreach ===========================================

			


			//return $html;
			$trBefore='';
			$trAfter='';
			if($trTag){
				$trBefore='<tr>';
				$trAfter='</tr>';
			}

			if(!$tableTag)
			{
				$css = '
				<style type="text/css">
#tablePreview{
	font-family:Menlo, Monaco, Consolas, "Courier New", monospace;
cursor:default;
    border-collapse: collapse;
    border-spacing: 0;
    margin:0 auto;
    }


#tablePreview,
#tablePreview tr,
#tablePreview tr td,
#tablePreview tr th{
	-webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

#tablePreview,
#tablePreview tr td{
	border: 1px solid rgba(0,0,0,.08);
	}
#tablePreview tr th{
	background:rgba(0,0,0,.6);
	color:#fff;
	border: 1px solid rgba(0,0,0,1);;
	}

#tablePreview tr th,
#tablePreview tr td{
	padding:10px;
}



#tablePreview tr:nth-child(even) {
		background:rgba(0,0,0,.07);	
		}



#tablePreview tr:hover td{
	background:#82b1ff;
	color:#fff;
	border:1px solid #6c94d6;
	}
</style>
				';
				$html = $css. '<table cellspacing="0" id="tablePreview" align="center">'.$trBefore . $html .$trAfter.'</table>';	



				$html = preg_replace_callback('~('.$innerHTML.')~', function($matches){

					
					$content =  str_replace('td', 'th', $matches[0]);

					return '<thead>' . $content .'</thead>';

					}, $html, 1);

				$html = preg_replace('~(>'.$innerHTML.'<)~', '><', $html);
			} 

			return $html;

		}



}