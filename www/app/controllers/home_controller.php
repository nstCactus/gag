<?php

/**
 * Home Controller
 *
 * @author Maxime Colin
 *
 */
class HomeController extends AppController
{
    var $uses = [];

    /**
     * Home / Index
     */
    function index()
    {
    }


    /**
     * Rediriger / sur la langue courante
     */
    function redirectLang()
    {
        $this->redirect(array(
            'controller' => 'home',
            'action' => 'index',
            'lang' => Configure::read('Config.langUrl')
        ), 301);
    }
}
