<?php
namespace Model;

class Calendar extends PlanningManager
{

    // **************************************************
    // Attributs de l'objet
    // **************************************************
    private $_jour;

    private $_mois;

    private $_annee;

    private $_id_user;

    private $_aDayWeek = array(
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
        'Sun'
    );

    private $_aDayWeekFrench = array(
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi'
    );

    private $_aDayMonthPrev = array();

    private $_aDayMonth = array();

    private $_aDayWeekSelect = array();

    // **************************************************
    // Methode
    // **************************************************
    public function hydrate($aData)
    {
        if ($aData != false) {
            foreach ($aData as $key => $value) {
                // On récupère le nom du setter correspondant à l'attribut en mettant sa première lettre en majuscule.
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }

    // *************************************************************************
    // retourne le planning de la journée pour l'afficher dans le <aside>
    public function getlastRappel($value, $user)
    {
        $aPlaning = parent::get('date_planning', $value, $user);
        if ($aPlaning == false) {
            return false;
        } else {
            $aPlaningDay;
            $aPlaningDay = new PlanningDay();
            $aPlanningDayDetails = $aPlaningDay->getPlanningRecipe($aPlaning[0]['id_planning'], $user);

            for ($i = 0; $i < count($aPlanningDayDetails); $i ++) {
                $aPlaning[0]['id_planningDay'][$i] = $aPlanningDayDetails[$i];
            }
            return $aPlaning;
        }
    }

    // *************************************************************************
    // récupère la semaine (lundi au dimanche) dont le jour sélectionné en fait partie.
    // renvoie un array contenant la date complète au format SQL, le nom de la journée et si un évènement est présent via le planning
    public function getWeekSelect()
    {
        $moisPrev = $this->_mois;
        // echo $this->_mois;
        $anneePrev = $this->_annee;

        if ($this->_mois == 0) {
            $moisPrev = 11;
            $anneePrev = intval($this->_annee - 1);
        } else {
            $moisPrev = $this->_mois - 1;
        }

        $datePrev = mktime(0, 0, 0, $moisPrev, 1, $anneePrev);
        $date = mktime(0, 0, 0, $this->_mois, 1, $this->_annee);

        $resPrev = date("D", $datePrev);
        $res = date("D", $date); // trouve le premier jour du mois (ex:Tue)

        $keyPrev = array_search($resPrev, $this->_aDayWeek);
        $key = array_search($res, $this->_aDayWeek); // retourne la clé correspondant à la amleur de $res pour récupérer le jour français du 1er du mois (ex:mardi)

        $numberPrevMonth = cal_days_in_month(CAL_GREGORIAN, $moisPrev, $anneePrev); // nombre de jour dans le mois d'avant
        $numberMonth = cal_days_in_month(CAL_GREGORIAN, $this->_mois, $this->_annee); // nombre de jour dans le mois (ex:31)
                                                                                      // echo $this->_jour;

        $jourNext = $key;
        for ($x = 1; $x <= $numberMonth; $x ++) // array contenant le mois actuel
        {
            $this->_aDayMonth[$x]['jour'] = $this->_aDayWeekFrench[$jourNext];
            if ($this->_aDayWeekFrench[$jourNext] == 'lundi') {
                $this->_aDayMonth[$x]['debut'] = 'nouvel';
            }
            if ($this->_aDayWeekFrench[$jourNext] == 'dimanche') {
                $this->_aDayMonth[$x]['fin'] = 'nouvel';
            } // str_pad : ajoute un zéro ou autre (2eme param), en début ou fin(4ème param), pour former nombre à 2 chiffre (ex 8 => 08)
            $this->_aDayMonth[$x]['date'] = $this->_annee . '-' . str_pad($this->_mois, 2, 0, STR_PAD_LEFT) . '-' . str_pad($x, 2, 0, STR_PAD_LEFT);
            $jourNext ++;
        }

        // print_r($this->_aDayMonth);
        // echo $this->_jour;
        for ($j = $this->_jour; $j >= 1; $j --) // array contenant la semaine en cour
        {

            if (array_key_exists('debut', $this->_aDayMonth[$j])) // on récupère les jours qui précède la date sélectionnée depuis le lundi
            {
                $this->_aDayWeekSelect[$j] = $this->_aDayMonth[$j];
                break;
            } else {
                $this->_aDayWeekSelect[$j] = $this->_aDayMonth[$j];
            }
        }
        // print_r($this->_aDayWeekSelect);
        for ($j = $this->_jour; $j <= $numberMonth; $j ++) {
            if (array_key_exists('fin', $this->_aDayMonth[$j])) // on récupère les jours qui suive la date sélectionnée depuis le dimanche
            {
                $this->_aDayWeekSelect[$j] = $this->_aDayMonth[$j];
                break;
            } else {
                $this->_aDayWeekSelect[$j] = $this->_aDayMonth[$j];
            }
        }
        // print_r($this->_aDayWeekSelect);
        ksort($this->_aDayWeekSelect); // on remet par ordre croissant les clés du tableau

        if (count($this->_aDayWeekSelect) < 6) { // on vérifie si il manque des jours (fin ou début de mois pour semaine à cheval)
            $manque = 7 - count($this->_aDayWeekSelect); // nombre de jour qu'il manque pour avair une semaine complète
            $jourSemaine = count($this->_aDayWeekSelect); // nbr de jour actuel dans le array

            if ($this->_jour > 20) // si c'est en fin de mois
            {
                $jourSemaineIndex = $jourSemaine;
                for ($j = 1; $j <= $manque; $j ++) {

                    $this->_aDayWeekSelect[$j]['jour'] = $this->_aDayWeekFrench[$jourSemaineIndex];
                    if ($this->_aDayWeekFrench[$jourSemaineIndex] == 'lundi') {
                        $this->_aDayWeekSelect[$j]['debut'] = 'nouvel';
                    }
                    if ($this->_aDayWeekFrench[$jourSemaineIndex] == 'dimanche') {
                        $this->_aDayWeekSelect[$j]['fin'] = 'nouvel';
                    }
                    $this->_aDayWeekSelect[$j]['date'] = $this->_annee . '-' . str_pad($this->_mois + 1, 2, 0, STR_PAD_LEFT) . '-' . str_pad($j, 2, 0, STR_PAD_LEFT);
                    $jourSemaineIndex ++;
                }
            } else // si c'est en début de mois, on récupère les jour du mois d'avant
            {
                $jourSemaineIndex = $manque - 1;
                for ($j = 0; $j < $manque; $j ++) {

                    $this->_aDayWeekSelect[$numberPrevMonth - $j]['jour'] = $this->_aDayWeekFrench[$jourSemaineIndex];
                    if ($this->_aDayWeekFrench[$jourSemaineIndex] == 'lundi') {
                        $this->_aDayWeekSelect[$numberPrevMonth - $j]['debut'] = 'nouvel';
                    }
                    if ($this->_aDayWeekFrench[$jourSemaineIndex] == 'dimanche') {
                        $this->_aDayWeekSelect[$numberPrevMonth - $j]['fin'] = 'nouvel';
                    }
                    $this->_aDayWeekSelect[$numberPrevMonth - $j]['date'] = $this->_annee . '-' . str_pad($moisPrev, 2, 0, STR_PAD_LEFT) . '-' . str_pad($numberPrevMonth - $j, 2, 0, STR_PAD_LEFT);
                    $jourSemaineIndex --;
                }
            }
        }
        // print_r($this->_aDayWeekSelect);
        $this->_aDayWeekSelect = self::orderWeek($this->_aDayWeekSelect);
        $this->_aDayWeekSelect = self::getPlanningWeekSelect($this->_aDayWeekSelect);
        return $this->_aDayWeekSelect;
    }

    // ***********************************************
    public function orderWeek($arrWeek)
    {
        $arrNew = array_values($arrWeek); // on réinitialise les clés
        $arrRes = array();
        for ($i = 0; $i < count($arrNew); $i ++) {
            $arrNew[$i]['dateFr'] = strftime('%d-%m-%Y', strtotime($arrNew[$i]['date']));
            if ($arrNew[$i]['jour'] == "lundi") {
                $arrRes[0] = $arrNew[$i];
            } elseif ($arrNew[$i]['jour'] == "mardi") {
                $arrRes[1] = $arrNew[$i];
            } elseif ($arrNew[$i]['jour'] == "mercredi") {
                $arrRes[2] = $arrNew[$i];
            } elseif ($arrNew[$i]['jour'] == "jeudi") {
                $arrRes[3] = $arrNew[$i];
            } elseif ($arrNew[$i]['jour'] == "vendredi") {
                $arrRes[4] = $arrNew[$i];
            } elseif ($arrNew[$i]['jour'] == "samedi") {
                $arrRes[5] = $arrNew[$i];
            } else {
                $arrRes[6] = $arrNew[$i];
            }
        }

        return $arrRes;
    }

    // *********************************************
    public function getPlanningWeekSelect($arrWeek)
    {
        foreach ($arrWeek as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == 'date') {

                    $aPlaningDay = parent::get('date_planning', $value2, $this->_id_user);
                    $arrWeek[$key]['title'] = $aPlaningDay[0]['title'];
                    $arrWeek[$key]['list'] = $aPlaningDay[0]['list'];
                    $planninDay = new PlanningDay();

                    $aPlanningDayDetails = $planninDay->getPlanningRecipe($aPlaningDay[0]['id_planning'], $this->_id_user);
                    $arrWeek[$key]['id_planning_day'] = $aPlanningDayDetails;

                    // array_push($arrWeek[$key], $aPlanningDayDetails[0]['']);
                }
            }
        }
        return $arrWeek;
    }

    // **************************************************
    // GETTERS
    // **************************************************

    /**
     * Retourne le jour
     */
    public function getJour()
    {
        return $this->_jour;
    }

    /**
     * Retournele mois
     */
    public function getMois()
    {
        return $this->_mois;
    }

    /**
     * Retourne l'année
     */
    public function getAnnee()
    {
        return $this->_annee;
    }

    /**
     * Retourne l'id de l'utilisateur
     */
    public function getId_user()
    {
        return $this->_id_user;
    }

    // **************************************************
    // SETTERS
    // **************************************************

    /**
     * Assigne le jour
     */
    public function setJour($jour)
    {
        $jour = (int) $jour;
        $this->_jour = $jour;
    }

    /**
     * Assigne le mois
     */
    public function setMois($mois)
    {
        $mois = (int) $mois;
        $this->_mois = $mois;
    }

    /**
     * Assigne l'année
     */
    public function setAnnee($annee)
    {
        $annee = (int) $annee;
        $this->_annee = $annee;
    }

    /**
     * Assigne l'id de l'utilisateur
     */
    public function setId_user($id_user)
    {
        $id_user = (int) $id_user;
        $this->_id_user = $id_user;
    }
}
	
