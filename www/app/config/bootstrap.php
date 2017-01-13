<?php


// Host

$appHost = $_SERVER['HTTP_HOST'];
Configure::write('App.host', $appHost);
Configure::write('App.httpHost', 'http://'.$appHost);


// Medias

Configure::write('media.path', '/media/');
Configure::write('static.image', '/static/img/');
Configure::write('static.flv', '/static/flv/');
Configure::write('static.mp3', '/static/mp3/');
Configure::write('static.swf', '/static/swf/');


// Page courante

Configure::write('currentUrl', 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);


// CkEditor

if (defined('CKE_IMG_BACK_DIR'))
	$appCkeImageBackDir = CKE_IMG_BACK_DIR;
else
	$appCkeImageBackDir = '../../../media/images';

if (defined('CKE_IMG_FRONT_DIR'))
	$appCkeImageFrontDir = CKE_IMG_FRONT_DIR;
else
	$appCkeImageFrontDir = '/media/images/';

Configure::write('cke.imageBackDir', $appCkeImageBackDir);
Configure::write('cke.imageFrontDir', $appCkeImageFrontDir);


// Langues

global $LANG_LANGUAGE, $LANG_LANG_CODE, $LANG_LANGUAGES, $LANG_LANGUAGES_MAPPING, $LANG_HOST, $LANGUAGES_ENABLED;


// Langue par defaut
Configure::write('Config.onlyOneLanguage', true);

Configure::write('Config.defaultLanguage', 'eng');
// fre
Configure::write('Config.language', $LANG_LANGUAGE);
// fr
Configure::write('Config.langUrl', $LANG_LANG_CODE);
// ['fr' => 'Français', 'en' => 'English]
Configure::write('Config.languages', $LANG_LANGUAGES);
// ['fr' => 'fre', 'en' => 'eng']
Configure::write('Config.languagesMapping', $LANG_LANGUAGES_MAPPING);
// ['fr' => 'host.fr', 'en' => 'host.com']
Configure::write('Config.langHost', $LANG_HOST);
Configure::write('Config.langCode3', $LANG_LANGUAGES_MAPPING[$LANG_LANG_CODE]);
Configure::write('Config.languagesEnabled', $LANGUAGES_ENABLED);

// Date

$datesMapping = array(
	'en' => '%m/%d/%y',
	'fr' => '%d/%m/%y',
	'es' => '%m.%d.%y',
	'de' => '%m/%d/%y',
	'ru' => '%m.%d.%y',
	'jp' => '%m.%d.%y',
	'cn' => '%m.%d.%y',
	'it' => '%d/%m/%y',
	'tr' => '%d/%m/%y',
	'pt' => '%d/%m/%y',
	'cs' => '%d/%m/%y',
	'be' => '%d/%m/%y',
);
Configure::write('Config.dateFormat', $datesMapping[$LANG_LANG_CODE]);


// Date Locale

$dateLocales =  array(
	'fr' => 'fr_FR',
	'en' => 'en_GB',
	'es' => 'es_ES',
	'it' => 'it_IT',
	'de' => 'de_DE',
	'jp' => 'en_GB',
	'cn' => 'en_GB',
	'be' => 'en_GB'
);
Configure::write('Config.dateLocales',$dateLocales[$LANG_LANG_CODE]);

// Définition de la locale
setlocale(LC_ALL, $dateLocales[$LANG_LANG_CODE]);


// Email

global $smtpOptions;
Configure::write('Config.smtpOptions', $smtpOptions);


// Configuration du cache

if(!defined('CACHE_REQUEST_ENABLE')){
	define('CACHE_REQUEST_ENABLE', true);
}


// Fallback mb_ucfirst

if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) {
	function mb_ucfirst($string) {
		$string = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
		return $string;
	}
}
