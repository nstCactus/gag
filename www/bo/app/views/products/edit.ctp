<div class="products form">
    <?php echo $form->create('Product', ['type' => 'file', 'onsubmit' => 'return checkForm (this)']); ?>
	<h1><?php echo __('Modifier un produit'); ?></h1>

	<fieldset>
		<legend><?php echo __('Produit', true); ?></legend>
        <?php
        echo $boLhsForm->input('Product.id', ['label' => __('Id', 1)]);
        ?>
        <?php
        echo $boLhsForm->input('Product.name', ['label' => __('Nom', 1), 'div' => 'inlined']);
        ?>
        <?php
        echo $boLhsForm->input('Product.description',
            [
                'label' => __('Description', 1),
                'type'  => [
                    'type'    => 'fck',
                    'toolbar' => Acl::checkAco("others/ckeditorSuperToolbar") ? "superuser" : "default",
                ],
            ]
        );
        ?>
        <?php
        echo $boLhsForm->input('Product.product_category_id', ['label' => __('Catégorie', 1)]);
        ?>
        <?php
        echo $boLhsForm->input('Product.producer_id', ['label' => __('Producteur', 1)]);
        ?>
	</fieldset>
        <?php
        $photosExtensions = ['jpg', 'jpeg', 'png'];
        $photoDimensions = ['width' => 300, 'height' => 300];
        echo $boLhsForm->input('Product.photo_1', [
            'label' => __('Image', 1),
            'type'  => [
                'type'    => 'image',
                'legend'  => 'Photo 1',
                'preview' => true,
                'alt'     => false,
                'ext'     => $photosExtensions,
                'dim'     => $photoDimensions,
            ],
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Product.photo_2', [
            'label' => __('Image', 1),
            'type'  => [
                'type'    => 'image',
                'legend'  => 'Photo 2',
                'preview' => true,
                'alt'     => false,
                'ext'     => $photosExtensions,
                'dim'     => $photoDimensions,
            ],
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Product.photo_3', [
            'label' => __('Image', 1),
            'type'  => [
                'type'    => 'image',
                'legend'  => 'Photo 3',
                'preview' => true,
                'alt'     => false,
                'ext'     => $photosExtensions,
                'dim'     => $photoDimensions,
            ],
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Product.photo_4', [
            'label' => __('Image', 1),
            'type'  => [
                'type'    => 'image',
                'legend'  => 'Photo 4',
                'preview' => true,
                'alt'     => false,
                'ext'     => $photosExtensions,
                'dim'     => $photoDimensions,
            ],
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Product.photo_5', [
            'label' => __('Image', 1),
            'type'  => [
                'type'    => 'image',
                'legend'  => 'Photo 5',
                'preview' => true,
                'alt'     => false,
                'ext'     => $photosExtensions,
                'dim'     => $photoDimensions,
            ],
        ]);
        ?>

    <?php echo $this->element('form_footer'); ?>
</div>
