	// génère le calendrier de la semaine.
	// selectDay => jour sélectionné sur le calendrier du mois ou jour actuel
	// récupère le planning de la semaine en BDD et créer l'affichage


	function calendarHebdo(selectDay, mois, annee)
	{
		$('#validAllPlanningWeek p').html('Valider le planning!') // initalisation du bouton de sauvegarde
		constructPlanningWeek();
		var arrJourSemaine=   new Array('lundi','mardi','mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');

	   	$.post('index.php?action=giveFirstDayMonth', {jour:selectDay, mois:mois, annee:annee}, function(aData){
	   		// on récupère le planning de la semaine en BDD sous forme le calendrier hebdo du lundi au dimanche
	   		var data = JSON.parse(aData); 
	   		var elemPlanningWeek = $('#planningAllWeek').children(); // on récupère les 7 div de la semaine

		    for(var i = 0 ; i <7 ; i++) 
		    {
	    		$(elemPlanningWeek[i]).children('div.contentPlaningWeek h3.dayWeek').html(data[i]['jour']); // on ajoute la journée
	    		$(elemPlanningWeek[i]).children('div.contentPlaningWeek  p.dateWeek').html(data[i]['dateFr']); // la date
	    		
	    		if((data[i]['list']!=0)&&(data[i]['list']!=null)){ 

		  			$(elemPlanningWeek[i]).children('div.contentPlaningWeek span.fa-clipboard-list').removeClass('emptySpan');
		    	}

	    		if(data[i]['title']!=null) // le nom de l'évènement si il y en a un
		    	{

		    		$(elemPlanningWeek[i]).children('form').children('#putTitleEvent'+i).val(escapeHtml(data[i]['title']));
		    	}

	    		if(Array.isArray(data[i]['id_planning_day']))// si il y a un planning d eprévus
	    		{
	    			for(var j = 0 ; j < data[i]['id_planning_day'].length ; j++)
	    			{
	    				var elemRang = $(elemPlanningWeek[i]).children('form').children('div'); // on met un id aux spans qui ajoute des recettes

	    				if(data[i]['id_planning_day'][j]['libel']!=''){ // on cherche si c'est une recette ou un ingredient quelconque
	    					var ingredient =escapeHtml(data[i]['id_planning_day'][j]['libel']);
	    					var typeInput = 'inputText';
	    				}else{
	    					var ingredient =escapeHtml(data[i]['id_planning_day'][j]['other']);
	    					var typeInput = 'textarea';
	    				}
	    				
	    				if(data[i]['id_planning_day'][j]['rang'] == 0)// si c'est rang petit déjeuné
					   	{
					   		var div = $(elemPlanningWeek[i]).children('form').children('div.breakfast');					   		
					   		var input = constructPlanningDay(typeInput, String(i)+String(j),data[i]['id_planning_day'][j]['personn'], data[i]['id_planning_day'][j]['id_recette'], ingredient)
					   		$(input).insertAfter($(div).children('p'));
					   		$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#removeRecipe'+String(i)+String(j)).click(function(){
								ctrlDeletePlanningDay($(this)); // controle le retrait de l'input
							});
							$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnMinus'+String(i)+String(j)).click(function(){
								ctrlPeoplePlanningminus($(this)); // controle le nombre de personne du planning
							});
							$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnPlus'+String(i)+String(j)).click(function(){
								ctrlPeoplePlanningPlus($(this)); // controle le nombre de personne du planning
							});
					   	}
					   	if(data[i]['id_planning_day'][j]['rang'] == 1)// si c'est rang déjeuné
					   	{
					   		var div = $(elemPlanningWeek[i]).children('form').children('div.lunch');
					   		var input = constructPlanningDay(typeInput, String(i)+String(j),data[i]['id_planning_day'][j]['personn'], data[i]['id_planning_day'][j]['id_recette'], ingredient);
					   		$(input).insertAfter($(div).children('p'));
					   		$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#removeRecipe'+String(i)+String(j)).click(function(){
								ctrlDeletePlanningDay($(this)); // controle le retrait de l'input
							});
							$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnMinus'+String(i)+String(j)).click(function(){
								ctrlPeoplePlanningminus($(this)); // controle le nombre de personne du planning
							});
							$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnPlus'+String(i)+String(j)).click(function(){
								ctrlPeoplePlanningPlus($(this)); // controle le nombre de personne du planning
							});
					   	}
					   	if(data[i]['id_planning_day'][j]['rang'] == 2)// si c'est rang dinner
					   	{
					   		var div = $(elemPlanningWeek[i]).children('form').children('div.dinner');
					   		var input = constructPlanningDay(typeInput, String(i)+String(j),data[i]['id_planning_day'][j]['personn'], data[i]['id_planning_day'][j]['id_recette'], ingredient);
					   		$(input).insertAfter($(div).children('p'));
					   		$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#removeRecipe'+String(i)+String(j)).click(function(){
								ctrlDeletePlanningDay($(this)); // controle le retrait de l'input
							});
							$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnMinus'+String(i)+String(j)).click(function(){
								ctrlPeoplePlanningminus($(this)); // controle le nombre de personne du planning
							});
							$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnPlus'+String(i)+String(j)).click(function(){
								ctrlPeoplePlanningPlus($(this)); // controle le nombre de personne du planning
							});
					   	}
	    			}
		    		
		    	}
		    }
		var elemSpan = $('#planningAllWeek').children('div.contentPlaningWeek')
		$(elemSpan).children('form').children('div.flexColumn').children('div.flexrow').children('input[type="text"]').focus(function(){
			searchBarPlanning(this);
		});
		    ctrlPlanningWeek();
		});
		$('#planningAllWeek div.contentPlaningWeek h3').click(function(){
			if(($(this).parent('.contentPlaningWeek').children('form')).is(":visible")){
				$(this).parent('.contentPlaningWeek').children('form').fadeOut(0);
			}else{
				$('#planningAllWeek div.contentPlaningWeek h3').parent('.contentPlaningWeek').children('form').fadeOut(0);
				$(this).parent('.contentPlaningWeek').children('form').fadeIn(200);
			}
		})
	}
