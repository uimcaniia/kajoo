
//*******************************************************************
//pour créer une recette, on réinitialise tout
$('#contentNewRecipe h2').click(function(){
	$('#idRecetteSelectToShow').html('');
	$('#contentNewViewRecipe').fadeIn(500);
	$('#contentRecipesMenu').fadeOut(0);
	$('#contentViewRecipe').fadeOut(0);
	$('#contentModifViewRecipe').fadeOut(0);
	closeCateg();
	closeanimMenuRecipe()

	$('#Newlove').html('<span class="fas fa-heart emptySpan"></span>');
	$('#newTitleRecipe').val('');
	$('#newAlphaRecipe').val('') ;
	$('#selectNewCategRecipe').val(0);
	$('#NewtimePrepareRecipe').html('');
	$('#NewPriceRecipe').html('<div class="price"></div>');
	$('#NeweasyRecipe').html('<div class="hard"></div>');

	$('#imgNew').attr('src', '');
	$('#submitImgRecipeModif').click(false);
	var inputFile = $($('#imgNewRecipe #file'));
	inputFile.replaceWith(inputFile.val('').clone(true)); // on reset le input file
	$('#imgNewRecipe #submitImgRecipeNew').next('p').html('');
	$('#imgNew').attr("src", '');
	$('#imgNewRecipe span:first-child').removeClass('fa-times');
	$('#imgNewRecipe span:first-child').addClass('fa-camera');
	$('#formImgRecipe').css('display', 'none'); 

			var childIng = $('#contentAllOfNewIng').children('div.whiteSpace');
			var sizeChildIng = childIng.length;
			for(var x = 0 ; x < sizeChildIng ; x++){
				$(childIng[x]).remove();
			}


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
//pour annuler la modification de la recette
$('#annulNewRecipe').click(function(){
	$('#contentNewViewRecipe').fadeOut(0);
	$('#contentRecipesMenu').fadeIn(500);
	animMenuRecipe()
});

//----------------------------------------
//pour modifier l'indicateur de j'aime ou non
function makeLoveSpan(btn){
	if ($(btn).children().hasClass('fa-heart')){
		$(btn).html('<img src="public/img/fraise.png" alt="fraise">');
	}else{
		$(btn).html('<span class="fas fa-heart emptySpan"></span>');
	}
}
//----------------------------------------
//pour modifier l'indicateur de privée ou public
function makePrivateSPan(btn){
	if ($(btn).children().hasClass('fa-lock-open')){
		$(btn).html('<span class="fas fa-lock"></span>');
	}else{
		$(btn).html('<span class="fas fa-lock-open"></span>');
	}
}
//----------------------------------------
//pour modifier l'indicateur de prix
function addPriceSpan(newOrModif){
	if(newOrModif == 'new'){
		divNewOrModif = '#NewPriceRecipe';
	}else{
		divNewOrModif = '#ModifPriceRecipe';
	}
	var price = $(divNewOrModif).children().length;
	if (price == 3){
	}else{
		$(divNewOrModif).append('<div class="price"></div>');
	}
}
function removePriceSpan(newOrModif){
	if(newOrModif == 'new'){
		divNewOrModif = '#NewPriceRecipe';
	}else{
		divNewOrModif = '#ModifPriceRecipe';
	}
	var price = $(divNewOrModif).children().length;
	if (price == 1){
	}else{
		$(divNewOrModif+' div:first-child').remove();
	}
}
//----------------------------------------
//pour modifier l'indicateur du nbr de personne
function addPeopleSpan(newOrModif){
	if(newOrModif == 'new'){
		divNewOrModif = '#NewnbrPeopleRecipe';
	}else{
		divNewOrModif = '#ModifnbrPeopleRecipe';
	}
	var people = $(divNewOrModif).html();
	$(divNewOrModif).html(parseInt(people)+1);
}
function removePeopleSpan(newOrModif){
	if(newOrModif == 'new'){
		divNewOrModif = '#NewnbrPeopleRecipe';
	}else{
		divNewOrModif = '#ModifnbrPeopleRecipe';
	}
	var people = $(divNewOrModif).html();
	if (people == 1){
	}else{
		$(divNewOrModif).html(parseInt(people)-1);
	}
}
//----------------------------------------
//pour modifier l'indicateur de la facilité
function addEasySpan(newOrModif){
	if(newOrModif == 'new'){
		divNewOrModif = '#NeweasyRecipe';
	}else{
		divNewOrModif = '#ModifeasyRecipe';
	}
	var price = $(divNewOrModif).children().length;
	if (price == 3){
	}else{
		$(divNewOrModif).append('<div class="hard"></div>');
	}
}
function removeEasySpan(newOrModif){
	if(newOrModif == 'new'){
		divNewOrModif = '#NeweasyRecipe';
	}else{
		divNewOrModif = '#ModifeasyRecipe';
	}
	var price = $(divNewOrModif).children().length;
	if (price == 1){
	}else{
		$(divNewOrModif+' div:first-child').remove();
	}
}
//----------------------------------------
 //on supprime un ingrédient
function delIngInRecipe(newOrModif, btn) {
	if(newOrModif == 'new'){
		divNewOrModif = '#contentNewFood #contentAllOfNewIng';
		idSpanRemove = 'removeNewIng';
		idQt = 'qtNewIngRecipe'
		idIng = 'searchNewIngRecipe'
		idAjout = 'ajoutNew'
		divBlockNum= '#newBlockFour';
		divBlockHidden='#newBlockFour div.hideDivAnim';
	}else{
		divNewOrModif = '#contentModifFood #contentAllOfModifIng';
		idSpanRemove = 'removeIng';
		idQt = 'qtIngRecipe'
		idIng = 'searchIngRecipe'
		idAjout = 'ajoutModif'
		divBlockNum= '#modifBlockFour';
		divBlockHidden='#modifBlockFour div.hideDivAnim';
	}

	$(btn).parent().remove();

	var nbrIngRestant = document.querySelectorAll(divNewOrModif+' > div.whiteSpace');
	var nbrIdRestant = nbrIngRestant.length;
	var nbrchildRestant = $(nbrIngRestant).children();

	for (var i = 0; i < nbrIdRestant; i++) {
		$(nbrIngRestant[i]).children('span').attr('id', idSpanRemove + [i]);
		$(nbrIngRestant[i]).children('p:nth-child(2)').attr('id', idQt + [i]);
		$(nbrIngRestant[i]).children('p:nth-child(4)').attr('id', idIng + [i]);
		$(nbrIngRestant[i]).children('input').attr('id', idAjout + [i]);
	}
	resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');
}


//-------------------------------------------------
function pushNewEtapeInRecipe(newOrModif, btnClick){
	if(newOrModif == 'new'){
		var divselect = 'contentNewEtape';
		var numBlock = '#newBlockFour';
		var numBlockHidden = '#newBlockFour div.hideDivAnim';
		var etapeHour = 'newEtapeHour';
		var etapeMin = 'newEtapeMinute';
		var etapeSec = 'newEtapeSecond';
		var etapeText = 'newEtapeText';
		var etapeImg = 'imgNewEtape';
	}else{
		var divselect = 'contentModifEtape';
		var numBlock = '#modifBlockFour';
		var numBlockHidden = '#modifBlockFour div.hideDivAnim';
		var etapeHour = 'modifEtapeHour';
		var etapeMin = 'modifEtapeMinute';
		var etapeSec = 'modifEtapeSecond';
		var etapeText = 'modifEtapeText';
		var etapeImg = 'imgEtape';
	}

	$(btnClick).unbind('click'); // block les double action
	var divParent = $(btnClick).parent();
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
	resizeDivEtapeFood(numBlock, numBlockHidden);

	var nbrElement = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn').length; // on calcule le nouveau nbr d'étape

	var elemDelEtapeInside = $('div#'+divselect+' div.etapeRecipeFlex div div p span.fa-minus');
	var baliseNum          = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) p.numEtape');
	var selectDivLabel1    = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(1)');
	var selectDivSelect1   = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(2)');
	var selectDivLabel2    = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(4)');
	var selectDivSelect2   = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(5)');
	var selectDivLabel3    = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(7)');
	var selectDivSelect3   = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(8)');

	var textareaDivLabel   = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(2) label');
	var textareaDiv        = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(2) textarea');
	var textareaImg        = $('div#'+divselect+' div.etapeRecipeFlex div div.flexColumn div:nth-child(2) img');

	for(var i = 0 ; i < nbrElement ; i++){ // on renomme les attributs de chaque input pour leur attribuer le bon ordre afin de pouvoir enregistrer
		$(elemDelEtapeInside[i]).attr('id', 'removeEtape'+[i]);
		$(selectDivLabel1[i]).attr('for', etapeHour+[i]);
		$(selectDivLabel2[i]).attr('for', etapeMin+[i]);
		$(selectDivLabel3[i]).attr('for', etapeSec+[i]);

		$(selectDivSelect1[i]).attr('id', etapeHour+[i]);
		$(selectDivSelect2[i]).attr('id', etapeMin+[i]);
		$(selectDivSelect3[i]).attr('id', etapeSec+[i]);

		$(selectDivSelect1[i]).change();

		$(baliseNum[i]).html(i+1);
		$(textareaDivLabel[i]).attr('for', etapeText+[i]);
		$(textareaDiv[i]).attr('id', etapeText+[i]);
		$(textareaDiv[i]).attr('name', etapeText+[i]);
		$(textareaImg[i]).attr('name', etapeImg+[i]);
	}
};
//----------------------------------------------
	// on supprime une étape et on renumérote les étapes restante
function delEtapeAndRewriteOrder(newOrModi, btnDel) {
	if (newOrModi == 'new') {
		divNewOrModif = 'contentNewEtape';
		divBlockNum= '#newBlockFour';
		divBlockHidden='#newBlockFour div.hideDivAnim';
		labelHour='newEtapeHour';
		labelMin='newEtapeMinute';
		labelSecond='newEtapeSecond';
		labelArea='newEtapeText';
		nameImg='imgEtapeNew'
	} else {
		divNewOrModif = 'contentModifEtape';
		divBlockNum= '#modifBlockFour';
		divBlockHidden='#modifBlockFour div.hideDivAnim';
		labelHour='modifEtapeHour';
		labelMin='modifEtapeMinute';
		labelSecond='modifEtapeSecond';
		labelArea='modifEtapeText';
		nameImg='imgEtape'
	}
	elemDelOneEtape = $('div#'+divNewOrModif+' div.etapeRecipeFlex div').children('div.flexColumn');

	if (elemDelOneEtape.length != 1) {
		$(btnDel).parent().parent().parent().remove();
		var nbrRestantEtape = $(elemDelOneEtape).length;

		var nbrRestantEtape = $(elemDelOneEtape).length;// on calcule le nouveau nbr d'étape
		var elemDelEtapeInside = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div p span.fa-minus');
		var baliseNum = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) p.numEtape');
		var selectDivLabel1 = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(1)');
		var selectDivSelect1 = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(2)');
		var selectDivLabel2 = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(4)');
		var selectDivSelect2 = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(5)');
		var selectDivLabel3 = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div label:nth-child(7)');
		var selectDivSelect3 = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(1) div select:nth-child(8)');
		var textareaDivLabel = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(2) label');
		var textareaDiv = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(2) textarea');
		var textareaImg = $('div#'+divNewOrModif+' div.etapeRecipeFlex div div.flexColumn div:nth-child(2) img');

		for (var i = 0; i < nbrRestantEtape; i++) {// on renomme les attributs de chaque input pour leur attribuer le bon ordre afin de pouvoir enregistrer

			$(elemDelEtapeInside).attr('id', 'removeEtape' + [i]);
			$(selectDivLabel1[i]).attr('for', labelHour + [i]);
			$(selectDivLabel2[i]).attr('for', labelMin + [i]);
			$(selectDivLabel3[i]).attr('for', labelSecond + [i]);

			$(selectDivSelect1[i]).attr('id', labelHour + [i]);
			$(selectDivSelect2[i]).attr('id', labelMin + [i]);
			$(selectDivSelect3[i]).attr('id', labelSecond + [i]);
			$(selectDivSelect1[i]).change();

			$(baliseNum[i]).html(i + 1);
			$(textareaDivLabel[i]).attr('for', labelArea + [i]);
			$(textareaDiv[i]).attr('id', labelArea + [i]);
			$(textareaDiv[i]).attr('name', labelArea + [i]);
			$(textareaImg[i]).attr('name', nameImg + [i]);
		}
	}
	resizeDivEtapeFood(divBlockNum, divBlockHidden);
}
	//----------------------------------------
	//pour afficher le formulaire de l'image de la recette
