<?php
/**
 * Converti une date sql en 02 mars 2012
 */
function smarty_modifier_human_date($date)
{
	// Format incorrect : pas de traitement
	if( !  preg_match('#.{4}-.{2}-.{2}#', $date, $matches)){
		return $date;
	}

	// Mapping lang ISO > Lang windows
	$languages =  array(
		'fr' => 'French',
		'en' => 'en',
		'es' => 'esp',
		'it' => 'Italian',
		'de' => 'deu',
		'jp' => 'jpn',
		'cn' => 'Chinese'	
	);
	
	// Langue courante + set PHP local
	$lang = Configure::read('Config.langUrl');
	setlocale(LC_ALL, $languages[$lang]);
	
	// Découpe la date (format mysql)
	list($year, $month, $day) = explode('-', $date);
	
	//
	return utf8_encode(strftime(Dico::get("date.format"), mktime(0,0,0, $month, $day, $year)));
}