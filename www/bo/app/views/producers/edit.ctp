<div class="producers form">
    <?php echo $form->create('Producer', ['onsubmit' => 'return checkForm (this)']); ?>
	<h1><?php echo __('Modifier un producteur'); ?></h1>

    <?php echo $form->input('CmsContainer.id'); ?>

	<fieldset>
		<legend><?php echo __('Producteur', true); ?></legend>
        <?php
        echo $boLhsForm->input('Producer.id', [
            'label' => __('Id', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.corporate_name', [
            'label' => __('Raison sociale', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.legal_form', [
            'label' => __('Forme juridique', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.siret', [
            'label' => __('SIRET', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.producer_activity_id', [
            'label' => __('Activité', 1),
            'div'   => 'inlined',
        ]);
        ?>
	</fieldset>

	<fieldset>
		<legend>Adresse</legend>

        <?php
        echo $boLhsForm->input('Producer.address', [
            'label' => __('Adresse de l\'exploitation', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.post_code', [
            'label' => __('Code postal', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.city', [
            'label' => __('Ville', 1),
            'div'   => 'inlined',
        ]);
        ?>
	</fieldset>

	<fieldset>
		<legend>Contact</legend>

        <?php
        echo $boLhsForm->input('Producer.email', [
            'label' => __('E-mail', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.phone_mobile', [
            'label' => __('Téléphone portable', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('Producer.phone_landline', [
            'label' => __('Téléphone fixe', 1),
            'div'   => 'inlined',
        ]);
        ?>
	</fieldset>

	<fieldset>
		<legend>Référencement</legend>
        <?php echo $this->element('form/slug'); ?>

        <?php if ((Acl::checkAco('others/seo'))): ?>
            <?php
            echo $boLhsForm->input('Producer.seotitle', [
                'label' => __('Titre', 1),
                'type'  => ['type' => 'seo'],
                'div'   => 'inlined',
            ]);
            ?>
            <?php
            echo $boLhsForm->input('Producer.seodescription', [
                'label' => __('Description', 1),
                'type'  => ['type' => 'seo'],
                'div'   => 'inlined',
            ]);
            ?>
            <?php
            echo $boLhsForm->input('Producer.seokeywords', [
                'label' => __('Keywords', 1),
                'type'  => ['type' => 'seo'],
                'div'   => 'inlined',
            ]);
            ?>
        <?php endif; ?>
	</fieldset>

	<?php echo $this->element('cms_container/block_manager'); ?>

	<fieldset>
		<legend>Publication</legend>
        <?php
        echo $boLhsForm->input('Producer.statut', [
            'label' => __('Publier sur le site', 1),
        ]);
        ?>
	</fieldset>

    <?php echo $this->element('form_footer'); ?>
</div>
