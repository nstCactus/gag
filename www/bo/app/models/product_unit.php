<?php

/**
 * ProductUnit Model
 *
 * @author    nstCactus <nstCactus@gmail.com>
 * @version   26/01/2017
 */
class ProductUnit extends AppModel
{
    var $name = 'ProductUnit';
    var $displayField = 'name';

    /**
     * Validate
     */
    var $validate = [
        'name' => [
            'notEmpty' => [
                'rule'    => 'notEmpty',
                'message' => 'Ce champ ne peut pas rester vide',
            ],
        ],
    ];
}
