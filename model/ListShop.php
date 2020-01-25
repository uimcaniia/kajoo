<?php
namespace Model;

class ListShop extends ListShopManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_list_shop;

    private $_id_list;

    // id de la liste de course du planning_day
    private $_more;

    // ajout de la personne de chose qui ne sont pas des ingrédient d'une recette

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
     * Retourne id de l'ingrédient
     */
    public function getId_list_shop()
    {
        return $this->_id_list_shop;
    }

    /**
     * Retourne id de la liste de course du planning_day
     */
    public function getId_list()
    {
        return $this->_id_list;
    }

    /**
     * Retourne ajout de la personne de chose qui ne sont pas des ingrédient d'une recette
     */
    public function getMore()
    {
        return $this->_more;
    }

    // **************************************************
    // SETTERS
    // **************************************************

    /**
     * Assigne id de l'ingrédient
     */
    public function setId_list_shop($id_list_shop)
    {
        $id_list_shop = (int) $id_list_shop;
        $this->_id_list_shop = $id_list_shop;
    }

    /**
     * Assigne id de la liste de course du planning_day
     */
    public function setId_list($id_list)
    {
        $id_list = (int) $id_list;
        $this->_id_list = $id_list;
    }

    /**
     * Assigne ajout de la personne de chose qui ne sont pas des ingrédient d'une recette
     */
    public function setMore($more)
    {
        if (is_string($more)) {
            htmlspecialchars($more);
            $this->_more = $more;
        }
    }
}
	
