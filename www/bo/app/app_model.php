<?php
/*
      Copyright (c) 2009, La Haute Société (http://www.lahautesociete.com).
      All rights reserved.
 *
 * @version Jan 2010
 * @author Mounir DJIAR
 * Email: mounir@lahautesociete.com
 */

/**
 * AppModel
 *
 */
class AppModel extends Model
{
    static $contentLanguagesNames = null;
    static $contentLanguagesCodes = null;
    static $idLanguagePrincipale = null;
    static $UserId = null;

    function setContentLanguages($type, $cl)
    {
        switch ($type) {
            case 'names':
                self::$contentLanguagesNames = $cl;
                break;

            case 'codes':
                self::$contentLanguagesCodes = $cl;
                break;
        }
    }

    function setIdLanguagePrincipale($id)
    {
        self::$idLanguagePrincipale = $id;
    }

    function getIdLanguagePrincipale()
    {
        return self::$idLanguagePrincipale;
    }

    function setUserId($id)
    {
        self::$UserId = $id;
    }

    function getUserId()
    {
        return self::$UserId;
    }

    /**
     * BeforeValidate
     */
    function beforeValidate()
    {
        // Rajout des SEO
        $this->addSeoFields();

        $behaviors = array('Traduisible', 'Upload');

        foreach ($behaviors as $behavior) {
            if (isset($this->validationErrors[$behavior])) {
                foreach ($this->validationErrors[$behavior] as $field => $err) {
                    if (!isset($this->validationErrors[$field])) {
                        $this->validationErrors[$field] = $err;
                    }
                }
                unset($this->validationErrors[$behavior]);
            }
        }
    }

    /**
     * AddSEOFields
     *
     * Ajoute les champs SEO vide s'ils sont présent dans le schéma
     * et pas présent dans this->data pour l'AJOUT uniquement
     */
    function addSeoFields()
    {
        // Je récupere la liste des champs
        $listFieldsSelf = Tools::getFieldList($this->_schema, '/seo/i');
        $listFieldsI18n = array();
        if (isset($this->actsAs['Traduisible'])) {
            $listFieldsI18n = Tools::getFieldList($this->actsAs['Traduisible'], '/seo/i');
        }

        $languages = Lang::getAllLang();
        $languages = Set::combine($languages, ' {n}.Language.code_pays', ' {n}.Language.code_iso');
        foreach ($listFieldsI18n as $currentField) {
            foreach ($languages as $langCode) {
                if (!isset($this->data[$this->alias][$currentField][$langCode]) && !isset($this->data[$this->alias]['id'])) {
                    $this->data[$this->alias][$currentField][$langCode] = '';
                }
            }
        }
    }

    /**
     * Sert pour la duplication d'un enregistrement
     * Ne duplique pas les fichiers et les medias
     * @param $id
     */
    function duplicate($id = null)
    {

        if (isset($id)) {
            $item = $this->read(null, $id);
            $actsAs = $this->actsAs;

            // On désactive l'upload de fichier
            if (isset($actsAs['Upload']) && !empty($actsAs['Upload'])) {
                foreach ($actsAs['Upload'] as $keyToUpload => $val) {
                    // Si c'est de l'upload mutliple alors c'est un tableau
                    if (isset($actsAs['Upload'][$keyToUpload]['associatedModel'])) {
                        $item[$actsAs['Upload'][$keyToUpload]['associatedModel']] = array();
                    } else { // Si c'est de l'upload simple alors c'est une key dans le model courant
                        $item[$this->alias][$keyToUpload] = '';
                    }
                }
            }
            // Désactive le behavior
            $this->Behaviors->detach("Upload");

            // On désactive le behavior publiable (facebook et tweeter)
            if (isset($actsAs['Publiable']) && !empty($actsAs['Publiable'])) {
                foreach ($actsAs['Publiable'] as $key) {
                    $item[$this->alias][$key] = 0;
                }
            }

            // On supprime l'id
            unset($item[$this->alias]['id']);

            // On formate les data pour avoir la meme structure de données comme lors d'un 'add'

            // Gestion des traduisibles
            if (isset($actsAs['Traduisible'])) {
                foreach ($actsAs['Traduisible'] as $field => $namePlu) {
                    if (isset($item[$namePlu])) {
                        $value = $item[$namePlu];
                    } elseif (isset($item[$explodeName[0]][$explodeName[1]])) {
                        $value = $item[$explodeName[0]][$explodeName[1]];
                    } else {
                        $value = '';
                    }

                    if (is_array($value)) {
                        $data = @Set::combine($value, ' {n}.locale', ' {n}.content');
                        unset($item[$this->alias][$field]);
                        $listLang = $this->getContentLanguages('names');
                        foreach ($listLang as $langCode => $langName) {
                            $item[$this->alias][$field][$langCode] = $data[$langCode];
                        }
                    }

                    // Supprime le tableau pluriel
                    unset($item[$namePlu]);
                }
            }

            // Gestion des sortable
            if (isset($actsAs['Sortable'])) {
                foreach ($actsAs['Sortable'] as $field) {
                    $item[$this->alias][$field] = 1;
                }
            }

            // Netoyer les data
            if (isset($item[$this->alias]['locale'])) {
                unset($item[$this->alias]['locale']);
            }
            if (isset($item[$this->alias]['created'])) {
                unset($item[$this->alias]['created']);
            }
            if (isset($item[$this->alias]['updated'])) {
                unset($item[$this->alias]['updated']);
            }

            // Ne pas publier !
            if (isset($item[$this->alias]['statut'])) {
                $item[$this->alias]['statut'] = 0;
            }

            // Il faut faire maintenant la "création"
            $this->create();

            if ($this->save($item)) {
                return $this->id;
            }

            return null;
        }
    }

    function getContentLanguages($type)
    {
        switch ($type) {
            case 'names':
                return self::$contentLanguagesNames;
                break;

            case 'codes':
                return self::$contentLanguagesCodes;
                break;
        }
    }

    /**
     * UnbindAll
     */
    function unbindModelAll()
    {
        foreach (array(
                     'hasOne'              => array_keys($this->hasOne),
                     'hasMany'             => array_keys($this->hasMany),
                     'belongsTo'           => array_keys($this->belongsTo),
                     'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany),
                 ) as $relation => $model) {
            $this->unbindModel(array($relation => $model));
        }
    }


    /**
     * Change Data Source
     */
    function changeDataSource($newSource)
    {
        parent::setDataSource($newSource);
        parent::__construct();
    }
}
