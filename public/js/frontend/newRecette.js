
//*******************************************************************
//pour créer une recette, on réinitialise tout
$('#contentNewRecipe h2').click(function(){
	$('#contentNewViewRecipe').fadeIn(500);

	$('#contentRecipesMenu').fadeOut(0);
	$('#contentViewRecipe').fadeOut(0);
	$('#contentModifViewRecipe').fadeOut(0);
	closeCateg();
	closeanimMenuRecipe()

	$('#Newlove').html('<span class="fas fa-heart emptySpan"></span>');
	$('#newTitleRecipe').val('');
	$('#newAlphaRecipe').val('') ;
	$('#selectNewCategRecipe').val(1);
	$('#NewtimePrepareRecipe').html('');
	$('#NewPriceRecipe').html('<span class="fas fa-coins"></span>');
	$('#NeweasyRecipe').html('<span class="fas fa-pepper-hot"></span>');
	$('#imgRecipeNew').html('<img src="" id="img">');

	var inputFile = $($('#imgNewRecipe #file'));
			//console.log(inputFile)
	inputFile.replaceWith(inputFile.val('').clone(true)); // on reset le input file
	$('#imgNewRecipe span:first-child').removeClass('fa-times');
	$('#imgNewRecipe span:first-child').addClass('fa-camera');
	$('#formImgRecipe').css('display', 'none'); 

	$('#contentNewFood').children('div.flexrow').remove();
	$('#contentNewFood').children('div.titleIngRecipe').remove();

	var elemEtape = $('#contentNewEtape div.etapeRecipeFlex').children().children('div.flexColumn');
	$('#newEtapeHour0').val('00'); // reset select temps etape
	$('#newEtapeMinute0').val('00');
	$('#newEtapeSecond0').val('00');
	$('#newEtapeText0').val('');

	for (var i = 1 ; i < elemEtape.length ; i++){ // on supprime toutes les étape sauf la première
		$(elemEtape[i]).remove();
	}
	var heightTwo = $('#newBlockTwo').css("height");
	var heightThree = $('#newBlockThree').css("height");
	var heightFour = $('#newBlockFour').css("height");

	if(heightTwo != '0px'){
		$('#newBlockTwoTitle').click()
	}
	if(heightThree != '0px'){
		$('#newBlockThreeTitle').click()
	}
	if(heightFour != '0px'){
		$('#newBlockFourTitle').click()
	}



});

//----------------------------------------
//pour annuler la modification de la recette on réinitialise tout
$('#annulNewRecipe').click(function(){

	$('#Newlove').html('<span class="fas fa-heart emptySpan"></span>');
	$('#newTitleRecipe').val('');
	$('#newAlphaRecipe').val('') ;
	$('#selectNewCategRecipe').val(1);
	$('#NewtimePrepareRecipe').html('');
	$('#NewPriceRecipe').html('<span class="fas fa-coins"></span>');
	$('#NeweasyRecipe').html('<span class="fas fa-pepper-hot"></span>');
	$('#imgRecipeNew').html('<img src="" id="img">');

	var inputFile = $($('#imgNewRecipe #file'));
	inputFile.replaceWith(inputFile.val('').clone(true)); // on reset le input file
	$('#imgNewRecipe span:first-child').removeClass('fa-times');
	$('#imgNewRecipe span:first-child').addClass('fa-camera');
	$('#formImgRecipe').css('display', 'none'); 

	$('#contentNewFood').children('div.flexrow').remove();
	$('#contentNewFood').children('div.titleIngRecipe').remove();

	var elemEtape = $('#contentNewEtape div.etapeRecipeFlex').children().children('div.flexColumn');
	$('#newEtapeHour0').val('00');
	$('#newEtapeMinute0').val('00');
	$('#newEtapeSecond0').val('00');
	$('#newEtapeText0').val('');

	for (var i = 1 ; i < elemEtape.length ; i++){
		$(elemEtape[i]).remove();
	}
	$('#contentNewViewRecipe').fadeOut(0);

});

