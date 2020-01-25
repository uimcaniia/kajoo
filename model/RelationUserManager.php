<?php
namespace Model;

class RelationUserManager extends Bdd
{

    // CONSTANTES
    const TAB_RELATION = 'relation_user';

    // nom de la table

    // ******************************************************************************************************************
    // ajoute une relation
    public function add(RelationUser $relationUser)
    {
        $param2 = $relationUser->getId_user();
        $param3 = $relationUser->getId_friend();
        $param4 = $relationUser->getModif_recipe();
        $param5 = $relationUser->getModif_planning();
        $param6 = $relationUser->getModif_shop();

        $request = 'INSERT INTO ' . self::TAB_RELATION . '(id_user, id_friend, modif_recipe, modif_planning, modif_shop) VALUES (:id_user, :id_friend, :modif_recipe, :modif_planning, :modif_shop)';
        $request2 = 'INSERT INTO ' . self::TAB_RELATION . '(id_user, id_friend, modif_recipe, modif_planning, modif_shop) VALUES (:id_friend, :id_user, :modif_recipe, :modif_planning, :modif_shop)';

        $arr = array(
            array(
                ":id_user",
                $param2
            ),
            array(
                ":id_friend",
                $param3
            ),
            array(
                ":modif_recipe",
                $param4
            ),
            array(
                ":modif_planning",
                $param5
            ),
            array(
                ":modif_shop",
                $param6
            )
        );
        parent::reqPrepaExec($request, $arr);
        parent::reqPrepaExec($request2, $arr);
    }

    // *****************************************************************************************************************
    // retourne toute les relations d'un utilisateur
    public function getallRelationOfUser($_id_user)
    {
        $request = 'SELECT * FROM ' . self::TAB_RELATION . ' WHERE id_user  = :value ';
        $arr = array(
            array(
                ":value",
                $_id_user
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // *****************************************************************************************************************
    // retourne la relation entre 2 personnes
    public function getRelationBetweenUsers($id_friend, $id_user)
    {
        $request = 'SELECT * FROM ' . self::TAB_RELATION . ' WHERE id_user = :id_user AND id_friend = :id_friend';
        $arr = array(
            array(
                ":id_friend",
                $id_friend
            ),
            array(
                ":id_user",
                $id_user
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // ******************************************************************************************************************
    // recupère tous les id des amis d'un utilisateur
    public function getIdPeopleWhithRelationOfUser($idUser)
    {
        $request = 'SELECT id_friend FROM ' . self::TAB_RELATION . ' WHERE id_user = :id_user ORDER BY id_friend';
        $arr = array(
            array(
                ":id_user",
                $idUser
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // ******************************************************************************************************************
    // recupère tous utilisateur sauf l'admin et les compte supprimé
    /*
     * public function getAllUserExist()
     * {
     * $request = 'SELECT * FROM '. self::TAB_RELATION.' WHERE admin = 0 AND deleteUser = 0 ORDER BY id_user';
     * $aRes = parent::addRequestSelect($request);
     * return $aRes;
     * }
     */
    // ******************************************************************************************************************
    // actualise les relations d'un utilisateur et d'un amie
    public function update($modif_recipe, $modif_planning, $modif_shop, $id_friend, $id_user)
    {
        $request = 'UPDATE ' . self::TAB_RELATION . ' SET modif_recipe = :modif_recipe, modif_planning = :modif_planning, modif_shop = :modif_shop WHERE id_user = :id_user AND id_friend = :id_friend';
        $arr = array(
            array(
                ":modif_recipe",
                $modif_recipe
            ),
            array(
                ":modif_planning",
                $modif_planning
            ),
            array(
                ":modif_shop",
                $modif_shop
            ),
            array(
                ":id_friend",
                $id_friend
            ),
            array(
                ":id_user",
                $id_user
            )
        );
        $aRes = parent::reqPrepaExec($request, $arr);

        $request2 = 'SELECT * FROM ' . self::TAB_RELATION . ' WHERE id_user = :id_user AND id_friend = :id_friend AND modif_recipe = :modif_recipe AND modif_planning = :modif_planning AND modif_shop = :modif_shop';
        $arr2 = array(
            array(
                ":modif_recipe",
                $modif_recipe
            ),
            array(
                ":modif_planning",
                $modif_planning
            ),
            array(
                ":modif_shop",
                $modif_shop
            ),
            array(
                ":id_friend",
                $id_friend
            ),
            array(
                ":id_user",
                $id_user
            )
        );
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
        return $aRes2;
    }

    // ******************************************************************************************************************
    // supprime une relation entre un user et un friend
    public function delete($id_friend, $id_user)
    {
        $request = 'DELETE FROM ' . self::TAB_RELATION . ' WHERE id_user = :id_user AND id_friend = :id_friend';
        $arr = array(
            array(
                ":id_friend",
                $id_friend
            ),
            array(
                ":id_user",
                $id_user
            )
        );
        $aRes = parent::reqPrepaExec($request, $arr);

        $request1 = 'DELETE FROM ' . self::TAB_RELATION . ' WHERE id_user = :id_friend AND id_friend = :id_user';
        $arr1 = array(
            array(
                ":id_friend",
                $id_friend
            ),
            array(
                ":id_user",
                $id_user
            )
        );
        $aRes1 = parent::reqPrepaExec($request1, $arr1);

        $request2 = 'SELECT * FROM ' . self::TAB_RELATION . ' WHERE id_user = :id_user AND id_friend = :id_friend';
        $arr2 = array(
            array(
                ":id_friend",
                $id_friend
            ),
            array(
                ":id_user",
                $id_user
            )
        );
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
        if ($aRes2 == false) {
            $request3 = 'SELECT * FROM ' . self::TAB_RELATION . ' WHERE id_user = :id_friend AND id_friend = :id_user';
            $arr3 = array(
                array(
                    ":id_friend",
                    $id_friend
                ),
                array(
                    ":id_user",
                    $id_user
                )
            );
            $aRes3 = parent::reqPrepaExecSEl($request3, $arr3);
            if ($aRes3 == false) {
                return $aRes3;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}