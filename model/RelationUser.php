<?php
namespace Model;

class RelationUser extends RelationUserManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_relation_user;

    // id de la relation
    private $_id_user;

    // id de l'utilisateur du compte
    private $_id_friend;

    // id de l'ami pour le partage
    private $_modif_recipe;

    // autorise (1) ou non (0) la modification des recettes
    private $_modif_planning;

    // autorise (1) ou non (0) la modification du planning
    private $_modif_shop;

    // autorise (1) ou non (0) la modification de la liste des courses

    // **************************************************
    // Methode
    // **************************************************
    public function hydrate($aData)
    {
        foreach ($aData as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut en mettant sa première lettre en majuscule.
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // **************************************************
    // GETTERS
    // **************************************************

    /**
     * Retourne l' id de la relation
     */
    public function getId_relation_user()
    {
        return $this->_id_relation_user;
    }

    /**
     * Retourne id de l'utilisateur du compte
     */
    public function getId_user()
    {
        return $this->_id_user;
        ;
    }

    /**
     * Retourne id de l'ami pour le partage
     */
    public function getId_friend()
    {
        return $this->_id_friend;
    }

    /**
     * Retourne autorise (1) ou non (0) la modification des recettes
     */
    public function getModif_recipe()
    {
        return $this->_modif_recipe;
    }

    /**
     * Retourne autorise (1) ou non (0) la modification du planning
     */
    public function getModif_planning()
    {
        return $this->_modif_planning;
    }

    /**
     * Retourne autorise (1) ou non (0) la modification de la liste des courses
     */
    public function getModif_shop()
    {
        return $this->_modif_shop;
    }

    // **************************************************
    // SETTERS
    // **************************************************
    public function setId_relation_user($id_relation_user)
    {
        $id_relation_user = (int) $id_relation_user;
        $this->_id_relation_user = $id_relation_user;
    }

    public function setId_user($id_user)
    {
        $id_user = (int) $id_user;
        $this->_id_user = $id_user;
    }

    public function setId_friend($id_friend)
    {
        $id_friend = (int) $id_friend;
        $this->_id_friend = $id_friend;
    }

    public function setModif_recipe($modif_recipe)
    {
        $modif_recipe = (int) $modif_recipe;
        $this->_modif_recipe = $modif_recipe;
    }

    public function setmodif_planning($modif_planning)
    {
        $modif_planning = (int) $modif_planning;
        $this->_modif_planning = $modif_planning;
    }

    public function setModif_shop($modif_shop)
    {
        $modif_shop = (int) $modif_shop;
        $this->_modif_shop = $modif_shop;
    }
}
	
