<?php

function smarty_modifier_ck_remove_p ($html) {

	$withoutP = preg_replace('#</?p.*>#U', '', $html);

	return $withoutP;
}