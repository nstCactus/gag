<?php
/**
 * JS COMPILER
 * Definir le cache dans config perso (CACHE_JS_ENABLE)
 */
include('../../../config/config.php');

// Cache
$cacheEnabled = true;
if(defined('CACHE_JS_ENABLE')){
	$cacheEnabled = CACHE_JS_ENABLE;
}

// Header
header("Content-type: application/x-javascript");

if($cacheEnabled){
	$expires = 60*60*24*365;
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	if(file_exists('closure_compiler.js'))
	{
		readfile('closure_compiler.js');
		die();
	}
}

require('ClosureCompiler.php');
$cc = new ClosureCompiler();

echo $cc->display();
