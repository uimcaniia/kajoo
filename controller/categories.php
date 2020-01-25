<?php
use Model\EtapeRecette;
use Model\Calendar;
use Model\Category;
use Model\Form;
use Model\ImgRecipe;
use Model\Ingredient;
use Model\IngredientRecette;
use Model\Liste;
use Model\ListShop;
use Model\Planning;
use Model\PlanningDay;
use Model\Preference;
use Model\Recette;
use Model\Shop;
use Model\User;
use Model\RelationUser;

// ********************************************************
// AJAX
// ajout d'une cétagorie et son rang dans le menu en comparant les rang déjà occumé par les autres catégorie, puis échange
function addCategorie($newCateg, $rangNewCateg)
{
    $category = new Category();
    $aUserCategory = $category->get('id_user', $_SESSION['idUser']);

    if ($aUserCategory != false) {
        for ($i = 0; $i < count($aUserCategory); $i ++) {
            if ($aUserCategory[$i]['rang'] == $rangNewCateg) {
                for ($j = 0; $j < count($aUserCategory); $j ++) {
                    if (($aUserCategory[$j]['rang'] > $rangNewCateg) || ($aUserCategory[$j]['rang'] == $rangNewCateg)) {
                        $category->update('rang', $aUserCategory[$j]['rang'] + 1, $aUserCategory[$j]['id_category'], $_SESSION['idUser']);
                    }
                }
            }
        }
    }

    $aDataNewCategory = array(
        "rang" => $rangNewCateg,
        "title" => $newCateg,
        "id_user" => $_SESSION['idUser'],
        "default_category" => 1
    );

    $category2 = new Category();
    $category2->hydrate($aDataNewCategory);
    $category2->add($category2);

    $aUserAllCategory = $category->get('id_user', $_SESSION['idUser']);
    $res = responseAjax($aUserAllCategory);
    echo json_encode($res);
}

// **********************************************************
// AJAX
// pour modifier le libellé d'une catégorie
function modifLibelCategorie($idCategory, $labelCateg)
{
    $category = new Category();
    $category->update('title', htmlspecialchars($labelCateg), $idCategory, $_SESSION['idUser']);

    $aUserAllCategory = $category->get('id_user', $_SESSION['idUser']);
    // print_r($aUserAllCategory);
    $res = responseAjax($aUserAllCategory);
    // print_r($res);
    echo json_encode($res);
}

// **********************************************************
// AJAX
// pour modifier l'ordre d'affichache des catégories
function modifRangCategorie($idCategory, $rangCateg)
{
    $category = new Category();
    $aUserCategory = $category->get('id_user', $_SESSION['idUser']);
    $rangCategActel = '';

    if ($aUserCategory != false) {
        for ($i = 0; $i < count($aUserCategory); $i ++) {
            if ($aUserCategory[$i]['id_category'] == $idCategory) {
                $rangCategActel = $aUserCategory[$i]['rang'];
            }
        }
        for ($j = 0; $j < count($aUserCategory); $j ++) {
            if ($aUserCategory[$j]['rang'] == $rangCateg) {
                $category->update('rang', $rangCategActel, $aUserCategory[$j]['id_category'], $_SESSION['idUser']);
                $category->update('rang', $rangCateg, $idCategory, $_SESSION['idUser']);
            }
        }
    }

    $aUserAllCategory = $category->get('id_user', $_SESSION['idUser']);
    $res = responseAjax($aUserAllCategory);
    echo json_encode($res);
}

// **********************************************************
// AJAX
// pour supprimer une catégorie
function delCategorie($idcategory)
{
    $category = new Category();
    $category->delete($_SESSION['idUser'], $idcategory);
    $aUserCategory = $category->get('id_user', $_SESSION['idUser']);

    if ($aUserCategory != false) {
        for ($i = 0; $i < count($aUserCategory); $i ++) {
            foreach ($aUserCategory[$i] as $key => $value) {
                if ($key == 'id_category') {
                    $idCategory = $value;
                }
                if ($key == 'rang') {
                    $category->update('rang', $i + 1, $idCategory, $_SESSION['idUser']);
                }
            }
        }
    }

    $aUserAllCategory = $category->get('id_user', $_SESSION['idUser']);
    $res = responseAjax($aUserAllCategory);
    echo json_encode($res);
}

