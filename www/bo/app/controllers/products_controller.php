<?php

/**
 * Products Controller
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 26/01/2017
 */
class ProductsController extends AppController
{
    /**
     * @var String
     **/
    var $name = 'Products';

    /**
     * @var Product
     **/
    var $Product;

    /**
     * Products/BeforeFilter
     **/
    function beforeFilter()
    {
        $this->pageTitle = __('Produits', true);
        parent::beforeFilter();

        $this->set('productCategories', $this->getProductCategoryList());
        $this->set('producers', $this->getProducerList());
    }

    /**
     * Product/Index
     **/
    function index()
    {
        $this->Filter->getConditions([
            'limit' => ['label' => ''],
        ]);

        // Options de la requete
        $this->paginate = array_merge($this->paginate, [
            'recursive' => 0,
            'fields'    => ['id', 'name', 'product_category_id', 'producer_id'],
        ]);

        $this->set('products', $this->paginate());
    }

    /**
     * Product/Add
     **/
    function add()
    {
        // Enregistrement
        if (!empty($this->data)) {
            $this->Product->create();
            if ($this->Product->save($this->data)) {
                $this->Session->setFlash(__('Produit enregistré.', true), 'flash_succes');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('Produit non enregistré.', true), 'flash_error');
            }
        }
    }

    /**
     * Product/Edit
     * @param int $id Identifiant de l'enregistrement
     **/
    function edit($id = null)
    {
        // Enregistrement
        if (!empty($this->data)) {
            if ($this->Product->save($this->data)) {
                $this->Session->setFlash(__('Produit enregistré.', true), 'flash_succes');
                $redirect = ($this->Session->check('Temp.referer')) ? $this->Session->read('Temp.referer') : ['action' => 'index'];
                $this->Session->del('Temp.referer');
                $this->redirect($redirect);
            } else {
                $this->Session->setFlash(__('Produit non enregistré.', true), 'flash_error');
            }
        }

        if (empty($this->data)) {
            $this->data = $this->Product->read(null, $id);

            // Referer pour recuperer la page precedente
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
                $this->Session->write('Temp.referer', $_SERVER['HTTP_REFERER']);
            }
        }
    }


    /**
     * Product/Delete
     * @param int $id Identifiant de l'enregistrement à supprimer
     **/
    function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Identifiant invalide.', true), 'flash_error');
            $this->redirect(['action' => 'index']);
        }
        if ($this->Product->del($id)) {
            $this->Session->setFlash(__('Produit supprimé.', true), 'flash_succes');
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * @return array|false
     * @fixme Afficher le chemin complet de la catégorie
     */
    protected function getProductCategoryList()
    {
        $productCategories = $this->Product->ProductCategory->find('list', [
            'order' => ['ProductCategory.id' => 'DESC'],
        ]);

        return $productCategories;
    }

    /**
     * @return array|false
     */
    protected function getProducerList()
    {
        $producers = $this->Product->Producer->find('list', [
            'order' => ['Producer.id' => 'DESC'],
        ]);

        return $producers;
    }
}
