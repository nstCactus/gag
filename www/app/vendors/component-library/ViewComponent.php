<?php

class ViewComponent {

	public $name;
	public $viewPath;
	public $config;

	public function __construct($name, $viewPath, $config) {
		$this->name = $name;
		$this->viewPath = $viewPath;
		$this->config = array_merge_recursive([
			'children' => []
		],$config);
	}

	public function getRelativePathToElementFolder() {

		$relativePath = $this->relativePath(
			realpath(CONFIG_WEBROOT . '/' . CONFIG_APP . '/views/elements'),
			$this->viewPath
		);

		$relativePath = preg_replace('#.tpl$#', '', $relativePath);
		return $relativePath;
	}
	
	public function getStates() {
		$states = [];
		if(!isset($this->config['availableFields'])){
			return $states;
		}
		foreach ($this->config['availableFields'] as $field => $values) {
			if( ! is_array($values) || count($values) < 2 ) {
				continue;
			}

			$fieldStates = [];
			foreach ($values as $value) {
				$active = false;
				$currentFields = $this->config['fields'];
				if($currentFields[$field] == $value) {
					$active = true;
				}
				else {
					$currentFields[$field] = $value;
				}

				$fieldStates[] = [
					'name' => $value,
					'active' => $active,
					'fields' => $currentFields,
				];
			}
			$states[$field] = $fieldStates;
		}
		
		return $states;
	}

	private function relativePath($from, $to, $ps = DIRECTORY_SEPARATOR) {
		$arFrom = explode($ps, rtrim($from, $ps));
		$arTo = explode($ps, rtrim($to, $ps));
		while(count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0]))
		{
			array_shift($arFrom);
			array_shift($arTo);
		}
		return str_pad("", count($arFrom) * 3, '..'.$ps).implode($ps, $arTo);
	}
}