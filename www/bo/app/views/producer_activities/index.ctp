<?php
$options = [
    'title'   => 'ProducerActivities',
    'actions' => [
        'addActionTitle' => __("Ajouter une activité", true),
    ],
    'model'   => 'ProducerActivity',
    'data'    => $producerActivities,
    'fields'  => [
        'id'   => [
            'label' => __("Id", true),
        ],
        'name' => [
            'label' => __("Nom", true),
            'width' => '100%',
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
