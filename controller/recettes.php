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


//********************************************************************************************
//pour afficher la pages des recettes
function showRecipeView()
{
	$user         = new User();
	$getInfosUser = $user->get('id_user', $_SESSION['idUser']);
	$user-> hydrate($getInfosUser[0]);

    $getRelationShip = $user->getRelationUserAndInfosFriend($_SESSION['idUser']);

	$category      = new Category(); // on récupère les catégories de l'utilisateur
	$aUserCategory = $category->get('id_user', $_SESSION['idUser']);
	//print_r($aUserCategory);

	//$recette = new recette(); // on récupère les lettre de référence pour créer la navigation

	$pref = new Preference();
	$aUserPref = $pref->get('id_user', $_SESSION['idUser']);
	$aPlanningToday = makeRappelPlanning();
	require('view/frontend/recetteView.php');
}
//**********************************************************************
//récupère toutes les lettres alpha en supprimant les doublons
function delDooble($aArr, $param)
{
	$aReturn = array();
	$akeyDoble = array(); // array qui contiendra les déjà chargé pour éviter les doublons

	for($i = 0 ; $i < count($aArr) ; $i++)
	{
		foreach ($aArr[$i] as $key => $value)
		{
			if($key == $param)
			{
				if(!in_array($value, $akeyDoble))
				{
					array_push($aReturn, $aArr[$i]);
					array_push($akeyDoble, $value);
				}
			}
		}
	}
	return $aReturn;
}


//*****************************************************************
// AJAX
// affiche le contenu de la recette sélectionné
function showOneRecipes($idRecette)
{
	$_SESSION['idRecette']  = $idRecette;
	$recette = new Recette();
	$aAllRecipe = $recette->getRecipeMethod($idRecette, $_SESSION['idUser']);
		
	$res = responseAjax($aAllRecipe);
	echo json_encode($res);
}

//***************************************************************
// supprime une rectte ainsi que les étpes de la recette et ses ingrédients
function delRecipes($idRecette)
{
	$recette = new Recette();
	$aAllRecipe = $recette->deleteAllMethod($idRecette, $_SESSION['idUser']);

	deleteImgRecipe($idRecette);

	$res = responseAjax($aAllRecipe);
	echo json_encode($res);
}
//***************************************************************
// copy une rectte ainsi que les étpes de la recette et ses ingrédients
function copyRecipes($idRecette)
{
    $result = false;
    $recette = new Recette();
    $aAllRecipe = $recette->get('id_recette', $idRecette);
    if($aAllRecipe != false){
/*        $aDataRecette=array(
            "title"        => $aAllRecipe[0]['title'],
            "prepare_time" => $aAllRecipe[0]['prepare_time'],
            "people"       => $aAllRecipe[0]['people'],
            "private"      => $aAllRecipe[0]['private'],
            "id_category"  => 0,
            "alpha"        => $aAllRecipe[0]['alpha'],
            "love"         => $aAllRecipe[0]['love'],
            "price"        => $aAllRecipe[0]['price'],
            "easy"         => $aAllRecipe[0]['easy'],
            "id_user"      => $_SESSION['idUser']);

        $recette->hydrate($aDataRecette);
        $recette->add($recette);*/

        $aCopyRecipe = $recette->copy($aAllRecipe[0]['id_recette'], $_SESSION['idUser']);

        if($aCopyRecipe != false){
            $ingRecette = new IngredientRecette();
            $aResIngCopy = $ingRecette->copy($idRecette, $aCopyRecipe[0]['id_recette']);

            $etapeRecette = new EtapeRecette();
            $aResEtapeCopy = $etapeRecette->copy($idRecette, $aCopyRecipe[0]['id_recette']);

            $aResImgCopy = copyImgRecipe($aAllRecipe[0]['id_user'], $idRecette, $aCopyRecipe[0]['id_recette']);

            if(($aResIngCopy == false)||($aResEtapeCopy == false)||($aResImgCopy == false)){
                $result = false;
            }else{
                $result = true;
            }
        }
    }
    $res = responseAjax($result);
    echo json_encode($res);
}
//**********************************************************************
//barre de recherche ingrédient
function searchBarIngredient($val)
{
	$ingredient = new Ingredient();
	$aIngredient= $ingredient->getsearchBar('title', htmlspecialchars($val));

	$res = responseAjax($aIngredient);
	echo json_encode($res);
}

