

//*******************************************************************
//AJAX pour modifier la recette
$('#modifRecipe').click(function(){


		$('#validModifRecipe p').html('Sauvegarder la recette');
		var classes = $(this).attr('class');
		var idRecette = classes.split(' ')[3];

		$('#idRecetteSelectToShow').html(idRecette);
		$('#contentViewRecipe').fadeOut(0);
		$('#contentModifViewRecipe').fadeIn(500);

		useAjaxReqestJson('index.php?action=showOneRecipes', 'POST', 'json', {idRecette: idRecette}, function (data) {

			$('input#titleNewModifRecipe').attr('value', escapeHtml(data[0]['title']));
			$('input#alphaNewModifRecipe').attr('value', escapeHtml(data[0]['alpha']));
			if (data[0]['private'] === "1") {
				$('#modifPrivateRecipe').html('<span class="fas fa-lock"></span>');
			} else {
				$('#modifPrivateRecipe').html('<span class="fas fa-lock-open"></span>');
			}

			var inputFile = $('#modifFormImgRecipe #file');
			inputFile.replaceWith(inputFile.val('').clone(true)); // on reset le input file
			$('#imgRecipeModif img').attr("src", '');

			if ($('#imgModifRecipe span:first-child').hasClass('fa-times')) {
				$('#imgModifRecipe span:first-child').removeClass('fa-times');
				$('#imgModifRecipe span:first-child').addClass('fa-camera');
				$('#modifFormImgRecipe').css('display', 'none');

			}
			useAjaxReqestJson('index.php?action=loadImgRecipe', 'POST', 'json', {idRecette: idRecette}, function (dataImg) {

				if (Array.isArray(dataImg)) {

					$('#imgModifRecipe span.fa-camera').click()
					$('#imgRecipeModif img').attr("src", dataImg[0]['img_src']);
					if($('#modifBlockThreeTitle span').hasClass('fa-sort-down')){
						$('#modifBlockThreeTitle').click()
					}
					resizeDivEtapeFood('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
				}else{
					resizeDivEtapeFood('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
				}
			});


			$('#ModifnbrPeopleRecipe').html(data[0]['people']);
			var aTime = data[0]['prepare_time'].split(':');
			var spanPrive = '<span class="fas fa-coins emptySpan"></span>';

			if (data[0]['price'] === 1) {
				spanPrive = '<span class="fas fa-coins"></span>';
			} else {
				var spanPrive = '';
				for (var i = 0; i < data[0]['price']; i++) {
					spanPrive = spanPrive + '<span class="fas fa-coins"></span>';
				}
			}
			$('#ModifPriceRecipe').html(spanPrive);

			if (data[0]['love'] === 0) {
				$('#Modiflove').html('<span class="fas fa-heart emptySpan"></span>');
			} else {
				$('#Modiflove').html('<img src="public/img/fraise.png" alt="fraise">');
			}

			var spanEasy = '<span class="fas fa-pepper-hot emptySpan"></span>';
			if (data[0]['price'] === 1) {
				spanEasy = '<span class="fas fa-pepper-hot"></span>';
			} else {
				spanEasy = '';
				for (var i = 0; i < data[0]['easy']; i++) {
					spanEasy = spanEasy + '<span class="fas fa-pepper-hot"></span>';
				}
			}
			$('#ModifeasyRecipe').html(spanEasy);
			$('#selectModifCategRecipe').val(data[0]['id_category']);
			var ingredient = '<p>Ingrédient :</p>';

			for (var i = 0; i < data[0]['id_ingredient_recette'].length; i++) {
				ingredient2 = '<div class="flexrow pushIngDiv"><span id ="removeIng' + i + '" class="fas fa-minus ' + data[0]['id_ingredient_recette'][i]['id_ingredient_recette'] + '"></span>';
				ingredient3 = '<label for="qtIngRecipe' + i + '"></label><input type="text" id="qtIngRecipe' + i + '" name="qtIngRecipe' + i + '" value="' + escapeHtml(data[0]['id_ingredient_recette'][i]['quantity']) + '" autocomplete="off">';
				ingredient4 = '<p>' + data[0]['id_ingredient_recette'][i]['unit'] + '</p>';
				ingredient5 = '<label for="searchIngRecipe' + i + '"></label><input type="texte" class="' + data[0]['id_ingredient_recette'][i]['id_ingredient'] + '" name ="searchIngRecipe' + i + '" id="searchIngRecipe' + i + '" placeholder="' + escapeHtml(data[0]['id_ingredient_recette'][i]['title']) + '" autocomplete="off"></div><div class="titleIngRecipe"></div>';
				ingredient = ingredient + ingredient2 + ingredient3 + ingredient4 + ingredient5;
			}
			ingredient = ingredient + '<span id ="pushIng" class="fas fa-plus flexrow"><p>Ajouter un ingrédient à la recette</p></span><span id ="createNewIng" class="fas fa-plus flexrow"><p>Ajouter un ingrédient au lexique</p></span>';
			$('#contentModifFood').html(ingredient);
			// on active la recherche une fois les inputs dans le DOM
			for (var i = 0; i < data[0]['id_ingredient_recette'].length; i++) {
				searchBar('contentModifFood #qtIngRecipe' + i, 'contentModifFood #searchIngRecipe' + i, 'annulIng', 'pushIng', 'contentModifFood span#createNewIng');
			}

			var etape = '';

			for (var i = 0; i < data[0]['id_etape'].length; i++) {
				var aTime = data[0]['id_etape'][i]['time'].split(':');
				var selecttime = '<div class="flexrow"><label for="modifEtapeHour' + i + '"></label><select id="modifEtapeHour' + i + '">';

				for (var j = 0; j <= 48; j++) {
					var dizaine = 0;
					if (j > 9) {
						dizaine = '';
					}
					var value = dizaine + j;
					if (value == aTime[0]) {
						selecttime = selecttime + '<option selected="selected" value="' + dizaine + '' + j + '">' + j + '</option>';
					} else {
						selecttime = selecttime + '<option value="' + dizaine + '' + j + '">' + j + '</option>';
					}
				}

				selecttime = selecttime + '</select><p>H</p><label for="modifEtapeMinute' + i + '"></label><select id="modifEtapeMinute' + i + '" class="flexrow">';
				$('#modifEtapeHour' + i + '').val(aTime[0]);

				for (var j = 0; j <= 60; j++) {
					var dizaine = 0;
					if (j > 9) {
						dizaine = '';
					}
					var value = dizaine + j;
					if (value == aTime[1]) {
						selecttime = selecttime + '<option selected="selected" value="' + dizaine + '' + j + '">' + j + '</option>';
					} else {
						selecttime = selecttime + '<option value="' + dizaine + '' + j + '">' + j + '</option>';
					}
				}

				selecttime = selecttime + '</select><p>min</p><label for="modifEtapeSecond' + i + '"></label><select id="modifEtapeSecond' + i + '" class="flexrow">';
				$('#modifEtapeMinute' + i + '').val(aTime[1]);

				for (var j = 0; j <= 60; j++) {
					var dizaine = 0;
					if (j > 9) {
						dizaine = '';
					}
					var value = dizaine + j;
					if (value == aTime[2]) {
						selecttime = selecttime + '<option selected="selected" value="' + dizaine + '' + j + '">' + j + '</option>';
					} else {
						selecttime = selecttime + '<option value="' + dizaine + '' + j + '">' + j + '</option>';
					}
				}
				selecttime = selecttime + '</select><p>sec</p></div>';
				$('#modifEtapeSecond' + i + '').val(aTime[2]);

				etape2 = '<div class="flexColumn"><div class="flexrow"><p><span id ="removeEtape' + i + '" class="fas fa-minus"></span><p>Etape n°</p><p class="numEtape">' + parseInt(i + 1) + '</p>';
				etape3 = '<p>temps</p>' + selecttime + '</div>';
				etape4 = '<div class="flexrow"><label for="modifEtapeText' + i + '"></label><textarea id="modifEtapeText' + i + '" class=' + data[0]['id_etape'][i]['id_etape'] + '" name="modifEtapeText' + i + '" autocomplete="off">' + escapeHtml(data[0]['id_etape'][i]['text']) + '</textarea>';
				etape5 = '</div><hr><span class="pushEtapeInside fas fa-plus flexrow"><p>Ajouter une étape intermédiaire?</p></span><hr></div>';
				etape = etape + etape2 + etape3 + etape4 + etape5;
			}

			$('#contentModifEtape .etapeRecipeFlex div').html(etape);

			var heightTwo = $('#modifBlockTwo').css("height");
			var heightFour = $('#modifBlockFour').css("height");

			if(heightTwo == '0px'){
				$('#modifBlockTwoTitle').click()
			}
			if(heightFour == '0px'){
				$('#modifBlockFourTitle').click()
			}
		});
});
//	}
//----------------------------------------
//pour annuler la modification de la recette
$('#annulModifRecipe').click(function(){
	$('#contentModifViewRecipe').fadeOut(0);
	//$('#contentRecipesMenu').fadeIn(0);
animMenuRecipe()
});

//----------------------------------------
//pour modifier l'indicateur de j'aime ou non
$('#Modiflove').click(function(){
	if ($(this).children().hasClass('fa-heart')){
		$(this).html('<img src="public/img/fraise.png" alt="fraise">');
		
	}else{
		$(this).html('<span class="fas fa-heart emptySpan"></span>');
	}
});
//----------------------------------------
//pour modifier l'indicateur de privée ou public
$('#modifPrivateRecipe').click(function(){
	if ($(this).children().hasClass('fa-lock-open')){
		$(this).html('<span class="fas fa-lock"></span>');

	}else{
		$(this).html('<span class="fas fa-lock-open"></span>');
	}
});
//----------------------------------------
//pour modifier l'indicateur de prix
$('#ModifPriceRecipe').prev().prev().click(function(){
	var price = $('#ModifPriceRecipe').children().length;
	if (price == 1){
	}else{
		$('#ModifPriceRecipe span:first-child').remove();
	}
});
	//----------------------------------------
$('#ModifPriceRecipe').prev().click(function(){
	var price = $('#ModifPriceRecipe').children().length;
	if (price == 3){
	}else{
		$('#ModifPriceRecipe').append('<span class="fas fa-coins"></span>');
	}
});
//----------------------------------------
//pour modifier l'indicateur du nbr de personne
$('#ModifnbrPeopleRecipe').prev().prev().click(function(){
	var people = $('#ModifnbrPeopleRecipe').html();
	if (people == 1){
	}else{
		$('#ModifnbrPeopleRecipe').html(parseInt(people)-1);
	}
});
	//----------------------------------------
$('#ModifnbrPeopleRecipe').prev().click(function(){
	var people = $('#ModifnbrPeopleRecipe').html();
	$('#ModifnbrPeopleRecipe').html(parseInt(people)+1);
});
	//----------------------------------------
	//pour modifier l'indicateur de la facilité
$('#ModifeasyRecipe').prev().prev().click(function(){
	var price = $('#ModifeasyRecipe').children().length;
	if (price == 1){
	}else{
		$('#ModifeasyRecipe span:first-child').remove();
	}
});
	//----------------------------------------
$('#ModifeasyRecipe').prev().click(function(){
	var price = $('#ModifeasyRecipe').children().length;
	if (price == 3){
	}else{
		$('#ModifeasyRecipe').append('<span class="fas fa-pepper-hot"></span>');
	}
});

//----------------------------------------
//pour modifoier l'image de la recette
$('#imgModifRecipe span:first-child').click(function(){

	if($('#imgModifRecipe span:first-child').hasClass('fa-camera')){
		$('#imgModifRecipe span:first-child').next().css('display', 'block'); // on affiche le formulaire
		$('#imgModifRecipe span:first-child').removeClass('fa-camera');
		$('#imgModifRecipe span:first-child').addClass('fa-times');
		resizeDivEtapeFood('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
	}else{
		$('#imgModifRecipe span:first-child').removeClass('fa-times');
		$('#imgModifRecipe span:first-child').addClass('fa-camera');
		$('#imgModifRecipe span:first-child').next().css('display', 'none');
		resizeDivEtapeFood('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
	}
});

	$('#imgModifRecipe').on('click', '#submitImgRecipeModif',function(e){

		var form = document.getElementById('modifFormImgRecipe'); // id du formulaire
		e.preventDefault(); // bloque le comportement par défault. (évite le rechargement de la page)
		var myData = new FormData(form);
		//console.log( $('#imgModifRecipe #file'))
        var files = $('#imgModifRecipe #file')[0].files[0];

        if(files['size']>8388608){ //limite par défault de php (post_max_size)
        	$('#imgModifRecipe #submitImgRecipeModif').next('p').html('Le fichier est beaucoup trop gros pour le transfert');
        }else{

	        myData.append('file',files);

	        $.ajax({
	            url: 'index.php?action=uploadImgRecipe',
	            type: 'post',
	            data: myData, 
	            contentType: false,
	            processData: false,
	            success: function(response){
	            	var adata = JSON.parse(response);
	            	
	                if(adata['src'] == false){
	                	$('#imgModifRecipe #submitImgRecipeModif').next('p').html(adata['error']);
    				}else{
    					$('#imgModifRecipe #submitImgRecipeModif').next('p').html('');
    					$("#imgRecipeModif img").attr("src", ''); 
	                    $("#imgRecipeModif img").attr("src", adata['src']); 
	                    $("#imgRecipeModif img").show(); // Display image element
						resizeDivImg('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
	                }
	            },
	        });
	    }
	});




	//----------------------------------------
function getTimePrepare(){

	$('div#contentModifEtape').on('change', 'div.etapeRecipeFlex div div.flexColumn div.flexrow select', function(){

		var elemEtapeRecipeTime = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn');
		var hourPrepare         = '';
		var minutePrepare       = '';
		var secondePrepare      = '';

		for(var i = 0 ; i < elemEtapeRecipeTime.length ; i++){
			var select   = ($(elemEtapeRecipeTime[i]).children('div.flexrow:nth-child(1)').children('div.flexrow').children('select'));
			var hour     = $(select[0]).val();
			var minute   = $(select[1]).val();
			var seconde  = $(select[2]).val();

			var hourPrepare    = Number(hourPrepare) + Number(hour);
			var minutePrepare  = Number(minutePrepare) + Number(minute);
			var secondePrepare = Number(secondePrepare) + Number(seconde);

			if (secondePrepare >=60){
				secondePrepare = Number(secondePrepare) - 60;
				minutePrepare  = Number(minutePrepare) + 1;
			}
			if (minutePrepare >=60){
				minutePrepare = Number(minutePrepare) - 60;
				hourPrepare   = Number(hourPrepare) + 1;
			}
		}

		$('#ModiftimePrepareRecipe').html('<p>'+hourPrepare+'H '+minutePrepare+'Min '+secondePrepare+'Sec')
	});
}
getTimePrepare();


//----------------------------------------
 //on supprime un ingrédient
$('div#contentModifFood').on('click', 'div.flexrow span', function(){
	var classSpanIng     = $(this).attr('class');
	var classMinusOrPlus = classSpanIng.split(' ')[1];

	if(classMinusOrPlus=='fa-minus')
	{
		$(this).parent().next().remove();
		$(this).parent().remove();
	}
		var nbrIngRestant = document.querySelectorAll('#contentModifFood > div.flexrow');
		var nbrIdRestant  = nbrIngRestant.length;
		var nbrchildRestant = $(nbrIngRestant[i]).children();

		for(var i = 0 ; i < nbrIdRestant ; i++){
			$(nbrIngRestant[i]).children(nbrchildRestant[0]).attr('id', 'removeIng'+[i]);
			$(nbrIngRestant[i]).children(nbrchildRestant[1]).attr('for', 'qtIngRecipe'+[i]);
			$(nbrIngRestant[i]).children(nbrchildRestant[2]).attr('id', 'qtIngRecipe'+[i]);
			$(nbrIngRestant[i]).children(nbrchildRestant[2]).attr('name', 'qtIngRecipe'+[i]);
			$(nbrIngRestant[i]).children(nbrchildRestant[4]).attr('for', 'searchIngRecipe'+[i]);
			$(nbrIngRestant[i]).children(nbrchildRestant[5]).attr('id', 'searchIngRecipe'+[i]);
			$(nbrIngRestant[i]).children(nbrchildRestant[5]).attr('name', 'searchIngRecipe'+[i]);
		}
	resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');
});

//----------------------------------------
// on ajoute un ingrédient
$('div#contentModifFood').on('click', 'span#pushIng', function(){
	var nbrIng = document.querySelectorAll('#contentModifFood div.titleIngRecipe');
	var numId  = nbrIng.length;
	var div    = '<div class="flexrow pushIngDiv"><span id ="removeIng'+numId+'" class="fas fa-minus"></span>';
	var div1   = div + '<label for="qtIngRecipe'+numId+'"></label><input type="text" id="qtIngRecipe'+numId+'" name="qtIngRecipe'+numId+'" value="" autocomplete="off">';
	var div2   = div1 + '<p></p>'
	var div3   = div2 + '<label for="searchIngRecipe'+numId+'"></label><input class="" type="texte" name ="searchIngRecipe'+numId+'" id="searchIngRecipe'+numId+'" placeholder="ingrédient à ajouter" autocomplete="off">';
	var div4   = div3 + '</div><div class="titleIngRecipe"></div><div class="flexrow"><span id ="annulIng" class="fas fa-times"></div>';

	$(div4).insertBefore($(this));
	$('#removeIng'+numId).fadeOut(0);
	$('#pushIng').fadeOut(0);
	$('#contentModifFood span#createNewIng').fadeOut(0);
	resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');

	searchBar('qtIngRecipe'+numId, 'searchIngRecipe'+numId,'annulIng', 'pushIng', 'contentModifFood span#createNewIng');

	$('#annulIng').click(function(){
		$('#pushIng').fadeIn(100);
		$('#contentModifFood span#createNewIng').fadeIn(100);
		$('#annulIng').parent().prev().prev().remove(); // supprime l'input du nouvel ingérdient a insérer
		$('#annulIng').parent().prev().remove(); //supprime la zone de recherche (liste des ingrédients de la BDD)
		$('#annulIng').parent().remove(); // supprime le bouton pour annuler l'insert de l'ingrédient
		resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');
	});
});
	//----------------------------------------
$('div#contentModifFood').on('click', 'span#createNewIng', function(){// on créer un nouvel ingrédient dans la BDD
	createIngBdd($(this));
});



//----------------------------------------------------------------------------
// on supprime une étape
$('div#contentModifEtape').on('click', 'div.etapeRecipeFlex div div p span.fa-minus', function(){

	var elemDelOneEtape = $('div#contentModifEtape div.etapeRecipeFlex div').children('div.flexColumn'); 
	var idSpan          = $(this).attr('id');

	if(elemDelOneEtape.length != 1){

		$(this).parent().parent().parent().remove();

		var nbrRestantEtape    = $(elemDelOneEtape).length;// on calcule le nouveau nbr d'étape 
		var elemDelEtapeInside = $('div#contentModifEtape div.etapeRecipeFlex div div p span.fa-minus');
		var baliseNum          = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) p.numEtape');
		
		var selectDivLabel1    = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(1)');
		var selectDivSelect1   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(2)');
		var selectDivLabel2    = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(4)');
		var selectDivSelect2   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(5)');
		var selectDivLabel3    = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(7)');
		var selectDivSelect3   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(8)');

		var textareaDivLabel   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) label');
		var textareaDiv        = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) textarea');
		var textareaImg        = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) img');
		
		for(var i = 0 ; i < nbrRestantEtape ; i++){// on renomme les attributs de chaque input pour leur attribuer le bon ordre afin de pouvoir enregistrer
			$(elemDelEtapeInside).attr('id', 'removeEtape'+[i]);
			$(selectDivLabel1[i]).attr('for', 'modifEtapeHour'+[i]);
			$(selectDivLabel2[i]).attr('for', 'modifEtapeMinute'+[i]);
			$(selectDivLabel3[i]).attr('for', 'modifEtapeSecond'+[i]);

			$(selectDivSelect1[i]).attr('id', 'modifEtapeHour'+[i]);
			$(selectDivSelect2[i]).attr('id', 'modifEtapeMinute'+[i]);
			$(selectDivSelect3[i]).attr('id', 'modifEtapeSecond'+[i]);
			$(selectDivSelect1[i]).change();

			$(baliseNum[i]).html(i+1);
			$(textareaDivLabel[i]).attr('for', 'modifEtapeText'+[i]);
			$(textareaDiv[i]).attr('id', 'modifEtapeText'+[i]);
			$(textareaDiv[i]).attr('name', 'modifEtapeText'+[i]);
			$(textareaImg[i]).attr('name', 'imgEtape'+[i]);
		}
	}
	resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');
});

	//-------------------------------------------------

pushModifEtape()

function pushModifEtape(){ // pour rajouter une étape ou une étape intermédiaire
	$('div#contentModifEtape').on('click', 'div.etapeRecipeFlex div div.flexColumn span.pushEtapeInside', function(){

		$(this).unbind('click'); // block les double action 
		var divParent = $(this).parent();
		var etape = '';
			var selecttime = '<div class="flexrow"><label for=""></label><select id="">';
			for(var j = 0 ; j <= 48 ; j++){ // on créer les options des select du temps de préparation de l'étape... pour les heures
				var dizaine = 0;
				if(j > 9){
					dizaine = '';
				}
				selecttime = selecttime +'<option value="'+dizaine+''+j+'">'+j+'</option>';
			}
			selecttime = selecttime+'</select><p>H</p><label for=""></label><select id="" class="flexrow">';
			for(var j = 0 ; j <= 60 ; j++){ // les minutes
				var dizaine = 0;
				if(j > 9){
					dizaine = '';
				}
				selecttime = selecttime +'<option value="'+dizaine+''+j+'">'+j+'</option>';
			}
			selecttime = selecttime+'</select><p>min</p><label for=""></label><select id="" class="flexrow">';
			for(var j = 0 ; j <= 60 ; j++){ // les secondes
				var dizaine = 0;
				if(j > 9){
					dizaine = '';
				}

				selecttime = selecttime +'<option value="'+dizaine+''+j+'">'+j+'</option>';
			}
			selecttime = selecttime+'</select><p>sec</p></div>';		
			
			etape2 = '<div class="flexColumn"><div class="flexrow"><p><span id ="" class="fas fa-minus"></span><p>Etape n°</p><p class="numEtape"></p>';
			etape3 = '<p>temps</p>'+selecttime+'</div>';
			etape4 = '<div class="flexrow"><label for=""></label><textarea id="" class="" name="" autocomplete="off"></textarea>';
			etape5 = '</div><hr><span class="pushEtapeInside fas fa-plus flexrow"><p>Ajouter une étape intermédiaire?</p></span><hr></div>';
			etape  = etape+etape2+etape3+etape4+etape5;
		
		$(etape).insertAfter(divParent);
		resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');

		var nbrElement         = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn').length; // on calcule le nouveau nbr d'étape 

		var elemDelEtapeInside = $('div#contentModifEtape div.etapeRecipeFlex div div p span.fa-minus');
		var baliseNum          = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) p.numEtape');
		var selectDivLabel1    = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(1)');
		var selectDivSelect1   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(2)');
		var selectDivLabel2    = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(4)');
		var selectDivSelect2   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(5)');
		var selectDivLabel3    = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(7)');
		var selectDivSelect3   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(8)');

		var textareaDivLabel   = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) label');
		var textareaDiv        = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) textarea');
		var textareaImg        = $('div#contentModifEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) img');

		for(var i = 0 ; i < nbrElement ; i++){ // on renomme les attributs de chaque input pour leur attribuer le bon ordre afin de pouvoir enregistrer
			$(elemDelEtapeInside[i]).attr('id', 'removeEtape'+[i]);
			$(selectDivLabel1[i]).attr('for', 'modifEtapeHour'+[i]);
			$(selectDivLabel2[i]).attr('for', 'modifEtapeMinute'+[i]);
			$(selectDivLabel3[i]).attr('for', 'modifEtapeSecond'+[i]);

			$(selectDivSelect1[i]).attr('id', 'modifEtapeHour'+[i]);
			$(selectDivSelect2[i]).attr('id', 'modifEtapeMinute'+[i]);
			$(selectDivSelect3[i]).attr('id', 'modifEtapeSecond'+[i]);

			$(selectDivSelect1[i]).change();

			$(baliseNum[i]).html(i+1);
			$(textareaDivLabel[i]).attr('for', 'modifEtapeText'+[i]);
			$(textareaDiv[i]).attr('id', 'modifEtapeText'+[i]);
			$(textareaDiv[i]).attr('name', 'modifEtapeText'+[i]);
			$(textareaImg[i]).attr('name', 'imgEtape'+[i]);
		}
	});
}

$('#validModifRecipe').click(function(){
	saveOrUpdateInBdd('#ModifPriceRecipe', '#ModifeasyRecipe', '#ModifnbrPeopleRecipe', 'contentModifEtape', '#selectModifCategRecipe',
		'#titleNewModifRecipe', '#alphaNewModifRecipe','#Modiflove span', 'div#contentModifFood div.flexrow', '#searchIngRecipe', '#idRecetteSelectToShow',
		'#qtIngRecipe', 'div#contentModifEtape div.etapeRecipeFlex div div.flexColumn', '#modifEtapeText', '#modifEtapeHour', '#modifEtapeMinute',
		'#modifEtapeSecond','#imgModifRecipe span.fa-times', 'modifFormImgRecipe','#imgModifRecipe #submitImgRecipeModif', '#validModifRecipe p', '#modifFormImgRecipe #file', '#modifPrivateRecipe span')
	
});