//******************************************************************
// construction des bloc de journée séparé en 3 partie principale (petit dej, déjeuner et dinner)
function constructPlanningWeek(){
	var divGlobal ='';
	for(var i = 0 ; i < 7; i++){
		div = '<div class="contentPlaningWeek"><h3 class="dayWeek"></h3><span class="fas fa-clipboard-list emptySpan"></span><p class="dateWeek"></p><form><label for="putTitleEvent'+i+'"></label><input type="text" name="putTitleEvent'+i+'" value ="" id="putTitleEvent'+i+'" placeholder="Aucun titre" autocomplete="off">';
		
		div1 = '<div class="breakfast flexColumn '+i+'"><p>Petit déjeuner: </p><span class="far fa-edit flexrow"><p> Ajouter</p></span></div>';
		
		div2 = '<div class="lunch flexColumn '+i+'"><p>Déjeuner: </p><span class="far fa-edit flexrow"><p> Ajouter</p></span></div>';
		
		div3 = '<div class="dinner flexColumn '+i+'"><p>Dîner: </p><span class="far fa-edit flexrow"><p> Ajouter</p></span></div>';

		div4 = '</form></div>';

		divGlobal = divGlobal + div+div1+div2+div3+div4;
	}
	
	$('#planningAllWeek').html(divGlobal);			
}

