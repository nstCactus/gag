<?php

/**
 * Producer Model
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 19/01/2017
 */
class Producer extends AppModel
{
    var $name = 'Producer';
    var $displayField = 'name';

    var $actsAs = [
        'Slug' => [ 'from' => 'corporate_name' ],
    ];

    /**
     * BelongsTo
     */
    var $belongsTo = [
        'ProducerActivity' => [
            'className'  => 'ProducerActivity',
            'foreignKey' => 'producer_activity_id',
        ],
        'CmsContainer'     => [
            'className'  => 'CmsContainer',
            'foreignKey' => 'cms_container_id',
        ],
    ];
}
