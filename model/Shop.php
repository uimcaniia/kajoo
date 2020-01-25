<?php
namespace Model;

class Shop extends ShopManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_shop;

    private $_date_planning_start;

    // date du début du planing
    private $_date_planning_end;

    // date de fin du planning
    private $_list;

    // liste de courses
    private $_recall;

    // date du début du rappel
    private $_id_user;

    // id de lutilisateur

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
    public function getId_shop()
    {
        return $this->_id_shop;
    }

    /**
     * Retourne rang du planning dans la journée
     */
    public function getDate_planning_start()
    {
        return strftime('%d-%m-%Y', strtotime($this->_date_planning_start));
    }

    /**
     * Retourne 1 : entree ; 2: plat ; 3:dessert
     */
    public function getDate_planning_end()
    {
        return strftime('%d-%m-%Y', strtotime($this->_date_planning_end));
    }

    /**
     * Retourne liste des plats ou autre qui ne viennet pas d'une recette
     */
    public function getList()
    {
        return $this->_list;
    }

    /**
     * Retourne id de la recette
     */
    public function getRecall()
    {
        return strftime('%d-%m-%Y', strtotime($this->_recall));
    }

    /**
     * Retourne id du planning correspondant
     */
    public function getId_user()
    {
        return $this->_id_user;
    }

    // **************************************************
    // SETTERS
    // **************************************************
    public function setId_shop($id_shop)
    {
        $id_shop = (int) $id_shop;
        $this->_id_shop = $id_shop;
    }

    /**
     * Assigne rang du planning dans la journée
     */
    public function setDate_planning_start($date_planning_start)
    {
        $this->_date_planning_start = $date_planning_start;
    }

    /**
     * Assigne 1 : entree ; 2: plat ; 3:dessert
     */
    public function setDate_planning_end($date_planning_end)
    {
        $this->_date_planning_end = $date_planning_end;
    }

    /**
     * Assigne liste des plats ou autre qui ne viennet pas d'une recette
     */
    public function setList($list)
    {
        if (is_string($list)) {
            htmlspecialchars($list);
            $this->_list = $list;
        }
    }

    /**
     * Assigne id de la recette
     */
    public function setRecall($recall)
    {
        $this->_recall = $recall;
    }

    /**
     * Assigne id du planning correspondant
     */
    public function setId_user($id_user)
    {
        $id_user = (int) $id_user;
        $this->_id_user = $id_user;
    }
}
	
