<div class="productUnits form">
    <?php echo $form->create('ProductUnit', ['onsubmit' => 'return checkForm (this)']); ?>
	<h1><?php echo __('Modifier une unité'); ?></h1>

	<fieldset>
		<legend><?php echo __('Unité', true); ?></legend>
        <?php
        echo $boLhsForm->input('ProductUnit.id', [ 'label' => __('Id', 1) ]);
        ?>
        <?php
        echo $boLhsForm->input('ProductUnit.name', [ 'label' => __('Nom', 1), 'div' => 'inlined' ]);
        ?>
	</fieldset>

    <?php echo $this->element('form_footer'); ?>
</div>
