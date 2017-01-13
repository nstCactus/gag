<?php

// Charger la configuration
$configFile = dirname(__FILE__).'/../../../../config/config.php';
$configLanguagesFile = dirname(__FILE__).'/../../../../config/config_languages.php';
if(file_exists($configFile) && file_exists($configLanguagesFile)){
	require_once($configFile);
	require_once($configLanguagesFile);
} else {
	die('Impossible de charger la configuration');
}

Configure::write('debug', 1);


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

set_include_path(get_include_path() . PATH_SEPARATOR . GATO_LIBS_BACK_OFFICE . PATH_SEPARATOR);


