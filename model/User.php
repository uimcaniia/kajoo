<?php
namespace Model;

class User extends UserManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_id_user;

    // Nom de la colonne id de la table locale
    private $_registration;

    // date d'inscription (date)
    private $_email;

    // email de l'utilisateur
    private $_pseudo;

    // pseudo de l'utilisateur
    private $_password;

    // mot de pass de l'utilisateur
    private $_admin;

    // autorisation admin (0=utilisateur ; 1=admin

    // **************************************************
    // Methode
    // **************************************************
    public function getDataToHydrate($mail, $psw)
    {
        $aData = parent::get($mail, $psw);
        self::hydrate($aData);
    }

    public function hydrate($aData)
    {
        foreach ($aData as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut en mettant sa première lettre en majuscule.
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function sendMail($mail)
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "uimcaniia@gmail.com";
        $to = $mail;
        $subject = "Envoie de votre mot de passe.";
        $message = "http://www.kajoo.uimainon.com/index.php?action=spaceUpdatePsw";

        $headers = <<<EOT
        From: $from 
        MIME-Version: 1.0
        Content-Type: text/plain; charset="UTF-8"
EOT;

        mail($to, $subject, $message, $headers);

        // echo "L'email a été envoyé.";
    }

    public function getRelationUserAndInfosFriend($_id_user)
    {
        $relation = new RelationUser();
        $aAllRelation = $relation->getallRelationOfUser($_id_user);

        if ($aAllRelation != false) {
            for ($i = 0; $i < count($aAllRelation); $i ++) {
                foreach ($aAllRelation[$i] as $key => $value) {
                    if ($key == 'id_friend') {
                        $aInfoFriend = parent::get('id_user', $value);

                        $aAllRelation[$i]['email'] = $aInfoFriend[0]['email'];
                        $aAllRelation[$i]['pseudo'] = $aInfoFriend[0]['pseudo'];
                    }
                }
            }
        }
        // print_r($aAllRelation);
        return $aAllRelation;
    }

    public function getInvitationSend($id_send)
    {
        $invit = new Invitation();
        $aAllInviation = $invit->getInvitationOfUser($id_send);

        if ($aAllInviation != false) {
            for ($i = 0; $i < count($aAllInviation); $i ++) {

                foreach ($aAllInviation[$i] as $key => $value) {
                    if ($key == 'id_receive') {
                        $aInfoFriend = parent::get('id_user', $value);

                        $aAllInviation[$i]['email'] = $aInfoFriend[0]['email'];
                        $aAllInviation[$i]['pseudo'] = $aInfoFriend[0]['pseudo'];
                    }
                }
            }
        }
        return $aAllInviation;
    }

    public function getInvitationOfFriend($id_receive)
    {
        $invit = new Invitation();
        $aAllInviation = $invit->getInvitationOfAllFriend($id_receive);

        if ($aAllInviation != false) {
            for ($i = 0; $i < count($aAllInviation); $i ++) {
                foreach ($aAllInviation[$i] as $key => $value) {
                    if ($key == 'id_receive') {
                        $aInfoFriend = parent::get('id_user', $value);
                        $aAllInviation[$i]['email'] = $aInfoFriend[0]['email'];
                        $aAllInviation[$i]['pseudo'] = $aInfoFriend[0]['pseudo'];
                    }
                }
            }
        }
        return $aAllInviation;
    }


    // **************************************************
    // GETTERS
    // **************************************************

    /**
     * Retourne l'ID' de l'item
     */
    public function getId()
    {
        return $this->_id_user;
    }

    /**
     * Retourne la date d'inscription
     */
    public function getRegistration()
    {
        return strftime('%d-%m-%Y', strtotime($this->_registration));
    }

    /**
     * Retourne l'adresse mail de l'utilisateur
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Retourne son pseudo
     */
    public function getPseudo()
    {
        return $this->_pseudo;
    }

    /**
     * Retourne son mot de passe
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Retourne son rang en tant qu'utilisateur(0) ou admin(1)
     */
    public function getAdmin()
    {
        return $this->_admin;
    }

    // **************************************************
    // SETTERS
    // **************************************************

    /**
     * Assigne l'ID' de l'item
     */
    public function setId($id_user)
    {
        $id_user = (int) $id_user;
        $this->_id_user = $id_user;
    }

    /**
     * Assigne la date d'inscription
     */
    public function setRegistration($registration)
    {
        $this->_registration = $registration;
    }

    /**
     * Assigne l'adresse mail de l'utilisateur
     */
    public function setEmail($email)
    {
        if (is_string($email)) {
            htmlspecialchars($email);
            $this->_email = $email;
        }
    }

    /**
     * Assigne son pseudo
     */
    public function setPseudo($pseudo)
    {
        if (is_string($pseudo)) {
            htmlspecialchars($pseudo);
            $this->_pseudo = $pseudo;
        }
    }

    /**
     * Assigne son mot de passe
     */
    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    /**
     * Assigne son rang en tant qu'utilisateur(0) ou admin(1)
     */
    public function setAdmin($admin)
    {
        $admin = (int) $admin;
        $this->_admin = $admin;
    }
}
