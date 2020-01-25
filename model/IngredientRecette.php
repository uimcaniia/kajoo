<?php
namespace Model;

class IngredientRecette extends IngredientRecetteManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_ingredient_recette;

    private $_quantity;

    // quantité de l'ingrédient (gr;cl;unité...)
    private $_id_ingredient;

    // id de l'ingrédient
    private $_id_recette;

//  ajout, complément d'information(ex: parfum) 
    private $_ajout_recette;

    // id de l'ingrédient
    const TAB_INGREC = 'ingredient_recette';

    // nom de la table

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

    public function getMultiDataToPushInBdd($arrIng)
    {
        if ($arrIng != false) {
            $request = 'INSERT INTO ' . self::TAB_INGREC . '(quantity, id_ingredient, id_recette, ajout_recette) VALUES';
            $separateur = ",";
            $arr = array();
            for ($i = 0; $i < count($arrIng); $i ++) {
                self::hydrate($arrIng[$i]);
                if ($i == count($arrIng) - 1) {
                    $separateur = ";";
                }
                $quantity = $this->getQuantity();
                $id_ingredient = $this->getId_ingredient();
                $idRecette = $this->getId_recette();
                $ajout_recette = $this->getAjout_recette();

                $request .= '(:quantity' . $i . ', :id_ingredient' . $i . ', :id_recette' . $i . ', :ajout_recette' . $i . ')' . $separateur;

                array_push($arr, array(
                    ":quantity" . $i,
                    $quantity
                ));
                array_push($arr, array(
                    ":id_ingredient" . $i,
                    $id_ingredient
                ));
                array_push($arr, array(
                    ":id_recette" . $i,
                    $idRecette
                ));
                array_push($arr, array(
                    ":ajout_recette" . $i,
                    $ajout_recette
                ));
            }
            parent::reqPrepaExec($request, $arr);
        }
    }

    // **************************************************
    // GETTERS
    // **************************************************

    /**
     * Retourne l'ID' de l'item
     */
    public function getId_ingredient_recette()
    {
        return $this->_id_ingredient_recette;
    }

    /**
     * Retourne quantité de l'ingrédient (gr;cl;unité...)
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * Retourne id de l'ingrédient
     */
    public function getId_ingredient()
    {
        return $this->_id_ingredient;
    }

    /**
     * Retourne id de la recette
     */
    public function getId_recette()
    {
        return $this->_id_recette;
    }

        /**
     * Retourne ajout, complément d'information(ex: parfum)     
     */
    public function getAjout_recette()
    {
        return $this->_ajout_recette;
    }

    // **************************************************
    // SETTERS
    // **************************************************

    /**
     * Assigne l'ID' de l'item
     */
    public function setId_ingredient_recette($id_ingredient_recette)
    {
        $id_ingredient_recette = (int) $id_ingredient_recette;
        $this->_id_ingredient_recette = $id_ingredient_recette;
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

    /**
     * Assigne id de l'ingrédient
     */
    public function setId_ingredient($id_ingredient)
    {
        $id_ingredient = (int) $id_ingredient;
        $this->_id_ingredient = $id_ingredient;
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
     * Assigne ajout, complément d'information(ex: parfum)  
     */
    public function setAjout_recette($ajout_recette)
    {
        if (is_string($ajout_recette)) {
            htmlspecialchars($ajout_recette);
            $this->_ajout_recette = $ajout_recette;
        }
    }
}
	
