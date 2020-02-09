
//*******************************************************************
//AJAX pour modifier la recette
$('#modifRecipe').click(function(){

		$('#validModifRecipe p').html('Sauvegarder la recette');
		//var idRecette = $(this).attr('class');
		let idRecette = $('#idRecetteSelectToShow').html();
		//$('#modifIdRecette').html(idRecette);
		$('#contentViewRecipe').fadeOut(0);
		$('#contentModifViewRecipe').fadeIn(500);

		useAjaxReqestJson('index.php?action=showOneRecipes', 'POST', 'json', {idRecette: idRecette}, true, true,function (data) {

			$('input#titleNewModifRecipe').attr('value', data[0]['title']);
			$('input#alphaNewModifRecipe').attr('value', escapeHtml(data[0]['alpha']));
			if (data[0]['private'] === "1") {
				$('#modifPrivateRecipe').html('<span class="fas fa-lock"></span>');
			} else {
				$('#modifPrivateRecipe').html('<span class="fas fa-lock-open"></span>');
			}
			let inputFile = $('#modifFormImgRecipe #fileModif');
			inputFile.replaceWith(inputFile.val('').clone(true)); // on reset le input file
			$('#imgModif').attr("src", '');
			$('#imgModifRecipe #submitImgRecipeModif').next('p').html('');

			const $imgModifRecipe_span_first_child = $('#imgModifRecipe span:first-child');
			if ($imgModifRecipe_span_first_child.hasClass('fa-times')) {
				$imgModifRecipe_span_first_child.removeClass('fa-times');
				$imgModifRecipe_span_first_child.addClass('fa-camera');
				$('#modifFormImgRecipe').css('display', 'none');
			}
			useAjaxReqestJson('index.php?action=loadImgRecipe', 'POST', 'json', {idRecette: idRecette}, true,true,function (dataImg) {
				if (Array.isArray(dataImg)) {

					$('#imgModifRecipe span.fa-camera').click();
					$('#imgRecipeModif img').attr("src", dataImg[0]['img_src']+'.png');
					if($('#modifBlockThreeTitle span').hasClass('fa-sort-down')){
						$('#modifBlockThreeTitle').click()
					}
					resizeDivImg('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
				}else{
					resizeDivImg('#modifBlockThree', '#modifBlockThree div.hideDivAnim');
				}
			});

			$('#ModifnbrPeopleRecipe').html(data[0]['people']);

			//let aTime = data[0]['prepare_time'].split(':');
			$('#ModiftimePrepareRecipe').html(data[0]['prepare_time']);

			let spanPrive = '';
			if (data[0]['price'] === '1') {
				 spanPrive = '<div class="price"></div>';
			} else {
				//spanPrive = '';
				for (let i = 0; i < data[0]['price']; i++) {
					spanPrive = spanPrive + '<div class="price"></div>';
				}
			}
			$('#ModifPriceRecipe').html(spanPrive);

			if (data[0]['love'] === '0') {
				$('#Modiflove').html('<span class="fas fa-heart emptySpan"></span>');
			} else {
				$('#Modiflove').html('<img src="public/img/fraise.png" alt="fraise">');
			}

			let spanEasy;
			if (data[0]['price'] === '1') {
				spanEasy = '<div class="hard"></div>';
			} else {
				spanEasy = '';
				for (let i = 0; i < data[0]['easy']; i++) {
					spanEasy = spanEasy + '<div class="hard"></div>';
				}
			}
			$('#ModifeasyRecipe').html(spanEasy);

			$('#selectModifCategRecipe').val(data[0]['id_category']);


			let childIng = $('#contentAllOfModifIng').children('div.whiteSpace');
			let sizeChildIng = childIng.length;
			for(let x = 0 ; x < sizeChildIng ; x++){
				$(childIng[x]).remove();
			}

			let div = '';
			for (let i = 0; i < data[0]['id_ingredient_recette'].length; i++) {
				let ajout = data[0]['id_ingredient_recette'][i]['ajout_recette'];
				if(ajout !== ""){
					ajout = escapeHtml(data[0]['id_ingredient_recette'][i]['ajout_recette'])
				}
				
				let div0 ='<div class="flexrow whiteSpace"><span id ="removeIng'+i+'" class="fa fa-times-circle"></span>';
				let div1 = '<p id="qtIngRecipe'+i+'">'+escapeHtml(data[0]['id_ingredient_recette'][i]['quantity'])+'</p>';
				let div2 = '<p>'+data[0]['id_ingredient_recette'][i]['unit'] +'</p>';
				let div3 = '<p id="searchIngRecipe'+i+'" class="'+data[0]['id_ingredient_recette'][i]['id_ingredient']+'">'+escapeHtml(data[0]['id_ingredient_recette'][i]['title']) +'</p>';
				let div4 = '<input id="ajoutModif'+i+'" type="text" value="'+ajout+'" placeholder="précision supplémentaire ?"></div>';
				div = div+div0+div1+div2+div3+div4;
			}

			$(div).insertBefore($('#contentAllOfModifIng #pushIng'));


			let etape = '';

			for (let i = 0; i < data[0]['id_etape'].length; i++) {
				let aTime = data[0]['id_etape'][i]['time'].split(':');
				let selecttime = '<div class="flexrow"><label for="modifEtapeHour' + i + '"></label><select id="modifEtapeHour' + i + '">';

				for (let j = 0; j <= 48; j++) {
					let dizaine = 0;
					if (j > 9) {
						dizaine = '';
					}
					let value = dizaine + j;
					if (value == aTime[0]) {
						selecttime = selecttime + '<option selected="selected" value="' + dizaine + '' + j + '">' + j + '</option>';
					} else {
						selecttime = selecttime + '<option value="' + dizaine + '' + j + '">' + j + '</option>';
					}
				}

				selecttime = selecttime + '</select><p>H</p><label for="modifEtapeMinute' + i + '"></label><select id="modifEtapeMinute' + i + '" class="flexrow">';
				$('#modifEtapeHour' + i + '').val(aTime[0]);

				for (let j = 0; j <= 60; j++) {
					let dizaine = 0;
					if (j > 9) {
						dizaine = '';
					}
					let value = dizaine + j;
					if (value == aTime[1]) {
						selecttime = selecttime + '<option selected="selected" value="' + dizaine + '' + j + '">' + j + '</option>';
					} else {
						selecttime = selecttime + '<option value="' + dizaine + '' + j + '">' + j + '</option>';
					}
				}

				selecttime = selecttime + '</select><p>min</p><label for="modifEtapeSecond' + i + '"></label><select id="modifEtapeSecond' + i + '" class="flexrow">';
				$('#modifEtapeMinute' + i + '').val(aTime[1]);

				for (let j = 0; j <= 60; j++) {
					let dizaine = 0;
					if (j > 9) {
						dizaine = '';
					}
					let value = dizaine + j;
					if (value == aTime[2]) {
						selecttime = selecttime + '<option selected="selected" value="' + dizaine + '' + j + '">' + j + '</option>';
					} else {
						selecttime = selecttime + '<option value="' + dizaine + '' + j + '">' + j + '</option>';
					}
				}
				selecttime = selecttime + '</select><p>sec</p></div>';
				$('#modifEtapeSecond' + i + '').val(aTime[2]);

				let etape2 = '<div class="flexColumn"><div class="flexrow"><p><span id ="removeEtape' + i + '" class="fas fa-minus"></span><p>Etape n°</p><p class="numEtape">' + parseInt(i + 1) + '</p>';
				let etape3 = '<p>temps</p>' + selecttime + '</div>';
				let etape4 = '<div class="flexrow"><label for="modifEtapeText' + i + '"></label><textarea id="modifEtapeText' + i + '" class="updateTextAreaHeight" name="modifEtapeText' + i + '" autocomplete="off" oninput="updateTextareaHeight(this);">' + escapeHtml(data[0]['id_etape'][i]['text']) + '</textarea>';
				let etape5 = '</div><hr><span class="pushEtapeInside fas fa-plus flexrow"><p>Ajouter une étape intermédiaire?</p></span><hr></div>';
				etape = etape + etape2 + etape3 + etape4 + etape5;
			}

			$('#contentModifEtape .etapeRecipeFlex div').html(etape);
			updateTextareaHeightInit('contentModifEtape .etapeRecipeFlex div');

			let heightTwo = $('#modifBlockTwo').css("height");
			let heightThree = $('#modifBlockThree').css("height");
			let heightFour = $('#modifBlockFour').css("height");

			if(heightTwo === "0px"){
				$('#modifBlockTwoTitle').click()
			}
			if(heightThree === "0px"){
				$('#modifBlockThreeTitle').click()
				//$('#modifBlockThreeTitle').click()
			}
			if(heightFour === "0px"){
				$('#modifBlockFourTitle').click()
			}else{
				resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');
			}
		});
});
//----------------------------------------
//pour annuler la modification de la recette
$('#annulModifRecipe').click(function(){
	$('#contentModifViewRecipe').fadeOut(0);
	animMenuRecipe();
});

//-------------------------------------------------------------------------------------------------------------------------
//pour modifier l'indicateur de j'aime ou non
$('#Modiflove').click(function(){
	makeLoveSpan(this);
});
$('#Newlove').click(function(){
	makeLoveSpan(this);
});
//-------------------------------------------------------------------------------------------------------------------------
//pour modifier l'indicateur de privée ou public
$('#modifPrivateRecipe').click(function(){
	makePrivateSPan(this);
});
$('#newPrivateRecipe').click(function(){
	makePrivateSPan(this);
});
//-------------------------------------------------------------------------------------------------------------------------
//pour modifier l'indicateur de prix
const $NewPriceRecipe = $('#NewPriceRecipe');
const $ModifPriceRecipe = $('#ModifPriceRecipe');
$ModifPriceRecipe.prev().prev().click(function(){
	removePriceSpan('modif');
});
$ModifPriceRecipe.prev().click(function(){
	addPriceSpan('modif');
});

$NewPriceRecipe.prev().prev().click(function(){
	removePriceSpan('new');
});
$NewPriceRecipe.prev().click(function(){
	addPriceSpan('new');
});
//------------------------------------------------------------------------------------------------------------------------
//pour modifier l'indicateur du nbr de personne
const $NewnbrPeopleRecipe =$('#NewnbrPeopleRecipe');
const $ModifnbrPeopleRecipe = $('#ModifnbrPeopleRecipe');

$ModifnbrPeopleRecipe.prev().prev().click(function(){
	removePeopleSpan('modif');
});
$ModifnbrPeopleRecipe.prev().click(function(){
	addPeopleSpan('modif');
});

$NewnbrPeopleRecipe.prev().prev().click(function() {
	removePeopleSpan('new');
});

$NewnbrPeopleRecipe.prev().click(function(){
	addPeopleSpan('new');
});
//------------------------------------------------------------------------------------------------------------------------
//pour modifier l'indicateur de la facilité
const $NeweasyRecipe = $('#NeweasyRecipe');
const $ModifeasyRecipe = $('#ModifeasyRecipe');

$ModifeasyRecipe.prev().prev().click(function(){
	removeEasySpan('modif');
});
$NeweasyRecipe.prev().prev().click(function(){
	removeEasySpan('new');
});

$ModifeasyRecipe.prev().click(function(){
	addEasySpan('modif');
});
$NeweasyRecipe.prev().click(function(){
	addEasySpan('new');
});

//------------------------------------------------------------------------------------------------------------------------
//pour afficher le formulaire de l'image de la recette
$('#imgModifRecipe span:first-child').click(function () {//modif Recipe
	showFormImgRecipe(this, '#modifBlockThree', '#modifBlockThree div.hideDivAnim',
		'#imgModif', '#imgModifRecipe #submitImgRecipeModif', '#modifFormImgRecipe #fileModif','#modifFormImgRecipe')
});
$('#imgNewRecipe span:first-child').click(function () {//new recipe
	showFormImgRecipe(this, '#newBlockThree', '#newBlockThree div.hideDivAnim',
		'#imgNew', '#imgNewRecipe #submitImgRecipeNew', '#imgNewRecipe #file', '#formImgRecipe')
});
//------------------------------------------------------------------------------------------------------------------------
//pour charger l'image de la recette
$('#submitImgRecipeModif').click(function (e) { //modif Recipe
	e.preventDefault();
	makeCanvasWithInputFileImg('#imgModifRecipe #fileModif', '#imgModifRecipe #submitImgRecipeModif', "#imgRecipeModif img", '#modifBlockThree', '#modifBlockThree  div.hideDivAnim');
});
$('#submitImgRecipeNew').click(function (e) {//new recipe
	e.preventDefault();
	makeCanvasWithInputFileImg('#imgNewRecipe #file', '#imgNewRecipe #submitImgRecipeNew', "#imgRecipeNew img",'#newBlockThree', '#newBlockThree  div.hideDivAnim');
});

$('#parcourirImgRecipeModif').click(function(){ //modif Recipe
	$('#imgModifRecipe #fileModif').click();
});
$('#parcourirImgRecipeNew').click(function(){//new recipe
	$('#imgNewRecipe #file').click();
});

//------------------------------------------------------------------------------------------------------------------------
// calcul le temps total de la recette en additionnant les temps des étapes
const $contentModifEtape = $('#contentModifEtape');
const $contentNewEtape = $('#contentNewEtape');
$contentModifEtape.on('change', 'div.etapeRecipeFlex div div.flexColumn div.flexrow select', function(){
	getTimeGlobal('modif');
});
$contentNewEtape.on('change', 'div.etapeRecipeFlex div div.flexColumn div.flexrow select', function(){
	getTimeGlobal('new');
});

//----------------------------------------
 //on supprime un ingrédient
$('div#contentModifFood').on('click', 'div span.fa-times-circle', function(){
	delIngInRecipe('modif', this);
});
$('div#contentAllOfNewIng').on('click', 'div span.fa-times-circle', function(){
	delIngInRecipe('new', this);
});
//----------------------------------------
// on ajoute un ingrédient
$('#pushNewIng').click(function(){
	createIngInREcipe( 'new', this, 'removeNewIng','qtNewIngRecipe','searchNewIngRecipe','annulNewIng', 'ajoutNew');
});
$('#pushIng').click(function(){
	createIngInREcipe( 'modif', this,'removeIng','qtIngRecipe','searchIngRecipe','annulIng','ajoutModif');
});

//--------------------------------------------------------------------------------------------------------------------
// on supprime une étape et on renumérote les étapes restante
$contentModifEtape.on('click', 'div.etapeRecipeFlex div div p span.fa-minus', function() {
	delEtapeAndRewriteOrder('modif',this);
});
$contentNewEtape.on('click', 'div.etapeRecipeFlex div div p span.fa-minus', function () {
	delEtapeAndRewriteOrder('new',this);
});
//---------------------------------------------------------------------------------------------------------------------------------
//on ajoute une étape et on renumérote l'ensemble des étapes
$contentModifEtape.on('click', 'div.etapeRecipeFlex div div.flexColumn span.pushEtapeInside', function(){
	pushNewEtapeInRecipe('modif', this)
});
$contentNewEtape.on('click', 'div.etapeRecipeFlex div div.flexColumn span.pushEtapeInside', function(){
	pushNewEtapeInRecipe('new', this)
});

//----------------------------------------
//si on veut sauvegarder
$('#validNewRecipe').click(function(){
	saveOrUpdateInBdd('#NewPriceRecipe', '#NeweasyRecipe', '#NewnbrPeopleRecipe', 'contentNewEtape', '#selectNewCategRecipe',
		'#newTitleRecipe', '#newAlphaRecipe','#Newlove span', 'div#contentAllOfNewIng', '#searchNewIngRecipe', '#idRecetteSelectToShow',
		'#qtNewIngRecipe', '#ajoutNew', 'div#contentNewEtape div.etapeRecipeFlex div div.flexColumn', '#newEtapeText', '#newEtapeHour', '#newEtapeMinute',
		'#newEtapeSecond','#imgNewRecipe span.fa-times', 'formImgRecipe','#imgNewRecipe #submitImgRecipeNew', '#validNewRecipe p', '#formImgRecipe #file', '#newPrivateRecipe span')
});
$('#validModifRecipe').click(function(){
	saveOrUpdateInBdd('#ModifPriceRecipe', '#ModifeasyRecipe', '#ModifnbrPeopleRecipe', 'contentModifEtape', '#selectModifCategRecipe',
		'#titleNewModifRecipe', '#alphaNewModifRecipe','#Modiflove span', 'div#contentAllOfModifIng', '#searchIngRecipe', '#idRecetteSelectToShow',
		'#qtIngRecipe', '#ajoutModif', 'div#contentModifEtape div.etapeRecipeFlex div div.flexColumn', '#modifEtapeText', '#modifEtapeHour', '#modifEtapeMinute',
		'#modifEtapeSecond','#imgModifRecipe span.fa-times', 'modifFormImgRecipe','#imgModifRecipe #submitImgRecipeModif', '#validModifRecipe p', '#modifFormImgRecipe #fileModif', '#modifPrivateRecipe span')
});

