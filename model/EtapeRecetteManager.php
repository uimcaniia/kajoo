<?php

namespace Model;

class EtapeRecetteManager extends Bdd{

	// CONSTANTES

		const TAB_ETP = 'etape'; // nom de la table

//******************************************************************************************************************
	 	 //ajoute une etape aux recettes
	 	 public function add(EtapeRecette $etape){
	 	 	$param1 = $etape->getRang();
		    $param2 = $etape->getText();
		    $param3 = $etape->getImg();
		    $param4 = $etape->getTime();
		    $param5 = $etape->getId_recette();
		    		 	 			//echo $param4;

	 	 	$request = 'INSERT INTO '. self::TAB_ETP.'(rang, text, img, time, id_recette) VALUES (:rang, :text, :img, :time, :id_recette)';
	 	 	$arr=array(
	 	 		array(":rang"  , $param1),
	 	 		array(":text"  , $param2),
	 	 		array(":img"  , $param3),
	 	 		array(":time"  , $param4),
	 	 		array(":id_recette"  , $param5));
	 	 	parent::reqPrepaExec($request,$arr);

	 	 	$request2 = 'SELECT * FROM '. self::TAB_ETP.' WHERE id_recette  = :id_recette AND rang = :rang';
	 	 	$arr2=array(
	 	 		array(":rang"  , $param1),
	 	 		array(":id_recette", $param5));
	 	 	$aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
	 	 	return $aRes2;
	 	 }

 //*****************************************************************************************************************
	 	 //lit une entrée de la table etape en comparant un paramètre et une valeur
	 	 public function get($param, $value)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_ETP.' WHERE '.$param.'  = :value ORDER BY rang';
		 	$arr=array(
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }

//******************************************************************************************************************
	 	//actualise une catégorie en respectant l'utilisateur concerné et l'id de la catégory
	 	 public function update($col, $val, $idcategory, $id_user){

	 	 	$request = 'UPDATE '. self::TAB_ETP.' SET '.$col.' = :val WHERE id_user = :id_User AND id_category = :val2';
	 	 	$arr=array(
	 	 		array(":val"    , $val),
	 	 		array(":id_User" , $id_user),
	 	 		array(":val2"   , $idcategory));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);
	 	 }


//******************************************************************************************************************
	 	 //supprime une les étapes d'une recette
	 	 public function delete($idrecette){
	 	 	
	 	 	$request = 'DELETE FROM '. self::TAB_ETP.' WHERE id_recette = :idrecette';
	 	 	$arr=array(
	 	 		array(":idrecette" , $idrecette));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);

	 	 	$request2 = 'SELECT * FROM '. self::TAB_ETP.' WHERE id_recette = :id_recette';
	 	 	$arr2=array(
	 	 		array(":id_recette", $idrecette));
	 	 	$aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
	 	 	return $aRes2;
	 	 }
    //*********************************************************************************************
    //copier les étapes d'un recette
    public function copy($id_recette, $id_newRecette){
        $request ='INSERT INTO '. self::TAB_ETP.' (rang, text, img, time, id_recette) SELECT rang, text, img, time, :id_newRecette FROM '. self::TAB_ETP.' where id_recette = :id_recette';
        $arr=array(
            array(":id_recette"    , $id_recette),
            array(":id_newRecette"   , $id_newRecette));
        $aRes = parent::reqPrepaExec($request, $arr);

        $request2 = 'SELECT * FROM '. self::TAB_ETP.' WHERE id_recette = :id_recette';
        $arr2=array(
            array(":id_recette" , $id_newRecette));
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
        return $aRes2;
    }

		


	}