<?php

$baseUrl = dirname(env('SCRIPT_NAME'));
if($baseUrl == '/') {
	$baseUrl = '';
}
Configure::write('App.baseUrl', $baseUrl);
if(!defined('BASE')) define('BASE',$baseUrl);

// Chargement des librairies
// ===============================

// Vérification de la config

if(!defined('GATO_LIBS')){
	die('Erreur : Le chemin GATO_LIBS n\'est pas défini');
}

// Vérification du path vers GATO

if(!file_exists(GATO_LIBS)){
	die('Erreur : Le chemin vers GATO_LIBS est incorrect');
}
define('GATO_LIBS_FRONT_OFFICE', GATO_LIBS.DS.'front_office'.DS);


// Localisation des composants
// CakePHP fait un truc dégeulasse :
// les variables suivantes sont utilisées dans Configure::__loadBootstrap
// qui include ce fichier core.php

$modelPaths = array(
	GATO_LIBS_FRONT_OFFICE . 'models' . DS,
);
$behaviorPaths 	= array(
	GATO_LIBS_FRONT_OFFICE . 'models' . DS . 'behaviors' . DS,
);
$helperPaths 	= array(
	GATO_LIBS_FRONT_OFFICE . 'views' . DS . 'helpers' . DS,
);
$viewPaths 		= array(
	GATO_LIBS_FRONT_OFFICE . 'views' . DS,
);
$controllerPaths = array(
	GATO_LIBS_FRONT_OFFICE . 'controllers' . DS,
);
$componentPaths = array(
	GATO_LIBS_FRONT_OFFICE . 'controllers' . DS . 'components' . DS,
);
$pluginPaths 	= array(
	GATO_LIBS_FRONT_OFFICE . 'plugins' . DS,
);
$vendorPaths 	= array(
	GATO_LIBS_FRONT_OFFICE . 'vendors' . DS,
);


// Injection dans le path

set_include_path(get_include_path() . PATH_SEPARATOR . GATO_LIBS_FRONT_OFFICE);





// Configuration de l'application
// ==============================

// App host
Configure::write('HASH_SECRET_KEY', 'd280e0b9d43ef306f25bb29d7c9fdd41');

// App host

Configure::write('App.host', $_SERVER['HTTP_HOST']);


// Encoding

Configure::write('App.encoding', 'UTF-8');


// Log error

define('LOG_ERROR', 2);


// Cookie

ini_set('session.cookie_lifetime', 0);


// Base URL + cookie path

if(defined('CONFIG_BASE_URL')){
	$appBase = CONFIG_BASE_URL;
	if($appBase == '/'){
		$appBase = '.';
	}
	Configure::write('App.base', $appBase);
	$cookiePath = CONFIG_BASE_URL;
	if($cookiePath != '/') $cookiePath .= '/';
	ini_set('session.cookie_path', $cookiePath);
	session_start();
}


// Debug level

Configure::write('debug', 0);
if(defined('CORE_DEBUG')){
	Configure::write('debug', CORE_DEBUG);
}

Configure::write('Error', array(
    'handler' => 'ErrorHandler::handleError',
	'level' => E_ALL & ~E_STRICT & ~E_DEPRECATED,
    'trace' => true
));




// Cache

Configure::write('Cache.disable', true);
Configure::write('Cache.check', false);

if(defined('CORE_CACHE_DISABLE')){
	Configure::write('Cache.disable', CORE_CACHE_DISABLE);
	Configure::write('Cache.check', !CORE_CACHE_DISABLE);
}
Cache::config('default', array(
	'engine' => 'File',
));


// Session

Configure::write('Session.save', 'php');
Configure::write('Session.cookie', 'GATO-FRONT');
Configure::write('Session.timeout', 3600*24);
Configure::write('Session.start', true);
Configure::write('Session.checkAgent', false);
Configure::write('Security.level', 'medium');
Configure::write('Security.salt', 'DYhG9tni7lWqBqimDwXn557tGb0qyJfIxfstni7lWqBqimDwXn557tG');


// ACL

Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');
