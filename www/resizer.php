<?php
/**
 * 2010-12-10
 * Ajout des parametres background et from
 * Exemple : c100x100+bg-50505077+from-png
 * bg : rrggbbaa (aa = alpha de 0 à 127)
 * from : type du fichier original : jpg|gif|png , l'extension finale indique le type de destination
 * 
 * Dimensions : entre 1 et 2000px
 * 
 * @author Maxime COLIN
 */

// ===== CONFIG =====
require('config/config.php');




// =====================================
// =========== PARAMETRES ==============
// La qualité (A mettre en parametre c'est mieux !!!!)
$quality = 85;

// Nombre max de dossiers pas image
$nombreDeclinaisonsAutorise = 50;

// Taille max en pixel (hauteur et largeur)
$maxSize = 2000;

$resizedFolderPrefix = 'resize/';
// =====================================


$params = $_GET['params'];

// Transfert de dossier MEDIA vers chantier (en dev)
// ===========================================
if(defined('CONFIG_MEDIA_DIR') && CONFIG_MEDIA_DIR && substr($params, 0, 5) == 'media' ){
	$params = CONFIG_MEDIA_DIR.$params;
	if(file_exists($params)){
		// Extension ?
		$fileExtensionTo = explode('.', $params);
		$fileExtensionTo = $fileExtensionTo[count($fileExtensionTo)-1];
		
		// Retourne le bon header
		switch($fileExtensionTo) {
			case 'jpeg':
			case 'jpg':
				header('Content-type: image/jpeg');
				break;
			case 'png':
				header('Content-type: image/png');
				break;
			case 'gif':
				header('Content-type: image/gif');
				break;
		}
		
		// Retourne l'image
		readfile($params);
		exit();
	}

}
// ===========================================


$params = explode('/', $params);

if($params[0].'/' == $resizedFolderPrefix = 'resize/'){
	unset($params[0]);
	$params = array_values($params);
}

// Mapping des parametres

// On récupere la longueur
$longueurArbo = count($params) - 1;

// Le nom du fichier
$filename = $params[$longueurArbo]; 

// Parametres
$parametres = $params[$longueurArbo - 1]; 
$parametres = explode(' ', $parametres);

// Le répertoire contenant l'image d'origine
$dirOriginalImage = $params;
unset($dirOriginalImage[$longueurArbo - 1]);
unset($dirOriginalImage[$longueurArbo]);
$dirOriginalImage = implode('/', $dirOriginalImage); 

// Les dimensions souhaités
$dimensions = $parametres[0];
$resizedFolder = $resizedFolderPrefix.$dirOriginalImage.'/'.$dimensions;

// Autres parametres
unset($parametres[0]);
$mapParametres = array(
	'bg' => 'pBackground',
	'from' => 'pFromType',
	'wmax' => 'pWMax',
	'hmax' => 'pHMax',
	'filter' => 'pFilter'
);

foreach($parametres as $current){
	list($key, $value) = explode('-', $current);
	if(array_key_exists($key, $mapParametres)){
		${$mapParametres[$key]} = $value;				
		$resizedFolder .= '+'.$key.'-'.$value;
	}
}

// Recherche l'extension de l'image
$fileParts = explode('.', $filename);
$fileExtensionTo = $fileParts[count($fileParts)-1];
unset($fileParts[count($fileParts)-1]);

$filenameWhitoutExtension = implode('.', $fileParts);

$fileExtensionFrom = $fileExtensionTo;
if(isset($pFromType)){
	$fileExtensionFrom = $pFromType;
}

// Image d'origine
$originalImage = $dirOriginalImage.'/'.$filenameWhitoutExtension.'.'.$fileExtensionFrom;

// Securite nombre de dossier maxi)
$files = glob($resizedFolder.'/../*/'.$filename);
$tooManyDimension = ( count($files) >=  $nombreDeclinaisonsAutorise );

// Image existe  ou trop de dimension
if(!file_exists($originalImage) || $tooManyDimension){
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	echo 'IMAGE INVALIDE';
	if($tooManyDimension){
		echo ' - FOLDERS';
	} else {
		echo ' - NOT EXISTS';
	}
	exit();
}

// L'image resizé
$resizedImage = $resizedFolder.'/'.$filename;