function showFormImgRecipe(btn,divBlock, divBlockHiden,divImg, divMess,inputFileBtn, idForm) {
	if ($(btn).hasClass('fa-camera')) {
		$(idForm).css('display', 'block'); // on affiche le formulaire
		$(btn).removeClass('fa-camera');
		$(btn).addClass('fa-times');
		resizeDivEtapeFood(divBlock, divBlockHiden);

	} else {
		$(btn).removeClass('fa-times');
		$(btn).addClass('fa-camera');
		$(idForm).css('display', 'none');

		$(divImg).attr('src', '');
		var inputFile = $($(inputFileBtn));
		inputFile.replaceWith(inputFile.val('').clone(true)); // on reset le input file
		$(divMess).next('p').html('');
		resizeDivEtapeFood(divBlock, divBlockHiden);
	}
}
	//----------------------------------------
	//pour charger l'image de la recette
function makeCanvasWithInputFileImg(inputTypeFile, divMess, divImg, divBlock, divBlockHiden) {
	if (!$(inputTypeFile)[0].files[0]) {
		$(divMess).next('p').html('Vous devez choisir une image avant de l\'importer.');
	}else{
		var isGoodFormat = $(inputTypeFile)[0].files[0].type;
		if (!isGoodFormat.match(/image.*/)) {
			$(divMess).next('p').html('Seule les images sont acceptées.');
		} else {
			var current_file = $(inputTypeFile)[0].files[0];
			var reader = new FileReader();
			var canvas = document.createElement('canvas');

			reader.onload = function (event) {
				var image = new Image();
				image.src = event.target.result;
				image.onload = function () {
					var maxWidth = 500,
						maxHeight = 500,
						imageWidth = image.width,
						imageHeight = image.height;

					if (imageWidth > imageHeight) {
						if (imageWidth > maxWidth) {
							imageHeight *= maxWidth / imageWidth;
							imageWidth = maxWidth;
						}
					} else {
						if (imageHeight > maxHeight) {
							imageWidth *= maxHeight / imageHeight;
							imageHeight = maxHeight;
						}
					}
					canvas.width = imageWidth;
					canvas.height = imageHeight;
					image.width = imageWidth;
					image.height = imageHeight;
					var ctx = canvas.getContext("2d");
					ctx.drawImage(this, 0, 0, imageWidth, imageHeight);

					var dataURL = canvas.toDataURL();
					$(divImg).attr("src", dataURL);
					resizeDivImg(divBlock, divBlockHiden);
				}

			}
		}
		reader.readAsDataURL(current_file);
		
	}
}
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
		useAjaxReqestJson('index.php?action=verifTitle', 'POST', 'json', {title:title}, true,true,function(data){
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
//----------------------------------------
// calcul le temps total de la recette en additionnant les temps des étapes
function getTimeGlobal(divNewOrModif){
	if(divNewOrModif == 'new'){
		divContent = 'div#contentNewEtape';
		divTime = '#NewtimePrepareRecipe';
	}else{
		divContent ='div#contentModifEtape';
		divTime = '#ModiftimePrepareRecipe';
	}
	var elemEtapeRecipeTime = $(divContent+' div.etapeRecipeFlex div div.flexColumn');
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
	$(divTime).html('<p>'+hourPrepare+'H '+minutePrepare+'Min '+secondePrepare+'Sec')
}
//----------------------------------------------------------
//rafraichir
function refresh(time){
	setTimeout(function () { window.location.reload(); }, time);
}

//----------------------------------------
//si on veut sauvegarder
function saveOrUpdateInBdd(divPrice, divEasy, divPeople, divEtape, divCateg,
	divTitle, divAlpha, divLoveSpan, divIng, divSearchIng, divIdRecipe,
	divQtIng, ajout, divContentEtape, divEtapeText, divEtapeHour, divEtapeMin,
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

	var elemIngRecipe = $(divIng).children(' div.whiteSpace'); // ingrédient et leur quantités

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
	if ($(divImgSubmit).next('p').html() != '') { // on vérifie qu'il n'y a pas d'erreur avec le fichier
		messError += 'Il y a un problème avec l\'image de la recette. <br>';
	}

	if (messError != '') {
		showErrorWithImg(messError, aContainImg[0][0], aContainImg[0][0]);
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
			}, true,true,function (data) {
				if ((Object.keys(data).length == 1) && ("false" in data)) {
					newMessErrorSave += 'La recette n\'a pas pu être créée. <br>';
					showErrorWithImg(newMessErrorSave, aContainImg[0][0], aContainImg[0][1]);
				} else {
					id_recette = data[0]['id_recette']; // id de la nouvelle recette
					$(divIdRecipe).html(id_recette);
					saveRecipeInBdd(id_recette);
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
			}, true,true,function (data) {
				if (Array.isArray(data)) {
					saveRecipeInBdd(id_recette);
				} else {
					newMessErrorSave += 'La recette n\'a pas pu être modifiée. <br>';
					showErrorWithImg(newMessErrorSave, aContainImg[0][0], aContainImg[0][1]);
				}
			});
		}

		//-----------------------------------------------------------
		function saveRecipeInBdd(id_recipe) {
			$('#loading').fadeIn(0);
			useAjaxReqestJson('index.php?action=delIngRecipe', 'POST', 'json', {id_recette: id_recipe}, true,true,function (data) {

				if ((Object.keys(data).length == 1) && ("false" in data)) { // si les anciens ingrédient se sont bien fait supprimés on continue
					var arrIng = new Object();
					var elemIngRecipe = $(divIng).children(' div.whiteSpace');

					for (var i = 0; i < elemIngRecipe.length; i++) {
						arrIng[i] = new Object(); // initialisation de l'object qui contiendra les données

						//var valueQt = $(divQtIng + i).html();
						arrIng[i]['quantity'] = $(divQtIng + i).html();
						arrIng[i]['id_ingredient'] = $(divSearchIng + i).attr('class');
						arrIng[i]['id_recette'] = id_recipe;
						arrIng[i]['ajout_recette'] = $(ajout + i).val();

					}

					var dataIng = JSON.stringify(arrIng);


					useAjaxReqestJson('index.php?action=actualizeIngRecipe', 'POST', 'json', {arrIng: dataIng}, true,true,function (data) {
						//console.log(data)
						if ((Object.keys(data).length == 1) && ("false" in data)) {
							$('#loading').fadeOut(1000);
							newMessErrorSaveFinal += "La recette ,' pas pu être correctement sauvegardée. <br>";
							showErrorWithImg(newMessErrorSaveFinal, aContainImg[1][0], aContainImg[1][1]);
							$(btnValidSave).html('Sauvegarde incomplète');
						} else {
							useAjaxReqestJson('index.php?action=delEtapeRecipe', 'POST', 'json', {id_recette: id_recipe}, true,true,function (data) {
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
									useAjaxReqestJson('index.php?action=actualizeEtapeRecipe', 'POST', 'json', {arrEtape: dataEtape}, true,true,function (aData) {
										if ((Object.keys(aData).length == 1) && ("false" in aData)) {
											$('#loading').fadeOut(1000);
											newMessErrorSaveFinal += "La recette ,' pas pu être correctement sauvegardée. <br>";
											showErrorWithImg(newMessErrorSaveFinal, aContainImg[1][0], aContainImg[1][1]);
											$(btnValidSave).html('Sauvegarde incomplète');
										} else {
											if ($(divImgSpan).is(":visible")) { // si le formulaire est ouvert
												var form = document.getElementById(divFormImg); // id du formulaire
												if ($(form).children('img').attr('src') != "") {
													if ($(fileImg)[0].files[0]) { // on vérifie si il y a une image de chargée
														var current_file = $(fileImg)[0].files[0];
														var reader = new FileReader();
														var canvas = document.createElement('canvas');

														reader.onload = function (event) {

																var image = new Image();
																image.src = event.target.result;
																image.onload = function () {
																	var maxWidth = 500,
																		maxHeight = 500,
																		imageWidth = image.width,
																		imageHeight = image.height;

																	if (imageWidth > imageHeight) {
																		if (imageWidth > maxWidth) {
																			imageHeight *= maxWidth / imageWidth;
																			imageWidth = maxWidth;
																		}
																	} else {
																		if (imageHeight > maxHeight) {
																			imageWidth *= maxHeight / imageHeight;
																			imageHeight = maxHeight;
																		}
																	}
																	canvas.width = imageWidth;
																	canvas.height = imageHeight;
																	image.width = imageWidth;
																	image.height = imageHeight;
																var ctx = canvas.getContext("2d");
																ctx.drawImage(this, 0, 0, image.width, image.height);
																var dataURL = canvas.toDataURL();

																useAjaxReqestJson('index.php?action=uploadImgRecipe', 'POST', 'json', {img: dataURL}, true, true, function (adata) {
																	$('#loading').fadeOut(1000);
																	newMessResFinalOk = "La recette a bien été sauvegardée. <br>";
																	showErrorWithImg(newMessResFinalOk, aContainImg[6][0], aContainImg[6][1]);
																	$(btnValidSave).html('Recette sauvegardée!');
																	//refresh(2000);
																});
															}
														}
														reader.readAsDataURL(current_file);
													}else{ // si image pas changée
														$('#loading').fadeOut(1000);
														newMessResFinalOk = "La recette a bien été sauvegardée. <br>";
														showErrorWithImg(newMessResFinalOk, aContainImg[6][0], aContainImg[6][1]);
														$(btnValidSave).html('Recette sauvegardée!');
														//refresh(2000);
													}

												}else{ // si formulaire ouvert mais pas d'image

													useAjaxReqestJson('index.php?action=deleteImgRecipe', 'POST', 'json', {id_recette: id_recipe}, true, true, function (aData) {
														$('#loading').fadeOut(1000);
														newMessResFinalOk = "La recette a bien été sauvegardée. <br>";
														showErrorWithImg(newMessResFinalOk, aContainImg[6][0], aContainImg[6][1]);
														$(btnValidSave).html('Recette sauvegardée!');
														//refresh(2000);
													});
												}
											}else { // si formulaire fermé

												useAjaxReqestJson('index.php?action=deleteImgRecipe', 'POST', 'json', {id_recette: id_recipe}, true, true, function (aData) {
													$('#loading').fadeOut(1000);
													newMessResFinalOk = "La recette a bien été sauvegardée. <br>";
													showErrorWithImg(newMessResFinalOk, aContainImg[6][0], aContainImg[6][1]);
													$(btnValidSave).html('Recette sauvegardée!');
													//refresh(2000);

												});
											}
										}
									});
								}
							});
						}
					});
				}
			});
		}
	}
}


