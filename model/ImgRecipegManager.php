<?php

namespace Model;

class ImgRecipegManager extends Bdd{

	// CONSTANTES

		const TAB_IMG = 'images'; // nom de la table

//******************************************************************************************************************
	 	 //ajoute une image
	 	 public function add(ImgRecipe $imgRecipe){

		    $param1 = $imgRecipe->getImg_nom();
		    $param2 = $imgRecipe->getImg_taille();
		    $param3 = $imgRecipe->getImg_type();
		    $param4 = $imgRecipe->getImg_blob();
		     $param5 = $imgRecipe->getImg_src();
		   


	 	 	$request = 'INSERT INTO '. self::TAB_IMG.'(img_nom, img_taille, img_type, img_blob, img_src) VALUES (:img_nom, :img_taille, :img_type, :img_blob, :img_src)';
	 	 	$arr=array(
	 	 		array(":img_nom"  , $param1),
	 	 		array(":img_taille"  , $param2),
	 	 		array(":img_type"  , $param3),
	 	 		array(":img_blob"  , $param4),
	 	 		array(":img_src"  , $param5));
	 	 	parent::reqPrepaExec($request,$arr);
	 	 }

 //*****************************************************************************************************************
	 	 //lit une entrée de la table image
	 	 public function get($param, $value)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_IMG.' WHERE '.$param.'  = :value';
		 	$arr=array(
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	//print_r($aRes);
		 	return $aRes;
	 	 }

//******************************************************************************************************************
	 	//actualise une image
	 	 public function update($img_nom, $img_taille, $img_type, $img_blob, $img_src, $idImg){

	 	 	$request = 'UPDATE '. self::TAB_IMG.' SET img_nom = :img_nom, img_taille = :img_taille, img_type = :img_type, img_blob= :img_blob, img_src = :img_src WHERE img_id = :idImg';
	 	 	$arr=array(
	 	 		array(":img_id"  , $idImg),
	 	 		array(":img_nom"  , $img_nom),
	 	 		array(":img_taille"  , $img_taille),
	 	 		array(":img_type"  , $img_type),
	 	 		array(":img_blob"  , $img_blob),
	 	 		array(":img_src"  , $img_src));
	 	 	parent::reqPrepaExec($request, $arr);
	 	 	//print_r($aRes);
	 	 }


//******************************************************************************************************************
	 	 //supprime une image
	 	 public function delete($img_nom){
	 	 	
	 	 	$request = 'DELETE FROM '. self::TAB_IMG.' WHERE img_nom = :img_nom';
	 	 	$arr=array(
	 	 		array(":img_nom" , $img_nom));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);
             $request2 = 'SELECT * FROM '. self::TAB_IMG.' WHERE img_nom  = :value';
             $arr2=array(
                 array(":value" , $img_nom));
             $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
             return $aRes2;
	 	 }
//*********************************************************************************************
    //copier une image (on vérifie s l'original existe vu que son existence n'est pas obligatoire
    public function copy($img_nom, $img_newNom, $img_srcNom){

        $request0 = 'SELECT * FROM '. self::TAB_IMG.' WHERE img_nom = :img_nom';
        $arr0=array(
            array(":img_nom" , $img_nom));
        $aRes0 = parent::reqPrepaExecSEl($request0, $arr0);

        if($aRes0 != false) {
            $request = 'INSERT INTO ' . self::TAB_IMG . ' (img_nom, img_taille, img_type, img_blob, img_src) SELECT :img_newNom, img_taille, img_type, img_blob, :img_src FROM ' . self::TAB_IMG . ' where img_nom = :img_nom';
            $arr = array(
                array(":img_nom", $img_nom),
                array(":img_newNom", $img_newNom),
                array(":img_src", $img_srcNom));
            $aRes = parent::reqPrepaExec($request, $arr);

            $request2 = 'SELECT * FROM ' . self::TAB_IMG . ' WHERE img_nom  = :img_nom';
            $arr2 = array(
                array(":img_nom", $img_newNom));
            $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
            return $aRes2;
        }else{
            return $aRes0;
        }

}

		


	}