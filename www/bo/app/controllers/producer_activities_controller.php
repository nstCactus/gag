<?php

/**
 * ProducerActivities Controller
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 19/01/2017
 */
class ProducerActivitiesController extends AppController
{
    /**
     * @var String
     **/
    var $name = 'ProducerActivities';

    /**
     * @var ProducerActivity
     **/
    var $ProducerActivity;

    /**
     * ProducerActivities/BeforeFilter
     **/
    function beforeFilter()
    {
        $this->pageTitle = __('Activités des producteurs', true);
        parent::beforeFilter();
    }

    /**
     * ProducerActivity/Index
     **/
    function index()
    {
        $this->Filter->getConditions([
            'limit' => ['label' => ''],
        ]);

        // Options de la requete
        $this->paginate = array_merge($this->paginate, [
            'recursive' => 0,
            'fields'    => [ 'id', 'name' ],
        ]);

        $this->set('producerActivities', $this->paginate());
    }

    /**
     * ProducerActivity/Add
     **/
    function add()
    {
        // Enregistrement
        if (!empty($this->data)) {
            $this->ProducerActivity->create();
            if ($this->ProducerActivity->save($this->data)) {
                $this->Session->setFlash(__('Activité enregistrée.', true), 'flash_succes');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('Activité non enregistrée.', true), 'flash_error');
            }
        }
    }

    /**
     * ProducerActivity/Edit
     * @param int $id Identifiant de l'enregistrement
     **/
    function edit($id = null)
    {
        // Enregistrement
        if (!empty($this->data)) {
            if ($this->ProducerActivity->save($this->data)) {
                $this->Session->setFlash(__('Activité enregistrée.', true), 'flash_succes');
                $redirect = ($this->Session->check('Temp.referer')) ? $this->Session->read('Temp.referer') : ['action' => 'index'];
                $this->Session->del('Temp.referer');
                $this->redirect($redirect);
            } else {
                $this->Session->setFlash(__('Activité non enregistrée.', true), 'flash_error');
            }
        }

        if (empty($this->data)) {
            $this->data = $this->ProducerActivity->read(null, $id);

            // Referer pour recuperer la page precedente
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
                $this->Session->write('Temp.referer', $_SERVER['HTTP_REFERER']);
            }
        }

    }


    /**
     * ProducerActivity/Delete
     * @param int $id Identifiant de l'enregistrement
     **/
    function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('ID invalide.', true), 'flash_error');
            $this->redirect(['action' => 'index']);
        }
        if ($this->ProducerActivity->del($id)) {
            $this->Session->setFlash(__('Activité supprimée.', true), 'flash_succes');
            $this->redirect(['action' => 'index']);
        }
    }

}
