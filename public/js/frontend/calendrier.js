// Date actuelle
var today = new Date();
today.setHours(0,0,0,0);
// Mois actuel
var currentMonth = new Date(today.getFullYear(), today.getMonth(), 1);

//*************************************************************************
// si on veut afficher le calendrier du mois
$('#ShowCurentMonth').click(function(){
	$('#validAllPlanningWeek').css('display','none');
	$('#ShowCurentMonth').fadeOut(0)
	$('#ShowCurentWeek').fadeIn(0);
	$('section div.flexrow.planingWeek').fadeOut(0);
	$('section div.flexrow.calendrier').fadeIn(0);
	$('#validAllPlanningWeek').fadeOut(0);
	calendar(currentMonth, today);
})

//*************************************************************************
function getPlanningDay(){
	$('#validAllPlanningWeek').css('display','flex');
	$('#ShowCurentWeek').fadeOut(0);
	$('#ShowCurentMonth').fadeIn(0);
	$('section div.flexrow.calendrier').fadeOut(0);
	$('section div.flexrow.planingWeek').css('display','flex');
	$('#validAllPlanningWeek').fadeIn(0);
	calendarHebdo(today.getDate(), today.getMonth()+1, today.getFullYear());

}

//*************************************************************************
// si on veut afficher le calendrier de la semaine
$('#ShowCurentWeek').click(function(){
	getPlanningDay();
})


//*************************************************************************
$('#suiteRappel').click(function(){
	$('li#btnPlaning a').get(0).click();

})
//*************************************************************************
$('#suiteRappelMobile').click(function(){
	$('li#btnPlaning a').get(0).click();

})
	
//*************************************************************************
function calendar(currentMonth, today){
	$('#calendar').html('');
    this.domElement = document.getElementById('calendar');

    // Liste des mois
    this.monthList = new Array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aôut', 'septembre', 'octobre', 'novembre', 'décembre');
    // Liste des jours de la semaine
    this.dayList = new Array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');

    // On créé le div qui contiendra l'entête de notre calendrier
    var header = document.createElement('div');
    header.classList.add('header');
    this.domElement.appendChild(header);

    // On créé le div qui contiendra les jours de notre calendrier
    var content = document.createElement('div');
    $(content).attr('id', 'divAllDay');
    this.domElement.appendChild(content);

    // Bouton "précédent"
    var previousButton = document.createElement('button');
    previousButton.setAttribute('data-action', '-1');
    //previousButton.textContent = '\u003c';//\u003c'
    previousButton.setAttribute('class', "fas fa-angle-double-left");//\u003c'
    header.appendChild(previousButton);

    // Div qui contiendra le mois/année affiché
    this.monthDiv = document.createElement('div');
    this.monthDiv.classList.add('month');
    header.appendChild(this.monthDiv);

    // Bouton "suivant"
    var nextButton = document.createElement('button');
    nextButton.setAttribute('data-action', '1');
    //nextButton.textContent = '\u003e';//\u003e
    nextButton.setAttribute('class', "fas fa-angle-double-right");//\u003e
    header.appendChild(nextButton);

    // Action des boutons "précédent" et "suivant"
    $('#calendar div.header button').click(function(){
    	var action = $(this).attr('data-action');	            
             currentMonth.setMonth(currentMonth.getMonth() * 1 + action * 1);
            loadMonth(currentMonth, content, today);
    });

    // On charge le mois actuel
    loadMonth(currentMonth, content, today);
}

//*************************************************************************
function loadMonth(date, content, today)	{
	month = date.getMonth()+1;
    // On vide notre calendrier
    content.textContent = '';

    // On ajoute le mois/année affiché
    this.monthDiv.textContent = this.monthList[date.getMonth()].toUpperCase() + ' ' + date.getFullYear();

    // Création des cellules contenant le jour de la semaine
    for(let i=0; i<this.dayList.length; i++)
    {
        let cell = document.createElement('span');
        cell.classList.add('cell');
        cell.classList.add('day');
        cell.textContent = this.dayList[i].substring(0, 3).toUpperCase();
        content.appendChild(cell);

    }

    // Création des cellules vides si nécessaire
    for(let i=0; i<date.getDay(); i++)
    {
        let cell = document.createElement('span');
        cell.classList.add('cell');
        cell.classList.add('empty');
        content.appendChild(cell);
    }

    // Nombre de jour dans le mois affiché
    let monthLength = new Date(date.getFullYear(), date.getMonth()+1, 0).getDate();
    // on récupère les évènement dans le mois

   	$.post('index.php?action=loadPlanningMonth', {month:month}, function(aData){


	    // Création des cellules contenant les jours du mois affiché
	    for(let j=1; j<=monthLength; j++)
	    {
	        let cell = document.createElement('span');
	        cell.classList.add('cell');
	        cell.classList.add('number');
	        cell.textContent = j;
	                let timestamp = new Date(date.getFullYear(), date.getMonth(),j).getTime();
	        
	        // Ajoute une classe spéciale pour aujourd'hui
	        if(timestamp === today.getTime())
	        {
	            cell.classList.add('today');
	        }

	        if(aData!= false){ // si il n'y a  évènement dans le mois affiché
	        	var data = JSON.parse(aData);

				for(var i=0; i<data.length; i++){
					var justDay = data[i]['date_planning'].substr(data[i]['date_planning'].length - 2); // on récupère juste le jour 
					if(justDay.substr(0,1) == '0') // on vérifie si le jour commence par un '0' ex: 08
					{
						data[i]['date_planning'] =justDay.substr(1); // on le supprime pour le garder que le premier chiffre (8)
					}else{
						data[i]['date_planning'] = data[i]['date_planning'].substr(data[i]['date_planning'].length - 2); 
					}
					if(data[i]['date_planning'] == j){ // si un évènement est présent à cette date, on change la couleur de fond
						cell.classList.add('eventHear');
					}
					

				}
			}
	        content.appendChild(cell);
	        // Timestamp de la cellule

	    }
    	return aData;
	});
    // charge les évènement de la journée sélectionnée
    $('#calendar').on('click', 'div#divAllDay span.cell.number', function(e){	    	
   		showEventDay(this, month, date.getFullYear());
   	});

}


