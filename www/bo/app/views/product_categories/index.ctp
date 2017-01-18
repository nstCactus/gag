<h1>Catégories de produits</h1>
<div class="barre">
    <div class="barreLeft">
        <div class="barreElement">
            <a href="<?php echo $html->url(array('controller'=>'product_categories', 'action'=>'add')); ?>" class="addIcon">Ajouter une catégorie de produits</a>
        </div>
    </div>
</div>
<div id="treeContainer">
    <?php  $tree->make('ProductCategory',  $productCategories); ?>
</div>
<script type="text/javascript">
    (function($){
        console.log($('#treeContainer'));
        $('#treeContainer').tree({
            changeServiceURL: '<?php
                echo $html->url(array('controller'=>'product_categories', 'action'=>'tree'));
                ?>'
        });
    })(jQuery);
</script>
