<?php

define('URL_DOMAIN_BASED', true);

// Liste des langues actives sur le front
$LANGUAGES_ENABLED = [ 'fr' => [
    'default' => true,
    'mainHost' => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '127.0.0.1',
    'aliasHost' => [],
]];
