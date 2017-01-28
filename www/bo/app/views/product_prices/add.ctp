<div class="productPrices form">
    <?php echo $form->create('ProductPrice', ['onsubmit' => 'return checkForm (this)']); ?>
	<h1><?php echo __('Ajouter un prix'); ?></h1>

	<fieldset>
		<legend><?php echo __('Prix', true); ?></legend>
        <?php
        echo $boLhsForm->input('ProductPrice.price', ['label' => __('Prix', 1), 'div' => 'inlined']);
        ?>
        <?php
        echo $boLhsForm->input('ProductPrice.min_quantity', ['label' => __('Quantité min', 1), 'div' => 'inlined']);
        ?>
        <?php
        echo $boLhsForm->input('ProductPrice.max_quantity', ['label' => __('Quantité max', 1), 'div' => 'inlined']);
        ?>
        <?php
        echo $boLhsForm->input('ProductPrice.product_id', ['label' => __('Produit', 1), 'div' => 'inlined']);
        ?>
        <?php
        echo $boLhsForm->input('ProductPrice.product_unit_id', ['label' => __('Unité', 1), 'div' => 'inlined']);
        ?>
	</fieldset>

	<fieldset>
		<legend>Prix à l'unité de mesure</legend>
        <?php
        echo $boLhsForm->input('ProductPrice.measure_unit_price', ['label' => __('Prix', 1), 'div' => 'inlined']);
        ?>
        <?php
        echo $boLhsForm->input('ProductPrice.measure_unit_id', [
            'label'   => __('Unité', 1),
            'div'     => 'inlined',
            'type'    => 'select',
            'options' => $productUnits,
        ]);
        ?>
	</fieldset>

    <?php echo $this->element('form_footer'); ?>
</div>
