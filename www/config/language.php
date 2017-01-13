<?php 

/**
 * Format config :
 * 
 * Langue basée sur le domaine :
 * $LANGUAGES_ENABLED = array(
	'fr' => array(
		'mainHost' => '10.0.0.32',
		'aliasHost' => array(
			'127.0.0.1',     // DEFAULT : 301
			'local.host' => 302
		)
	),
	'en' => array(
		'mainHost' => 'localhost',
		'default' => true,  // Langue par défaut
	),
);
 * 
 * Langue en sous dossier (/fr ; /en)
 * $MAIN_HOST = '10.0.0.32';
   $LANGUAGES_ENABLED = array(
		'fr', 'en' => array('default' => true),
	);
 * 
 * 
 * 
 * 
 */



/**
 * /!\ NE PAS MODIFIER /!\
 * Vérifie la langue
 * Redirige sur l'host principal
 */


/**
 * Détection automatique de la langue du navigateur
 *
 * Les codes langues du tableau $aLanguages doivent obligatoirement être sur 2 caractères
 *
 * Utilisation : $langue = autoSelectLanguage(array('fr','en','es','it','de','cn'), 'en')
 *
 * @param array $aLanguages Tableau 1D des langues du site disponibles (ex: array('fr','en','es','it','de','cn')).
 * @param string $sDefault Langue à choisir par défaut si aucune n'est trouvée
 * @return string La langue du navigateur ou bien la langue par défaut
 * @author Hugo Hamon
 * @version 0.1
 */
function autoSelectLanguage($aLanguages, $sDefault = 'fr') {
	if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$aBrowserLanguages = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		foreach($aBrowserLanguages as $sBrowserLanguage) {
			$sLang = strtolower(substr($sBrowserLanguage,0,2));
			if(in_array($sLang, $aLanguages)) {
				return $sLang;
			}
		}
	}
	return $sDefault;
}

// Langue pas basée sur l'host par défaut
if(!defined('URL_DOMAIN_BASED')) define('URL_DOMAIN_BASED', false);

// Liste des langues
$languagesMapping =  array(
	'fr' => array(
		'name' => 'Français',
		'shortName' => 'FR',
		'iso3' => 'fre'
	),
	'en' => array(
		'name' => 'English',
		'shortName' => 'EN',
		'iso3' => 'eng'
	),
	'de' => array(
		'name' => 'Deutsch',
		'shortName' => 'DE',
		'iso3' => 'deu'
	),
	'it' => array(
		'name' => 'Italiano',
		'shortName' => 'IT',
		'iso3' => 'ita'
	),
);



// Q = URL / Compatibilité IIS
if(isset($_GET['q'])){
	$_GET['url'] = $_GET['q'] ;
}


// === Init ===
$LANG_LANG_CODE = false;
$LANG_LANGUAGE = false;
$LANG_LANGUAGES = false;
$LANG_LANGUAGES_MAPPING = false;
$LANG_HOST = array();
$defaultLanguage = 'en';
$aliasHost = array();


$defaultLanguage = autoSelectLanguage($LANGUAGES_ENABLED, $defaultLanguage);


// Init à partir de la config
foreach($LANGUAGES_ENABLED as $codeLang => $currentLang) {
	
	if(!is_string($codeLang)){
		$codeLang = $currentLang;
		$currentLang = array();
	}
	
	// Langue pas dans liste (en haut)
	if(!isset($languagesMapping[$codeLang])){
		die('LANGUE "'.$codeLang.'" NON CONFIGUREE!');
	}
	
	// Mapping par domaine
	if(isset($currentLang['mainHost']) && URL_DOMAIN_BASED){
		$LANG_HOST[$codeLang] = $currentLang['mainHost'];
		$LANG_HOST_MAPPING[$currentLang['mainHost']] = $codeLang;
	}	
	
	// Domaine par défaut (si aucun : en)
	if(isset($currentLang['default']) && $currentLang['default'] == true){
		$defaultLanguage = $codeLang;
	}
	
	// Mapping ISO => ISO3
	$LANG_LANGUAGES_MAPPING[$codeLang] = $languagesMapping[$codeLang]['iso3'];
	
	// Mapping ISO => Name
	$LANG_LANGUAGES[$codeLang] = $languagesMapping[$codeLang]['name'];
	
	// Mapping alias host => ISO
	if(isset($currentLang['aliasHost']) && URL_DOMAIN_BASED){
		foreach($currentLang['aliasHost'] as $currentAliasHost => $redirectionCode){
			
			if(!is_string($currentAliasHost)){
				$currentAliasHost = $redirectionCode;
				$redirectionCode = 301;
			}
			
			$aliasHost[$currentAliasHost] = array(
				'codeLang' => $codeLang,
				'redirectionCode' => $redirectionCode
			);
		} 
	}
}


// === Analyse de l'host ===
if(URL_DOMAIN_BASED){
	$host = $_SERVER['HTTP_HOST'];
	if(isset($LANG_HOST_MAPPING[$host])){
		$LANG_LANG_CODE = $LANG_HOST_MAPPING[$host];
		
	} elseif(isset($aliasHost[$_SERVER['HTTP_HOST']]) && isset($LANG_HOST[$aliasHost[$_SERVER['HTTP_HOST']]['codeLang']])) {
		$redirectionUrl = $LANG_HOST[$aliasHost[$_SERVER['HTTP_HOST']]['codeLang']];
		$url = '/';
		if(isset($_SERVER['REQUEST_URI'])) $url = $_SERVER['REQUEST_URI'];
		
		if($aliasHost[$_SERVER['HTTP_HOST']]['redirectionCode'] == 302){
			header("Status: 302 Moved Temporarily", false, 302);
		} else {
			header('HTTP/1.1 301 Moved Permanently', false, 301);
		}
		header('Location: http://'.$redirectionUrl.$url);
		exit();
	}
}


// === Analyse de l'URL ===
if(!URL_DOMAIN_BASED){
	if(!$LANG_LANG_CODE && !empty($_GET['url'])){
		if(strpos($_GET['url'], '/') !== false){
			$langFromUrl = substr($_GET['url'], 0, strpos($_GET['url'], '/'));
		} else {
			$langFromUrl = $_GET['url'];
		}
		$pattern = '`/lang:(.*)`';
		preg_match($pattern, $_GET['url'], $matches, PREG_OFFSET_CAPTURE, 3);
		if(isset($matches[1][0])){
			$langFromUrl = $matches[1][0];
		}

		// Code langue accepté ?
		if(isset($LANG_LANGUAGES[$langFromUrl])){
			$LANG_LANG_CODE = $langFromUrl;
		}
	}
}


// === Langue par défaut ====
// Pas de langue trouvée ou n'est pas acceptée
if(!$LANG_LANG_CODE || !isset($LANG_LANGUAGES[$LANG_LANG_CODE])){
	$LANG_LANG_CODE = $defaultLanguage;
	
	header('HTTP/1.1 301 Moved Permanently', false, 301);
	header('Location: '.CONFIG_BASE_URL.'/'.$LANG_LANG_CODE);
	exit();
}



// === Mapping ===
$LANG_LANGUAGE = $LANG_LANGUAGES_MAPPING[$LANG_LANG_CODE];

