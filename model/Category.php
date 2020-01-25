<?php
namespace Model;

class Category extends CategoryManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_category;

    private $_rang;

    // rang de la catégorie pour l'affichage
    private $_title;

    // libellé de la catégory
    private $_id_user;

    // id user a qui appartient la catégorie
    private $_default_category;

    // category par défaut : 1 sinon 0

    // **************************************************
    // Methode
    // **************************************************
    public function getDataToHydrate($intIdEpisode)
    {
        if ((is_int($intIdEpisode)) && ($intIdEpisode > 0)) {
            $aData = parent::get($intIdEpisode);
            self::hydrate($aData);
        } else {
            throw new Exception('le chapitre ' . $intIdEpisode . ' n\'existe pas');
        }
    }

    public function hydrate($aData)
    {
        if ($aData != false) {
            foreach ($aData as $key => $value) {
                // On récupère le nom du setter correspondant à l'attribut en mettant sa première lettre en majuscule.
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }

    // **************************************************
    // GETTERS
    // **************************************************

    /**
     * Retourne l'ID' de l'item
     */
    public function getId_category()
    {
        return $this->_id_category;
    }

    /**
     * Retourne rang de la catégorie pour l'affichage
     */
    public function getRang()
    {
        return $this->_rang;
    }

    /**
     * Retourne libellé de la catégory
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Retourne id user a qui appartient la catégorie
     */
    public function getId_user()
    {
        return $this->_id_user;
    }

    /**
     * Retourne category par défaut : 1 sinon 0
     */
    public function getDefault_category()
    {
        return $this->_default_category;
    }

    // **************************************************
    // SETTERS
    // **************************************************

    /**
     * Assigne l'ID' de l'item
     */
    public function setId_category($id_category)
    {
        $id_category = (int) $id_category;
        $this->_id_category = $id_category;
    }

    /**
     * Retourne rang de la catégorie pour l'affichage
     */
    public function setRang($rang)
    {
        $rang = (int) $rang;
        $this->_rang = $rang;
    }

    /**
     * Assigne libellé de la catégory
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            htmlspecialchars($title);
            $this->_title = $title;
        }
    }

    /**
     * Assigne id user a qui appartient la catégorie
     */
    public function setId_user($id_user)
    {
        $id_user = (int) $id_user;
        $this->_id_user = $id_user;
    }

    /**
     * Assigne category par défaut : 1 sinon 0
     */
    public function setDefault_category($default_category)
    {
        $default_category = (int) $default_category;
        $this->_default_category = $default_category;
    }
}
	
