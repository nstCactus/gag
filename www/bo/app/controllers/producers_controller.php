<?php

App::import('Vendor', 'CmsContainerFactory');

/**
 * Producers Controller
 *
 * @author  nstCactus <nstCactus@gmail.com>
 * @version 20/01/2017
 */
class ProducersController extends AppController
{
    var $uses = ['Producer', 'ProducerActivity'];

    /**
     * @var String
     **/
    var $name = 'Producers';

    /**
     * @var Producer
     **/
    var $Producer;

    /**
     * @var ProducerActivity
     */
    var $ProducerActivity;

    /**
     * Producers/BeforeFilter
     **/
    function beforeFilter()
    {
        $this->pageTitle = __('Producteurs', true);
        parent::beforeFilter();
    }

    /**
     * Producer/Index
     **/
    function index()
    {
        $this->Filter->getConditions([
            'limit' => ['label' => ''],
        ]);

        // Options de la requete
        $this->paginate = array_merge($this->paginate, [
            'recursive' => 0,
            'fields'    => [
                'id',
                'statut',
                'corporate_name',
                'legal_form',
                'siret',
                'producer_activity_id',
                'post_code',
                'city',
                'phone_mobile',
                'phone_landline',
                'email',
            ],
        ]);

        $this->set('producers', $this->paginate());
        $this->set('activities', $this->getProducerActivities());
    }

    /**
     * Producer/Add
     **/
    function add()
    {
        // Créer le cmsContainer
        $cmsContainerFactory = new CmsContainerFactory();
        $cmsContainer = $cmsContainerFactory->create();

        // Création
        $data = array(
            'Producer' => array(
                'cms_container_id' => $cmsContainer->id,
            )
        );
        $this->Producer->create();
        $this->Producer->save($data);
        $this->redirect(array(
            'action' => 'edit',
            $this->Producer->id
        ));
    }

    protected function getProducerActivities()
    {
        return $this->ProducerActivity->find('list', [
            'order' => ['ProducerActivity.id' => 'DESC'],
        ]);
    }

    /**
     * Producer/Edit
     * @param int $id Identifiant de l'enregistrement
     **/
    function edit($id = null)
    {
        // Enregistrement
        if (!empty($this->data)) {
            // Enregistrer les données liées aux cmsContainer
            if(isset($this->data['blocks']))
            {
                $this->data['CmsContainer']['blocks'] = $this->data['blocks'];
            }
            $this->Producer->CmsContainer->save($this->data);

            if ($this->Producer->save($this->data)) {
                $this->Session->setFlash(__('Producteur enregistré.', true), 'flash_succes');
                $redirect = ($this->Session->check('Temp.referer')) ? $this->Session->read('Temp.referer') : ['action' => 'index'];
                $this->Session->del('Temp.referer');
                $this->redirect($redirect);
            } else {
                $this->Session->setFlash(__('Producteur non enregistré.', true), 'flash_error');
            }
        }

        if (empty($this->data)) {
            $this->data = $this->Producer->read(null, $id);

            // Récupération des blocks CMS
            $cmsContainer = $this->Producer->CmsContainer->read(null, $this->data['Producer']['cms_container_id']);
            $this->data['CmsContainer'] = $cmsContainer['CmsContainer'];
            $availableBlocks = $this->Producer->CmsContainer->getAvailableBlocks($this->data['Producer']['cms_container_id']);
            $this->set('availableBlocks', $availableBlocks);

            // Referer pour recuperer la page precedente
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
                $this->Session->write('Temp.referer', $_SERVER['HTTP_REFERER']);
            }
        }

        $this->set('producerActivities', $this->getProducerActivities());
    }

    /**
     * Producer/Delete
     * @param int $id Identifiant de l'enregistrement à supprimer
     **/
    function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Identifiant invalide.', true), 'flash_error');
            $this->redirect(['action' => 'index']);
        }
        if ($this->Producer->del($id)) {
            $this->Session->setFlash(__('Producteur supprimé.', true), 'flash_succes');
            $this->redirect(['action' => 'index']);
        }
    }
}
