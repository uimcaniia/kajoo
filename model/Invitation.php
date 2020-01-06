<?php

namespace Model;

	class Invitation extends InvitationManager {

		
		// **************************************************
		// Attributs de l'objet
		// **************************************************
		
		 private $_id_invitation; //  identifiant de l'invitation 
	  	 private $_id_send; //  	identifiant de l'envoyeur 
		 private $_id_receive;  //   	identifiant du receveur 


	 	 public function getDataToHydrate($mail, $psw){

	 	 		$aData = parent::get($mail, $psw);
	 	 		self::hydrate($aData);
	 	 }

	 	 public function hydrate($aData){
	 	 	foreach ($aData as $key => $value){
	 	 		 // On récupère le nom du setter correspondant à l'attribut en mettant sa première lettre en majuscule. 
	 	 		$method = 'set'.ucfirst($key);
	 	 		if(method_exists($this, $method)){
	 	 			$this->$method($value);
	 	 		}
	 	 	}
	 	 }
        public function sendInvitationCreateAcompteMail($mailReceive)
        {
            ini_set( 'display_errors', 1 );
            error_reporting( E_ALL );
            $from = $_SESSION['email'];
            $to = $mailReceive;
            $subject = "Kajoo - Vous êtes invité sur Kajoo !!.";
            $message = $_SESSION['pseudo']. "(" .$_SESSION['email']. ") vous a invitez à le rejoindre. 
            Créez votre compte et partagez ensemble vos recettes de cuisine, gérer votre planning alimentaire et vos liste de courses!
            http://www.kajoo.uimainon.com";
            $headers = <<<EOT
From: $from 
MIME-Version: 1.0
Content-Type: text/plain; charset="UTF-8"
EOT;
            mail($to,$subject,$message, $headers);

        }

	 	 	public function sendInvitationMail($mailReceive, $idReceive)
	 	 {
	 	 	ini_set( 'display_errors', 1 );
		    error_reporting( E_ALL );
		    $from = $_SESSION['email'];
		    $to = $mailReceive;
		    $subject = "Kajoo - Vous avez une invitation en attente.";
		    $message = $_SESSION['pseudo']. "(" .$_SESSION['email']. ") vous a demandé en ami. Connectez-vous à votre espace pour valider ou refuser cette invitation ! http://www.kajoo.uimainon.com/index.php?action=spaceConnect";
		    $headers = <<<EOT
From: $from 
MIME-Version: 1.0
Content-Type: text/plain; charset="UTF-8"
EOT;
		    mail($to,$subject,$message, $headers);

	 	 }
		// **************************************************
		// GETTERS
		// **************************************************
		
		/** Retourne identifiant de l'invitation */
		public function getId_invitation() {
			return $this->_id_invitation;
		}
		
		/** Retourne l 	identifiant de l'envoyeur  */
		public function getId_send() {
			return $this->_id_send;
		}
		
		/** Retourne  	identifiant du receveur  */
		public function getId_receive() {
			return $this->_id_receive;
		}
		

		// **************************************************
		// SETTERS
		// **************************************************

		/** Assigne identifiant de l'invitation */
		public function setId_invitation($id_invitation) {
			$id_invitation = (int) $id_invitation;
			$this->_id_invitation = $id_invitation;
		}
		
		/** Assigne  	identifiant de l'envoyeur  */
		public function setId_send($id_send) {
			$id_send = (int) $id_send;
			$this->_id_send = $id_send;
		}
		
		/** Assigne  	identifiant du receveur  */
		public function setId_receive($id_receive) {
			$id_receive = (int) $id_receive;
			$this->_id_receive = $id_receive;
		}

	}
	