//******************************************************************
//construit le planning de la journée pour l'insérer dans le bloc principal 
function constructPlanningDay(typeInput, id, personn, idRecette, ingredient){
		if(typeInput == 'textarea'){
			div1 = '<div class="flexrow recipe"><span id="removeRecipe'+id+'" class="fas fa-minus"></span>';
			div2 ='<label for="inputRecipe'+id+'"></label><textarea name="inputRecipe'+id+'" class = "textearea" id="inputRecipe'+id+'">'+ingredient+'</textarea>';
			div3 ='<span class="fas fa-child"></span><span id="nbrPersonnMinus'+id+'" class="fas fa-minus"></span><span id="nbrPersonnPlus'+id+'" class="fas fa-plus"></span>';
			div4 ='<p id="planingNbrPeopleRecipe'+id+'">'+personn+'</p></div></div>';
		}else{
			div1 = '<div class="flexrow recipe"><span id="removeRecipe'+id+'" class="fas fa-minus"></span>';
			div2 = '<label for="inputRecipe'+id+'"></label><input type="text" class="'+idRecette+'" name="inputRecipe'+id+'" id="inputRecipe'+id+'" value="'+ingredient+'" placeholder="'+ingredient+'" autocomplete="off">';
			div3 = '<span class="fas fa-child"></span><span id="nbrPersonnMinus'+id+'" class="fas fa-minus"></span><span id="nbrPersonnPlus'+id+'" class="fas fa-plus"></span>';
			div4 = '<p id="planingNbrPeopleRecipe'+id+'">'+personn+'</p></div><div id="content'+id+'"class="flexrow"><div class="searchRecipe'+id+'"></div></div>';
		}

		divGlobal = div1+div2+div3+div4;

		return divGlobal;
}


//******************************************************************
	//pour Controler le planning
function ctrlPlanningWeek(){

	var elemSpan = $('#planningAllWeek').children('div.contentPlaningWeek')
	//---------------------------------------------------------------------------------------------------
	// pour ajouter une recette ou liste, génération des deux boutons de choix ( soit recette soit liste)
	$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('span.fa-edit').click(function(){
		var esarchTextarea = $(this).parent().attr('class');
		var nbrDiv         = $(this).parent().children('div.flexrow.recipe');
		var arrDiv         = [];

		for(var i = 0 ;i < nbrDiv.length ; i++){ // on vérifie si un textearea est déjà présent dans le planing
			if($(nbrDiv[i]).children('textarea').length !=0){
				arrDiv.push(1);
			}
		}
		if(arrDiv.length==0){ // on ajoute ou non un bouton supplémentaire pour générer un textearea de liste
			var div ='<div class="btnAddRecipe flexColumn"><span class="recipe fas fa-plus flexrow"><p>Ajouter une recette</p></span><span class="liste fas fa-plus flexrow"><p>Ajouter liste</p></span></div>';

		}else{
			var div ='<div class="btnAddRecipe"><span class="recipe fas fa-plus flexrow"><p>Ajouter une recette</p></span></div>';
		}
		$(div).insertBefore(this);
		ctrlAddPlanningEtape();
		$(this).fadeOut(0); // on cache la div pour insérer une recette
	});

	//----------------------------------------
	//pour modifier l'indicateur de présence sur une liste de course ou non
		$('#planningAllWeek').children('div.contentPlaningWeek').children('span.fas.fa-clipboard-list').click(function(){
			if ($(this).hasClass('emptySpan')){
				$(this).removeClass('emptySpan');
			}else{
				$(this).addClass('emptySpan');
			}
		});
}

	//------------------------------------------------------------------------------------------------------
	// pour ajouter une étape dans le planning de la journée on vérifie la classe pour savoir si c'est un textarea ou un input à insérer
	function ctrlAddPlanningEtape(){
		$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.btnAddRecipe').children('span').click(function(){

			var nbrChildNewId1 = $(this).parent().parent().parent().children('div.flexColumn').children('div.recipe').length;
			var nbrChildNewId2 = $(this).parent().parent().attr('class').split(' ')[2];
			var newId          = nbrChildNewId2+nbrChildNewId1;

			if($(this).hasClass('liste')){ // si "liste" est dans la class du span cliqué, on génère textarea sinon un input pour une recette
				div1 = '<div class="flexrow recipe"><span id="removeRecipe'+newId+'" class="fas fa-minus"></span>';
				div2 ='<label for="inputRecipe'+newId+'"></label><textarea name="inputRecipe'+newId+'"  class = "textearea" id="inputRecipe'+newId+'"></textarea>';
				div3 ='<span class="fas fa-child"></span><span id="nbrPersonnMinus'+newId+'" class="fas fa-minus"></span><span id="nbrPersonnPlus'+newId+'" class="fas fa-plus"></span>';
				div4 ='<p id="planingNbrPeopleRecipe'+newId+'">1</p></div></div>';
			}else{
				div1 = '<div class="flexrow recipe"><span id="removeRecipe'+newId+'" class="fas fa-minus"></span>';
				div2 = '<label for="inputRecipe'+newId+'"></label><input type="text" class="" name="inputRecipe'+newId+'" id="inputRecipe'+newId+'" value="" placeholder="recette" autocomplete="off">';
				div3 = '<span class="fas fa-child"></span><span id="nbrPersonnMinus'+newId+'" class="fas fa-minus"></span><span id="nbrPersonnPlus'+newId+'" class="fas fa-plus"></span>';
				div4 = '<p id="planingNbrPeopleRecipe'+newId+'">1</p></div><div class="flexrow"><div class="searchRecipe"></div></div>';
			}
			$(this).parent().next().fadeIn(0); // affiche la div pour ajouter une nouvelle recette
			divGlobal = div1+div2+div3+div4;
			$(divGlobal).insertBefore($(this).parent());
			$(this).parent().remove(); //supprime div "ajouter une recette"
			$(this).parent().next().fadeIn(0); // affiche la div pour ajouter une nouvelle recette
		
		$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#removeRecipe'+newId).click(function(e){
			ctrlDeletePlanningDay($(this)); // controle le retrait de l'input
		});
		$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnMinus'+newId).click(function(e){
			ctrlPeoplePlanningminus($(this)); // controle le nombre de personne du planning
		});
		$('#planningAllWeek').children('div.contentPlaningWeek').children('form').children('div.flexColumn').children('div.flexrow').children('span#nbrPersonnPlus'+newId).click(function(e){
			ctrlPeoplePlanningPlus($(this)); // controle le nombre de personne du planning
		});

			var elemSpanSearch = $('#planningAllWeek').children('div.contentPlaningWeek')
			$(elemSpanSearch).children('form').children('div.flexColumn').children('div.flexrow').children('input[type="text"]').focus(function(){
				searchBarPlanning(this); // active la barre de recherche 
				
			});
		});
	}