//----------------------------------------
//pour modifier l'indicateur de j'aime ou non
$('#Newlove').click(function(){

	if ($(this).children().hasClass('fa-heart')){
		$(this).html('<img src="public/img/fraise.png" alt="fraise">');
	}else{
		$(this).html('<span class="fas fa-heart emptySpan"></span>');
	}
});
//----------------------------------------
//pour modifier l'indicateur de privée ou public
$('#newPrivateRecipe').click(function(){
	if ($(this).children().hasClass('fa-lock-open')){
		$(this).html('<span class="fas fa-lock"></span>');

	}else{
		$(this).html('<span class="fas fa-lock-open"></span>');
	}
});
	//----------------------------------------
//pour modifier l'indicateur de prix
$('#NewPriceRecipe').prev().prev().click(function(){
	var price = $('#NewPriceRecipe').children().length;
	if (price == 1){
	}else{
		$('#NewPriceRecipe span:first-child').remove();
	}
});
//----------------------------------------
	$('#NewPriceRecipe').prev().click(function(){
	var price = $('#NewPriceRecipe').children().length;
	if (price == 3){
	}else{
		$('#NewPriceRecipe').append('<span class="fas fa-coins"></span>');
	}
});
//----------------------------------------
//pour modifier l'indicateur du nbr de personne
$('#NewnbrPeopleRecipe').prev().prev().click(function(){
	var people = $('#NewnbrPeopleRecipe').html();
	if (people == 1){
	}else{
		$('#NewnbrPeopleRecipe').html(parseInt(people)-1);
	}
});
		//----------------------------------------
$('#NewnbrPeopleRecipe').prev().click(function(){
	var people = $('#NewnbrPeopleRecipe').html();
	$('#NewnbrPeopleRecipe').html(parseInt(people)+1);
});
//----------------------------------------
//pour modifier l'indicateur de la facilité
$('#NeweasyRecipe').prev().prev().click(function(){
	var price = $('#NeweasyRecipe').children().length;
	if (price == 1){
	}else{
		$('#NeweasyRecipe span:first-child').remove();
	}
});
	//----------------------------------------
$('#NeweasyRecipe').prev().click(function(){
	var price = $('#NeweasyRecipe').children().length;
	if (price == 3){
	}else{
		$('#NeweasyRecipe').append('<span class="fas fa-pepper-hot"></span>');
	}
});

//----------------------------------------
 //on supprime un ingrédient
