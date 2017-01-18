<div class="productCategories form">
    <?php echo $form->create('ProductCategory', ['onsubmit' => 'return checkForm (this)']); ?>
	<h1><?php echo __('Modifier une catégorie de produits'); ?></h1>

	<fieldset>
		<legend><?php echo __('Catégorie de produits', true); ?></legend>
        <?php
        echo $boLhsForm->input('ProductCategory.id', [
            'label' => __('Id', 1),
        ]);
        ?>
        <?php
        echo $boLhsForm->input('ProductCategory.name', [
            'label' => __('Nom', 1),
            'div'   => 'inlined',
        ]);
        ?>
        <?php
        echo $boLhsForm->input('ProductCategory.parent_id', [
            'label'   => __('Catégorie parente', 1),
            'options' => $productCategories,
            'div'     => 'inlined',
        ]);
        ?>
	</fieldset>

	<fieldset>
		<legend>Référencement</legend>
        <?php echo $this->element('form/slug'); ?>

        <?php if ((Acl::checkAco('others/seo'))): ?>
            <?php
            echo $boLhsForm->input('ProductCategory.seotitle', [
                'label' => __('Titre', 1),
                'type'  => ['type' => 'seo'],
                'div'   => 'inlined',
            ]);
            ?>
            <?php
            echo $boLhsForm->input('ProductCategory.seodescription', [
                'label' => __('Description', 1),
                'type'  => ['type' => 'seo'],
                'div'   => 'inlined',
            ]);
            ?>
            <?php
            echo $boLhsForm->input('ProductCategory.seokeywords', [
                'label' => __('Keywords', 1),
                'type'  => ['type' => 'seo'],
                'div'   => 'inlined',
            ]);
            ?>
        <?php endif; ?>
	</fieldset>

	<fieldset>
		<legend>Publication</legend>
        <?php
        echo $boLhsForm->input('ProductCategory.statut', [
            'label' => __('Publier sur le site', 1),
        ]);
        ?>
	</fieldset>

    <?php echo $this->element('form_footer'); ?>
</div>