//---------------------------------------------------------------------------------------------------
// pour retirer une recette ou liste
	function ctrlDeletePlanningDay(span){

		var ClassparentRestantSection = $(span).parent().parent().attr('class').split(' ')[0];
		var ClassparentRestantNbr = $(span).parent().parent().attr('class').split(' ')[2];

		$(span).parent().remove(); // on cache la div pour insérer une recette
		var parentRestant = $('div.planingWeek.flexrow').children();
		var parentChild = $('div.planingWeek.flexrow #planningAllWeek div.contentPlaningWeek form div.flexColumn.'+[ClassparentRestantNbr]+' div.flexrow.recipe');
	
		for(var i = 0 ; i < parentChild.length ; i++){
			$(parentChild[i]).children('span.fa-minus:nth-child(1)').attr('id', 'removeRecipe'+String(ClassparentRestantNbr)+String(i));
			$(parentChild[i]).children('label').attr('for', 'inputRecipe'+String(ClassparentRestantNbr)+String(i));
			$(parentChild[i]).children('label').next().attr('id', 'inputRecipe'+String(ClassparentRestantNbr)+String(i));
			$(parentChild[i]).children('span.fa-minus:nth-child(5)').attr('id', 'nbrPersonnMinus'+String(ClassparentRestantNbr)+String(i));
			$(parentChild[i]).children('span.fa-plus:nth-child(6)').attr('id', 'nbrPersonnPlus'+String(ClassparentRestantNbr)+String(i));
			$(parentChild[i]).children('p').attr('id', 'planingNbrPeopleRecipe'+String(ClassparentRestantNbr)+String(i));
		}
	}
