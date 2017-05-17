<?php

//Conversion date En to date Fr
function dateEnToFr($dateEn) {
	return date_i18n('l j F Y', strtotime($dateEn));
}

function timeStringToInt($timestring){
	return (int)str_replace(':', '', $timestring);
}

/*
** Vérifie si le début et la fin d'un temps donné est dans les temps de référence (en heure:minute[hh:mm])
*/
function isInRefTime($_ref_start, $_ref_end, $_start, $_end)
{
	$ref_start = timeStringToInt($_ref_start);
	$ref_end = timeStringToInt($_ref_end);
	$start = timeStringToInt($_start);
	$end = timeStringToInt($_end);
	if ( $start >=  $ref_start && $start < $ref_end && $end > $ref_start && $end <= $ref_end )
		return true;
	else
		return false;
}

/*
** Vérifie si le début et la fin d'un temps donné est hors des temps de référence (en heure:minute[hh:mm])
*/
function isOutRefTime($_ref_start, $_ref_end, $_start, $_end)
{
	$ref_start = timeStringToInt($_ref_start);
	$ref_end = timeStringToInt($_ref_end);
	$start = timeStringToInt($_start);
	$end = timeStringToInt($_end);
	if ( ($ref_start > $start || $start >= $ref_end) && ($ref_start >= $end || $end > $ref_end) )
		return true;
	else
		return false;
}


/*
** Vérifie un temps donné est hors des temps de référence (en heure:minute[hh:mm])
*/
function isTimeInRef($_ref_start, $_ref_end, $_time){
	$ref_start = timeStringToInt($_ref_start);
	$ref_end = timeStringToInt($_ref_end);
	$time = timeStringToInt($_time);
	if ( $time >=  $ref_start && $time < $ref_end )
		return true;
	else
		return false;
}

//Calcul nombre de jour entre deux dates
// $date_start string [YYYY-MM-dd]
// $date_end string [YYYY-MM-dd]
function getNumDay($date_start, $date_end) {
	$dteStart = new DateTime($date_start);
   	$dteEnd   = new DateTime($date_end);

   	return (int)$dteStart->diff($dteEnd)->days + 1;
}

function getHoursList($hour_start, $hour_end, $interval) {
	$interval = (int)$interval;

	$start = strtotime($hour_start);
	$end = strtotime($hour_end);
	while ( $start <= $end )
	{
    	$hours_list[] = date('H:i', $start);
		$start = strtotime('+'.$interval.' minutes',$start);
	}
	$last = count($hours_list) - 1;
	unset($hours_list[$last]);
	return $hours_list;
}
?>