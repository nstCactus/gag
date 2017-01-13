<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===== INIT =====
date_default_timezone_set('Europe/Paris');
header('Content-Type: text/html; charset=utf-8');


// ===== CONFIG =====
require('config/config.php');

// ===== CONFIG LANGUAGE =====
require('config/language.php');


// Mapping config
$webroot = CONFIG_WEBROOT;
$cake = CONFIG_CAKE;
$app = CONFIG_APP;

// =================================================================================
// Cake - /!\ Ne pas toucher
// =================================================================================
/**
 * Separateur dossier
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * Webroot path
 */
if (!defined('ROOT')) {
    define('ROOT', $webroot);
}

/**
 * Dossier contenant l'application (beta)
 */
if (!defined('APP_DIR')) {
    define('APP_DIR', $app);
}

/**
 * Dossier contenant CakePHP
 */
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    define('CAKE_CORE_INCLUDE_PATH', $cake);
}

/**
 * Editing below this line should NOT be necessary.
 * Change at your own risk.
 */
if (!defined('WEBROOT_DIR')) {
    define('WEBROOT_DIR', basename(dirname(__FILE__)));
}

if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', dirname(__FILE__) . DS);
}

if (!defined('CORE_PATH')) {
    if (function_exists('ini_set') && ini_set('include_path',
            CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS . PATH_SEPARATOR . ini_get('include_path'))
    ) {
        define('APP_PATH', null);
        define('CORE_PATH', null);
    } else {
        define('APP_PATH', ROOT . DS . APP_DIR . DS);
        define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
    }
}

if (!include(CORE_PATH . 'cake' . DS . 'bootstrap.php')) {
    trigger_error('CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your ' . DS . 'cake core directory and your ' . DS . 'vendors root directory.',
        E_USER_ERROR);
}

if (isset($_GET['url']) && $_GET['url'] === 'favicon.ico') {
    return;
} else {
    $Dispatcher = new Dispatcher();
    $Dispatcher->dispatch($url);
}

if (Configure::read('debug') == 2) {
    echo '<!-- ' . round(getMicrotime() - $TIME_START, 4) . 's -->';
}
