<?php
$options = [
    'menu' => [
        // ==== Content ====
        [
            'title' => __("Site content", true),
            'elements' => [
                [
                    'title' => __("Pages", true),
                    'controller' => 'cms_nodes',
                    'action' => 'index',
                    'admin' => true,
                ],
            ],
        ],

        // ==== Superuser ====
        [
            'title' => __("Back-office management", true),
            'elements' => [
                [
                    'title' => __("Users", true),
                    'controller' => 'users',
                    'action' => 'index',
                ],
                [
                    'title' => __("Groups", true),
                    'controller' => 'groupes',
                    'action' => 'index',
                ],
                [
                    'title' => __("Autorisations", true),
                    'controller' => 'acls',
                    'action' => 'index',
                ],
                [
                    'title' => __("Languages", true),
                    'controller' => 'languages',
                    'action' => 'index',
                ],
                [
                    'title' => __("Translations", true),
                    'controller' => 'dictionaries',
                    'action' => 'index',
                ],
                [
                    'title' => __("Configuration", true),
                    'controller' => 'blocks',
                    'action' => 'index',
                ],
            ],
        ],
    ],
];
echo $boHomeIndexVue->index($options, $user);
