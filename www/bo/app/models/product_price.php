<?php

/**
 * ProductPrice Model
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 26/01/2017
 */
class ProductPrice extends AppModel
{
    var $name = 'ProductPrice';
    var $displayField = 'name';

    /**
     * BelongsTo
     */
    var $belongsTo = [
        'Product'     => [
            'className'  => 'Product',
            'foreignKey' => 'product_id',
        ],
        'ProductUnit' => [
            'className'  => 'ProductUnit',
            'foreignKey' => 'product_unit_id',
        ],
    ];
}
