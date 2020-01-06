<?php

namespace Model;

	class Form extends UserManager{

		// **************************************************
		// attribut  de l'objet
		// **************************************************
		private $_regMail ="#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#"; // regex mail
		private $_regPsw  = "#^(?=.*[A-Z])(?=.*[0-9]).{8,}$#"; //regex pssword
		private $_regPseudo  = "#^[a-zA-Z0-9]{3,}$#"; 
		private $_regNbrPeople  = "#^[0-9]{1,2}$#"; // regex nombre de personne par défault

		private $_aTestError = array( // array contenant les différente erreur a afficher
		    "tstMail"   => array("","Veuillez indiquer un e-mail", "Ce mail existe déjà. Vous avez déjà un compte?" , "Adresse mail invalide."),
		    "tstPseudo" => array("", "Veuillez indiquer un Pseudo", "Ce pseudo existe déjà. Veuillez en choisir un autre", 'Le pseudo doit avoir au moins 3 caractères valides'),
		    "tstPsw"    => array("", "Veuillez indiquer un mot de passe","", "Le mot de passe n'est pas assez sécurisé. Veuillez utiliser 8 caractères minimum avec au moins une majuscule et un chiffre", "Le mot de passe et (ou) l'adresse mail renseigné n'est pas le bon.", "Les 2 mots de passe ne sont pas identiques", 'veuillez remplir les champs', 'ce compte a été supprimé!')
		);

		// **************************************************
		// Methode
		// **************************************************

		// test email et mot de passe fournis lors d'une tentative de connexion
		public function tstLog($email, $psw)
		{
			$emailClean    = htmlspecialchars($email);
			$pswClean      = htmlspecialchars($psw);
			$errorConnexion = self::verifUserInfos($pswClean, $emailClean, 'email', 'password');

			return $this->_aTestError['tstPsw'][$errorConnexion];
		}

		// **************************************************
		// test email fournis lors d'une tentative d'inscription
		public function tstSubMail($email)
		{
			$emailClean    = htmlspecialchars($email);
			$errorMail   = self::verifChaine($emailClean,  $this->_regMail, 'email' , "" , true); // vérification des infos

			return $this->_aTestError['tstMail'][$errorMail];
		}
		// **************************************************
		// test pseudo fournis lors d'une tentative d'inscription
		public function tstSubPseudo($pseudo)
		{
			$pseudoClean   = htmlspecialchars($pseudo);
			$errorPseudo = self::verifChaine($pseudoClean, $this->_regPseudo, 'pseudo', "" , true);

			return $this->_aTestError['tstPseudo'][$errorPseudo];
		}
		// **************************************************
		// test mot de passe fournis lors d'une tentative d'inscription
		public function tstSubPsw($psw, $pswAgain)
		{
			$pswClean      = htmlspecialchars($psw);
			$pswAgainClean = htmlspecialchars($pswAgain);
			$errorPsw    = self::verifChaine($pswClean, $this->_regPsw , '', $pswAgainClean, false);

			return $this->_aTestError['tstPsw'][$errorPsw];
		}
		// **************************************************
		// test email fournis lors d'un changement de préférence pour chrome (placeholder mail ne fonctione pas et se transforme en value)
		public function tstModifMail($email)
		{
			$emailClean    = htmlspecialchars($email);
			$errorMail   = self::verifChaine($emailClean,  $this->_regMail, 'email' , "" , true); // vérification des infos
			if($errorMail == 2){
				$errorMail = '';
			}
			else{
				return $this->_aTestError['tstMail'][$errorMail];
			}
			
		}
				// **************************************************
		// test changement de nombre de personne par défault
		public function tstChangeNbrPeople($nbrPeople, $max)
		{
			$pswClean      = htmlspecialchars($nbrPeople);
			if((preg_match($this->_regNbrPeople, $nbrPeople) == FALSE) || ($nbrPeople > $max) || ($nbrPeople < 1))
			{
				$errorNbrPeople ='Veuillez choisir un nombre entre 1 et '.$max.'';
			}
			else
			{
				$errorNbrPeople ='';
			}

			return $errorNbrPeople;
		}

		// **************************************************
		//test lors d'une inscription
		public function verifChaine ($chaine, $regex, $paramBdd, $confirm, $empty)
		{ 
			$numError= 0;
			$aResultError=array();

			if(empty($chaine)) // test si chaine vide
			{
				$numError = 1;
				array_push($aResultError, $numError);
			}
			else{
				if($paramBdd != '') // test en base de donnée si le mail ou le pseudo existe déjà
				{
					$user = new User();
					$verifInfo = parent::get($paramBdd, $chaine);
					if (is_array($verifInfo))
					{
						$numError = 2;
						array_push($aResultError, $numError);
					}
				}
				if (!empty($regex)) // test sécurité mot de passe et conformité adresse mail avec regex
				{
					if(preg_match($regex, $chaine) == FALSE)
					{
						$numError = 3;
						array_push($aResultError, $numError);
					}
				}
				if ($empty == false) // test si le mot de passe et sa confirmation sont identique
				{
					if($chaine != $confirm)
					{
						$numError = 5;
						array_push($aResultError, $numError);
					}
				}
			}
			if(count($aResultError) == 0)
			{
				return 0;
			}
			else{
				return $numError;
			}
		}

		// **************************************************
		//test lors d'une connexion
		public function verifUserInfos($psw, $mail, $paramBdd, $pswCompare)
		{
			$numError= 0;
			$aResultError=array();

			if(empty($mail) || empty($psw))
			{
				$numError = 6;
				array_push($aResultError, $numError);
			}
			else
			{
				$verifInfo = parent::get($paramBdd, $mail);
				if (is_array($verifInfo))
				{
					if(password_verify($psw, $verifInfo[0][$pswCompare]))
					{
						$numError = 0;
					}
					else{
						$numError= 4;
						array_push($aResultError, $numError);
					}
				}
				else
				{
					$numError= 4;
					array_push($aResultError, $numError);
				}
			}
			if(count($aResultError) == 0)
			{
				return 0;
			}
			else{
				return $numError;
			}

		}

	}
	