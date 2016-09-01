<?php 
class array_error extends Exception {

// public function __construct($message, $code = 0, Exception $previous = null) {
//         
//         // garante que tudo está corretamente inicializado
//         parent::__construct($message, $code, $previous);
//     }

	public function getArrayError($full=true)
	{
		$out = array(); //init

		if($full)
		{

		$arr = $this->getTrace();
		// $arr[] = $this->message;
		$arr['message'] = $this->message;
		// $out['error'] = array_reverse($arr); // inverte posição dos elementos da array
		$out['error'] = $arr;
		unset($out['error'][0]);

		// remover ultimo elemento da array | na real primeira setada
		// $length = count($out['error']) -1;
		// unset($out['error'][$length]); // remover

		}else{
			$out['error'] = $this->message;
		}
		return $out;
	}

}

class errorArray{

	public function __construct(){}

/**
 * detalhe do erro
 * @param string $message mensagem do erro (personalizado)
 * @param string $type_out definir a saida json|array
 * @param boolean $get_message definir se retorna array|json messagem ou boolean TRUE
 * @return json|array
 */
	public function error($message='',  $type_out='array')
	{
		try{

			throw new array_error($message, true);

		}catch(array_error $e){


			$out = true;
			if($type_out === 'json')
			{
				$out =  json_encode($e->getArrayError());
			}elseif ($type_out === 'array')
				{
					$out =  $e->getArrayError();
				}

				return $out;
			
		}
	}



	public function hasError($condicion)
	{

		if(is_array($condicion) && array_key_exists('error', $condicion)) return true;
		return false;

	}
}