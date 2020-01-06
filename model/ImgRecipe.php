<?php
namespace Model;
	class ImgRecipe extends ImgRecipegManager {

		// **************************************************
		// Attributs de l'objet
		// **************************************************
		
		private $_img_id;
		private $_img_nom; //le nom de l'image d'origine 	
		private $_img_taille; // 	l'information de la taille 
		private $_img_type; //le type de l'image 
		private $_img_blob; //contenu binaire de l'image 
		private $_img_src; // url de l'image du dossier serveur	


		// **************************************************
		// Methode
		// **************************************************

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

	 	 public function vérif() {
	 	 	$verif = parent::get('img_nom', $this->_img_nom);
	 	 	if($verif == false){
	 	 		return false;
	 	 	}
	 	 	else{
	 	 		return true;
	 	 	}
	}

	 	 //*************************************************************************
	

		// **************************************************
		// GETTERS
		// **************************************************
		
		/** Retourne  clé primaire  */
		public function getJour()
		{
			return $this->_img_id;
		}
			
		/** Retourne le nom de l'image d'origine  */
		public function getImg_nom()
		{
			return $this->_img_nom;
		}

		/** Retourne  l'information de la taille */
		public function getImg_taille()
		{
			return $this->_img_taille;
		}
		/** Retourne le type de l'image  */
		public function getImg_type()
		{
			return $this->_img_type;
		}
				/** Retourne  contenu binaire de l'image 	 */
		public function getImg_blob()
		{
			return $this->_img_blob;
		}
		/** Retourne url de l'image 	 */
		public function getImg_src()
		{
			return $this->_img_src;
		}
		// **************************************************
		// SETTERS
		// **************************************************

		/** Assigne clé primaire */
		public function setImg_id($img_id)
		{
			$img_id = (int) $img_id;
			$this->_img_id = $img_id;
		}
		/** Assigne le nom de l'image d'origine  */
		public function setImg_nom($img_nom)
		{
/*			if (is_string($img_nom))
    		{
    			htmlspecialchars($img_nom);*/
				$this->_img_nom = $img_nom;
		//	}
		}
		/** Assigne l'information de la taille*/
		public function setImg_taille($img_taille)
		{
			//if (is_string($img_taille))
    		//{
    			//htmlspecialchars($img_taille);
				$this->_img_taille = $img_taille;
			//}
		}
		/** Assigne le type de l'image  */
		public function setImg_type($img_type)
		{
/*			if (is_string($img_type))
    		{
    			htmlspecialchars($img_type);*/
				$this->_img_type = $img_type;
			//}
		}
		/** Assigne contenu binaire de l'image 	 */
		public function setImg_blob($img_blob)
		{
			//if (is_string($img_blob))
    		//{
    		//	htmlspecialchars($img_blob);
				$this->_img_blob = $img_blob;
			//}
		}
		/** Assigne url de l'image 	 */
		public function setImg_src($img_src)
		{
			//if (is_string($img_blob))
    		//{
    		//	htmlspecialchars($img_blob);
				$this->_img_src = $img_src;
			//}
		}

		
	}
	