/*
 * //************************************************************************************************************
 * function addRelationAlpha($param, $value){
 * $recette = new Recette();
 * $paginationLetter = false;
 *
 * $relation = new RelationUser();
 * $aAllRelation = $relation->getallRelationOfUser($_SESSION['idUser']);
 *
 * if($aAllRelation != false){
 * for($i = 0; $i < count($aAllRelation) ; $i++){
 * if(($param == "")&&($value == "")){
 * $paginationFriend = $recette -> getOneColumnPublic('alpha', $aAllRelation[$i]['id_user']);
 * }else{
 * $paginationFriend = $recette -> getOneColumnByChoicePublic('alpha', $param, $value, 'private',0, $aAllRelation[$i]['id_user']);
 * }
 * }
 * }
 * $paginationNoDooble = delDooble($paginationLetter, 'alpha');
 * //print_r($paginationLetter);
 * return $paginationNoDooble;
 * }
 * //************************************************************************************************************
 * function countRelationRecipe($alpha, $param, $value){
 * $recette = new Recette();
 * $aCount = false;
 *
 * $relation = new RelationUser();
 * $aAllRelation = $relation->getallRelationOfUser($_SESSION['idUser']);
 *
 * if($aAllRelation != false){
 * for($i = 0; $i < count($aAllRelation) ; $i++){
 * if(($alpha == "")&&($param == "")&&($value == "")){
 * $aCount = $recette -> countAllQuantityPublic($aAllRelation[$i]['id_user']);
 * }else{
 * $aCount = $recette -> countCategQuantityPublic('alpha', $alpha, $aAllRelation[$i]['id_user']);
 * }
 * }
 * }
 * return $aCount;
 * }
 */

// ************************************************************************************************************
// ************************************************************************************************************
// AJAX
// compte les lettre Alpha et le nombre total de recette
function countNumberRecipe($alpha)
{
    $recette = new Recette();
    $paginationLetter = $recette->getOneColumn('alpha', $_SESSION['idUser']);

    if ($paginationLetter != false) {
        $paginationNoDooble = delDooble($paginationLetter, 'alpha');
    } else {
        $paginationNoDooble = $paginationLetter;
    }
    if ($alpha == "") {
        $aCount = $recette->countAllQuantity($_SESSION['idUser']);
    } else {
        $aCount = $recette->countCategQuantity('alpha', $alpha, $_SESSION['idUser']);
    }
    makePaginationForSelection($aCount, $paginationNoDooble);
}

// --------------------------------------------------------------
// AJAX
// affiche toutes les recettes
function showRecipes($offset, $alpha)
{
    $recette = new Recette();
    if ($alpha == "") {
        $aAllRecipe = $recette->getAllAndQuantity($_SESSION['idUser'], $_SESSION['limit_pagination'], $offset);
    } else {
        $aAllRecipe = $recette->getByChoiseAndQuantity('alpha', $alpha, $_SESSION['idUser'], $_SESSION['limit_pagination'], $offset);
    }
    $res = responseAjax($aAllRecipe);
    echo json_encode($res);
}

// ************************************************************************************************************
// ************************************************************************************************************
// AJAX
// compte les lettre Alpha et le nombre de recette de la catégorie
function countNumberRecipeInCategorie($idcategory, $alpha)
{
    $recette = new Recette();
    // $paginationLetter = addAlphaAndRelationAlpha("id_category", "$idcategory");
    $paginationLetter = $recette->getOneColumnByChoice('alpha', 'id_category', $idcategory, $_SESSION['idUser']);

    if ($paginationLetter != false) {
        $paginationNoDooble = delDooble($paginationLetter, 'alpha');
    } else {
        $paginationNoDooble = $paginationLetter;
    }

    if ($alpha == "") {
        $aCount = $recette->countCategQuantity('id_category', $idcategory, $_SESSION['idUser']);
    } else {
        $aCount = $recette->countNumberRecipeAlphaAndCateg('id_category', $idcategory, 'alpha', $alpha, $_SESSION['idUser']);
    }
    makePaginationForSelection($aCount, $paginationNoDooble);
}

// --------------------------------------------------------------
// AJAX
// affiche les recettes suivant leur catégories
function showRecipesCateg($idcategory, $offset, $alpha)
{
    $recette = new Recette();
    if ($alpha == "") {
        $aRecipeCategory = $recette->getByChoiseAndQuantity('id_category', $idcategory, $_SESSION['idUser'], $_SESSION['limit_pagination'], $offset);
    } else {
        $aRecipeCategory = $recette->getByChoiseAndQuantityAlpha('id_category', $idcategory, $_SESSION['idUser'], $_SESSION['limit_pagination'], $offset, $alpha);
    }
    $res = responseAjax($aRecipeCategory);
    echo json_encode($res);
}

// ************************************************************************************************************
// ************************************************************************************************************
// AJAX
// compte les lettre Alpha et le nombre de recette des amis
function countNumberFriendRecipe($idFriend, $alpha)
{
    $recette = new Recette();
    // $paginationLetter = addAlphaAndRelationAlpha("id_category", "$idcategory");
    $paginationLetter = $recette->getOneColumnPublic('alpha', $idFriend);

    if ($paginationLetter != false) {
        $paginationNoDooble = delDooble($paginationLetter, 'alpha');
    } else {
        $paginationNoDooble = $paginationLetter;
    }

    if ($alpha == "") {
        $aCount = $recette->countAllQuantityPublic($idFriend);
    } else {
        $aCount = $recette->countAllQuantityAlphaPublic($idFriend, $alpha);
    }
    makePaginationForSelection($aCount, $paginationNoDooble);
}

