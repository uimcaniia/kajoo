<?php
namespace Model;
	class Preference extends PreferenceManager {


		// **************************************************
		// Attributs de l'objet
		// **************************************************
		
	  	 private $_id_pref;
	  	 private $_id_user; //mois concerné par le planing pour le calendrier 	
	  	 private $_id_planning_day; //liste des id du planning day correspondant 
		 private $_people_recipe;// id de lutilisateur 	
		 private $_limit_pagination;// nombre de recette a afficher par page
	
		// **************************************************
		// Methode
		// **************************************************

	 	 public function getDataToHydrate($intPlaning)
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
		
		/** Retourne  id de l'ingrédient 	  */
		public function getId_pref()
		{
			return $this->_id_pref;
		}

		/** Retourne mois concerné par le planing pour le calendrier   */
		public function getId_user()
		{
			return $this->_id_user;
		}
		/** Retourne id de lutilisateur */
		public function getPeople_planning()
		{
			return $this->_people_planning;
		}
		/** Retourne id de lutilisateur */
		public function getPeople_recipe()
		{
			return $this->_people_recipe;
		}
		public function getLimit_pagination()
		{
			return $this->_limit_pagination;
		}

		// **************************************************
		// SETTERS
		// **************************************************



		/** Assigne  id de l'ingrédient 	 */
		public function setId_pref($id_pref)
		{
			$id_pref = (int) $id_pref;
			$this->_id_pref = $id_pref;
		}

		/** Assigne mois concerné par le planing pour le calendrier  	 */
		public function setId_user($id_user)
		{
			$id_user = (int) $id_user;
			$this->_id_user = $id_user;
		}

		/** Assigne id de lutilisateur */
		public function setPeople_planning($people_planning)
		{
			$people_planning = (int) $people_planning;
			$this->_people_planning = $people_planning;
		}
		/** Retourne id de lutilisateur */
		public function setPeople_recipe($people_recipe)
		{
			$people_recipe = (int) $people_recipe;
			$this->_people_recipe = $people_recipe;
		}
		public function setLimit_pagination($limit_pagination)
		{
			$limit_pagination = (int) $limit_pagination;
			$this->_limit_pagination = $limit_pagination;
		}



		
	}
	
