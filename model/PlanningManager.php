<?php
namespace Model;

class PlanningManager extends Bdd{

	// CONSTANTES

		const TAB_PLA = 'planning'; // nom de la table

//******************************************************************************************************************
	 	 //ajoute un évènement au planing
	 	 public function add(Planning $planning){
	 	 	$param1 = $planning->getDate_planning();
		    $param2 = $planning->getMonth();
		    $param3 = $planning->getTitle();
		    $param5 = $planning->getId_user();
		     $param8 = $planning->getList();
		    // echo $param1;

	 	 	$request = 'INSERT INTO '. self::TAB_PLA.'(date_planning, list, month, title, id_user) VALUES (:date_planning, :list, :month, :title, :id_user)';
	 	 	$arr=array(
	 	 		array(":date_planning"  , $param1),
	 	 		array(":month"  , $param2),
	 	 		array(":title"  , $param3),
	 	 		array(":list"  , $param8),
	 	 		array(":id_user"  , $param5));
	 	 	parent::reqPrepaExec($request,$arr);
	 	 }

 //*****************************************************************************************************************
	 	 //lit une entrée de la table planing en comparant un paramètre et une valeur
	 	 public function get($param, $value, $user)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_PLA.' WHERE '.$param.'  = :value AND id_user = :user';
		 	$arr=array(
		 		array(":user" , $user),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	//print_r($aRes);
		 	return $aRes;
	 	 }


//******************************************************************************************************************
	 	 //recupère tous utilisateur sauf l'admin
	 	 public function getAllUser()
	 	 {
		 	 $request = 'SELECT * FROM '. self::TAB_PLA.' WHERE admin = 0 ORDER BY id_user';
		 	 $arr=array(
	 	 		array(":val" , $val));
		 	 $aRes = parent::reqPrepaExecSEl($request, $arr);
		 	 	return $aRes;
	 	 }
//****************************************************************************************************************
	 	 //récupère l'id du dernier planning enregistré (en cas de création)
	 	 public function getLastPlanning()
	 	 {
	 	 	$request = 'SELECT MAX(id_planning) FROM '. self::TAB_PLA.'';
	 	 	$id = parent::addRequestSelect($request);
	 	 	return $id;
	 	 }

//******************************************************************************************************************
	 	//actualise le planing en respectant l'utilisateur concerné
	 	 public function update(Planning $planning){
	 	 	$param0 = $planning->getId_planning();
	 	 	$param1 = $planning->getDate_planning();
	 	 	$param2 = $planning->getMonth();
		    $param3 = $planning->getTitle();
		    $param5 = $planning->getId_user();
		     $param8 = $planning->getList();
		     
/*		     echo $param0;
		     echo $param1;
		     echo $param2;
		     echo $param3;
		     echo $param5;
		     echo $param8;*/


	 	 	$request = 'UPDATE '. self::TAB_PLA.' SET title = :title, month = :month, date_planning = :date_planning, list= :list WHERE id_user = :id_User AND id_planning = :id_planning';
	 	 	$arr=array(
	 	 		array(":id_planning"  , $param0),
	 	 		array(":date_planning"  , $param1),
	 	 		array(":month"  , $param2),
	 	 		array(":title"  , $param3),
	 	 		array(":id_User"  , $param5),
	 	 		array(":list"  , $param8));
	 	 	parent::reqPrepaExec($request, $arr);
	 	 	//print_r($aRes);
	 	 }


//******************************************************************************************************************
	 	 //supprime le planning d'une journée
	 	 public function delete($id_planning){
	 	 	
	 	 	$request = 'DELETE FROM '. self::TAB_PLA.' WHERE id_planning = :id_planning';
	 	 	$arr=array(
	 	 		array(":id_planning" , $id_planning));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);
	 	 }


		


	}