<?php

/**
 * This component is used to inject header-related content (define view variables) to the layout.
 */
class LayoutHeaderComponent extends AppComponent
{
    /** @var array Liste des éléments du menu */
    var $headerMenuItems = [];

    /** @var AppController Contrôleur */
    var $controller;

    /** @var LanguageComponent $Language */
    public $Language;

    /**
     * BeforeRender
     * @param $controller
     */
    function beforeRender($controller)
    {
        $this->controller = $controller;
        $this->setHeaderMenuNodes();
        $this->setLanguages();
    }

    /**
     * Pass header menu nodes to view
     */
    private function setHeaderMenuNodes()
    {
        $headerNodes = $this->controller->CmsNode->getNode('header');

        foreach ($headerNodes['children'] as $node) {
            $active = false;
            if (
                (isset($node['CmsNode']['currentPage']) && $node['CmsNode']['currentPage']) ||
                (isset($node['CmsNode']['containCurrentPage']) && $node['CmsNode']['containCurrentPage']) ||
                (isset($node['CmsNode']['selected']) && $node['CmsNode']['selected'])
            ) {
                $active = true;
            }

            $this->headerMenuItems[$node['CmsNode']['key']] = [
                'title' => $node['CmsNode']['title'],
                'href' => Router::url($node['CmsNode']['link'], true),
                'active' => $active,
            ];
        }

        $this->controller->set('headerMenuItems', $this->headerMenuItems);
    }

    protected function setLanguages()
    {
        $languages = [];
        array_walk($this->controller->Language->languages, function($languageName, $languageCode) use (&$languages){
            $languages[$languageCode] = [
                'name'  => $languageName,
                'url'   => Router::url([
                    'controller'    => 'home',
                    'action'        => 'index',
                    'lang'          => $languageCode,
                ]),
            ];
        });

        $this->controller->set('languages',         $languages);
        $this->controller->set('currentLanguage',   $this->controller->Language->currentLanguage);
    }
}
