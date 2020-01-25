<?php
namespace Model;

class Politique extends Bdd
{

    const TAB_POL = 'politique';

    // nom de la table
    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id;

    private $_titre;

    private $_text;

    // **************************************************
    // Methode
    // **************************************************

    // recupère Les mentions
    public function get()
    {
        $request = 'SELECT * FROM ' . self::TAB_POL . '';
        $aRes = parent::addRequestSelect($request);
        return $aRes;
    }

    // **************************************************
    // GETTERS
    // **************************************************

    /**
     * Retourne l'ID' de l'item
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Retourne le titre de la politique de confidentialité
     */
    public function getTitre()
    {
        return $this->_titre;
    }

    /**
     * Retourne le texte de la politique de confidentialité
     */
    public function getText()
    {
        return $this->_text;
    }

    // **************************************************
    // SETTERS
    // **************************************************

    /**
     * Assigne l'ID' de l'item
     */
    public function setId($id)
    {
        $id = (int) $id;
        $this->_id = $id;
    }

    /**
     * Assigne le titre de la politique de confidentialité
     */
    public function setTitre($titre)
    {
        if (is_string($titre)) {
            htmlspecialchars($titre);
            $this->_titre = $titre;
        }
    }

    /**
     * Assigne le texte de la politique de confidentialité
     */
    public function setText($text)
    {
        if (is_string($text)) {
            htmlspecialchars($text);
            $this->_text = $text;
        }
    }
}
	
