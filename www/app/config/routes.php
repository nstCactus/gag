<?php

// Définir les REGEX utilisées
// dans les routes
//@formatter:off
$ID   = '[0-9]+';
$PAGE = '[0-9]+';
$LANG = '[a-z]{2}';
$SLUG = '.+';
//@formatter:on


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
    'action'     => 'index',
], ['lang' => $LANG]);


// Utilisateurs
appConnect('/:lang/login', [
    'controller' => 'user',
    'action'     => 'login',
], ['lang' => $LANG]);
appConnect('/:lang/login/flash', [
    'controller' => 'user',
    'action'     => 'testFlash',
], ['lang' => $LANG]);


// Components
appConnect('/:lang/component-library', [
    'controller' => 'componentLibrary',
    'action'     => 'index',
], ['lang' => $LANG]);
appConnect('/:lang/component-library/:componentName', [
    'controller' => 'componentLibrary',
    'action'     => 'view',
], ['lang' => $LANG]);


// Pages CMS
appConnect(
    '/:lang/:slug',
    [
        'controller' => 'cms_contents',
        'action'     => 'view',
    ],
    [
        'slug' => $SLUG,
        'lang' => $LANG,
    ]
);
