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
//*************************************************************************
// affiche la page planning 
function showPlanningMonth()
{
	$pref = new Preference();
	$aUserPref = $pref->get('id_user', $_SESSION['idUser']);
	$aPlanningToday = makeRappelPlanning();
    require('view/frontend/shopView.php');
	//require('view/frontend/planingMonthView.php');
}

//*************************************************************************
// charge le calendrier et le planing correspondant
function loadPlanningMonth($month)
{
	$planning = new Planning();
	$aPlaning = $planning->get('month', $month, $_SESSION['idUser']);

	if($aPlaning == false){
		echo false;
	}
	else{
		echo json_encode($aPlaning);
	}
}
//*************************************************************************
// charge le planing de la journée sélectionnée 
function loadPlanningDay($day, $month)
{
	if(strlen($day)==1)
	{
		$day = '0'.$day;
	}
	if(strlen($month)==1)
	{
		$month = '0'.$month;
	}
	$date     = ''.date('Y').'-'.$month.'-'.$day.'';
	$planning = new Planning();
	$aPlaning = $planning->get('date_planning', $date, $_SESSION['idUser']);

	if($aPlaning == false)
	{
		echo false;
	}else{
		for($i = 0 ; $i < count($aPlaning) ; $i++)
		{
			foreach($aPlaning[$i] as $key => $value)
			{
				if($key == 'date_planning')
				{
					$aPlaning[$i]['date_planning']= strftime('%d-%m-%Y',strtotime($aPlaning[$i]['date_planning']));
				}
				if($key == 'id_planning')
				{
					$planningDay  = new PlanningDay();
					$aPlanningDay = $planningDay->getPlanningRecipe($value, $_SESSION['idUser']);
					$aPlaning[$i]['id_planning_day'] = $aPlanningDay;
				}
			}
		}
		echo json_encode($aPlaning);
	}
}
//************************************************************************************
// récupère le jour sélectionné et construit la semaine autours en commençant par lundi
function giveFirstDayMonth($jour, $mois, $annee)
{
	$calendar = new Calendar();

	$aDataCalendar=array(
	"jour"    => $jour,
	"mois"    => $mois,
	"annee"   => $annee,
	"id_user" =>$_SESSION['idUser']);

	$calendar->hydrate($aDataCalendar);
	$aDayWeekSelect = $calendar->getWeekSelect();

	echo json_encode($aDayWeekSelect);

}

//*********************************************************************************
// création d'un nouveau planning
function createPlanning($arrWeek)
{

	$json_data = json_decode($arrWeek, true); // array via ajax
	for($i = 0 ; $i < count($json_data) ; $i++)
	{
		$planning = new Planning();
		$planningDay = new PlanningDay();
		$json_data[$i]['datePlaningUS'] = strftime('%Y-%m-%d',strtotime($json_data[$i]['datePlaning']));
		// on vérifie si ce planning existe déjà en comparant la date et l'id du user
		$aPlaning = $planning->get('date_planning', $json_data[$i]['datePlaningUS'], $_SESSION['idUser']);

		if($aPlaning ==  false) // si le planning de cette journée n'a jamais été enregistré une seule fois par ce user, 
		{
			$aDataPlanning=array( // on le sauvegarde, on récupère l'id
				"date_planning" => $json_data[$i]['datePlaning'],
				"month"         => $json_data[$i]['month'],
				"list"          => $json_data[$i]['list'],
				"title"         => $json_data[$i]['eventLibel'],
				"id_user"       =>$_SESSION['idUser']);

			$planning->hydrate($aDataPlanning);
			$planning->add($planning);

			$aLastIdPlanning = $planning->getLastPlanning(); //on récupère l'id
			$json_data[$i]['id_planning'] = $aLastIdPlanning[0]['MAX(id_planning)'];
		}
		else // si déjà sauvegarde, on utilise l'id, pour mettre à jour le planning et supprimer le planning day 
		{

			$json_data[$i]['id_planning'] = $aPlaning[0]['id_planning'];

			$aDataPlanning=array( 
				"id_planning"   => $aPlaning[0]['id_planning'],
				"date_planning" => $json_data[$i]['datePlaning'],
				"month"         => $json_data[$i]['month'],
				"list"          => $json_data[$i]['list'],
				"title"         => $json_data[$i]['eventLibel'],
				"id_user"       =>$_SESSION['idUser']);

			$planning->hydrate($aDataPlanning);
			$planning->update($planning); // maj planning
			$planningDay->delete($json_data[$i]['id_planning']); // del planning day
		}

		for($j = 0 ; $j < count($json_data[$i]['planning_day']) ; $j++)
		{
			$planningDay2 = new PlanningDay();
			$aDataPlanningDay = array(
				"rang"         => $json_data[$i]['planning_day'][$j][0],
				"id_recette"   => $json_data[$i]['planning_day'][$j][2],
				"id_planning"  => $json_data[$i]['id_planning'],
				"other"        => $json_data[$i]['planning_day'][$j][1],
				"personn"      => $json_data[$i]['planning_day'][$j][3],
				"id_user"      => $_SESSION['idUser']);

			$planningDay2->hydrate($aDataPlanningDay); // on les ajoute en BDD
			$planningDay2->add($planningDay2);
		}
	}
}