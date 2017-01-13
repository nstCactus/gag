<?php

App::import('Vendor', 'ViewComponent', array('file' => 'component-library'.DS.'ViewComponent.php'));


class FileComponent {

	private $folder;

	/**
	 * FileComponent constructor.
	 * @param $folder
	 */
	public function __construct($folder) {
		$this->folder = realpath($folder);
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	public function getComponents() {
		$components = [];

		foreach (glob($this->folder . '/*') as $componentFolder) {
			$name = basename($componentFolder);
			$component = $this->createComponent($name);
			array_push($components, $component);
		}

		return $components;
	}

	/**
	 * @param $name
	 * @param array $overrideFields
	 * @return ViewComponent
	 * @throws Exception
	 */
	public function createComponent($name, $overrideFields = []) {
		$componentFolder = realpath($this->folder . '/' . $name);

		if( ! file_exists($componentFolder)) {
			throw new Exception('Component folder"' . $componentFolder . '" not exists');
		}

		$viewPath = $componentFolder . '/' . $name . '.tpl';
		if( ! file_exists($viewPath)) {
			throw new Exception('View "'.$viewPath . '" not exists !');
		}

		$configPath = $componentFolder . '/' . $name . '.json';
		$config = $this->getConfig($configPath, $overrideFields);

		$component = new ViewComponent($name, $viewPath, $config);
		return $component;
	}

	/**
	 * @param $configPath
	 * @return array|mixed
	 */
	private function getConfig($configPath, $overrideFields = []) {
		if( ! file_exists($configPath)) {
			return [];
		}

		$config = json_decode(file_get_contents($configPath), true);

		if(json_last_error() != 0) {
			die('<pre><b style="color:red;">Erreur JSON invalide</b> : <br>Impossible de décoder le fichier '.$configPath.' </pre>');
		}
		
		$config['availableFields'] = $this->getConfigAvailableFields($config);
		$config['fields'] = $this->getConfigFields($config);

		// Merge config fields
		$config['fields'] = array_merge($config['fields'], $overrideFields);
		
		return $config;
	}

	/**
	 * @param $config
	 * @return array
	 */
	private function getConfigFields($config) {
		if( ! isset($config['fields'])) {
			return [];
		}

		$fields = array_map(function($field) {
			if(is_array($field)) {
				return reset($field);
			}

			return $field;
		}, $config['fields']);

		return $fields;
	}

	/**
	 * @param $config
	 * @return array
	 */
	private function getConfigAvailableFields($config) {
		if( ! isset($config['fields'])) {
			return [];
		}

		return $config['fields'];
	}


}