<?php
/**
 * Converti une date sql en short date
 */
function smarty_modifier_short_date($date)  {
	$format = Dico::get("core.date.short-format");
	$timestamp = strtotime($date);
	return date($format, $timestamp);
}