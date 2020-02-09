<?php
namespace Model;

class IngredientManager extends Bdd
{

    // CONSTANTES
    const TAB_ING = 'ingredient';

    // nom de la table
    // ******************************************************************************************************************

    // ajoute une un ingrédient
    public function add(Ingredient $ingredient)
    {
        $param1 = $ingredient->getTitle();
        $param2 = $ingredient->getUnit();
        $param3 = $ingredient->getCheck_ingredient();
        $param4 = $ingredient->getId_user();

        $request = 'INSERT INTO ' . self::TAB_ING . '(title, unit, check_ingredient, id_user) VALUES (:title, :unit, :check_ingredient, :id_user)';
        $arr = array(
            array(
                ":title",
                $param1
            ),
            array(
                ":unit",
                $param2
            ),
            array(
                ":check_ingredient",
                $param3
            ),
            array(
                ":id_user",
                $param4
            )
        );
        parent::reqPrepaExec($request, $arr);

        $request2 = 'SELECT * FROM ' . self::TAB_ING . ' WHERE title  = :value';
        $arr2 = array(
            array(
                ":value",
                $param1
            )
        );
       // echo $request2;
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
        return $aRes2;
    }

    // *****************************************************************************************************************
    // lit une entrée de la table ingrédient
    public function get($param, $value)
    {
        $request = 'SELECT * FROM ' . self::TAB_ING . ' WHERE ' . $param . '  = :value ORDER BY id_ingredient';
        $arr = array(
            array(
                ":value",
                $value
            )
        );
      // echo $value;
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // *****************************************************************************************************************
    // lit une entrée de la table ingrédient
    public function getsearchBar($param, $value)
    {
        $keywordVrac = explode(' ', $value);
        $size  = count($keywordVrac);
        //if($size < 2){
            for($j = 0 ; $j <$size ; $j++){
                if($keywordVrac[$j] == ""){
                    unset($keywordVrac[array_search("", $keywordVrac)]);
                }
            }
       // }

        $keyword = array_values($keywordVrac);
        $jk = count($keyword);
        if($jk != null){
            $arr = array();

            $request = 'SELECT * FROM ' . self::TAB_ING . ' WHERE ';
            // $request = 'SELECT * FROM ' . self::TAB_ING . ' WHERE ' . $param . ' LIKE :value ';
 /*           if($jk === 1){
                array_push($arr, array(":value",  $keyword[0].'%'));
                $request .= $param . ' LIKE :value ';
            }else{*/
                for($i = 0 ; $i < $jk ; $i++){
                    if ($i < count($keyword) - 1) {
                        $separateur = 'AND';
                    }else{
                        $separateur = '';
                    }
                    array_push($arr, array(":value" . $i,   '%'.$keyword[$i].'%'));
                    $request .= $param . ' LIKE :value'. $i .' ' .$separateur.' ';
                }
    //       }

            $request .= ';';

            $aRes = parent::reqPrepaExecSEl($request, $arr);
  //          print_r($aRes);
            return $aRes;
        }else{
            return false;
        }

    }

    // *****************************************************************************************************************
    // lit une entrée de la table ingrédient en comparant un paramètre et une valeur
    public function getByChoise($param, $value, $idUer)
    {
        $request = 'SELECT * FROM ' . self::TAB_ING . ' WHERE id_user = :idUser AND ' . $param . '  = :value ORDER BY id_ingredient';
        $arr = array(
            array(
                ":idUser",
                $idUer
            ),
            array(
                ":value",
                $value
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // ******************************************************************************************************************
    // actualise une catégorie en respectant l'utilisateur concerné et l'id de la catégory
    public function update($col, $val, $idcategory, $id_user)
    {
        $request = 'UPDATE ' . self::TAB_ING . ' SET ' . $col . ' = :val WHERE id_user = :id_User AND id_category = :val2';
        $arr = array(
            array(
                ":val",
                $val
            ),
            array(
                ":id_User",
                $id_user
            ),
            array(
                ":val2",
                $idcategory
            )
        );
        $aRes = parent::reqPrepaExec($request, $arr);
    }

    // ******************************************************************************************************************
    // supprime toutes les étapes d'une recette
    public function delete($id_recette)
    {
        $request = 'DELETE * FROM ' . self::TAB_ING . ' WHERE id_recette = :id_recette';
        $arr = array(
            array(
                ":id_recette",
                $id_recette
            )
        );
        $aRes = parent::reqPrepaExec($request, $arr);
    }
}

