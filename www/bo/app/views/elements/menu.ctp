<?php
$options = [
    'menu' => [
        // ==== Content ====
        [
            'title' => __('Contenu du site', true),
            'elements' => [
                [
                    'title' => __('Pages', true),
                    'controller' => 'cms_nodes',
                    'action' => 'index',
                    'admin' => true,
                ],
            ],
        ],

        // ==== Catalogue ====
        [
            'title' => __('Catalogue', true),
            'elements' => [
                [
                    'title' => __('Produits', true),
                    'controller' => 'products',
                    'action' => 'index',
                    'admin' => true,
                ],
                [
                    'title' => __('Producteurs', true),
                    'controller' => 'producers',
                    'action' => 'index',
                    'admin' => true,
                ],
                [
                    'title' => __('Catégories de produits', true),
                    'controller' => 'product_categories',
                    'action' => 'index',
                    'admin' => true,
                ],
                [
                    'title' => __('Activités des producteurs', true),
                    'controller' => 'producer_activities',
                    'action' => 'index',
                    'admin' => true,
                ],
            ],
        ],

        // ==== Superuser ====
        [
            'title' => __('Gestion du Back-office', true),
            'elements' => [
                [
                    'title' => __('Utilisateurs', true),
                    'controller' => 'users',
                    'action' => 'index',
                ],
                [
                    'title' => __('Groupes', true),
                    'controller' => 'groupes',
                    'action' => 'index',
                ],
                [
                    'title' => __('Autorisations', true),
                    'controller' => 'acls',
                    'action' => 'index',
                ],
                [
                    'title' => __('Gestion de langues', true),
                    'controller' => 'languages',
                    'action' => 'index',
                ],
                [
                    'title' => __('Dico', true),
                    'controller' => 'dictionaries',
                    'action' => 'index',
                ],
                [
                    'title' => __('Configuration', true),
                    'controller' => 'blocks',
                    'action' => 'index',
                ],
            ],
        ],
    ],
];
echo $boHomeIndexVue->index($options, $user);
