<?php
// ======== Chargement de la librairie Gato ========
// Si GATO_LIBS n'est pas défini
if(!defined('GATO_LIBS')){
	// Charger la configuration
	$configFile = dirname(__FILE__).'/../../../config/config.php';
	$configLanguagesFile = dirname(__FILE__).'/../../../config/config_languages.php';
	if(file_exists($configFile) && file_exists($configLanguagesFile)){
		require_once($configFile);
		require_once($configLanguagesFile);

		define('MAIN_HOST', $MAIN_HOST);
	} else {
		die('Impossible de charger la configuration');
	}
}


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
if(!defined('GATO_LIBS_BACK_OFFICE')){
	define('GATO_LIBS_BACK_OFFICE', GATO_LIBS.DS.'back_office'.DS);
}


// Localisation des composants
// CakePHP fait un truc dégeulasse :
// les variables suivantes sont utilisées dans Configure::__loadBootstrap
// qui include ce fichier core.php

$modelPaths = array(
	GATO_LIBS_BACK_OFFICE . 'models' . DS,
);
$behaviorPaths 	= array(
	GATO_LIBS_BACK_OFFICE . 'models' . DS . 'behaviors' . DS,
);
$helperPaths 	= array(
	GATO_LIBS_BACK_OFFICE . 'views' . DS . 'helpers' . DS,
);
$viewPaths 		= array(
	GATO_LIBS_BACK_OFFICE . 'views' . DS,
);
$controllerPaths = array(
	GATO_LIBS_BACK_OFFICE . 'controllers' . DS,
);
$componentPaths = array(
	GATO_LIBS_BACK_OFFICE . 'controllers' . DS . 'components' . DS,
);
$pluginPaths 	= array(
	GATO_LIBS_BACK_OFFICE . 'plugins' . DS,
);
$vendorPaths 	= array(
	GATO_LIBS_BACK_OFFICE . 'vendors' . DS,
);


// Injection dans le path
$appPath = realpath(__DIR__ . '/../');
set_include_path(get_include_path() . PATH_SEPARATOR . $appPath . PATH_SEPARATOR . GATO_LIBS_BACK_OFFICE . PATH_SEPARATOR);


if(defined('CONFIG_BO_BASE_URL')){
	Configure::write('App.base', CONFIG_BO_BASE_URL);
	ini_set('session.cookie_path', CONFIG_BO_BASE_URL);
	session_start();
}

// ======== Debug ========
	Configure::write('debug', 2);
	if(defined('CORE_DEBUG')){
		Configure::write('debug', CORE_DEBUG);
	}


// ======== App Encoding ========
	Configure::write('App.encoding', 'UTF-8');


// ======== Cache ========
	Configure::write('Cache.disable', true);
	if(defined('CORE_CACHE_DISABLE')){
		Configure::write('Cache.disable', CORE_CACHE_DISABLE);
	}
	Configure::write('Cache.disable', false);

// 	Configure::write('Cache.check', true);
	Cache::config('default', array('engine' => 'File'));


// ======== Error ========
	define('LOG_ERROR', 2);


// ======== Session ========
	Configure::write('Session.save', 'cake');
	Configure::write('Session.cookie', 'GATO-BACK');
	Configure::write('Session.timeout', '120');
	Configure::write('Session.start', true);
	Configure::write('Session.checkAgent', false);

// ======== Security ========
	Configure::write('Security.level', 'low');
	Configure::write('Security.salt', 'LhS');


// ======== ACL ========
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');

