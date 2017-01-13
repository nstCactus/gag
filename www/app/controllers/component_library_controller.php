<?php

App::import('Vendor', 'FileComponent', array('file' => 'component-library' . DS . 'FileComponent.php'));


class ComponentLibraryController extends AppController
{
    var $uses = [];
    var $componentsPath;

    public function beforeFilter()
    {
        $this->componentsPath = realpath(__DIR__ . '/../views/elements/components');
    }


    /**
     * CL / Index
     */
    function index()
    {
        $this->layout = 'blank';
        $fileComponent = new FileComponent($this->componentsPath);
        $components = $fileComponent->getComponents();
        $this->set('components', $components);
    }

    /**
     * CL / View
     */
    public function view()
    {
        $componentName = $this->params['componentName'];

        $overrideFields = [];
        if (isset($this->params['url']['fields'])) {
            $overrideFields = json_decode($this->params['url']['fields'], true);
        }

        $fileComponent = new FileComponent($this->componentsPath);
        $component = $fileComponent->createComponent($componentName, $overrideFields);

        if (isset($component->config['layout'])) {
            $this->layout = $component->config['layout'] . '/' . $component->config['layout'];
        }

        $this->set('componentLibraryComponent', $component);
    }
}
