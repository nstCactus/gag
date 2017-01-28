<?php 
	$options = array (
		'title' => 'ProductUnits',
		'actions' => array (
			'addActionTitle' => __("Ajouter productUnit", true),
		),
		'model' => 'ProductUnit',
		'data' => $productUnits,
		'fields' => array (
			'id' =>   array (
				'label' => __("Id", true),
			),
			'name' =>   array (
				'label' => __("Nom", true),
				'width' => '100%',
			),
		),
		'filters' => $filters,
	);

	if(isset($isAjax) && $isAjax){
		$json = array(
			'table' => $boIndexVue->index_table($options),
			'counter' => $boIndexVue->setCounter(),
		);					
		echo $javascript->Object($json);		
	} else {
		$afterBarre = '';
		if(count(Lang::getIso(Lang::getAdministrer())) > 0 && isset($options['i18n'])){
			$afterBarre = '<div class="highlightLegend"><span class="square_color"><em></em></span>'.__('Elément non présent dans votre langue principale',1).'</div>';
		}
		$content = array(
			'afterTitle' => $this->element('auto_complete_filter_index_vue'),
			'afterBarre' => $afterBarre,
			'afterTable' => ''
		);
		
		echo $boIndexVue->index($options, $content);
	}