<?php
namespace Model;
	class Ingredient extends IngredientManager {


		// **************************************************
		// Attributs de l'objet
		// **************************************************
		
		 private $_id_ingredient;
	  	 private $_title;// 	
		 private $_unit;//unité de mesure des ingrédients (gr, ml, unité...) 	
	  	 private $_check_ingredient; // verification de l'ingrédient 
	  	 private $_id_user ; //id de l'utilisateur qui a inséré l'ingrédient 
	
		// **************************************************
		// Methode
		// **************************************************

	 	 public function getDataToHydrate($intIdEpisode)
	 	 {
	 	 	if((is_int($intIdEpisode)) && ($intIdEpisode>0)){
	 	 		$aData = parent::get($intIdEpisode);
	 	 		self::hydrate($aData);
	 	 	}
	 	 	else
	 	 	{
	 	 		throw new Exception('le chapitre '.$intIdEpisode.' n\'existe pas'); 
	 	 	}
	 	 }

	 	 public function hydrate($aData)
	 	 {
	 	 	if($aData != false)
	 	 	{
		 	 	foreach ($aData as $key => $value)
		 	 	{
		 	 		 // On récupère le nom du setter correspondant à l'attribut en mettant sa première lettre en majuscule. 
		 	 		$method = 'set'.ucfirst($key);
		 	 		if(method_exists($this, $method))
		 	 		{
		 	 			$this->$method($value);
		 	 		}
		 	 	}
		 	}
	 	 }



		// **************************************************
		// GETTERS
		// **************************************************
		
		/** Retourne l'ID' de l'item */
		public function getId_ingredient()
		{
			return $this->_id_ingredient;
		}
		/** Retourne libellé de la catégory */
		public function getTitle()
		{
			return $this->_title;
		}
		/** Retourne rang de la catégorie pour l'affichage */
		public function getUnit()
		{
			return $this->_unit;
		}
					
		/** Retourne id user a qui appartient la catégorie  */
		public function getCheck_ingredient()
		{
			return $this->_check_ingredient;
		}
		/** Retourne id user a qui appartient la catégorie  */
		public function getId_user()
		{
			return $this->_id_user;
		}

		// **************************************************
		// SETTERS
		// **************************************************

		/** Assigne l'ID' de l'item */
		public function setId_ingredient($id_ingredient)
		{
			$id_ingredient = (int) $id_ingredient;
			$this->_id_ingredient = $id_ingredient;
		}
		/** Assigne libellé de la catégory */
		public function setTitle($title)
		{
			if (is_string($title))
    		{
    			htmlspecialchars($title);
				$this->_title = $title;
			}
		}
		/** Assigne libellé de la catégory */
		public function setUnit($unit)
		{
			if (is_string($unit))
    		{
    			htmlspecialchars($unit);
				$this->_unit = $unit;
			}
		}
		/** Assigne id user a qui appartient la catégorie  */
		public function setCheck_ingredient($check_ingredient)
		{
			$check_ingredient = (int) $check_ingredient;
			$this->_check_ingredient = $check_ingredient;
		}
				
		/** Assigne id user a qui appartient la catégorie  */
		public function setId_user($id_user)
		{
			$id_user = (int) $id_user;
			$this->_id_user = $id_user;
		}

		
	}
	
