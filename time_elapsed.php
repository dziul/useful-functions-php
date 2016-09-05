<?php


/**
 * Montar Plural
 * @param number $quantity Numero para saber se é plural (se é mais de um)
 * @param string $singularText Texto caso o $quantity for 1
 * @param string $pluralText Texto caso o $quantity for + de 1
 * @return string
 */
function pluralize($quantity, $singularText, $pluralText)
{
	return sprintf(ngettext("%d ".$singularText ." ", "%d ".$pluralText . " ", $quantity), $quantity);
}




/**
 * TEmpo decorrido escrito
 * @uses function.pluralize
 * @param type $date Data para comparação pattern: Y-m-d H:i:s
 * @param type|string $before_message primeiro conteudo do texto de retorno
 * @param bool $returnArray Retorna array ou não
 * @return string|array
 */
function time_elapsed( $date, $before_message='',$returnArray=false)
{


	$date_time_old 	= new DateTime( $date );

	$date_now 		= date('Y-m-d H:i:s');

	$date_time_now 	= new DateTime( $date_now );

	$diff      		= $date_time_old->diff($date_time_now);


	$year 		= $diff->y; //ano
	$month 		= $diff->m; //mes
	$day 		= $diff->d; //day
	$hour 		= $diff->h; //hour
	$minute 	= $diff->i; //minute
	$second 	= $diff->s; //segundo


	//messagem ========
	$message_year 	= $year 	? pluralize($year,'ano','anos')           : '';
	$message_month 	= $month 	? pluralize($month,' mês',' meses')       : '';
	$message_day 	= $day 		? pluralize($day,'dia','dias')            : '';
	$message_hour 	= $hour 	? pluralize($hour,'hora','horas')         : '';
	$message_minute = $minute 	? pluralize($minute,'minuto','minutos')   : '';
	$message_second = $second 	? pluralize($second,'segundo','segundos') : '';
	//messagem ========

	
	//montagem ========
	$message = !is_null($before_message) ? $before_message . ' ' : '';
	if($year) 					$message .= $message_year . $message_month . $message_day;
	elseif($month) 				$message .= $message_month . $message_day;
	elseif($day) 				$message .= $message_day;
	elseif($hour) 				$message .= $message_hour;
	elseif($minute) 			$message .= $message_minute;
	elseif($message_second) 	$message .= 'menos de 1 minuto';
	//montagem ========
	

	if($returnArray) return array('date_now'=>$date_now,'date_query'=>$date,'year'=>$year,'month'=>$month,'day'=>$day,'hour'=>$hour,'minute'=>$minute,'second' => $second, 'message' => $message);
	return $message;

}