$('div#contentNewFood').on('click', 'div.flexrow span', function(){
	var classSpanIng     = $(this).attr('class');
	var classMinusOrPlus = classSpanIng.split(' ')[1];

	if(classMinusOrPlus=='fa-minus')
	{
		$(this).parent().next().remove();
		$(this).parent().remove();
	}
		var nbrIngRestant = document.querySelectorAll('#contentNewFood > div.flexrow');
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

$('#pushNewIng').click(function(){ // on ajoute un ingrédient
	var nbrIng     = document.querySelectorAll('#contentNewFood div.titleIngRecipe');
	var numId      = nbrIng.length;

	var elemDelIng = $('div#contentNewFood div.flexrow span.fa-minus');
	var inputQt    =  $('div#contentNewFood div.flexrow input:nth-child(3)');
	var labelQt    =  $('div#contentNewFood div.flexrow label:nth-child(2)');
	var inputIng   = $('div#contentNewFood div.flexrow input:nth-child(6)');
	var labelIng   = $('div#contentNewFood div.flexrow label:nth-child(5)');
	
	for(var i = 0 ; i < numId ; i++){// on renomme les attributs de chaque input pour attribuer a chacun un id unique et dans le bon ordre

		$(elemDelIng[i]).attr('id', 'removeNewIng'+[i]);
		$(labelQt[i]).attr('for', 'qtNewIngRecipe'+[i]);
		$(labelIng[i]).attr('for', 'searchNewIngRecipe'+[i]);

		$(inputQt[i]).attr('id', 'qtNewIngRecipe'+[i]);
		$(inputIng[i]).attr('id', 'searchNewIngRecipe'+[i]);
		$(inputQt[i]).attr('name', 'qtNewIngRecipe'+[i]);
		$(inputIng[i]).attr('name', 'searchNewIngRecipe'+[i]);
	}

	var div  = '<div class="flexrow"><span id ="removeNewIng'+numId+'" class="fas fa-minus"></span>';
	var div1 = div + '<label for="qtNewIngRecipe'+numId+'"></label><input type="text" id="qtNewIngRecipe'+numId+'" name="qtNewIngRecipe'+numId+'" value="" autocomplete="off">';
	var div2 = div1 + '<p></p>'
	var div3 = div2 + '<label for="searchNewIngRecipe'+numId+'"></label><input class="" type="text" name ="searchNewIngRecipe'+numId+'" id="searchNewIngRecipe'+numId+'" placeholder="ingrédient à ajouter" autocomplete="off">';
	var div4 = div3 + '</div><div class="titleIngRecipe"></div><div class="flexrow"><span id ="annulNewIng" class="fas fa-times"></span></div>';//<span id ="validNewIng" class="fas fa-check"></span></div>';
	
	$(div4).insertBefore($(this));
	$(div4).focus();
	$('#removeNewIng'+numId).fadeOut(0);
	$('#pushNewIng').fadeOut(0);
	$('#createNewIng').fadeOut(0);
	resizeDivEtapeFood('#newBlockFour', '#newBlockFour div.hideDivAnim');
	
	searchBar('qtNewIngRecipe'+numId, 'searchNewIngRecipe'+numId,'annulNewIng', 'pushNewIng', 'createNewIng');

	$('#annulNewIng').click(function(){
		$('#pushNewIng').fadeIn(100);
		$('#createNewIng').fadeIn(100);
		$('#annulNewIng').parent().prev().prev().remove(); // supprime les inputs
		$('#annulNewIng').parent().prev().remove(); // supprime la div de recherche
		$('#annulNewIng').parent().remove(); // supprime la bouton annuler
		resizeDivEtapeFood('#newBlockFour', '#newBlockFour div.hideDivAnim');
	});
/*	$('#removeNewIng'+numId).click(function(){
		$(this).parent().next().remove();
		$(this).parent().remove();
		resizeDivEtapeFood('#newBlockFour', '#newBlockFour div.hideDivAnim');
	});*/
});


//----------------------------------------
$('#createNewIng p').click(function(){ // on créer un nouvel ingrédient dans la BDD
	createIngBdd($(this).parent());
});
	
//----------------------------------------
// calcul le temps total de la recette en additionnant les temps des étapes
function getTimeGlobal(){
	$('div#contentNewEtape').on('change', 'div.etapeRecipeFlex div div.flexColumn div.flexrow select', function(){
		var elemEtapeRecipeTime = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn');

		var hourPrepare    = '';
		var minutePrepare  = '';
		var secondePrepare = '';

		for(var i = 0 ; i < elemEtapeRecipeTime.length ; i++){

			var select  = ($(elemEtapeRecipeTime[i]).children('div.flexrow:nth-child(1)').children('div.flexrow').children('select'));
			var hour    = $(select[0]).val();
			var minute  = $(select[1]).val();
			var seconde = $(select[2]).val();

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
		$('#NewtimePrepareRecipe').html('<p>'+hourPrepare+'H '+minutePrepare+'Min '+secondePrepare+'Sec')
	});
}

getTimeGlobal();


//-------------------------------------------------

pushNewEtape()

// pour ajouter une étape à la recette
function pushNewEtape(){

	elemPushEtapeInside = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn span.pushEtapeInside');

	$(elemPushEtapeInside).click(function(){
		$(elemPushEtapeInside).unbind('click'); // block les double action 
		var divParent = $(this).parent();
		var etape = '';
		// création des select du temps de l'étape
		var selecttime = '<div class="flexrow"><label for=""></label><select id="">';
			for(var j = 0 ; j <= 48 ; j++){
				var dizaine = 0;
				if(j > 9){
					dizaine = '';
				}
				selecttime = selecttime +'<option value="'+dizaine+''+j+'">'+j+'</option>';
			}
			selecttime = selecttime+'</select><p>H</p><label for=""></label><select id="" class="flexrow">';
			for(var j = 0 ; j <= 60 ; j++){
				var dizaine = 0;
				if(j > 9){
					dizaine = '';
				}
				selecttime = selecttime +'<option value="'+dizaine+''+j+'">'+j+'</option>';
			}
			selecttime = selecttime+'</select><p>min</p><label for=""></label><select id="" class="flexrow">';
			for(var j = 0 ; j <= 60 ; j++){
				var dizaine = 0;
				if(j > 9){
					dizaine = '';
				}

				selecttime = selecttime +'<option value="'+dizaine+''+j+'">'+j+'</option>';
			}
			selecttime = selecttime+'</select><p>sec</p></div>';		
			
			etape2 = '<div class="flexColumn"><div class="flexrow"><p><span id ="" class="fas fa-minus"></span><p>Etape n°</p><p class="numEtape"></p>';
			etape3 = '<p>temps</p>'+selecttime+'</div>';
			etape4 = '<div class="flexrow"><label for=""></label><textarea id="" class="" name="" autocomplete="off" oninput="updateTextareaHeight(this);"></textarea>';
			etape5 = '</div><hr><span class="pushEtapeInside fas fa-plus flexrow"><p>Ajouter une étape intermédiaire?</p></span><hr></div>';
			etape  = etape+etape2+etape3+etape4+etape5;
		
		$(etape).insertAfter(divParent);
		resizeDivEtapeFood('#newBlockFour', '#newBlockFour div.hideDivAnim');

		var nbrElement = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn').length; // on calcule le nouveau nbr d'étape 

		var elemDelEtapeInside = $('div#contentNewEtape div.etapeRecipeFlex div div p span.fa-minus');
		var baliseNum          = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) p.numEtape');
		var selectDivLabel1    = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(1)');
		var selectDivSelect1   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(2)');
		var selectDivLabel2    = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(4)');
		var selectDivSelect2   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(5)');
		var selectDivLabel3    = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(7)');
		var selectDivSelect3   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(8)');

		var textareaDivLabel   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) label');
		var textareaDiv        = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) textarea');
		var textareaImg        = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) img');

		for(var i = 0 ; i < nbrElement ; i++){ // on renomme les attributs de chaque input pour leur attribuer le bon ordre afin de pouvoir enregistrer
			$(elemDelEtapeInside[i]).attr('id', 'removeEtape'+[i]);
			$(selectDivLabel1[i]).attr('for', 'newEtapeHour'+[i]);
			$(selectDivLabel2[i]).attr('for', 'newEtapeMinute'+[i]);
			$(selectDivLabel3[i]).attr('for', 'newEtapeSecond'+[i]);

			$(selectDivSelect1[i]).attr('id', 'newEtapeHour'+[i]);
			$(selectDivSelect2[i]).attr('id', 'newEtapeMinute'+[i]);
			$(selectDivSelect3[i]).attr('id', 'newEtapeSecond'+[i]);

			$(selectDivSelect1[i]).change();

			$(baliseNum[i]).html(i+1);
			$(textareaDivLabel[i]).attr('for', 'newEtapeText'+[i]);
			$(textareaDiv[i]).attr('id', 'newEtapeText'+[i]);
			$(textareaDiv[i]).attr('name', 'newEtapeText'+[i]);
			$(textareaImg[i]).attr('name', 'imgNewEtape'+[i]);
		}
		pushNewEtape()
	});
}

