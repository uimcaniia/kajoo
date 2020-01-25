<?php
namespace Model;

class PlanningDay extends PlanningDayManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_planning_day;

    private $_rang;

    // rang du planning dans la journée 1 : entree ; 2: plat ; 3:dessert
    private $_id_recette;

    // id de la recette
    private $_id_planning;

    // id du planning correspondant
    private $_other;

    // liste des plats ou autre qui ne viennet pas d'une recette
    private $_personn;

    // nbr de personne a manger
    private $_id_user;

    // id de l'utilisateur

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
    public function getId_planning_day()
    {
        return $this->_id_planning_day;
    }

    /**
     * Retourne rang du planning dans la journée
     */
    public function getRang()
    {
        return $this->_rang;
    }

    /**
     * Retourne id de la recette
     */
    public function getId_recette()
    {
        return $this->_id_recette;
    }

    /**
     * Retourne id du planning correspondant
     */
    public function getId_planning()
    {
        return $this->_id_planning;
    }

    /**
     * Retourne liste des plats ou autre qui ne viennet pas d'une recette
     */
    public function getOther()
    {
        return $this->_other;
    }

    /**
     * Retourne nbr de personne a manger
     */
    public function getPersonn()
    {
        return $this->_personn;
    }

    /**
     * Retourne id de l'utilisateur
     */
    public function getId_user()
    {
        return $this->_id_user;
    }

    // **************************************************
    // SETTERS
    // **************************************************
    public function setId_planning_day($id_planning_day)
    {
        $id_planning_day = (int) $id_planning_day;
        $this->_id_planning_day = $id_planning_day;
    }

    /**
     * Assigne rang du planning dans la journée
     */
    public function setRang($rang)
    {
        $rang = (int) $rang;
        $this->_rang = $rang;
    }

    /**
     * Assigne id de la recette
     */
    public function setId_recette($id_recette)
    {
        $id_recette = (int) $id_recette;
        $this->_id_recette = $id_recette;
    }

    /**
     * Assigne id du planning correspondant
     */
    public function setId_planning($id_planning)
    {
        $id_planning = (int) $id_planning;
        $this->_id_planning = $id_planning;
    }

    /**
     * Assigne liste des plats ou autre qui ne viennet pas d'une recette
     */
    public function setOther($other)
    {
        if (is_string($other)) {
            htmlspecialchars($other);
            $this->_other = $other;
        }
    }

    /**
     * Assigne nbr de personne a manger
     */
    public function setPersonn($personn)
    {
        $personn = (int) $personn;
        $this->_personn = $personn;
    }

    /**
     * Assigne id de l'utilisateur
     */
    public function setId_user($id_user)
    {
        $id_user = (int) $id_user;
        $this->_id_user = $id_user;
    }
}
	