// --------------------------------------------------------------
// AJAX
// affiche les recettes des amis
function showFriendRecipes($idFriend, $offset, $alpha)
{
    $recette = new Recette();
    if ($alpha == "") {
        $aRecipeCategory = $recette->getByChoiseAndQuantity('private', 0, $idFriend, $_SESSION['limit_pagination'], $offset);
    } else {
        $aRecipeCategory = $recette->getByChoiseAndQuantityAlpha('private', 0, $idFriend, $_SESSION['limit_pagination'], $offset, $alpha);
    }
    $res = responseAjax($aRecipeCategory);
    echo json_encode($res);
}

// ************************************************************************************************************
// ************************************************************************************************************
// AJAX
// compte les lettre Alpha et le nombre total de recette
function countNumberPrivateRecipe($alpha)
{
    $recette = new Recette();
    // $paginationLetter = addAlphaAndRelationAlpha("", "");
    $paginationLetter = $recette->getOneColumnByChoice('alpha', 'private', 1, $_SESSION['idUser']);

    if ($paginationLetter != false) {
        $paginationNoDooble = delDooble($paginationLetter, 'alpha');
    } else {
        $paginationNoDooble = $paginationLetter;
    }

    if ($alpha == "") {
        $aCount = $recette->countCategQuantity('private', 1, $_SESSION['idUser']);
    } else {
        $aCount = $recette->countNumberRecipeAlphaAndCateg('private', 1, 'alpha', $alpha, $_SESSION['idUser']);
    }
    makePaginationForSelection($aCount, $paginationNoDooble);
}

// --------------------------------------------------------------
// AJAX
// affiche les recettes privée
function showPrivateRecipes($offset, $alpha)
{
    $recette = new Recette();
    if ($alpha == "") {
        $aRecipeCategory = $recette->getByChoiseAndQuantity('private', 1, $_SESSION['idUser'], $_SESSION['limit_pagination'], $offset);
    } else {
        $aRecipeCategory = $recette->getByChoiseAndQuantityAlpha('private', 1, $_SESSION['idUser'], $_SESSION['limit_pagination'], $offset, $alpha);
    }

    $res = responseAjax($aRecipeCategory);
    echo json_encode($res);
}

// ************************************************************************************************************
// ************************************************************************************************************

// AJAX
// compte les lettre Alpha et le nombre de recette sans catégorie
function countNumberOtherRecipe($alpha)
{
    $recette = new Recette();
    // $paginationLetter = addAlphaAndRelationAlpha("id_category", 0);
    $paginationLetter = $recette->getOneColumnByChoice('alpha', 'id_category', 0, $_SESSION['idUser']);

    if ($paginationLetter != false) {
        $paginationNoDooble = delDooble($paginationLetter, 'alpha');
    } else {
        $paginationNoDooble = $paginationLetter;
    }

    if ($alpha == "") {
        $aCount = $recette->countCategQuantity('id_category', 0, $_SESSION['idUser']);
    } else {
        $aCount = $recette->countNumberRecipeAlphaAndCateg('id_category', 0, 'alpha', $alpha, $_SESSION['idUser']);
    }
    makePaginationForSelection($aCount, $paginationNoDooble);
}

// --------------------------------------------------------------
// AJAX
// affiche les recettes sans catégorie
function showOtherRecipes($offset, $alpha)
{
    $recette = new Recette();
    if ($alpha == "") {
        $aRecipeCategory = $recette->getByChoiseAndQuantity('id_category', 0, $_SESSION['idUser'], $_SESSION['limit_pagination'], $offset);
    } else {
        $aRecipeCategory = $recette->getByChoiseAndQuantityAlpha('id_category', 0, $_SESSION['idUser'], $_SESSION['limit_pagination'], $offset, $alpha);
    }

    $res = responseAjax($aRecipeCategory);
    echo json_encode($res);
}

// ******************************************************************
function makePaginationForSelection($aCount, $paginationNoDooble)
{
    $nbr = $aCount[0]['COUNT(*)'];

    if ($nbr <= $_SESSION['limit_pagination']) {
        $aNbrPage = array(
            "nbrPage" => 1,
            "pagination" => $_SESSION['limit_pagination'],
            "letterPage" => $paginationNoDooble
        );
    } else {

        $arrondi = $nbr / $_SESSION['limit_pagination'];
        $aNbrPage = array(
            "nbrPage" => round($arrondi, 0, PHP_ROUND_HALF_UP),
            "pagination" => $_SESSION['limit_pagination'],
            "letterPage" => $paginationNoDooble
        ); // on arrondit à l'entier supérieur
    }

    $res = responseAjax($aNbrPage);
    echo json_encode($res);
}
