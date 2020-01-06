<?php
namespace Model;
	class Recette extends RecetteManager {

		// **************************************************
		// Constances de l'objet
		// **************************************************

		const EXTRACT = 430; // nbr de lettre à conserver pour un extrait d'épisode

		// **************************************************
		// Attributs de l'objet
		// **************************************************
		
		 private $_id_recette;
	  	 private $_title;//titre de la recette 
		 private $_prepare_time;//temps de préparation 
	  	 private $_people; //nombre de personne 
	 	 private $_private; //recette privée (1) ou public(0) avec les copain du compte 
	 	 private $_id_category; //id de la catégorie de la recette  
	 	 private $_alpha; //  	lettre de rangement alphabetique pour trier : correspont à la première lettre du titre de la recette 
	 	 private $_love; //indicateur de la recette ( aime )
	 	 private $_price; // 	définit le cout de la recette 
	 	 private $_easy; // 	indicateur de la facilité 
	 	 private $_id_user; //id de lutilisateur 

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
	 	 //récupère une recette suivant son id
/*	 	 public function getOneRecette($idRecette)
	 	 {
	 	 	if(is_int($idEpisode)){
	 	 		$aData = parent::get($idRecette);
	 	 	}
	 	 	else
	 	 	{
	 	 		throw new Exception('l\'identifiant n\'est pas un nombre'); 
	 	 	}
	 	 	return $aData;
	 	 }*/

	 	 //*********************************************
	 	 public function getRecipeMethod($idRecette, $user)
	 	 {
            $aAllRecipe = parent:: get('id_recette', $idRecette);

            if($aAllRecipe!= false){
                if($aAllRecipe[0]['id_user']==$user) {
                    $aAllRecipe[0]['lecteur'] = $user;
                }else{
                    $aAllRecipe[0]['lecteur'] = false;
                }
                foreach($aAllRecipe[0] as $key => $value)
                {
                    if($key == 'id_category')
                    {
                        $category = new Category();
                        $aCategory= $category->get('id_category', $value);
                        if($aCategory == false)
                        {
                            $aAllRecipe[0]['libelCateg'] = 'Autre';
                        }
                        $aAllRecipe[0]['libelCateg']=$aCategory[0]['title'];
                    }
                }
			//}
                $etape = new EtapeRecette();
                $aEtape = $etape->get('id_recette', $idRecette); //on récup les étapes de la recette

                $ingredientRecette = new IngredientRecette();
                $aIngredientRecette = $ingredientRecette->get('id_recette', $idRecette); // on récup les ingrédients de la recette

                for($i = 0 ; $i < count($aIngredientRecette) ; $i++)
                {
                    foreach($aIngredientRecette[$i] as $key => $value)
                    {
                        if($key == 'id_ingredient')
                        {
                            $ingredient = new Ingredient();
                            $aIngredient= $ingredient->get('id_ingredient', $value);
                            $aIngredientRecette[$i]['title']=$aIngredient[0]['title'];
                            $aIngredientRecette[$i]['unit']=$aIngredient[0]['unit'];
                        }
                    }
                }
                $aAllRecipe[0]['id_ingredient_recette'] = $aIngredientRecette;
                $aAllRecipe[0]['id_etape'] = $aEtape;

            }
			return $aAllRecipe;
	 	 }

		// **************************************************
		// GETTERS
		// **************************************************
		
		/** Retourne l'ID' de l'item */
		public function getId_recette()
		{
			return $this->_id_recette;
		}
			
		/** Retourne le titre de la recette */
		public function getTitle()
		{
			return $this->_title;
		}

		/** Retourne le temps de préparation de la recette */
		public function getPrepare_time()
		{
			return strftime('%H:%M:%S',strtotime($this->_prepare_time));
		}

		/** Retourne le nombre de personne de la recette */
		public function getPeople()
		{
			return $this->_people;
		}

		/** Retourne recette privée (1) ou public(0) avec les copain du compte */
		public function getPrivate()
		{
			return $this->_private;
		}
		/** Retourne id de la catégorie de la recette  */
		public function getId_category()
		{
			return $this->_id_category;
		}
		/** Retourne lettre de rangement alphabetique pour trier  */
		public function getAlpha()
		{
			return $this->_alpha;
		}
		/** Retourne indicateur de la recette  */
		public function getLove()
		{
			return $this->_love;
		}
				/** Retourne indicateur de la recette  */
		public function getPrice()
		{
			return $this->_price;
		}
				/** Retourne indicateur de la recette  */
		public function getEasy()
		{
			return $this->_easy;
		}
		/** Retourne id de lutilisateur   */
		public function getId_user()
		{
			return $this->_id_user;
		}


		// **************************************************
		// SETTERS
		// **************************************************

		/** Assigne l'ID' de l'item */
		public function setId_recette($id_recette)
		{
			$id_recette = (int) $id_recette;
			$this->_id_recette = $id_recette;
		}
		/** Assigne le titre de la recette */
		public function setTitle($title)
		{
			if (is_string($title))
    		{
    			htmlspecialchars($title);
				$this->_title = $title;
			}
		}
		/** Assigne le temps de préparation de la recette */
		public function setPrepare_time($prepare_time)
		{
			$this->_prepare_time = $prepare_time;
		}
		/** Assigne le nombre de personne de la recette*/
		public function setPeople($people)
		{
			$people = (int) $people;
			$this->_people = $people;
		}

		/** Assigne recette privée (1) ou public(0) avec les copain du compte */
		public function setPrivate($private)
		{
			$private = (int) $private;
			$this->_private = $private;
			
		}
		/** Assigne id de la catégorie de la recette */
		public function setId_category($id_category)
		{
			$id_category = (int) $id_category;
			$this->_id_category = $id_category;
		}
		/** Assigne lettre de rangement alphabetique pour trier*/
		public function setAlpha($alpha)
		{
			if (is_string($alpha))
    		{
    			htmlspecialchars($alpha);
				$this->_alpha = $alpha;
			}
		}
		/** Assigne indicateur de la recette */
		public function setLove($love)
		{
			$love = (int) $love;
			$this->_love = $love;
		}
				/** Assigne indicateur de la recette */
		public function setPrice($price)
		{
			$price = (int) $price;
			$this->_price = $price;
		}
				/** Assigne indicateur de la recette */
		public function setEasy($easy)
		{
			$easy = (int) $easy;
			$this->_easy = $easy;
		}
		/** Assigne id de lutilisateur  */
		public function setId_user($id_user)
		{
			$id_user = (int) $id_user;
			$this->_id_user = $id_user;
		}



    }
	
