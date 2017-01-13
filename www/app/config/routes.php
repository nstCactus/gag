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


// Catalogue
appConnect(
    '/:lang/' . Dico::get('routes.catalog', 'catalog') . '/:id',
    [
        'controller'    => 'catalog',
        'action'        => 'download'
    ],
    [
        'id'    => $ID,
    ]
);


// Presse
// /fr/presse/marie-claire-maison-fevrier-2016
appConnect(
    '/:lang/' . Dico::get('routes.press', 'press') . '/:slug',
    [
        'controller'    => 'press',
        'action'        => 'view'
    ],
    [
        'slug' => '.+',
    ]
);

// showrooms
// /fr/showrooms/paris
appConnect(
    '/:lang/' . Dico::get('routes.showrooms', 'showrooms') . '/:slug',
    [
        'controller'    => 'showroom',
        'action'        => 'view'
    ],
    [
        'slug' => '.+',
    ]
);


// Produits – /!\ Ne pas modifier l'ordre de ces routes, sous peine de tout péter /!\
// /fr/produits/commodes/déclinaisons
appConnect(
    '/:lang/' . Dico::get('routes.products', 'products') . '/:category/' . Dico::get('routes.products_variations', 'variations'),
    [
        'controller'    => 'product',
        'action'        => 'variationsOverview'
    ],
    [
        'category' => '.+',
    ]
);

// /fr/produits/commodes/573-BF
appConnect(
    '/:lang/' . Dico::get('routes.products', 'products') . '/:category/:reference',
    [
        'controller'    => 'product',
        'action'        => 'view'
    ],
    [
        'reference' => '.+',
        'category'  => '.+',
    ]
);

// /fr/produits/commodes
appConnect(
    '/:lang/' . Dico::get('routes.products', 'products') . '/:category',
    [
        'controller'    => 'product',
        'action'        => 'index'
    ],
    [
        'category' => '.+',
    ]
);


// Controlleur formulaire : contact et newsletter
appConnect('/:lang/contactSubmit', [
    'controller'     => 'form',
    'action'        => 'contact'
]);
appConnect('/:lang/newsletterSubmit', [
    'controller'     => 'form',
    'action'        => 'newsletter'
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
