<?php

function smarty_modifier_component ($componentName, $componentConfig = []) {
	/** @var SmartyView $view */
	$view = ClassRegistry::getObject('view');

	// Keep the value of the `component` template var to restore it after rendering the component
	$tmp = $view->Smarty->getTemplateVars('component');

	$componentView = $view->renderElement('components/' . $componentName . '/' . $componentName, [
		'component' => $componentConfig,
	]);

	// Restore the value of the `component` template var, just in case it was overriden by the component's template
	$view->Smarty->assign('component', $tmp);

	return $componentView;
}