//*************************************************************************
 function showEventDay(cell, month, yearCalendar){
	var day = $(cell).html();

	$.post('index.php?action=loadPlanningDay', {day:day, month:month}, function(aData){
		var compareDate   = new Date(); // on récupère la date pour la comparer au jour sélectionné
		var monthToday    = compareDate.getMonth() + 1;
		var dayToday      = compareDate.getDate();
		var dateToday     = new Date(compareDate.getFullYear(), monthToday, dayToday);
		var dateCalendar  = new Date(yearCalendar,month,day); 

		if(aData == false){ // si il n'y a auncun évènement 
			$('#contentPlaningMonthDay').removeClass();
			$('#contentPlaningMonthDay').fadeOut(0);

			if(dateCalendar < dateToday){ //et que la date est déjà passée
				$('#addEventCalendar').fadeOut(0);
				$('#nothingEvent').fadeIn(0);
				$('#nothingEvent').removeClass();
				$('#nothingEvent').addClass(day+' '+month+' '+yearCalendar); // on insère la date cliqué dans la classe

			}else{
				$('#addEventCalendar').fadeIn(0);
				$('#nothingEvent').fadeIn(0);
				$('#nothingEvent').removeClass();
				$('#nothingEvent').addClass(day+' '+month+' '+yearCalendar);
			}
		}else{ // si il y a un évènement
			$('#contentPlaningMonthDay').fadeIn(0);
			$('#contentPlaningMonthDay').removeClass();
			$('#contentPlaningMonthDay').addClass(day+' '+month+' '+yearCalendar);
			$('#nothingEvent').fadeOut(0);
			$('#nothingEvent').removeClass();

			var data = JSON.parse(aData); 

			$('#dateView').html('date : '+ data[0]['date_planning']);
			if(data[0]['title']!=''){
				$('#titleEventView').html(data[0]['title'])
			}
			var divContentRecipe = '';

			var arrDate         = data[0]['date_planning'].split("-");
			var dateEvent       = new Date(arrDate[2],arrDate[1],arrDate[0]); 
			var divContentRecipe='';

			$('#contentPlaningMonthDay div div.flexColumn').empty();
			for (var i = 0 ; i < data[0]['id_planning_day'].length ; i++){

				if(data[0]['id_planning_day'][i]['rang'] == 0){
					var classContainerRecipe = 'breakfast';
				}else if (data[0]['id_planning_day'][i]['rang'] == 1){
					var classContainerRecipe = 'lunch';
				}else if (data[0]['id_planning_day'][i]['rang'] == 2){
					var classContainerRecipe = 'dinner';
				}

				if(data[0]['id_planning_day'][i]['libel']!=''){ // on cherche si c'est une recette ou un ingredient quelconque
					var ingredient =data[0]['id_planning_day'][i]['libel'];
				}else{
					var ingredient =data[0]['id_planning_day'][i]['other'];
				}

				divContentRecipe = '<div class="flexrow"><p>'+ingredient+' pour '+data[0]['id_planning_day'][i]['personn']+ '</p><span class="fas fa-child"></span></div>';
				$(divContentRecipe).appendTo($('#contentPlaningMonthDay  div.'+classContainerRecipe+' div.flexColumn'));
			}
		}
		return false;
	});
}

//*****************************************************************************************************************
// action pour afficher le planning de la semaine suivant le jour sélectionné
$('#calendarEvent ').on('click', 'div#contentPlaningMonthDay div#modiEventCalendar span.fa-eye', function(e){
	var date  = $(this).parent().parent().attr('class');
	var day   = date.split(' ')[0];
	var month = date.split(' ')[1];
	var year  = date.split(' ')[2];

	$('section div.flexrow.calendrier').fadeOut(0);
	$('#ShowCurentWeek').fadeOut(0);
	$('#ShowCurentMonth').fadeIn(0);
	$('section div.flexrow.planingWeek').css('display','flex');
	$('#validAllPlanningWeek').fadeIn(0);

	calendarHebdo(day, month, year);

});

//*************************************************************************
$('#calendarEvent').on('click', 'div#nothingEvent div#addEventCalendar span.fa-eye', function(e){
	var date  = $(this).parent().parent().attr('class'); // on récupère la date cliqué dans la class
	var day   = date.split(' ')[0];
	var month = date.split(' ')[1];
	var year  = date.split(' ')[2];

	$('section div.flexrow.calendrier').fadeOut(0);
	$('#ShowCurentWeek').fadeOut(0);
	$('#ShowCurentMonth').fadeIn(0);
	$('section div.flexrow.planingWeek').css('display','flex');
	$('#validAllPlanningWeek').fadeIn(0);

	calendarHebdo(day, month, year);
});