//----------------------------------------------
	// on supprime une étape et on renumérote les étapes restante

	$('div#contentNewEtape').on('click', 'div.etapeRecipeFlex div div p span.fa-minus', function(){

		var elemDelOneEtape = $('div#contentNewEtape div.etapeRecipeFlex div').children('div.flexColumn'); 
		var idSpan = $(this).attr('id');

		if(elemDelOneEtape.length != 1){

			$(this).parent().parent().parent().remove();
			var nbrRestantEtape = $(elemDelOneEtape).length;// on calcule le nouveau nbr d'étape 

			var elemDelEtapeInside = $('div#contentNewEtape div.etapeRecipeFlex div div p span.fa-minus');
			var baliseNum          = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) p.numEtape');
			var selectDivLabel1    = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(1)');
			var selectDivSelect1   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(2)');
			var selectDivLabel2    = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(4)');
			var selectDivSelect2   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(5)');
			var selectDivLabel3    = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(7)');
			var selectDivSelect3   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(8)');

			var textareaDivLabel   = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) label');
			var textareaDiv        = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) textarea');
			var textareaImg        = $('div#contentNewEtape div.etapeRecipeFlex div div.flexColumn div:nth-child(2) img');
			
			for(var i = 0 ; i < nbrRestantEtape ; i++){// on renomme les attributs de chaque input pour leur attribuer le bon ordre afin de pouvoir enregistrer
				
				$(elemDelEtapeInside).attr('id', 'removeEtape'+[i]);
				$(selectDivLabel1[i]).attr('for', 'newEtapeHour'+[i]);
				$(selectDivLabel2[i]).attr('for', 'newEtapeMinute'+[i]);
				$(selectDivLabel3[i]).attr('for', 'newEtapeSecond'+[i]);

				$(selectDivSelect1[i]).attr('id', 'newEtapeHour'+[i]);
				$(selectDivSelect2[i]).attr('id', 'newEtapeMinute'+[i]);
				$(selectDivSelect3[i]).attr('id', 'newEtapeSecond'+[i]);
				$(selectDivSelect1[i]).change();

				$(baliseNum[i]).html(i+1);
				$(textareaDivLabel[i]).attr('for', 'newEtapeText'+[i]);
				$(textareaDiv[i]).attr('id', 'newEtapeText'+[i]);
				$(textareaDiv[i]).attr('name', 'newEtapeText'+[i]);
				$(textareaImg[i]).attr('name', 'imgNewEtape'+[i]);
			}
		}
		resizeDivEtapeFood('#newBlockFour', '#newBlockFour div.hideDivAnim');
	});

	//----------------------------------------
	//pour modifier l'image de la recette
	$('#imgNewRecipe span:first-child').click(function(){
		if($(this).hasClass('fa-camera')){

			$(this).next().next().css('display', 'block'); // on affiche le formulaire
			$(this).removeClass('fa-camera');
			$(this).addClass('fa-times');
			resizeDivEtapeFood('#newBlockThree', '#newBlockThree div.hideDivAnim');
			//resizeDivEtapeFood('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
		}else{
			$(this).removeClass('fa-times');
			$(this).addClass('fa-camera');
			$(this).next().next().css('display', 'none');
			resizeDivEtapeFood('#newBlockThree', '#newBlockThree div.hideDivAnim');
		}
	});

	$('#submitImgRecipeNew').click(function(e){
		var form = document.getElementById('formImgRecipe'); // id du formulaire
		$('#loading').fadeIn(0);
		e.preventDefault(); // bloque le comportement par défault. (évite le rechargement de la page)
		var myData = new FormData(form);

        var files = $('#imgNewRecipe #file')[0].files[0];
        //console.log(files['size'])

        if(files['size']>8388608){ //limite par défault de php (post_max_size)
        	$('#imgNewRecipe #submitImgRecipeNew').next('p').html('Le fichier est beaucoup trop gros pour le transfert');
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
	                	$('#imgNewRecipe #submitImgRecipeNew').next('p').html(adata['error']);
    				}else{
    					$('#imgNewRecipe #submitImgRecipeNew').next('p').html('');
    					$("#imgRecipeNew img").attr("src", ''); 
	                    $("#imgRecipeNew img").attr("src", adata['src']); 
	                    $("#imgRecipeNew img").show(); // Display image element
						resizeDivEtapeFood('#newBlockThree', '#newBlockThree div.hideDivAnim');
	                }
					$('#loading').fadeOut(1000);
	            },
	        });
	    }

	});

