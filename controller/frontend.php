<?php
use \Model\EtapeRecette;
use \Model\Calendar;
use \Model\Category;
use \Model\Form;
use \Model\ImgRecipe;
use \Model\Ingredient;
use \Model\IngredientRecette;
use \Model\Liste;
use \Model\ListShop;
use \Model\Planning;
use \Model\PlanningDay;
use \Model\Preference;
use \Model\Recette;
use \Model\Shop;
use \Model\User;
use \Model\Mention;
use \Model\Politique;
use \Model\RelationUser;
use \Model\Invitation;

//********************************************************
//retour de réponse avec AJAX suite à une requete en bdd. 
//Le format de retour doit etre un array pour être formaté ensuite JSON même si la requête n'a rien trouvé (false).
//sinon, erreur dans la requete, on retourne l'arreur (pas de array afin que le message passe dans le .fail() de AJAX) 
function responseAjax($response){
	if($response === false){
		$aDataPref=array( 
		"false"    => "false");
		return $aDataPref;
	}
	elseif(is_array($response)){
		return $response;
	}
	elseif($response === true){
		$aDataPref=array( 
		"true"    => "true");
		return $aDataPref;
	}
	else{
		return $response;
	}
}
//********************************************************
//aside des rappels
function makeRappelPlanning()
{
	$calendar = new Calendar();
	$datetime = date("Y-m-d");
	if(isset($_SESSION['idUser'])){
		$aPlanningToday = $calendar->getlastRappel($datetime, $_SESSION['idUser']);
		if($aPlanningToday == false)
		{
			$aPlanningToday = false;
		}
		return $aPlanningToday;
	}
}
//********************************************************
//espace pour s'inscrire/home 
function spaceHome($erreurRouteur)
{
	$alertMessRouteur = $erreurRouteur;
	$alertConnectionMail  =''; // messages d'erreurs
	$alertConnectionPsw   ='';
	$alertConnectionPseudo='';
	$alert                ='';

	$aPlanningToday = makeRappelPlanning();

	require('view/frontend/homeView.php');
}

