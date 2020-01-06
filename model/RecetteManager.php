<?php
namespace Model;
class RecetteManager extends Bdd{

	// CONSTANTES
		const TAB_REC = 'recettes'; // nom de la table
//******************************************************************************************************************

	 	 //ajoute une recette 
	 	 public function add(Recette $recette){
	 	 	$param1 = $recette->getTitle();
		    $param2 = $recette->getPrepare_time();
		    $param3 = $recette->getPeople();
		    $param5 = $recette->getPrivate();
		    $param6 = $recette->getId_category();
		    $param7 = $recette->getAlpha();
		    $param8 = $recette->getLove();
		    $param9 = $recette->getPrice();
		    $param10 = $recette->getEasy();
		    $param11 = $recette->getId_user();

	 	 	$request = 'INSERT INTO '. self::TAB_REC.'(title, prepare_time, people, private, id_category, alpha, love, price, easy, id_user) VALUES (:title, :prepare_time, :people,:private, :id_category, :alpha, :love, :price, :easy, :id_user)';
	 	 	$arr=array(
	 	 		array(":title", $param1),
	 	 		array(":prepare_time", $param2),
	 	 		array(":people", $param3),
	 	 		array(":private", $param5),
	 	 		array(":id_category", $param6),
	 	 		array(":alpha", $param7),
	 	 		array(":love", $param8),
	 	 		array(":price", $param9),
	 	 		array(":easy", $param10),
	 	 		array(":id_user", $param11));
	 	 	parent::reqPrepaExec($request,$arr);

	 	 	$request2 = 'SELECT * FROM '. self::TAB_REC.' WHERE title = :title AND prepare_time = :prepare_time AND people = :people AND id_category = :id_category AND alpha = :alpha AND private = :private AND love = :love AND price = :price AND easy = :easy AND id_user = :id_user ';
		 	$arr2=array(
	 	 		array(":title", $param1),
	 	 		array(":prepare_time", $param2),
	 	 		array(":people", $param3),
	 	 		array(":private", $param5),
	 	 		array(":id_category", $param6),
	 	 		array(":alpha", $param7),
	 	 		array(":love", $param8),
	 	 		array(":price", $param9),
	 	 		array(":easy", $param10),
	 	 		array(":id_user", $param11));
		 	$aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
		 	return $aRes2;
	 	 }
    //*********************************************************************************************
    //copier une recette
    public function copy($id_recette, $id_user){
        $request ='INSERT INTO '. self::TAB_REC.' (title, prepare_time, people, private, id_category, alpha, love, price, easy, id_user) SELECT title, prepare_time, people, private, 0, alpha, love, price, easy, :id_user FROM '. self::TAB_REC.' where id_recette = :id_recette';
        $arr=array(
            array(":id_recette"    , $id_recette),
            array(":id_user"   , $id_user));
        $aRes = parent::reqPrepaExec($request, $arr);

        $request2 = 'SELECT MAX(id_recette) FROM '. self::TAB_REC.' WHERE id_user = :id_user';
        $arr2=array(
            array(":id_user"   , $id_user));
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
       // $id = parent::addRequestSelect($request);

        if($aRes2 != false){
            $idLastRecipe = $aRes2[0]['MAX(id_recette)'];
            $request3 = 'SELECT * FROM '. self::TAB_REC.' WHERE id_recette = '.$idLastRecipe.' AND id_user = :id_user';
            $arr3=array(
                array(":id_user" , $id_user));
            $aRes3 = parent::reqPrepaExecSEl($request3, $arr3);
            return $aRes3;
        }else{
            return false;
        }
    }
 //*****************************************************************************************************************
	 	 //lit une entrée de la table recette en comparant un paramètre et une valeur
	 	 public function get($param, $value)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_REC.' WHERE '.$param.'  = :value ORDER BY alpha';
		 	$arr=array(
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }

 //*****************************************************************************************************************
	 	 //lit une entrée de la table recette en comparant un paramètre et une valeur
	 	 public function getByChoise($param, $value, $idUer)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_REC.' WHERE id_user = :idUser AND '.$param.'  = :value ORDER BY alpha';
		 	$arr=array(
		 		array(":idUser" , $idUer),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }

