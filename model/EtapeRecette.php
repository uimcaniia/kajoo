<?php
namespace Model;
	class EtapeRecette extends EtapeRecetteManager {


		// **************************************************
		// Attributs de l'objet
		// **************************************************
		
		 private $_id_etape;
	  	 private $_rang;//rang de l'étape dans la rectte 	
		 private $_text;//texte de l'étape de la recette 
	  	 private $_img; // 	lien de l'image de l'étape 
	 	 private $_time; //temps de l'étape 
	 	 private $_id_recette; //id de la recette correspondante 	


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

	 	 //*********************************************
	 	 //récupère un épisode suivant son id
	 	 public function getOneRecette($idRecette)
	 	 {
	 	 	if(is_int($idEpisode)){
	 	 		$aData = parent::get($idRecette);
	 	 	}
	 	 	else
	 	 	{
	 	 		throw new Exception('l\'identifiant n\'est pas un nombre'); 
	 	 	}
	 	 	return $aData;
	 	 }



		// **************************************************
		// GETTERS
		// **************************************************
		
		/** Retourne l'ID' de l'item */
		public function getId_etape()
		{
			return $this->_id_etape;
		}
		
		/** Retourne le rang de l'étape dans la rectte */
		public function getRang()
		{
			return $this->_rang;
		}
		
		/** Retourne le texte de l'étape de la recette */
		public function getText()
		{
			return $this->_text;
		}
		/** Retourne le lien de l'image de l'étape  */
		public function getImg()
		{
			return $this->_img;
		}
				
		/** Retourne temps de l'étape  */
		public function getTime()
		{
			return strftime('%H:%M:%S',strtotime($this->_time));
		}
		/** Retourne id de la recette correspondante  */
		public function getId_recette()
		{
			return $this->_id_recette;
		}

		// **************************************************
		// SETTERS
		// **************************************************

		/** Assigne l'ID' de l'item */
		public function setId_etape($id_etape)
		{
			$id_etape = (int) $id_etape;
			$this->_id_etape = $id_etape;
		}
		/** Retourne le rang de l'étape dans la rectte */
		public function setRang($rang)
		{
			$rang = (int) $rang;
			$this->_rang = $rang;
		}
		/** Assigne le texte de l'étape de la recette */
		public function setText($text)
		{
			if (is_string($text))
    		{
    			htmlspecialchars($text);
				$this->_text = $text;
			}
		}
		
		/** Assigne le lien de l'image de l'étape  */
		public function setImg($img)
		{
			if (is_string($img))
    		{
    			htmlspecialchars($img);
				$this->_img = $img;
			}
		}
		
		/** Assigne temps de l'étape  */
		public function setTime($time)
		{
			$this->_time = $time;
		}
		
		/** Assigne id de la recette correspondante  */
		public function setId_recette($id_recette)
		{
			$id_recette = (int) $id_recette;
			$this->_id_recette = $id_recette;
		}

		
	}
	
