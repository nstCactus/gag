<?php

App::import('View', 'Smarty');
App::import('Vendor', 'Blocks');
App::import('Vendor', 'Tools');
App::import('Vendor', 'Statique');
App::import('Vendor', 'Media');

/**
 * GatoAppController
 */
class FrontController extends Controller
{
    /** @var string Système de vue utilisé SmartyView */
    var $view = 'Smarty';


    ////////////////
    // COMPONENTS //
    ////////////////
    /** @var array Liste des components */
    var $components = [
        'Email',
        'Layout',
        'Language',
        'Dico',
        'Block',
        'Breadcrumb',
        'Javascript',
        'CmsNode',
        'CmsContainer',
        'Seo',
        'HeadTag',
        'LayoutHeader',
        'LayoutFooter',
    ];

    /** @var EmailComponent */
    public $Email;

    /** @var LayoutComponent */
    public $Layout;

    /** @var LanguageComponent */
    public $Language;

    /** @var DicoComponent */
    public $Dico;

    /** @var BlockComponent */
    public $Block;

    /** @var BreadcrumbComponent */
    public $Breadcrumb;

    /** @var CmsNodeComponent */
    public $CmsNode;

    /** @var CmsContainerComponent */
    public $CmsContainer;

    /** @var SeoComponent */
    public $Seo;

    /** @var HeadTagComponent */
    public $HeadTag;

    /** @var JavascriptComponent */
    public $Javascript;

    /** @var LayoutHeaderComponent */
    public $LayoutHeader;

    /** @var LayoutFooterComponent */
    public $LayoutFooter;


    /////////////
    // HELPERS //
    /////////////
    /** @var array Liste des helpers */
    var $helpers = array(
        'Html',
        'Javascript',
        'Text',
        'Cache',
    );
    /** @var HtmlHelper */
    public $Html;
    /** @var HtmlHelper */
    public $Text;
    /** @var CacheHelper */
    public $Cache;

    // Collision de nom Composant / Helper. C'est le composant qui a le dernier mot.
    //    /** @var JavascriptHelper */
    //    public $Javascript;


    /**
     * Fil d'ariane
     * @var array
     */
    var $breadcrumb = [];

    /**
     * BeforeFilter
     */
    function beforeFilter()
    {
        parent::beforeFilter();

        // Set locale
        setlocale(LC_TIME, explode(',', Dico::get('core.locale')));

        // Constante base pour les smarty plugins
        if (!defined('BASE')) {
            define('BASE', $this->base);
        }
    }


    /**
     * BeforeRender
     */
    function beforeRender()
    {
        parent::beforeRender();
        $this->set('cmsNodeSelectedKey', '');

        $this->set('folders', [
            'static' => $this->base . '/static',
            'media' => $this->base . '/media',
        ]);
    }

    /**
     * Surcharge la méthode redirect pour ajouter la langue dans les url
     * @param string  $url
     * @param integer $status
     * @param boolean $exit
     * @see Controller::redirect()
     * @return mixed
     */
    function redirect($url, $status = null, $exit = false)
    {
        if (is_array($url) && !isset($url['lang'])) {
            $url["lang"] = Configure::read("Config.langUrl");
        }
        return parent::redirect($url, $status, $exit);
    }


    /**
     * Déclenche une erreur 404
     */
    function throw404()
    {
        // 404
        $this->cakeError('error404', [ [ 'url' => '/' ] ]);
        exit();
    }
}
