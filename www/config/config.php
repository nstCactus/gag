<?php

// SVN revision
define('SVN_REVISION', 'dev');

define('BO_EDIT_NOTIFICATION_ENABLED', true);

// Core
define('CORE_DEBUG', 1);
define('CORE_CACHE_DISABLE', true);
define('CACHE_REQUEST_ENABLE', false);


// BDD
define('BDD_HOST',      'localhost');
define('BDD_LOGIN',     'root');
define('BDD_PASSWORD',  '');
define('BDD_DATABASE',  'gag');


// Contact
define('EMAIL_FROM', 'sbooob+gag@gmail.com');


// ReCaptcha
define('RECAPTCHA_SITE_KEY',    '');
define('RECAPTCHA_SECRET_KEY',  '');


// SMTP
$smtpOptions = array_filter([
    'port' =>       '',
    'timeout' =>    '',
    'host' =>       '',
    'username' =>   '',
    'password' =>   '',
]);


// Langues
require('config_languages.php');
