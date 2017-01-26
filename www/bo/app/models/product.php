<?php

/**
 * Product Model
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 26/01/2017
 */
class Product extends AppModel
{
    var $name = 'Product';
    var $displayField = 'name';

    /**
     * Behaviors
     */
    var $actsAs = [
        'Upload' => [
            'photo_1' => [
                'extensions' => [
                    'value' => [ 'jpg', 'jpeg', 'png' ],
                ],
            ],
            'photo_2' => [
                'extensions' => [
                    'value' => [ 'jpg', 'jpeg', 'png' ],
                ],
            ],
            'photo_3' => [
                'extensions' => [
                    'value' => [ 'jpg', 'jpeg', 'png' ],
                ],
            ],
            'photo_4' => [
                'extensions' => [
                    'value' => [ 'jpg', 'jpeg', 'png' ],
                ],
            ],
            'photo_5' => [
                'extensions' => [
                    'value' => [ 'jpg', 'jpeg', 'png' ],
                ],
            ],
        ],
    ];


    /**
     * BelongsTo
     */
    var $belongsTo = [
        'ProductCategory' => [
            'className'  => 'ProductCategory',
            'foreignKey' => 'product_category_id',
        ],
        'Producer'        => [
            'className'  => 'Producer',
            'foreignKey' => 'producer_id',
        ],
    ];

    /**
     * HasMany
     */
    var $hasMany = [
        'ProductPrice' => [
            'className'    => 'ProductPrice',
            'foreignKey'   => 'product_id',
        ],
    ];
}