//---------------------------------------------------------------------------------------------------
// pour diminuer le nombre de personne
		function ctrlPeoplePlanningminus(span){
			var people = $(span).next().next().html();
			if (people <= 1){ // on ne descend pas en dessous de 1
			}else{
				$(span).next().next().html(parseInt(people)-1);
			}
		};


		// pour augmenter le nombre de personne
		function ctrlPeoplePlanningPlus(span){
			var people = $(span).next().html();
			$(span).next().html(parseInt(people)+1);
			
		};
	

//*******************************************************************
//barre de recehrche recette
function searchBarPlanning(divContentSearch){

		classActelle  = $(divContentSearch).attr('class');
		valueActuelle = $(divContentSearch).val();
		var showIng   = $(divContentSearch).parent().next().children('div.searchRecipe');
		var valueNp   = $(divContentSearch).val();
		var value     = escapeHtml(valueNp);
	
		$(divContentSearch).keyup(function(){ // a chaque touche enfoncée
			var elemActuel = $(this);
			var valueNp    = $(this).val();
			var value      = escapeHtml(valueNp);
			$(this).removeClass();

			if(value.length > 1){
				$.get('index.php?action=searchBarRecipe', {value:value}, function(aData){ // on recherche les recette avec les valeurs communes
					
					if(aData== false){
						$(showIng).html('<p>Aucune recette ne correspond...<span id="okCreateNewIng"></span></p>');
					}else{
						var data = JSON.parse(aData); // on les récupère
						var list = '';

						for( var i = 0 ; i < data.length ; i++){
							list = list + '<span class="'+ data[i]['id_recette']+'">'+escapeHtml(data[i]['title'])+'</span><br>';
							 // si la saisie correspond a une des recette de la liste, on remplis la class
							if(($(showIng).children('span').length == 1) && (data[i]['title'].toLowerCase() == value.toLowerCase())){
								$(divContentSearch).attr('value', data[i]['title']);
								$(divContentSearch).addClass(data[i]['id_recette']);
								$(showIng).empty()
								list = '';
								break;
							}
						}

						$(showIng).html(list);// on les affiche
						var elemenSpanIng    = $(showIng).children('span');
						var nbrElemenSpanIng = elemenSpanIng.length;

						$(elemenSpanIng).hover(function(){ // en cas de hover sur la liste, on pré-remplis les champs

							var classNewIng        = $(this).attr('class'); 
							var newIdIngredient    = classNewIng.split(' ')[0]; // on récupère l'id de l'ingrédient sélectionné
							var newtitleIngredient = $(this).html(); // le nom de l'ingrédient
							
							$(divContentSearch).removeClass();
							$(divContentSearch).addClass(newIdIngredient);
							$(divContentSearch).val(newtitleIngredient);
						});

						$(elemenSpanIng).click(function(){ // lors du click sur l'un des ingrédients, on remplis les champs

							var classNewIng        = $(this).attr('class'); 
							var newIdIngredient    = classNewIng.split(' ')[0]; // on récupère l'id de l'ingrédient sélectionné
							var newtitleIngredient = $(this).html();

							$(divContentSearch).addClass(newIdIngredient);
							$(divContentSearch).val(newtitleIngredient);
							$(this).parent().empty(); // on vide la liste des ingrédients

						});
					}
					return false;
				});
			}
		});
		$(divContentSearch).change(function() {
			if($(this).val().length < 3){
				$(this).attr('value', '');
				$(this).attr('class', '');
			}
			if(($(this).attr('class')== '')&&($('#okCreateNewIng') == undefined)){
				$(this).addClass(classActelle);
				$(this).val(valueActuelle);
				$(showIng).empty();
			}
		});
	
}