//----------------------------------------
// vérifie si la lettre de référence est correct
function verifAlpha(idDivAlpha){

	var alpha = $(idDivAlpha).val(); // on sauvegarde la lettre de référence
	var regalpha  = /^\D+$/; 
	var errorMess = '';

	if((alpha.length==0)||(alpha.length>1)){
		errorMess ='Vous devez renseigner une lettre de référence (conseil : la première lettre de la recette). <br>';
	}else if(!regalpha.test(alpha)){
		errorMess ='La lettre de référence doit être une lettre. <br>';
	}else{
		alpha = alpha.toUpperCase();
	}
	return errorMess;
}
	//----------------------------------------
function verifTitle(idDivTitle){
	var title = $(idDivTitle).val(); 
	var regTitle  = /^\D+$/; 
	var errorMess = '';

	if(title.length<2){
		errorMess = 'Vous devez renseigner un titre. <br>';
	}else if(!regTitle.test(title)){
		errorMess = 'Le titre ne doit contenir que des lettres. <br>';
	}else{
		useAjaxReqestJson('index.php?action=verifTitle', 'POST', 'json', {title:title}, function(data){
			if((Object.keys(data).length == 1)&&("true" in data)){
				errorMess = 'Ce titre existe déjà, vous devez en choisir un autre. <br>';
			}
		});
	}
	return errorMess;
}
	//----------------------------------------
	//récupère le temps de chaque étape, les additionne pour obtenir le temps total pour la BDD
