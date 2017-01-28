<?php
$options = [
    'title'   => 'Prix des produits',
    'actions' => [
        'addActionTitle' => __("Ajouter un prix", true),
    ],
    'model'   => 'ProductPrice',
    'data'    => $productPrices,
    'fields'  => [
        'id'              => [
            'label' => __("Id", true),
        ],
        'price'           => [
            'label' => __("Prix", true),
        ],
        'min_quantity'    => [
            'label' => __("Quantité min", true),
        ],
        'max_quantity'    => [
            'label' => __("Quantité max", true),
        ],
        'product_id'      => [
            'label'  => __("Produit", true),
            'values' => $products,
        ],
        'product_unit_id' => [
            'label'  => __("Unité", true),
            'values' => $productUnits,
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
