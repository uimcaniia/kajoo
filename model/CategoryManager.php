<?php
namespace Model;

class CategoryManager extends Bdd
{

    // CONSTANTES
    const TAB_CATE = 'category';

    // nom de la table

    // ******************************************************************************************************************
    // ajoute une catégorie aux recettes
    public function add(Category $category)
    {
        $param1 = $category->getDefault_category();
        $param2 = $category->getRang();
        $param3 = $category->getTitle();
        $param4 = $category->getId_user();

        $request = 'INSERT INTO ' . self::TAB_CATE . '(default_category, rang, title, id_user) VALUES (:default_category, :rang, :title, :id_user)';
        $arr = array(
            array(
                ":default_category",
                $param1
            ),
            array(
                ":rang",
                $param2
            ),
            array(
                ":title",
                $param3
            ),
            array(
                ":id_user",
                $param4
            )
        );
        parent::reqPrepaExec($request, $arr);
    }

    // *****************************************************************************************************************
    // lit une entrée de la table catégorie en comparant un paramètre et une valeur
    public function get($param, $value)
    {
        $request = 'SELECT * FROM ' . self::TAB_CATE . ' WHERE ' . $param . '  = :value ORDER BY rang';
        $arr = array(
            array(
                ":value",
                $value
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // ******************************************************************************************************************
    // recupère toute les catégories
    /*
     * public function getAllUser()
     * {
     * $request = 'SELECT * FROM '. self::TAB_CATE.' WHERE admin = 0 ORDER BY id_user';
     * $arr=array(
     * array(":val" , $val));
     * $aRes = parent::reqPrepaExecSEl($request, $arr);
     * return $aRes;
     * }
     */
    // ******************************************************************************************************************
    // recupère tous utilisateur sauf l'admin et les compte supprimé
    /*
     * public function getAllUserExist()
     * {
     * $request = 'SELECT * FROM '. self::TAB_CATE.' WHERE admin = 0 AND deleteUser = 0 ORDER BY id_user';
     * $aRes = parent::addRequestSelect($request);
     * return $aRes;
     * }
     */

    // ******************************************************************************************************************
    // actualise une catégorie en respectant l'utilisateur concerné et l'id de la catégory
    public function update($col, $val, $idcategory, $id_user)
    {
        $request = 'UPDATE ' . self::TAB_CATE . ' SET ' . $col . ' = :val WHERE id_user = :id_User AND id_category = :val2';
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
    // supprime une catégorie, met à jour les recettes associées
    public function delete($user, $idCategory)
    {
        $request = 'DELETE FROM ' . self::TAB_CATE . ' WHERE id_user = :user AND id_category = :idCategory';
        $arr = array(
            array(
                ":user",
                $user
            ),
            array(
                ":idCategory",
                $idCategory
            )
        );
        $aRes = parent::reqPrepaExec($request, $arr);

        $request3 = 'UPDATE recettes SET id_category = 0 WHERE id_user = :user AND id_category = :idCategory';
        $arr3 = array(
            array(
                ":user",
                $user
            ),
            array(
                ":idCategory",
                $idCategory
            )
        );
        $aRes3 = parent::reqPrepaExec($request3, $arr3);
    }
}