function getTimeToBdd(idDivTime){
	var elemEtapeRecipeTime = $('div#'+idDivTime+' div.etapeRecipeFlex div div.flexColumn');//on sauvegarde le temps de préparation global
	var hourPrepare         = '';
	var minutePrepare       = '';
	var secondePrepare      = '';
	
	for(var i = 0 ; i < elemEtapeRecipeTime.length ; i++){

		var select         = ($(elemEtapeRecipeTime[i]).children('div.flexrow:nth-child(1)').children('div.flexrow').children('select')); // on récupère tous les élements y compris les nouveaux
		var hour           = $(select[0]).val();
		var minute         = $(select[1]).val();
		var seconde        = $(select[2]).val();

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
	var prepare_time = hourPrepare+':'+minutePrepare+':'+secondePrepare; // on sauvegarde le temps de préparation
	return prepare_time;
}

/*function verifCateg(divSelect){
	var errorMess = '';
	if($(divSelect).val() == null){
		errorMess = 'Vous devez sélectionner une catégorie pour y ranger la recette. <br>';
	}
	return errorMess;
}*/

	//----------------------------------------
	//si on veut sauvegarder
	$('#validNewRecipe').click(function(e){
		saveOrUpdateInBdd('#NewPriceRecipe', '#NeweasyRecipe', '#NewnbrPeopleRecipe', 'contentNewEtape', '#selectNewCategRecipe',
			'#newTitleRecipe', '#newAlphaRecipe','#Newlove span', 'div#contentNewFood div.flexrow', '#searchNewIngRecipe', '#newIdRecette',
			'#qtNewIngRecipe', 'div#contentNewEtape div.etapeRecipeFlex div div.flexColumn', '#newEtapeText', '#newEtapeHour', '#newEtapeMinute',
			'#newEtapeSecond','#imgNewRecipe span.fa-times', 'formImgRecipe','#imgNewRecipe #submitImgRecipeNew', '#validNewRecipe p', '#formImgRecipe #file', '#newPrivateRecipe span')
	});

function saveOrUpdateInBdd(divPrice, divEasy, divPeople, divEtape, divCateg,
	divTitle, divAlpha, divLoveSpan, divIng, divSearchIng, divIdRecipe,
	divQtIng, divContentEtape, divEtapeText, divEtapeHour, divEtapeMin,
	divEtapeSec, divImgSpan, divFormImg, divImgSubmit, btnValidSave, fileImg, divPrivateSpan) {

	var messError = '';

	var price = $(divPrice).children().length; // on sauvegarde le prix
	var easy = $(divEasy).children().length; // on sauvegarde la facilité
	var people = $(divPeople).html(); // on sauvegarde le nombre de personne
	var prepare_time = getTimeToBdd(divEtape);

	messError += verifTitle(divTitle); // renvoie message si erreur
	messError += verifAlpha(divAlpha); // Met en majuscule et renvoie message si erreur

	if ($(divLoveSpan).hasClass('emptySpan')) { // on sauvegarde le j'aime
		var love = 0;
	} else {
		var love = 1;
	}

	if ($(divPrivateSpan).hasClass('fa-lock-open')) { // on sauvegarde le j'aime
		var private = 0;
	} else {
		var private = 1;
	}

	var elemIngRecipe = $(divIng); // ingrédient et leur quantités

	if (elemIngRecipe.length == 0) {
		messError += 'Vous devez renseigner des ingrédients. <br>';
	} else {
		for (var i = 0; i < elemIngRecipe.length; i++) {
			var id_ingredient = $(divSearchIng + i).attr('class');
			if ((id_ingredient == '') || (id_ingredient == 0)) {
				messError += 'l\'un des champs "ingrédient" est vide ou incorrect. Supprimez-le où réécrivez-le. <br>';
			}
		}
	}

	if (messError != '') {
		showErrorWithImg(messError, aContainImg[0][0], aContainImg[0][0]);
		//showErrorWithImg('#errorMessImgNoBtn', '#messErrorMessNoBtn', messError, '#imgErrorMessNoBtn', aContainImg[0][0], aContainImg[0][0])
	} else { // si il n'y a pas d'erreur, on sauvegarde
		title = $(divTitle).val();
		alpha = $(divAlpha).val();
		id_category = $(divCateg).val();
		if (id_category == "") {
			id_category = 0;
		}
		var newMessErrorSaveIng = '';
		var newMessErrorSaveEtape = '';
		var newMessErrorSave = '';

		if ($(divIdRecipe).html() == '') { // si c'est le premier enregistrement, pas de ID
			useAjaxReqestJson('index.php?action=saveNewRecipes', 'POST', 'json', {
				private: private,
				price: price,
				easy: easy,
				people: people,
				love: love,
				id_category: id_category,
				title: title.charAt(0).toUpperCase() + title.substring(1).toLowerCase(),
				alpha: alpha.toUpperCase(),
				prepare_time: prepare_time
			}, function (data) {
				if ((Object.keys(data).length == 1) && ("false" in data)) {
					newMessErrorSave += 'La recette n\'a pas pu être créée. <br>';
					//showErrorWithImg('#errorMessImgNoBtn', '#messErrorMessNoBtn', newMessErrorSave, '#imgErrorMessNoBtn', aContainImg[0][0], aContainImg[0][0])
					showErrorWithImg(newMessErrorSave, aContainImg[0][0], aContainImg[0][1]);
				} else {
					id_recette = data[0]['id_recette']; // id de la nouvelle recette
					$(divIdRecipe).html(id_recette);
					saveRecipeInBdd(id_recette);
					/*						saveEtapeInBdd(id_recette);
                                            saveImgInBdd(id_recette);*/
				}

			});
		} else {
			id_recette = $(divIdRecipe).html();
			useAjaxReqestJson('index.php?action=actualizeRecipes', 'POST', 'json', {
				private: private,
				id_recette: id_recette,
				price: price,
				easy: easy,
				people: people,
				love: love,
				id_category: id_category,
				title: title.charAt(0).toUpperCase() + title.substring(1).toLowerCase(),
				alpha: alpha.toUpperCase(),
				prepare_time: prepare_time
			}, function (data) {
				if (Array.isArray(data)) {
					saveRecipeInBdd(id_recette);
					/*						saveEtapeInBdd(id_recette);
                                            saveImgInBdd(id_recette);*/
				} else {
					newMessErrorSave += 'La recette n\'a pas pu être modifiée. <br>';
					showErrorWithImg(newMessErrorSave, aContainImg[0][0], aContainImg[0][1]);
					//showErrorWithImg('#errorMessImgNoBtn', '#messErrorMessNoBtn', newMessErrorSave, '#imgErrorMessNoBtn', aContainImg[0][0], aContainImg[0][0])
				}

			});
		}

		//-----------------------------------------------------------
		function saveRecipeInBdd(id_recipe) {
			$('#loading').fadeIn(0);
			saveImgInBdd(id_recipe);
			useAjaxReqestJson('index.php?action=delIngRecipe', 'POST', 'json', {id_recette: id_recipe}, function (data) {

				if ((Object.keys(data).length == 1) && ("false" in data)) { // si les anciens ingrédient se sont bien fait supprimés on continue
					var arrIng = new Object();
					var elemIngRecipe = $(divIng);

					for (var i = 0; i < elemIngRecipe.length; i++) {
						arrIng[i] = new Object(); // initialisation de l'object qui contiendra les données
						arrIng[i]['quantity'] = $(divQtIng + i).val();
						arrIng[i]['id_ingredient'] = $(divSearchIng + i).attr('class');
						arrIng[i]['id_recette'] = id_recipe;
					}
					var dataIng = JSON.stringify(arrIng);
					useAjaxReqestJson('index.php?action=actualizeIngRecipe', 'POST', 'json', {arrIng: dataIng}, function (data) {
						if ((Object.keys(data).length == 1) && ("false" in data)) {
							$('#loading').fadeOut(1000);
							newMessErrorSaveFinal += "La recette ,' pas pu être correctement sauvegardée. <br>";
							showErrorWithImg(newMessErrorSaveFinal, aContainImg[1][0], aContainImg[1][1]);
							$(btnValidSave).html('Sauvegarde incomplète');
						} else {
							useAjaxReqestJson('index.php?action=delEtapeRecipe', 'POST', 'json', {id_recette: id_recipe}, function (data) {
								if ((Object.keys(data).length == 1) && ("false" in data)) {
									var arrEtape = new Object();
									var elemEtapeRecipe = $(divContentEtape); // on sauvegarde les étapes, leur temps

									for (var i = 0; i < elemEtapeRecipe.length; i++) {
										arrEtape[i] = new Object(); // initialisation de l'object qui contiendra les données
										arrEtape[i]['rang'] = i + 1
										arrEtape[i]['text'] = $(divEtapeText + i).val();
										arrEtape[i]['img'] = '';
										var hour = $(divEtapeHour + i).val();
										var minute = $(divEtapeMin + i).val();
										var seconde = $(divEtapeSec + i).val();
										arrEtape[i]['time'] = hour + ':' + minute + ':' + seconde;
										arrEtape[i]['id_recette'] = id_recipe;
									}
									var dataEtape = JSON.stringify(arrEtape);
									useAjaxReqestJson('index.php?action=actualizeEtapeRecipe', 'POST', 'json', {arrEtape: dataEtape}, function (aData) {
										if ((Object.keys(aData).length == 1) && ("false" in aData)) {
											$('#loading').fadeOut(1000);
											newMessErrorSaveFinal += "La recette ,' pas pu être correctement sauvegardée. <br>";
											showErrorWithImg(newMessErrorSaveFinal, aContainImg[1][0], aContainImg[1][1]);
											$(btnValidSave).html('Sauvegarde incomplète');
										} else {
											$('#loading').fadeOut(1000);
											newMessResFinalOk = "La recette a bien été sauvegardée. <br>";
											showErrorWithImg(newMessResFinalOk, aContainImg[1][0], aContainImg[1][1]);
											$(btnValidSave).html('Recette sauvegardée!');
										}
									});
								}
							});
						}
					});
				}
			});
		}

		//---------------------------------------------------------------
		function saveImgInBdd(id_recipe) {

			if ($(divImgSpan).is(":visible")) {
				var form = document.getElementById(divFormImg); // id du formulaire


				if ($(fileImg)[0].files[0] != '') { // on vérifie si il y a une image de chargée
					if ($(divImgSubmit).next('p').html() == '') { // on vérifie qu'il n'y a pas d'erreur avec le fichier

						var myData = new FormData(form);

						var files = $(fileImg)[0].files[0];

						myData.append('file', files);
						console.log(myData)

						$.ajax({
							url: 'index.php?action=saveImgRecipe',
							type: 'post',
							data: myData,
							contentType: false,
							processData: false,
							success: function (response) {
							},
						});
					}
				}

			} else { // si pas d'image ou image retirée, on la supprime
				$.post('index.php?action=deleteImgRecipe', {id_recette: id_recipe}, function (aData) {
					return false;
				});
			}
		}

	}
}
