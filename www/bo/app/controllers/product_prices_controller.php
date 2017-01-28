<?php

/**
 * ProductPrices Controller
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 28/01/2017
 */
class ProductPricesController extends AppController
{
    /**
     * @var String
     **/
    var $name = 'ProductPrices';

    /**
     * @var ProductPrice
     **/
    var $ProductPrice;

    /**
     * ProductPrices/BeforeFilter
     **/
    function beforeFilter()
    {
        $this->pageTitle = __('Prix des produits', true);
        parent::beforeFilter();
    }

    /**
     * ProductPrice/Index
     **/
    function index()
    {
        $this->Filter->getConditions([
            'limit' => ['label' => ''],
        ]);

        // Options de la requete
        $this->paginate = array_merge($this->paginate, [
            'recursive' => 0,
            'fields'    => ['id', 'price', 'min_quantity', 'max_quantity', 'product_id', 'product_unit_id' ],
        ]);

        $this->set('productPrices', $this->paginate());
        $this->set('products', $this->getProducts());
        $this->set('productUnits', $this->getProductUnits());
    }

    /**
     * ProductPrice/Add
     **/
    function add()
    {
        // Enregistrement
        if (!empty($this->data)) {
            $this->ProductPrice->create();
            if ($this->ProductPrice->save($this->data)) {
                $this->Session->setFlash(__('Prix enregistré.', true), 'flash_succes');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('Prix non enregistré.', true), 'flash_error');
            }
        }

        $this->set('products', $this->getProducts());
        $this->set('productUnits', $this->getProductUnits());
    }

    /**
     * ProductPrice/Edit
     * @param int $id Identifiant de l'enregistrement
     **/
    function edit($id = null)
    {
        // Enregistrement
        if (!empty($this->data)) {
            if ($this->ProductPrice->save($this->data)) {
                $this->Session->setFlash(__('Prix enregistré.', true), 'flash_succes');
                $redirect = ($this->Session->check('Temp.referer')) ? $this->Session->read('Temp.referer') : ['action' => 'index'];
                $this->Session->del('Temp.referer');
                $this->redirect($redirect);
            } else {
                $this->Session->setFlash(__('Prix non enregistré.', true), 'flash_error');
            }
        }

        if (empty($this->data)) {
            $this->data = $this->ProductPrice->read(null, $id);

            // Referer pour recuperer la page precedente
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
                $this->Session->write('Temp.referer', $_SERVER['HTTP_REFERER']);
            }
        }

        $this->set('products', $this->getProducts());
        $this->set('productUnits', $this->getProductUnits());
    }


    /**
     * ProductPrice/Delete
     * @param int $id Identifiant de l'enregistrement à supprimer
     **/
    function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Identifiant invalide.', true), 'flash_error');
            $this->redirect(['action' => 'index']);
        }
        if ($this->ProductPrice->del($id)) {
            $this->Session->setFlash(__('Prix supprimé.', true), 'flash_succes');
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * @return mixed
     */
    protected function getProducts()
    {
        $products = $this->ProductPrice->Product->find('list', [
            'order' => ['Product.id' => 'DESC'],
        ]);

        return $products;
    }

    /**
     * @return mixed
     */
    protected function getProductUnits()
    {
        $productUnits = $this->ProductPrice->ProductUnit->find('list', [
            'order' => ['ProductUnit.id' => 'DESC'],
        ]);

        return $productUnits;
    }
}
