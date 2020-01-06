<?php
namespace Model;
	class Planning extends PlanningManager {


		// **************************************************
		// Attributs de l'objet
		// **************************************************
		
	  	 private $_id_planning;
	  	 private $_date_planning; //date correspondante au repas
	  	 private $_list;// indicateur si présent sur une liste de course (0: non ; 1: ok) 	 
	  	 private $_month; //mois concerné par le planing pour le calendrier 	
	  	 private $_title; //titre du repas  
		 private $_id_user;// id de lutilisateur 	
	
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
		 	 			//echo $value;
		 	 		}
		 	 	}
		 	}
	 	 }



		// **************************************************
		// GETTERS
		// **************************************************
		
		/** Retourne  id de l'ingrédient 	  */
		public function getId_planning()
		{
			return $this->_id_planning;
		}
		/** Retourne date correspondante au repas  */
		public function getDate_planning() {
			return strftime('%Y-%m-%d',strtotime($this->_date_planning));
		}
				/** Retourne  indicateur si présent sur une liste de course (0: non ; 1: ok)  */
		public function getList()
		{
			return $this->_list;
		}
		/** Retourne mois concerné par le planing pour le calendrier   */
		public function getMonth()
		{
			return $this->_month;
		}
		/** Retourne titre du repas  */
		public function getTitle()
		{
			return $this->_title;
		}
		/** Retourne id de lutilisateur */
		public function getId_user()
		{
			return $this->_id_user;
		}

		// **************************************************
		// SETTERS
		// **************************************************



		/** Assigne  id de l'ingrédient 	 */
		public function setId_planning($id_planning)
		{
			$id_planning = (int) $id_planning;
			$this->_id_planning = $id_planning;
		}
		/** Assigne date correspondante au repas  */
		public function setDate_planning($date_planning) {
			//$date = date_create_from_format('Y-M-d', $date);
			$this->_date_planning = $date_planning;
		}
				/** Assigne  indicateur si présent sur une liste de course (0: non ; 1: ok) */
		public function setList($list)
		{
			$list = (int) $list;
			$this->_list = $list;
		}
		/** Assigne mois concerné par le planing pour le calendrier  	 */
		public function setMonth($month)
		{
			$month = (int) $month;
			$this->_month = $month;
		}
		/** Assigne titre du repas  */
		public function setTitle($title)
		{
			if (is_string($title))
    		{
    			htmlspecialchars($title);
				$this->_title = $title;
			}
		}
		/** Assigne id de lutilisateur */
		public function setId_user($id_user)
		{
			$id_user = (int) $id_user;
			$this->_id_user = $id_user;
		}




		
	}
	
