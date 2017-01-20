<div class="producerActivities form">
    <?php echo $form->create('ProducerActivity', ['onsubmit' => 'return checkForm (this)']); ?>
	<h1><?php echo __('Ajouter une activité'); ?></h1>

	<fieldset>
		<legend><?php echo __('Activité', true); ?></legend>
        <?php
        echo $boLhsForm->input('ProducerActivity.id', ['label' => __('Id', 1)]);
        ?>
        <?php
        echo $boLhsForm->input('ProducerActivity.name', ['label' => __('Nom', 1), 'div' => 'inlined']);
        ?>
	</fieldset>

    <?php echo $this->element('form_footer'); ?>
</div>