//*********************************************************************************************
	//si on veut sauvegarder. Envoie des données avec AJAX sou forme d'object
	$('#validAllPlanningWeek').click(function(){
		var elemPlanningWeek = $('#planningAllWeek').children(); // on récupère les 7 div de la semaine
		var arrWeek = new Object();

	    for(var i = 0 ; i <7 ; i++){// on controle chaque div de la semaine
	    	arrWeek[i]      = new Object(); // initialisation de l'object qui contiendra les données
	    	dateId_planning = $(elemPlanningWeek[i]).children('div.contentPlaningWeek p.dateWeek').html()

			var day         = dateId_planning.split('-')[0];
			var month       = dateId_planning.split('-')[1];
			var year        = dateId_planning.split('-')[2];
			var datePlaning = day+'-'+month+'-'+year;

			month*=1; 
			// on enregistre si le planning est sur une liste de course
			var valEventLibel = $(elemPlanningWeek[i]).children('form').children('#putTitleEvent'+i).val();
			var eventLibel    = ""

			if(valEventLibel.length>0){ // vérifie si il y a un titre
				eventLibel = valEventLibel;
			}
			var listClass = $(elemPlanningWeek[i]).children('div.contentPlaningWeek span.fa-clipboard-list');

	 		if ($(listClass).hasClass('emptySpan')==true){
	 			var list = 0;
	 		}else{
	 			var list = 1;
	 		}
	 		var divAnalyse = elemPlanningWeek[i];
	 			    
 			arrWeek[i]['datePlaning']  = datePlaning; // date du planning
	 		arrWeek[i]['eventLibel']   = eventLibel; // titre ou non de la journée
	 		arrWeek[i]['list']         = list; // si inscrit sur liste de course ou non
	 		arrWeek[i]['month']        = month; 
	 		arrWeek[i]['planning_day'] = new Object();

 			divElem = $(divAnalyse).children('div.contentPlaningWeek form').children('div').children('div.recipe')
 			if(divElem.length > 0){

			 	for(var j = 0 ; j < divElem.length ; j++){  // on controle tous les ingrédients et plat de la journée dans chaque partie de la journée

			 		var rang = ''; // on récupère le rang afin de savoir si c'est le matin, le midi ou le soir
			 		var searchRang = $('#inputRecipe'+String(i)+String(j)).parent().parent().attr('class');
			 		if(searchRang.split(' ')[0] == 'breakfast'){
			 			rang = 0;
			 		}
			 		if(searchRang.split(' ')[0] == 'lunch'){
			 			rang = 1;
			 		}
			 		if(searchRang.split(' ')[0] == 'dinner'){
			 			rang = 2;
			 		}

			 		var classRecette = $('#inputRecipe'+String(i)+String(j)).attr('class') // si c'est un textarea ou un input
			 		var idRecette    = '0';
			 		var value        = '';
			 		var personn      = $('#planingNbrPeopleRecipe'+String(i)+String(j)).html();

			 		if(classRecette == 'textearea'){
			 			idRecette                     = '0';
			 			value                         = $('#inputRecipe'+String(i)+String(j)).val();
			 			arrWeek[i]['planning_day'][j] = new Object();
						arrWeek[i]['planning_day'][j] = [rang, value, idRecette, personn];
			 		}
			 		else if((classRecette != 'textearea')&&(classRecette != null)){
			 			idRecette                     = $('#inputRecipe'+String(i)+String(j)).attr('class');
			 			value                         = $('#inputRecipe'+String(i)+String(j)).val();
			 			arrWeek[i]['planning_day'][j] = new Object();
						arrWeek[i]['planning_day'][j] = [rang, value, idRecette, personn];
			 		}
			 	}
			}

			if(Object.keys(arrWeek[i]['planning_day']).length == 0) { //on s'assure qu'il y ai bien des étape de planning dans la journée
				delete arrWeek[i];
			}
		}
		var data = JSON.stringify(arrWeek);
		 $.post('index.php?action=createPlanning', {arrWeek:data}, function(aData){ // on supprime ceux actuel et on créer un nouvel id

		});
		 $('#validAllPlanningWeek p').html('Planning sauvegardé!');
	});

