<?php

class LayoutFooterComponent extends AppComponent
{
    /** @var array Liste des éléments du menu */
    public $footerMenuItems = [];

    /** @var AppController Contrôleur */
    var $controller;

    /**
     * BeforeRender
     * @param $controller
     */
    function beforeRender($controller)
    {
        $this->controller = $controller;
        $this->setFooterMenuNodes();
    }

    /**
     * Pass footer menu nodes to view
     */
    private function setFooterMenuNodes()
    {
        $footerNodes = $this->controller->CmsNode->getNode('footer');

        foreach ($footerNodes['children'] as $node) {
            $link = $node['CmsNode']['link'];
            $link['lang'] = Configure::read('Config.langUrl');

            $this->footerMenuItems[] = [
                'title' => $node['CmsNode']['title'],
                'key' => $node['CmsNode']['key'],
                'href' => Router::url($link, true),
            ];
        }

        $this->controller->set('footerMenuItems', $this->footerMenuItems);
    }
}
