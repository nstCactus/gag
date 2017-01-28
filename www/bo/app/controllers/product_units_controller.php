<?php

/**
 * ProductUnits Controller
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 28/01/2017
 */
class ProductUnitsController extends AppController
{
    /**
     * @var String
     **/
    var $name = 'ProductUnits';

    /**
     * @var ProductUnit
     **/
    var $ProductUnit;

    /**
     * ProductUnits/BeforeFilter
     **/
    function beforeFilter()
    {
        $this->pageTitle = __('Unités', true);
        parent::beforeFilter();
    }

    /**
     * ProductUnit/Index
     **/
    function index()
    {
        $this->Filter->getConditions([
            'limit' => ['label' => ''],
        ]);

        // Options de la requete
        $this->paginate = array_merge($this->paginate, [
            'recursive' => 0,
            'fields'    => ['id', 'name'],
        ]);

        $productUnits = $this->paginate();
        $this->set(compact('productUnits'));
    }

    /**
     * ProductUnit/Add
     **/
    function add()
    {
        // Enregistrement
        if (!empty($this->data)) {
            $this->ProductUnit->create();
            if ($this->ProductUnit->save($this->data)) {
                $this->Session->setFlash(__('Unité enregistrée.', true), 'flash_succes');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('Unité non enregistrée.', true), 'flash_error');
            }
        }
    }

    /**
     * ProductUnit/Edit
     * @param int $id Identifiant de l'enregistrement
     **/
    function edit($id = null)
    {
        // Enregistrement
        if (!empty($this->data)) {
            if ($this->ProductUnit->save($this->data)) {
                $this->Session->setFlash(__('Unité enregistrée.', true), 'flash_succes');
                $redirect = ($this->Session->check('Temp.referer')) ? $this->Session->read('Temp.referer') : ['action' => 'index'];
                $this->Session->del('Temp.referer');
                $this->redirect($redirect);
            } else {
                $this->Session->setFlash(__('Unité non enregistrée.', true), 'flash_error');
            }
        }

        if (empty($this->data)) {
            $this->data = $this->ProductUnit->read(null, $id);

            // Referer pour recuperer la page precedente
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
                $this->Session->write('Temp.referer', $_SERVER['HTTP_REFERER']);
            }
        }

    }


    /**
     * ProductUnit/Delete
     * @param int $id Identifiant de l'enregistrement à supprimer
     **/
    function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Identifiant invalide.', true), 'flash_error');
            $this->redirect(['action' => 'index']);
        }
        if ($this->ProductUnit->del($id)) {
            $this->Session->setFlash(__('Unité supprimée.', true), 'flash_succes');
            $this->redirect(['action' => 'index']);
        }
    }
}