//********************************************************
//espace pour se connecter (click sur la cerise)
function spaceConnect()
{
	$alertConnectionMail  =''; // messages d'erreurs par défaut
	$alertConnectionPsw   ='';
	$alertConnectionPseudo='';
	$alert                ='';
	$alertLost            = '';

	$aPlanningToday = makeRappelPlanning();

	require('view/frontend/loginView.php');
}
//********************************************************
//espace pour refaire son mot de passe
function spaceUpdatePsw()
{
	$_SESSION = array();
	session_destroy(); //on détruit la session
	$alertUpdate ='';
	$aPlanningToday = makeRappelPlanning();
	require('view/frontend/updateMdpView.php');
}
//*******************************************************
//Pour récupérer son mot de passe(envoie de mail à l'utilisateur)
function lostMdp($lostMdpEmail)
{
	$alertConnectionMail  =''; // messages d'erreurs
	$alertConnectionPsw   ='';
	$alertConnectionPseudo='';
	$alert                ='';
	$alertLost            ='';

	$user = new User();
	$getInfosUserConnect = $user->get('email', $lostMdpEmail);

	if($getInfosUserConnect == false)
	{
		$alertLost = 'Ce mail n\'existe pas...';
	}else
	{
		$alertLost = 'Un email vous a été envoyé à l\'adresse '.htmlspecialchars($lostMdpEmail);
		$user->sendMail($lostMdpEmail);
	}
	require('view/frontend/loginView.php');
}
//*******************************************************
// pour refaire son mot de pass suite à la réception du mail
function updateMdp($lostMdpEmail, $updatePsw)
{

	$user = new User();
	$alertUpdate='';

	$getInfosUserConnect = $user->get('email', $lostMdpEmail);

	if($getInfosUserConnect == false)
	{
		$alertUpdate = 'Ce mail n\'existe pas...';
	}else
	{
		$user->updateMdp(password_hash($updatePsw, PASSWORD_DEFAULT), $lostMdpEmail);
		makeSession(htmlspecialchars($lostMdpEmail));
		$aPlanningToday = makeRappelPlanning();

		$alertUpdate ='Votre nouveau mot de pass a bien été pris en compte.';
		require('view/frontend/updateMdpView.php');
	}

}
//*******************************************************
//test les erreur à la connexion
function testErrorLog($email, $psw)
{

	$form = new Form();
	$alert = $form->tstLog($email, $psw);

	$alertConnectionMail   ='';
	$alertConnectionPsw    ='';
	$alertConnectionPseudo ='';
	$alertLost             = '';

	if($alert !== '')
	{
		require('view/frontend/loginView.php');
	}
	else{
		$user = new User();
		$getInfosUserConnect = $user->get('email', $email);
		makeSession($email);
		// on créer la session et on redirige l'utilisateur vers son compte
		header ('location: index.php?action=space');
	}
}
//*******************************************************
//test les erreurs à l'inscription
function testErrorSubscribe($email, $pseudo, $psw, $pswAgain)
{
	$form = new Form();
	$alertMessRouteur      = "";
	$alertConnectionMail   = $form->tstSubMail($email);
	$alertConnectionPsw    = $form->tstSubPseudo($pseudo);
	$alertConnectionPseudo = $form->tstSubPsw($psw, $pswAgain);

	$alertLost = '';
	$alert     ='';
	// si on a des erreurs à l'inscription, on relance la zone de connexion et on affiche les messages d'erreurs
	if(($alertConnectionMail != "") || ($alertConnectionPsw != "") || ($alertConnectionPseudo != ""))
	{
		require('view/frontend/homeView.php');
	}
	else{ // si on réussit, on incrit l'utilisateur, on enregistre les données en session et on le redirige vers son compte
		subscribe($email, $pseudo, $psw);
		makeSession($email);

		$aDataPref=array( 
		"id_user"    => $_SESSION['idUser'],
		"people_planning"   => 4,
		"people_recipe" => 4,
		"limit_pagination"   => 6);

		$pref = new Preference(); // et les préférence par défault
		$pref-> hydrate($aDataPref);
		$pref->add($pref);

		header ('location: index.php?action=space');
	}
}
//*****************************************************
//mise en session des infos de l'utilisateur et ajout des préférences et catégorie par défault
function makeSession($mail)
{
	$user = new User();
	$getInfosUserConnect = $user->get('email', htmlspecialchars($mail));
	$pref = new Preference();
	$getPrefUser = $pref -> get('id_user', $getInfosUserConnect[0]['id_user']);

	$_SESSION['idUser'] = $getInfosUserConnect[0]['id_user'];
	$_SESSION['pseudo'] = $getInfosUserConnect[0]['pseudo'];
	$_SESSION['admin']  = $getInfosUserConnect[0]['admin'];
	$_SESSION['email']  = $getInfosUserConnect[0]['email'];

	$_SESSION['people_planning']  = $getPrefUser[0]['people_planning'];
	$_SESSION['people_recipe']  = $getPrefUser[0]['people_recipe'];
	$_SESSION['limit_pagination']  = $getPrefUser[0]['limit_pagination'];


}
//*******************************************************
//inscription d'un utilisateur
function subscribe($email, $pseudo, $psw)
{
	$pswHash = password_hash($psw, PASSWORD_DEFAULT); // on sécurise le mot de pass
	$aDataUser=array(
	"email"    => $email,
	"pseudo"   => $pseudo,
	"password" => $pswHash);

	$user = new User();
	$user-> hydrate($aDataUser);
	$user->add($user); //on ajoute un user à la bdd

}