// Création d'une nouvelle image en fonction du type
switch($fileExtensionFrom) {
	case 'jpeg':
	case 'jpg':
		$source = imagecreatefromjpeg($originalImage);
		break;
	case 'png':
		$source = imagecreatefrompng($originalImage);
		break;
	case 'gif':
		$source = imagecreatefromgif($originalImage);
		break;
	default:
		echo("Error Invalid Image Type");
		die;
		break;
}

// Récuperer la taille de l'image originale
list($originalWidth,  $originalHeight) = getimagesize($originalImage);

// Calcule les dimensions
$newDimensions = newDimensions($originalWidth, $originalHeight, $dimensions);
if($newDimensions == false){
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	echo 'IMAGE INVALIDE';
	exit();
}

// Verification de la taille de l'image
if($newDimensions['width'] < 1 
|| $newDimensions['width'] > $maxSize
|| $newDimensions['height'] < 1
|| $newDimensions['height'] > $maxSize
){
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	echo 'IMAGE INVALIDE';
	echo ' - DIMENSION';
	exit();
}

// Créer la nouvelle image
$thumb = imagecreatetruecolor($newDimensions['width'],  $newDimensions['height']);

// Fond transparent
$bgRed = 255;
$bgGreen = 255;
$bgBlue = 255;
$bgAlpha = 127;

if(isset($pBackground)){
	$toRGB = rgb2array($pBackground);
	$bgRed = $toRGB[0];
	$bgGreen = $toRGB[1];
	$bgBlue = $toRGB[2];
	$bgAlpha = $toRGB[3];
}

imagesavealpha($thumb, true);
$transparentColour = imagecolorallocatealpha($thumb, $bgRed, $bgGreen, $bgBlue, $bgAlpha);
imagefill($thumb, 0, 0, $transparentColour);

// Resize / Crop / Fit...
imagecopyresampled($thumb,  $source,  $newDimensions['destX'],  $newDimensions['destY'], 0, 0,  $newDimensions['innerWidth'],  $newDimensions['innerHeight'],  $originalWidth,  $originalHeight);

// Créer le sous dossier
if(!isset($_GET['nosave'])){
	createArbo($resizedFolder);
} 
// No Save
else {
	$resizedImage = null;
}


// ajouter un filtre à l'image
if(isset($pFilter))
{
	$filters = array(
		'grayscale' => IMG_FILTER_GRAYSCALE
	);
	
	// Si le filtre est dans le mapping
	if(array_key_exists($pFilter, $filters))
	{
		// Appliquer le filtre via imagefilter
		imagefilter($thumb, $filters[$pFilter]);
	}
}


// Entrelacement

imageinterlace($thumb, true);

// Save
switch($fileExtensionTo) {
	case 'jpeg':
	case 'jpg':
		header('Content-type: image/jpeg');
		imagejpeg($thumb, $resizedImage, $quality);
		break;
	case 'png':
		header('Content-type: image/png');
		imagepng($thumb, $resizedImage);
		break;
	case 'gif':
		header('Content-type: image/gif');
		imagegif($thumb, $resizedImage);
		break;
}

file_put_contents($resizedFolderPrefix.'/log.txt', 'SAVED '.$resizedImage."\r\n", FILE_APPEND);

if(isset($resizedImage) && file_exists($resizedImage)) {
	chmod($resizedImage, 0777);
}


// Envoi l'image au navigateur
if(!isset($_GET['nosave'])){
	readfile($resizedImage);
}

/**
 * Calcul la taille de la nouvelle image
 * 
 * @param unknown_type $oldW
 * @param unknown_type $oldH
 * @param unknown_type $dimension
 * @return Array width, height, srcX, srcY, destX, destY
 */
