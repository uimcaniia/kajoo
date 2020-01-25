<?php
namespace Model;

class Liste extends ListManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_list;

    private $_id_planning_day;

    // quantité de l'ingrédient (gr;cl;unité...)
    private $_quantity;

    // id de l'ingrédient

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
    public function getId_list()
    {
        return $this->_id_list;
    }

    /**
     * Retourne id de l'ingrédient
     */
    public function getId_planning_day()
    {
        return $this->_id_planning_day;
    }

    /**
     * Retourne quantité de l'ingrédient (gr;cl;unité...)
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    // **************************************************
    // SETTERS
    // **************************************************

    /**
     * Assigne l'ID' de l'item
     */
    public function setId_list($id_list)
    {
        $id_list = (int) $id_list;
        $this->_id_list = $id_list;
    }

    /**
     * Assigne id de l'ingrédient
     */
    public function setId_planning_day($id_planning_day)
    {
        $id_planning_day = (int) $id_planning_day;
        $this->_id_planning_day = $id_planning_day;
    }

    /**
     * Assigne quantité de l'ingrédient (gr;cl;unité...)
     */
    public function setQuantity($quantity)
    {
        if (is_string($quantity)) {
            htmlspecialchars($quantity);
            $this->_quantity = $quantity;
        }
    }
}
	