//*******************************************************
//déconnection de l'utilisateur
function disconnect()
{
	$_SESSION = array();
	session_destroy(); //on détruit la session

	header ('Location: index.php'); //on le redirige vers l'accueil
}
//******************************************************************************************
//espace utilisateur (paramètre, message d'erreur => a vide lorsque ça passe par le rooteur)
function spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend, $alertErrorPagination)
{
	$user = new User();
	$getInfosUser = $user->get('id_user', $_SESSION['idUser']);
	$user-> hydrate($getInfosUser[0]);

	$getRelationShip = $user->getRelationUserAndInfosFriend($_SESSION['idUser']);
	$getInviationSend = $user->getInvitationSend($_SESSION['idUser']);
	$getInviationReceive = $user->getInvitationOfFriend($_SESSION['idUser']);

	$pref = new Preference();
	$aUserPref = $pref->get('id_user', $_SESSION['idUser']);
	$aPlanningToday = makeRappelPlanning(); 

	require('view/frontend/spaceView.php');
}
//******************************************************************************************
//pour changer les préféernce dans le compte utilisateur
function changePref($newEmail, $newPseudo, $newPsw, $newPswConfirm, $nbrPeople, $pagination)
{
    $errorInvitMailFriend = "";
	$alertOkChange      ='';
	$alertErrorMail     ='';
	$alertErrorPseudo   ='';
	$alertErrorPsw      ='';
	$alertErrorNbrPeople='';
    $alertErrorPagination = "";
	$aPlanningToday     = makeRappelPlanning();

	$form = new Form();
	// text des erreur lors de la soumission des changements des préférences
	if($newEmail !=''){ 
		$alertErrorMail   = $form->tstModifMail($newEmail);
		if($alertErrorMail == '')
		{
			$user = new User();
			$user->update('email', $newEmail, $_SESSION['idUser']);
		}
	}
	if($newPseudo !=''){
		$alertErrorPseudo   = $form->tstSubPseudo($newPseudo);
		if($alertErrorPseudo == '')
		{
			$user = new User();
			$user->update('pseudo', $newPseudo, $_SESSION['idUser']);
		}
	}
	if($newPsw !=''){
		$alertErrorPsw   = $form->tstSubPsw($newPsw, $newPswConfirm);
		if($alertErrorPsw == '')
		{
			$user = new User();
			$user->update('password', password_hash($newPsw, PASSWORD_DEFAULT), $_SESSION['idUser']);
		}
	}
	if($nbrPeople !=''){ // changement du nombre de personne par défault
		$alertErrorNbrPeople   = $form->tstChangeNbrPeople($nbrPeople, 10);
		if($alertErrorNbrPeople == '')
		{
			$pref = new Preference();
			$pref->update('people_recipe', $nbrPeople, $_SESSION['idUser']);
            $_SESSION['people_recipe'] = $nbrPeople;
		}
	}
    if($pagination !=''){ // changement du nombre de personne par défault
        $alertErrorPagination   = $form->tstChangeNbrPeople($pagination, 30);
        if($alertErrorPagination == '')
        {
            $pref = new Preference();
            $pref->update('limit_pagination', $pagination, $_SESSION['idUser']);
            $_SESSION['limit_pagination'] = $pagination;
        }
    }

	// si on a des erreurs à l'inscription, on relance la zone de connexion et on affiche les messages d'erreurs
	if(($alertErrorMail != "") || ($alertErrorPseudo != "") || ($alertErrorPsw != "") || ($alertErrorNbrPeople != "") || ($alertErrorPagination != ""))
	{
		$alertOkChange ='';
		spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend, $alertErrorPagination);
	}
	else
	{
		$alertOkChange ='Votre profil a bien été mit à jour!';
		spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend, $alertErrorPagination);
	}
}
//************************************************************************
//accepte l'invitation d'un ami
function acceptFriend($friendIdToAccept){
    $invit = new Invitation();
    $relation = new RelationUser();

    $aDataUser=array(
        "id_user"    => $_SESSION['idUser'],
        "id_friend"   => $friendIdToAccept,
        "modif_recipe"   => 0,
        "modif_planning"   => 0,
        "modif_shop" => 0);

    $relation-> hydrate($aDataUser);
    $relation->add($relation); //on ajoute la relation à la bdd DES 2 COTES!!!!

    $delInvit = $invit->delete($friendIdToAccept, $_SESSION['idUser']); // on supprime l'invitation

    spaceUser("L'invitation a bien été Acceptée !","","","","","");

}
//************************************************************************
// refuse l'invitation d'un ami
function refuseFriend($friendIdToRefuse){
    $invit = new Invitation();
    $delInvit = $invit->delete($friendIdToRefuse, $_SESSION['idUser']);

    spaceUser("L'invitation a bien été supprimée !","","","","","","");
}
//*************************************************************************
// supprime une invitation envoyée à un ami
function annulInviteFriend($id_Friend){
    $invit = new Invitation();
    $delInvit = $invit->delete($_SESSION['idUser'], $id_Friend);
    $res = responseAjax($delInvit);
    echo json_encode($res);
}
//*************************************************************************
// supprime un ami
function delFriend($id_Friend){
    $relation = new RelationUser();
    $delRelation = $relation->delete($id_Friend, $_SESSION['idUser']);
    if( $delRelation == false){
        spaceUser("Cette personne a bien été retirée de vos amis","","","","","","");
    }else{
        spaceUser("Nous n'avons pas pu retirer cette personne de vos amis...","","","","","","");
    }

}