//**********************************************************************
//actualize les indicateurs d'une recette
function actualizeRecipes($idRecette, $price, $easy, $people, $love, $id_category, $title, $alpha, $prepare_time, $private)
{
	$recette = new Recette();

		$aDataRecette=array(
		"id_recette"    => $idRecette,
		"title"         => $title,
		"prepare_time"  => $prepare_time,
		"people"        => $people,
		"id_category"   => $id_category,
		"private"       => $private,
		"alpha"         => $alpha,
		"love"          => $love,
		"price"         => $price,
		"easy"          => $easy,
		"id_user"       => $_SESSION['idUser']);

	$recette->hydrate($aDataRecette);
	$lastRecipe = $recette->updateAll($recette);

	if($lastRecipe == false){ // si on arrive pas a récupérer la recette tout juste update
		$res = responseAjax(false);
	}else{
		$_SESSION['idRecette']  = $lastRecipe[0]['id_recette'];
		$res = responseAjax($lastRecipe);
	}
	//print_r($res);
	echo json_encode($res);

/*	$res = responseAjax($saveIng);
	echo json_encode($res);*/
}
//********************************************************************
//supprime les ingrédients d'une recette
function delIngRecipe($idRecette)
{
	$ingRecette = new IngredientRecette();
	$lastRecipe=$ingRecette->delete($idRecette);

	$res = responseAjax($lastRecipe);
	echo json_encode($res);
}
//********************************************************************
//supprime les étapes d'une recette
function delEtapeRecipe($idRecette)
{
	$etapeRecette = new EtapeRecette();
	$lastRecipe=$etapeRecette->delete($idRecette);

	$res = responseAjax($lastRecipe);
	echo json_encode($res);
}
//**********************************************************************
//actualize les ingrédients d'une recette
function actualizeIngRecipe($quantity, $id_ingredient, $idRecette)
{
	$ingRecette = new IngredientRecette();

	$aDataIngrédient=array(
	"quantity"      => $quantity,
	"id_ingredient" => $id_ingredient,
	"id_recette"    => $idRecette);

	$ingRecette->hydrate($aDataIngrédient);
	$saveIng = $ingRecette->add($ingRecette);

	$res = responseAjax($saveIng);
	echo json_encode($res);
}
//**********************************************************************
//actualize les étapes d'une recette
function actualizeEtapeRecipe($rang, $text, $img, $time, $idRecette)
{
	$etapeRecette = new EtapeRecette();

	$aDataEtape=array(
	"rang"       => $rang,
	"text"       => $text,
	"img"        => $img,
	"time"       => $time,
	"id_recette" => $idRecette);

	$etapeRecette->hydrate($aDataEtape);
	$saveEtape = $etapeRecette->add($etapeRecette);

	$res = responseAjax($saveEtape);
	echo json_encode($res);
}

//***********************************************************************
// pour ajouter un nouvel ingrédient dans le lexique
function addNewIngBdd($newIngLabel, $newIngUnit)
{
	$ingredient = new Ingredient();
	$exist = $ingredient->get('title', htmlspecialchars($newIngLabel));
	if($exist==false)
	{
		$aDataIngredient=array(
			"title"            => $newIngLabel,
			"unit"             => $newIngUnit,
			"check_ingredient" => 1,
			"id_user"          => $_SESSION['idUser']);

		$ingredient->hydrate($aDataIngredient);
		$ingredient->add($ingredient);
	}
}
//************************************************************************
// sauvegarde d'une nouvelle recette et renvoie de son ID
function saveNewRecipes($private, $price, $easy, $people, $love, $id_category, $title, $alpha, $prepare_time)
{
	$recette = new Recette();
	$aDataRecette=array(
		"title"        => $title,
		"prepare_time" => $prepare_time,
		"people"       => $people,
		"private"      => $private,
		"id_category"  => $id_category,
		"alpha"        => $alpha,
		"love"         => $love,
		"price"        => $price,
		"easy"         => $easy,
		"id_user"      => $_SESSION['idUser']);

	$recette->hydrate($aDataRecette);
	$lastRecipe = $recette->add($recette);

	if($lastRecipe == false){ // si on arrive pas a récupérer la recette tout juste enregistrée
		$res = responseAjax(false);
	}else{
		$_SESSION['idRecette']  = $lastRecipe[0]['id_recette'];
		$res = responseAjax($lastRecipe);
	}

	echo json_encode($res);
}
//*************************************************************************
// vérifie si un titre de recette n'est pas déjà utilisée
function verifTitle($title){
	$recette = new Recette();
	$existTitle = $recette->get('title', htmlspecialchars($title));

	if($existTitle != false)
	{
		$res = responseAjax(false);
		echo json_encode($res);
	}else
	{
		$res = responseAjax(true);
		echo json_encode($res);
	}
}


//*********************************************************************************
// barre de recherche des recettes pour le planning
function searchBarRecipe($value)
{
	$recette = new Recette();
	$aRecette= $recette->getsearchBarRecipe('title', $value, $_SESSION['idUser']);

	$res = responseAjax($aRecette);
	echo json_encode($res);
} 
