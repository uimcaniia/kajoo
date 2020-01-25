<?php
namespace Model;

class PlanningDayManager extends Bdd
{

    // CONSTANTES
    const TAB_PLADAY = 'planning_day';

    // nom de la table

    // ******************************************************************************************************************
    // ajoute un évènement au planing
    public function add(PlanningDay $planningDay)
    {
        $param1 = $planningDay->getRang();
        $param3 = $planningDay->getId_recette();
        $param4 = $planningDay->getId_planning();
        $param5 = $planningDay->getOther();
        $param6 = $planningDay->getPersonn();

        $param8 = $planningDay->getId_user();

        $request = 'INSERT INTO ' . self::TAB_PLADAY . '(rang, id_recette, id_planning, other, personn, id_user) VALUES (:rang, :id_recette, :id_planning, :other, :personn, :id_user)';
        $arr = array(
            array(
                ":rang",
                $param1
            ),
            array(
                ":id_recette",
                $param3
            ),
            array(
                ":id_planning",
                $param4
            ),
            array(
                ":other",
                $param5
            ),
            array(
                ":personn",
                $param6
            ),
            array(
                ":id_user",
                $param8
            )
        );
        parent::reqPrepaExec($request, $arr);
    }

    // *****************************************************************************************************************
    // lit une entrée de la table planing en comparant un paramètre et une valeur
    public function get($param, $value, $user)
    {
        $request = 'SELECT * FROM ' . self::TAB_PLADAY . ' WHERE ' . $param . '  = :value AND id_user = :user';
        $arr = array(
            array(
                ":user",
                $user
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
    // lit le planning de la journée et récupère le titre des recettes
    public function getPlanningRecipe2($idPlanning, $user)
    {
        $request = 'SELECT a.*, b.title
	 	 			   FROM ' . self::TAB_PLADAY . ' AS a 
	 	 			   INNER JOIN recettes AS b 
	 	 			   ON b.id_recette = a.id_recette 
	 	 			   WHERE a.id_user =:user AND a.id_planning =:idPlanning';

        $arr = array(
            array(
                ":user",
                $user
            ),
            array(
                ":idPlanning",
                $idPlanning
            )
        );

        $aRes = parent::reqPrepaExecSEl($request, $arr);

        return $aRes;
    }

    // ******************************************************************************************************************
    // lit le planning de la journée et récupère le titre des recettes si il y en a
    public function getPlanningRecipe($idPlanning, $user)
    {
        $request = 'SELECT * FROM ' . self::TAB_PLADAY . ' WHERE id_planning = :idPlanning AND id_user = :user ORDER BY rang';

        $arr = array(
            array(
                ":user",
                $user
            ),
            array(
                ":idPlanning",
                $idPlanning
            )
        );

        $aRes = parent::reqPrepaExecSEl($request, $arr);
        if ($aRes != false) {
            for ($i = 0; $i < count($aRes); $i ++) {
                $request2 = 'SELECT * FROM recettes WHERE id_recette = ' . $aRes[$i]['id_recette'] . '';
                $aRes2 = parent::addRequestSelect($request2);
                if ($aRes2 != false) {
                    $aRes[$i]['libel'] = $aRes2[0]['title'];
                } else {
                    $aRes[$i]['libel'] = "";
                }
            }
        } else {}

        return $aRes;
    }

    // ******************************************************************************************************************
    // actualise une catégorie en respectant l'utilisateur concerné et l'id de la catégory
    public function update($col, $val, $idcategory, $id_user)
    {
        $request = 'UPDATE ' . self::TAB_PLADAY . ' SET ' . $col . ' = :val WHERE id_user = :id_User AND id_category = :val2';
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
    // supprime une les étapes d'une recette
    public function delete($id_planning)
    {
        $request = 'DELETE FROM ' . self::TAB_PLADAY . ' WHERE id_planning = :id_planning';
        $arr = array(
            array(
                ":id_planning",
                $id_planning
            )
        );
        $aRes = parent::reqPrepaExec($request, $arr);
    }
}