function newDimensions($oldW, $oldH, $dimensions){
	$newDimensions = array();
	$newDimensions['destX'] = 0;
	$newDimensions['destY'] = 0;
	
	global $pWMax;
	
	
	// CROP ou FIT avec dimension exacte
	if(preg_match('/([c|f])(.*)x(.*)/', $dimensions, $matches)){
		$type = $matches[1];
		$newDimensions['width'] = (int)$matches[2];
		$newDimensions['height'] = (int)$matches[3];

		// Ratio
		$oldRatio = $oldW / $oldH;
		$newRatio = $newDimensions['width'] / $newDimensions['height'];
		
		// Crop
		if($type == 'c'){
			// Fit largeur et Crop haut et bas
			if(abs($oldRatio) <= abs($newRatio)){
				$newDimensions['innerWidth'] = min($newDimensions['width'], $oldW);
				$newDimensions['innerHeight'] = (int)(($newDimensions['innerWidth'] * $oldH) / $oldW);
			} else {
				$newDimensions['innerHeight'] = min($newDimensions['height'], $oldH);
				$newDimensions['innerWidth'] = (int)(($newDimensions['innerHeight'] * $oldW) / $oldH);
			}
		} else
		// Fit
		if($type == 'f'){
			// Fit largeur et Crop haut et bas
			if(abs($oldRatio) <= abs($newRatio)){
				$newDimensions['innerHeight'] = min($newDimensions['height'], $oldH);
				$newDimensions['innerWidth'] = (int)(($newDimensions['innerHeight'] * $oldW) / $oldH);
			} else {
				$newDimensions['innerWidth'] = min($newDimensions['width'], $oldW);
				$newDimensions['innerHeight'] = (int)(($newDimensions['innerWidth'] * $oldH) / $oldW);
			}
		} else {
			return false;
		}
		
	} else 
	
	// Largeur ou hauteur fixe
	if(preg_match('/w(.*)/', $dimensions, $matches)){
		$newDimensions['width'] = (int)$matches[1];
		$newDimensions['height'] = (int)min((($newDimensions['width'] * $oldH) / $oldW), $oldH);
		$newDimensions['innerWidth'] = min($newDimensions['width'], $oldW);
		$newDimensions['innerHeight'] = $newDimensions['height'];
	} else 
	
	if(preg_match('/h(.*)/', $dimensions, $matches)){
		$newDimensions['height'] = (int)$matches[1];
		$newDimensions['width'] = (int)min((($newDimensions['height'] * $oldW) / $oldH), $oldW);
		$newDimensions['innerHeight'] = min($newDimensions['height'], $oldH);
		$newDimensions['innerWidth'] = $newDimensions['width'];
	}
	else {
		return false;
	}
	
	// Vérifier si on a des tailles maximales a ne pas dépasser 
	if (
		(isset($pWMax) && $pWMax == "1" && $newDimensions['width'] >= $oldW) ||
		(isset($pHMax) && $pHMax == "1" && $newDimensions['height'] >= $oldH)
	)
	{
		$newDimensions['width'] = $oldW;
		$newDimensions['height'] = $oldH;
		$newDimensions['innerWidth'] = $oldW;
		$newDimensions['innerHeight'] = $oldH;
	}

	// Centrer inner image
	$newDimensions['destX'] = (int)(($newDimensions['width']-$newDimensions['innerWidth'])/2);
	$newDimensions['destY'] = (int)(($newDimensions['height']-$newDimensions['innerHeight'])/2);
	
	return $newDimensions;
}


/**
 * Convert color from hex in XXXXXX (eg. FFFFFF, 000000, FF0000) to array(R, G, B)
 * of integers (0-255).
 *
 * name: rgb2array
 * author: Yetty
 * @param $color hex in XXXXXX (eg. FFFFFF, 000000, FF0000)
 * @return string; array(R, G, B) of integers (0-255)
 */
function rgb2array($rgb) {
	$return = array();
    $return[0] = base_convert(substr($rgb, 0, 2), 16, 10);
    $return[1] = base_convert(substr($rgb, 2, 2), 16, 10);
	$return[2] = base_convert(substr($rgb, 4, 2), 16, 10);
	$return[3] = 0;
	
	if(strlen($rgb) == 8){
		$return[3] = base_convert(substr($rgb, 6, 2), 16, 10);
	}
	
    return $return;
}


/**
 * Créer les dossiers d'une arborescence
 * 
 */
function createArbo($folders){
	$folders = explode('/', $folders);
	$path = '';
	foreach($folders as $currentFolder){
		if(empty($currentFolder)) continue;

		$path .= $currentFolder.'/';
		
		if(!file_exists($path)){
			mkdir($path, 0777);
			chmod($path, 0777);
		}
		
	}
	
}

















