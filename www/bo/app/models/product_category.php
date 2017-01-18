<?php

/**
 * ProductCategory Model
 *
 * @author    nstCactus <nstCactus@gmail.com>
 * @version   15/01/2017
 */
class ProductCategory extends AppModel
{
    var $name = 'ProductCategory';
    var $displayField = 'name';

    /**
     * Behaviors
     */
    var $actsAs = [
        'Tree',
        'Slug' => [ 'from' => 'name' ],
    ];

    /**
     * BelongsTo
     */
    var $belongsTo = [
        'Parent' => [
            'className'  => 'ProductCategory',
            'foreignKey' => 'parent_id',
        ],
    ];
}
