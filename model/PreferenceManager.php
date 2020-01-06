<?php

namespace Model;

class PreferenceManager extends Bdd{

	// CONSTANTES

		const TAB_PREF = 'preference'; // nom de la table

//******************************************************************************************************************
	 	 //ajoute un évènement au planing
	 	 public function add(Preference $pref){
	 	 	$param1 = $pref->getId_user();
		    $param2 = $pref->getPeople_planning();
		    $param3 = $pref->getPeople_recipe();
		    $param4 = $pref->getLimit_pagination();

	 	 	$request = 'INSERT INTO '. self::TAB_PREF.'(id_user, people_planning, people_recipe, limit_pagination) VALUES (:id_user, :people_planning, :people_recipe, :limit_pagination)';
	 	 	$arr=array(
	 	 		array(":id_user"  , $param1),
	 	 		array(":people_planning"  , $param2),
	 	 		array(":people_recipe"  , $param3),
	 	 		array(":limit_pagination"  , $param4));
	 	 	parent::reqPrepaExec($request,$arr);
	 	 }

 //*****************************************************************************************************************
	 	 //lit une entrée de la table planing en comparant un paramètre et une valeur
	 	 public function get($param, $value)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_PREF.' WHERE '.$param.'  = :value';
		 	$arr=array(
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }


//******************************************************************************************************************
	 	 //recupère tous utilisateur sauf l'admin
	 	 public function getAllUser()
	 	 {
		 	 $request = 'SELECT * FROM '. self::TAB_PREF.' WHERE admin = 0 ORDER BY id_user';
		 	 $arr=array(
	 	 		array(":val" , $val));
		 	 $aRes = parent::reqPrepaExecSEl($request, $arr);
		 	 	return $aRes;
	 	 }
//******************************************************************************************************************
	 	 //recupère tous utilisateur sauf l'admin et les compte supprimé
	 	 public function getAllUserExist()
	 	 {
		 	$request = 'SELECT * FROM '. self::TAB_PREF.' WHERE admin = 0 AND deleteUser = 0 ORDER BY id_user';
		 	$aRes = parent::addRequestSelect($request);
		 	return $aRes; 
	 	 }

//******************************************************************************************************************
	 	//actualise une préférence en respectant l'utilisateur concerné 
	 	 public function update($col, $val, $id_user){

	 	 	$request = 'UPDATE '. self::TAB_PREF.' SET '.$col.' = :val WHERE id_user = :id_User';
	 	 	$arr=array(
	 	 		array(":val"    , $val),
	 	 		array(":id_User" , $id_user));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);
	 	 }


//******************************************************************************************************************
	 	 //supprime une les étapes d'une recette
	 	 public function delete($idrecette){
	 	 	
	 	 	$request = 'DELETE FROM '. self::TAB_PREF.' WHERE id_recette = :idrecette';
	 	 	$arr=array(
	 	 		array(":idrecette" , $idrecette));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);
	 	 }


		


	}