//*************************************************************************
// invite un amis en envoyant un mail
function inviteFriend($mailFriend){
    $errorInvitMailFriend = "";
    $alertOkChange      ='';
    $alertErrorMail     ='';
    $alertErrorPseudo   ='';
    $alertErrorPsw      ='';
    $alertErrorNbrPeople='';
    $alertErrorPagination='';
    $aPlanningToday     = makeRappelPlanning();

    $invit = new Invitation();
    $user = new User();
    $relation = new RelationUser();

    $verifIsExistFriend = $user ->get('email', $mailFriend);

    if($verifIsExistFriend != false){
        $verifIsRelationExist = $relation ->getRelationBetweenUsers($verifIsExistFriend[0]['id_user'], $_SESSION['idUser']);
        if($verifIsExistFriend[0]['email'] == $_SESSION['email']){
            $errorInvitMailFriend = "Vous ne pouvez pas vous envoyer à vous-même une invitation...";
            spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend,$alertErrorPagination);
        }elseif($verifIsRelationExist != false){
            $errorInvitMailFriend = "Vous êtes déjà ami avec cette personne...";
            spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend,$alertErrorPagination);
        }else{
            $aInVitIsAllReadyExist = $invit->getInvitation($_SESSION['idUser'], $verifIsExistFriend[0]['id_user']);
            if($aInVitIsAllReadyExist==false){
                $invit ->sendInvitationMail($mailFriend, $verifIsExistFriend[0]['id_user']);
                $aDataInvit=array(
                    "id_send"    => $_SESSION['idUser'],
                    "id_receive"   => $verifIsExistFriend[0]['id_user']);
                $invit ->hydrate($aDataInvit);
                $resInvitation = $invit -> add($invit);
                if($resInvitation == false){
                    $errorInvitMailFriend = "Le traitement de la demande n'a pas correctement aboutit...";
                    spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend,$alertErrorPagination);
                }else{
                    $errorInvitMailFriend = "L'invitation a bien été envoyée !";
                    spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend,$alertErrorPagination);
                }
            }else{
                $invit ->sendInvitationMail($mailFriend, $verifIsExistFriend[0]['id_user']);
                $errorInvitMailFriend = "Une demande a déjà été réalisé. Nous avons renvoyé une nouvelle demande";
                spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend,$alertErrorPagination);
            }
        }
    }else{
        $invit -> sendInvitationCreateAcompteMail($mailFriend);
        $errorInvitMailFriend = "Cet e-mail, ou cet utilisateur n'existe pas dans nos données... nous lui avons envoyé une invitation à vous rejoindre sur Kajoo !";
        spaceUser($alertOkChange,$alertErrorMail,$alertErrorPseudo,$alertErrorPsw,$alertErrorNbrPeople,$errorInvitMailFriend,$alertErrorPagination);
    }
}

//*************************************************************************
// affiche la page des liste de course
function showListShop()
{
	$aPlanningToday = makeRappelPlanning();
	require('view/frontend/shopView.php');
}

//********************************************************
// affiche les mentiosn légales
function mention()
{
	$mention = new Mention();
	$aMention = $mention->get();
	$aPlanningToday = makeRappelPlanning();
	require('view/frontend/mentionView.php');
}
//********************************************************
//affiche la politique de confidentialité
function politique()
{
	$politique = new Politique();
	$aPolitique = $politique->get();
	$aPlanningToday = makeRappelPlanning();
	require('view/frontend/politiqueView.php');
}