<?php
$options = [
    'title'   => 'Producteurs',
    'actions' => [
        'addActionTitle' => __("Ajouter un producteur", true),
    ],
    'model'   => 'Producer',
    'data'    => $producers,
    'fields'  => [
        'id' => [
            'label' => __("Id", true),
        ],
        'corporate_name' => [
            'label' => __("Raison sociale", true),
            'width' => '100%',
        ],
        'legal_form' => [
            'label' => __("Forme juridique", true),
        ],
        'siret' => [
            'label' => __("SIRET", true),
        ],
        'post_code' => [
            'label' => __("Code postal", true),
        ],
        'city' => [
            'label' => __("Ville", true),
        ],
        'phone_mobile' => [
            'label' => __("Portable", true),
        ],
        'phone_landline' => [
            'label' => __("Fixe", true),
        ],
        'email' => [
            'label' => __("E-mail", true),
        ],
        'producer_activity_id' => [
            'label' => __("Activité", true),
            'values' => $activities,
        ],
    ],
    'filters' => $filters,
];

if (isset($isAjax) && $isAjax) {
    $json = [
        'table'   => $boIndexVue->index_table($options),
        'counter' => $boIndexVue->setCounter(),
    ];
    echo $javascript->Object($json);
} else {
    $afterBarre = '';
    if (count(Lang::getIso(Lang::getAdministrer())) > 0 && isset($options['i18n'])) {
        $afterBarre = '<div class="highlightLegend"><span class="square_color"><em></em></span>' . __('Elément non présent dans votre langue principale',
                1) . '</div>';
    }
    $content = [
        'afterTitle' => $this->element('auto_complete_filter_index_vue'),
        'afterBarre' => $afterBarre,
        'afterTable' => '',
    ];

    echo $boIndexVue->index($options, $content);
}
