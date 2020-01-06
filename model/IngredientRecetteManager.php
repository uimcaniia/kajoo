<?php
namespace Model;
class IngredientRecetteManager extends Bdd{

	// CONSTANTES
		const TAB_INGREC = 'ingredient_recette'; // nom de la table
//******************************************************************************************************************

	 	 //ajoute une un ingrédient d'une recette 
	 	 public function add(IngredientRecette $ingredient_recette){
	 	 	$param1 = $ingredient_recette->getQuantity();
		    $param2 = $ingredient_recette->getId_ingredient();
		    $param3 = $ingredient_recette->getId_recette();

	 	 	$request = 'INSERT INTO '. self::TAB_INGREC.'(quantity, id_ingredient, id_recette) VALUES (:quantity, :id_ingredient, :id_recette)';
	 	 	$arr=array(
	 	 		array(":quantity", $param1),
	 	 		array(":id_ingredient", $param2),
	 	 		array(":id_recette", $param3));
	 	 	parent::reqPrepaExec($request,$arr);

	 	 	$request2 = 'SELECT * FROM '. self::TAB_INGREC.' WHERE id_ingredient  = :id_ingredient AND id_recette = :id_recette';
	 	 	$arr2=array(
	 	 		array(":id_recette", $param3),
	 	 		array(":id_ingredient", $param2));
	 	 	$aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
	 	 	return $aRes2;
	 	 }

 //*****************************************************************************************************************
	 	 //lit une entrée de la table ingrédient en comparant un paramètre et une valeur
	 	 public function get($param, $value)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_INGREC.' WHERE '.$param.'  = :value';
		 	$arr=array(
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }
//******************************************************************************************************************
	 	//actualise une les ingrédients d'une recette en respectant l'utilisateur concerné et l'id de la catégory
	 	 public function update($col, $val, $idcategory, $id_user){

	 	 	$request = 'UPDATE '. self::TAB_INGREC.' SET '.$col.' = :val WHERE id_user = :id_User AND id_category = :val2';
	 	 	$arr=array(
	 	 		array(":val"    , $val),
	 	 		array(":id_User" , $id_user),
	 	 		array(":val2"   , $idcategory));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);
	 	 }
//******************************************************************************************************************
	 	 //supprime les ingrédient d'un recette
	 	 public function delete($idrecette){
	 	 	
	 	 	$request = 'DELETE FROM '. self::TAB_INGREC.' WHERE id_recette = :id_recette';
	 	 	$arr=array(
	 	 		array(":id_recette" , $idrecette));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);

	 	 	$request2 = 'SELECT * FROM '. self::TAB_INGREC.' WHERE id_recette = :id_recette';
	 	 	$arr2=array(
	 	 		array(":id_recette", $idrecette));
	 	 	$aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
	 	 	return $aRes2;
	 	 }
    //*********************************************************************************************
    //copier les ingrédients d'un recette
    public function copy($id_recette, $id_newRecette){
        $request ='INSERT INTO '. self::TAB_INGREC.' (quantity, id_ingredient, id_recette) SELECT quantity, id_ingredient, :id_newRecette FROM '. self::TAB_INGREC.' where id_recette = :id_recette';
        $arr=array(
            array(":id_recette"    , $id_recette),
            array(":id_newRecette"   , $id_newRecette));
        $aRes = parent::reqPrepaExec($request, $arr);

        $request2 = 'SELECT * FROM '. self::TAB_INGREC.' WHERE id_recette  = :id_recette';
        $arr2=array(
            array(":id_recette" , $id_newRecette));
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
        return $aRes2;
	 }
}

