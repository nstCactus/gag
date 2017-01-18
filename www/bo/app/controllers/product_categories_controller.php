<?php

/**
 * ProductCategories Controller
 *
 * @author    nstCactus <nstCactus@gmail.com>
 * @version   15/01/2017
 */
class ProductCategoriesController extends AppController
{
    var $components =  [ 'Tree' ];

    /**
     * @var String
     **/
    var $name = 'ProductCategories';

    // Helpers
    var $helpers = array('Tree');

    /**
     * @var ProductCategory
     **/
    var $ProductCategory;

    /**
     * @var TreeComponent
     */
    var $Tree;

    /**
     * ProductCategories/BeforeFilter
     **/
    function beforeFilter()
    {
        $this->pageTitle = __('Catégories de produits', true);
        parent::beforeFilter();
    }

    /**
     * ProductCategory/Index
     **/
    function index()
    {
        $productCategories = $this->Tree->_generateTree($this->ProductCategory);
        $this->set('productCategories', $productCategories);
    }

    /**
     * Tree
     * Gestion des mouvements dans l'arbo
     * Affiche l'arbo
     */
    function tree(){
        $this->Tree->_moveTree($this->ProductCategory);
        $productCategories = $this->Tree->_generateTree($this->ProductCategory);
        $this->set('productCategories', $productCategories);
    }

    /**
     * ProductCategory/Add
     **/
    function add()
    {
        // Enregistrement
        if (!empty($this->data)) {
            $this->ProductCategory->create();
            if ($this->ProductCategory->save($this->data)) {
                $this->Session->setFlash(__('Catégorie de produits enregistrée.', true), 'flash_succes');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('Catégorie de produits non enregistrée.', true), 'flash_error');
            }
        }

        $this->_injectCategories();
    }

    /**
     * ProductCategory/Edit
     * @param int $id Id de l\'enregistrement
     **/
    function edit($id = null)
    {
        // Enregistrement
        if (!empty($this->data)) {
            if ($this->ProductCategory->save($this->data)) {
                $this->Session->setFlash(__('Catégorie de produits enregistrée.', true), 'flash_succes');
                $redirect = ($this->Session->check('Temp.referer')) ? $this->Session->read('Temp.referer') : ['action' => 'index'];
                $this->Session->delete('Temp.referer');
                $this->redirect($redirect);
            } else {
                $this->Session->setFlash(__('Catégorie de produits non enregistrée.', true), 'flash_error');
            }
        }

        if (empty($this->data)) {
            $this->data = $this->ProductCategory->read(null, $id);

            // Referer pour recuperer la page precedente
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
                $this->Session->write('Temp.referer', $_SERVER['HTTP_REFERER']);
            }
        }

        $this->_injectCategories();
    }


    /**
     * ProductCategory/Delete
     * @param int $id Identifiant de l'enregistrement
     **/
    function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Identifiant invalide.', true), 'flash_error');
            $this->redirect(['action' => 'index']);
        }
        if ($this->ProductCategory->del($id)) {
            $this->Session->setFlash(__('Catégorie de produits supprimée.', true), 'flash_succes');
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Injecter la liste des catégories
     * dans la vue.
     */
    function _injectCategories(){
        // Récupérer la liste des catégories
        $productCategories = $this->ProductCategory->find('threaded', [
            'recursive' => -1,
            'order' => [ 'ProductCategory.lft' => 'ASC' ]
        ]);

        // Transformer pour l'utiliser dans un select
        $productCategories = $this->Tree->_treeToSelect(
            $this->ProductCategory,
            $productCategories
        );
        $productCategories = ['' => 'No parent (root category)'] + $productCategories;

        // Passer à la vue
        $this->set('productCategories', $productCategories);
    }

}