	 	  //*****************************************************************************************************************
	 	 //lit une entrée de la table recette en comparant un paramètre et une valeur et quandtité
	 	 public function getByChoiseAndQuantity($param, $value, $idUer, $limit, $offset)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_REC.' WHERE id_user = :idUser AND '.$param.'  = :value ORDER BY alpha LIMIT '.$offset.', '.$limit.'';
		 	$arr=array(
		 		array(":idUser" , $idUer),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }
	 		//*****************************************************************************************************************
	 	 //lit une entrée de la table recette en comparant un paramètre et une valeur et quandtité et alpha
	 	 public function getByChoiseAndQuantityAlpha($param, $value, $idUer, $limit, $offset, $alpha)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_REC.' WHERE id_user = :idUser AND '.$param.'  = :value AND alpha = :alpha ORDER BY alpha LIMIT '.$offset.', '.$limit.'';
		 	$arr=array(
		 		array(":idUser" , $idUer),
		 		array(":alpha" , $alpha),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }

	 	 //*****************************************************************************************************************
	 	 //lit toute la table recette en comparant un paramètre et une valeur et quantité
	 	 public function getAllAndQuantity($idUer, $limit, $offset)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_REC.' WHERE id_user = :idUser ORDER BY alpha LIMIT '.$offset.', '.$limit.'';
		 	$arr=array(
		 		array(":idUser" , $idUer));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }

	 	  //*****************************************************************************************************************
	 	 //lit une colonne de la table recette en comparant un paramètre et une valeur
	 	 public function getOneColumn($col, $idUer)
	 	 { 
		 	$request = 'SELECT '.$col.' FROM '. self::TAB_REC.' WHERE id_user = :idUser  ORDER BY alpha';
		 	$arr=array(
		 		array(":idUser" , $idUer));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }
	 	 //*****************************************************************************************************************
	 	 //lit une colonne de la table recette en comparant un paramètre et une valeur
	 	 public function getOneColumnByChoice($col, $param, $value, $idUer)
	 	 { 
		 	$request = 'SELECT '.$col.' FROM '. self::TAB_REC.' WHERE id_user = :idUser AND '.$param.'  = :value ORDER BY alpha';
		 	$arr=array(
		 		array(":idUser" , $idUer),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }
	 	 //****************************************************************************************************************
            public function getOneColumnPublic($col, $idUer)
        {
            $request = 'SELECT '.$col.' FROM '. self::TAB_REC.' WHERE id_user = :idUser AND private = 0 ORDER BY alpha';
            $arr=array(
                array(":idUser" , $idUer));
            $aRes = parent::reqPrepaExecSEl($request, $arr);
            return $aRes;
        }
        //**********************************************************************************************************
        public function getOneColumnByChoicePublic($col, $param, $value, $idUer){
		 	$request = 'SELECT '.$col.' FROM '. self::TAB_REC.' WHERE id_user = :idUser AND private = 0 AND '.$param.'  = :value ORDER BY alpha';
		 	$arr=array(
		 		array(":idUser" , $idUer),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
        }
	 	 //*****************************************************************************************************************
	 	 //compte toutes les entrées de la table recette en comparant un paramètre et une valeur
	 	 public function countAllQuantity($idUer)
	 	 { 
		 	$request = 'SELECT COUNT(*) FROM '. self::TAB_REC.' WHERE id_user = :idUser';
		 	$arr=array(
		 		array(":idUser" , $idUer));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }
    //*****************************************************************************************************************
    //compte toutes les entrées public de la table recette d'un ami
        public function countAllQuantityPublic($idUer)
        {
            $request = 'SELECT COUNT(*) FROM '. self::TAB_REC.' WHERE id_user = :idUser AND private = 0';
            $arr=array(
                array(":idUser" , $idUer));
            $aRes = parent::reqPrepaExecSEl($request, $arr);
            return $aRes;
        }
    //*****************************************************************************************************************
    //compte toutes les entrées public de la table recette en comparant un paramètre et une valeur
        public function countAllQuantityAlphaPublic($idUer, $alpha)
        {
            $request = 'SELECT COUNT(*) FROM '. self::TAB_REC.' WHERE id_user = :idUser AND alpha  = :alpha AND private = 0';
            $arr=array(
                array(":alpha" , $alpha),
                array(":idUser" , $idUer));
            $aRes = parent::reqPrepaExecSEl($request, $arr);
            return $aRes;
        }
	 	  //*****************************************************************************************************************
	 	 //compte toutes les entrées de la table recette en comparant un paramètre et une valeur
	 	 public function countCategQuantity($param, $value, $idUer)
	 	 { 
		 	$request = 'SELECT COUNT(*) FROM '. self::TAB_REC.' WHERE id_user = :idUser AND '.$param.'  = :value ';
		 	$arr=array(
		 		array(":idUser" , $idUer),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }

	 	 //*****************************************************************************************************************
	 	 //compte toutes les entrées de la table recette en comparant 2 paramètre2 et 2 valeur2
	 	 public function countNumberRecipeAlphaAndCateg($param, $value, $param2, $value2, $idUer)
	 	 { 
		 	$request = 'SELECT COUNT(*) FROM '. self::TAB_REC.' WHERE id_user = :idUser AND '.$param.'  = :value AND '.$param2.'  = :value2 ';
		 	$arr=array(
		 		array(":idUser" , $idUer),
		 		array(":value2" , $value2),
	 	 		array(":value" , $value));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }
	 	 //*****************************************************************************************************************
	 	 //lit une entrée de la table ingrédient
	 	 public function getsearchBarRecipe($param, $value, $id_user)
	 	 { 
		 	$request = 'SELECT * FROM '. self::TAB_REC.' WHERE '.$param.' LIKE :value AND id_user = :id_user';

		 	$arr=array(
		 		array(":id_user" , $id_user),
	 	 		array(":value" , $value.'%'));
		 	$aRes = parent::reqPrepaExecSEl($request, $arr);
		 	return $aRes;
	 	 }

        //******************************************************************************************************************
	 	 //******************************************************************************************************************
	 	//actualise une recette en respectant l'utilisateur concerné et l'id de la catégory
	 	 public function updateAll(Recette $recette){
	 	 	$param0 = $recette->getId_recette();
	 	 	$param1 = $recette->getTitle();
		    $param2 = $recette->getPrepare_time();
		    $param3 = $recette->getPeople();
		    $param5 = $recette->getPrivate();
		    $param6 = $recette->getId_category();
		    $param7 = $recette->getAlpha();
		    $param8 = $recette->getLove();
		    $param9 = $recette->getPrice();
		    $param10 = $recette->getEasy();
		    $param11 = $recette->getId_user();

	 	 	$request = 'UPDATE '. self::TAB_REC.' SET title = :title, prepare_time = :prepare_time, people = :people, private = :private, id_category= :id_category, alpha = :alpha, love = :love, price = :price, easy = :easy WHERE id_user = :id_user AND id_recette = :id_recette';
	 	 	$arr=array(
	 	 		array(":id_recette", $param0),
	 	 		array(":title", $param1),
	 	 		array(":prepare_time", $param2),
	 	 		array(":people", $param3),
	 	 		array(":private", $param5),
	 	 		array(":id_category", $param6),
	 	 		array(":alpha", $param7),
	 	 		array(":love", $param8),
	 	 		array(":price", $param9),
	 	 		array(":easy", $param10),
	 	 		array(":id_user", $param11));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);

	 	 	$request2 = 'SELECT * FROM '. self::TAB_REC.' WHERE title = :title AND prepare_time = :prepare_time AND people = :people AND id_category = :id_category AND alpha = :alpha AND love = :love AND private = :private AND price = :price AND easy = :easy AND id_user = :id_user AND id_recette = :id_recette ';
		 	$arr2=array(
		 		array(":id_recette", $param0),
	 	 		array(":title", $param1),
	 	 		array(":prepare_time", $param2),
	 	 		array(":people", $param3),
	 	 		array(":private", $param5),
	 	 		array(":id_category", $param6),
	 	 		array(":alpha", $param7),
	 	 		array(":love", $param8),
	 	 		array(":price", $param9),
	 	 		array(":easy", $param10),
	 	 		array(":id_user", $param11));
		 	$aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
		 	return $aRes2;
	 	 }

//******************************************************************************************************************
	 	 //supprime une recette , ses étapes, ses ingrédient et l'image associé.
	 	 public function deleteAllMethod($id_recette, $id_user){
	 	 	
	 	 	$request ='DELETE recettes.*, ingredient_recette.*, etape.*, planning_day.* FROM recettes 
	 	 				LEFT JOIN ingredient_recette ON ingredient_recette.id_recette = recettes.id_recette  
	 	 				LEFT JOIN etape ON etape.id_recette  = recettes.id_recette
	 	 				LEFT JOIN planning_day ON planning_day.id_recette = recettes.id_recette
	 	 				WHERE recettes.id_recette = :id_recette AND recettes.id_user = :user';
	 	 	$arr=array(
	 	 		array(":user" , $id_user),
	 	 		array(":id_recette" , $id_recette));
	 	 	$aRes = parent::reqPrepaExec($request, $arr);

	 	 	$request2 = 'SELECT * FROM '. self::TAB_REC.' WHERE id_user = :idUser AND id_recette  = :value ORDER BY alpha';
		 	$arr2=array(
		 		array(":idUser" , $id_user),
	 	 		array(":value" , $id_recette));
		 	$aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
		 	return $aRes2;
	 	 }
//******************************************************************************************************************

	 	//AVEC AMIE

//******************************************************************************************************************



	}

