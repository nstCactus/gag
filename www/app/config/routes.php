<?php

// Définir les REGEX utilisées
// dans les routes

$ID = '[0-9]+';
$LANG = '.{2}';
$PAGE = '[0-9]+';


// Importer le dico

App::import('Vendor', 'Dico');
App::import('Component', 'Dico');
$d = new DicoComponent();
$d->initialize();

function appConnect($route, $default = [], $params = [])
{
    if (URL_DOMAIN_BASED) {
        $route = str_replace('/:lang', '/', $route);
    }
    Router::connect($route, $default, $params);
}

Router::connectNamed(false);


// =====================================================================================
// ROUTES
// =====================================================================================


// Page d'accueil
appConnect('/:lang', [
    'controller' => 'home',
    'action' => 'index'
]);


// Components
appConnect('/:lang/component-library', [
    'controller'    => 'componentLibrary',
    'action'        => 'index'
]);
appConnect('/:lang/component-library/:componentName', [
    'controller'    => 'componentLibrary',
    'action'        => 'view'
]);


// Pages CMS
appConnect(
    '/:lang/:slug',
    [
        'controller'    => 'cms_contents',
        'action'        => 'view'
    ],
    [
        'slug'  => '.+',
        'lang'  => $LANG
    ]
);
