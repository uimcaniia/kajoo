//****************************************************************************************************************
                        //UTILS
//****************************************************************************************************************
//defillmeent page
function defillement(link) {
	//$('a').click(function () {
		let page = $(link).attr('href');
		let speed = 750; //vitesse de défliement
		$('html, body').animate({scrollTop: $(page).offset().top - 100}, speed);
		return false; //Retire la hauteur du header fixed
}
function blockBody(){
	$('body').css('overflow', 'hidden');
}
function deleteBlockBody(){
	$('body').css('overflow', 'unset');
}
// array des textes
const aContainNotice = [
	['Êtes-vous sûr(e) de vouloir supprimer cette recette ?', 'confirmDelRecipe', 'annulDelRecipe'],
	['Êtes-vous sûr(e) de vouloir supprimer cette catégorie ?', 'confirmDelCateg', 'annulDelCateg'],
	['Votre recette a bien été sauvegardée !'],
	['La recette n\'a pas pu être sauvegardée'],
	['l\'un des champs "ingrédient" est vide ou incorrect. Supprimez-le où réécrivez-le'],
	['Veuillez corriger les erreurs pour pouvoir sauvegarder.'],
	['Vous devez créer une catégorie pour y ranger la recette'],
	['Le titre ne doit contenir que des lettres'],
	['La lettre de référence doit être une lettre'],
	['Vous devez renseigner une lettre de référence (conseil : la première lettre de la recette)'],
	['Le fichier est beaucoup trop gros pour le transfert'],
	['Êtes-vous sûr(e) de vouloir copier cette recette ?', 'confirmCopyRecipe', 'annulCopyRecipe'],
	['Êtes-vous sûr(e) de vouloir supprimer cette invitation ?', 'confirmDelInvit', 'annulDelInvit'],
	[]
];
const aContainPopMess = [
	['En activant la fraise, votre recette sera plus facilement repérable dans la liste du menu !'], // tombe
	['Le moteur de recherche utilise les titres de vos recettes pour vous aidez à les retrouvez plus facilement. Choisissez les bien !'], // pleure
	['Vous pouvez filtrer vos recettes par lettre dans la liste du menu ! Soyez judicieux dans votre choix. Exemple, pour une recette intitulée "les meringues au citron", privilégiez le "L" de "LES meringues..." ou le "M" de "meringue" ! C\'est vous qui voyez!'], // blazé
	['Choisissez la catégorie où ranger votre recette, sinon, elle sera rangé par défaut dans la catégorie "Autres" !'], // mignon
	['Votre recette sera pour combien de personne ? Cette indication servira au calcul des quantité d\'ingrédient pour vos listes de course !'], // pete un cable
	['Il s\'agit du temps total pour la réalisation de votre recette. Il se calcule automatiquement suivant le temps de chacune des étapes de votre recette que vous indiquerez !'], // uiiiii
	['Indiquez le coût financier de votre recette.'], // happy
	['Indiquez le niveau de difficulté de votre recette.'], // danse
	['Cette partie est consacrées au regroupement de vos ingrédients necessaire pour cette recette. Ce sera cette même liste qui sera utilisez pour compléter automatiquement vos listes de course!'], // costaud
	['Ajoutez des étapes de préaparation à votre recette pour vous faciliter la lecture! Pensez à notter le temps de chaque étape pour mettre à jour l\'indicateur du temps total pour réaliser votre recette !'],
	['Ajoutez une photo pour illustrer votre recette ?'],
	['Ajoutez une quantité et un ingrédient dans les zones indiquées. Kajoo possède un moteur de recherche et va vous présenter, juste en dessous, les ingrédients qu\'il connait déjà. Si un ingrédient n\'existe pas, vous pouvez l\'enregister dans le lexique pour l\'utilisez ensuite et permettre en même temps à la communoté de l\'utiliser à son tour !'],
	['Vous pouvez enregistrer ici des ingrédients qui n\'existe pas déjà dans le lexique de Kajoo! Il est important d\'inscrire correctement le nom de l\'ingrédient, de le mettre au singulier et de sélectionner la bonne unité de mesure ! Votre ingrédient sera non seulement visible par les autres utilisateurs de Kajoo, mais il servira aussi à générer correcteemnt les quantités pour vos listes de courses !'],
	['Les ingrédients ici présent, proviennent de la base de donnée de Kajoo que les utilisateur ont enrechit au fur et à mesure. Choisissez un ingrédient dans la liste et cela complètera automatiquement les champs prévus pour l\'afficher ainsi que son unité de mesure ! '],
	['Votre recette est tellement incroyable que vous ne voulez pas la partager ? Mettez la en privée et elle ne sera pas visible sur les comptes de vos amis !']
];
const srcImgMess = "public/img/kajoo/";
const aContainImg = [
	[srcImgMess + "kajoo1.png", "Kajoo, la noix de cajou"], // tombe
	[srcImgMess + "kajoo2.png", "Kajoo, la noix de cajou"], // pleure
	[srcImgMess + "kajoo3.png", "Kajoo, la noix de cajou"], // blazé
	[srcImgMess + "kajoo4.png", "Kajoo, la noix de cajou"], // mignon
	[srcImgMess + "kajoo5.png", "Kajoo, la noix de cajou"], // pete un cable
	[srcImgMess + "kajoo6.png", "Kajoo, la noix de cajou"], // uiiiii
	[srcImgMess + "kajoo7.png", "Kajoo, la noix de cajou"], // happy
	[srcImgMess + "kajoo8.png", "Kajoo, la noix de cajou"], // danse
	[srcImgMess + "kajoo9.png", "Kajoo, la noix de cajou"] // costaud
];

//remplace le htmlspecialchar de php pour éviter les injections XSS lors de l'affichage (échappement)
function escapeHtml(text) {
	const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
	return text.replace(/[&<>"']/g, function(m) {
		return map[m]; 
	});
}

//Exécuter ce code avant tout les autres aboutira à la création de la méthode Array.isArray()si elle n'est pas nativement prise en charge par le navigateur.
if(!Array.isArray) {
  Array.isArray = function(arg) {
    return Object.prototype.toString.call(arg) === '[object Array]';
  };
}

// requete ajax format JSON, résulat renvoyé et message si erreur
function useAjaxReqestJson(urlRequest, typeSend, typeReturn, dataToSend, contentTypeData, processDataData, callback){
	//var errorPhp = { error: "error" };
	if(contentTypeData === false){
	$.ajax({url:urlRequest, type:typeSend, dataType:typeReturn, data: dataToSend, contentType:contentTypeData, processData:processDataData})
		// Appel réussi : on réagit à la valeur de retour du code serveur contenue dans le paramètre response (ou response.d avec ASP.NET)
		//response : un objet représentant les données retournées par le code serveur
		//textStatus : une chaîne indiquant l'état de l'opération (valeur : success)
		//l'objet jqXHR : un objet contenant des informations sur l'appel AJAX.
		.done(function (response) {
			if((Array.isArray(response))||(typeof response == 'object')){
				callback.call(this, response);
			}
		})
		//Un appel AJAX ne sera pas réussi si les éléments de configuration de jQuery.ajax() ne sont pas corrects ou encore si le code serveur plante.
		// l'objet jqXHR : un objet contenant des informations sur l'appel AJAX. La propriété jqXHR.responseText contient le code HTML donnant de l'information complète sur l'erreur. Faites bien attention de ne jamais afficher ce texte à l'écran. Le débogueur JavaScript sera votre meilleur outil pour vérifier le contenu de cette propriété.
		//  textStatus : une chaîne indiquant l'état de l'erreur. Les valeurs possibles sont null, « timeout », « error », « abort » et« parsererror ».
		// errorThrown : texte donnant de l'information sur l'erreur. Ex : « Not Found », « Internal Server Error ».
		.fail(function (jqXHR) {
			//console.log(textStatus +   "errorThrown " +errorThrown+  "jqXHR " + jqXHR.responseText) // code erreur connexion réussis (resultat.status) : 200
			if(jqXHR.status === 200){
				showAjax("Oups ! "+jqXHR.responseText);
			}else{
				showAjax("Erreur ! "+jqXHR.responseText);
			}
		})
		//La fonction jqXHR.always() reçoit en paramètre une fonction de rappel qui permet de préciser le comportement du programme après l'appel AJAX, que l'appel ait été réussi ou non.
		.always(function (jqXHR, textStatus, errorThrown) {
		});
	//return data;
}else {
	$.ajax({url:urlRequest, type:typeSend, dataType:typeReturn, data: dataToSend})
		.done(function (response) {
			if((Array.isArray(response))||(typeof response == 'object')){
				callback.call(this, response);
			}
		})
		.fail(function (jqXHR) {
	 		//console.log(textStatus +   "errorThrown " +errorThrown+  "jqXHR " + jqXHR.responseText) // code erreur connexion réussis (resultat.status) : 200
			if(jqXHR.status === 200){
	 			showAjax("Oups ! "+jqXHR.responseText);
	 		}else{
				showAjax("Erreur ! "+jqXHR.responseText);
			}
	 	})
	 	.always(function (jqXHR, textStatus, errorThrown) { 
		});
	}
}
//----------------------------------------------------------
// affiche message d'erreur
function showError(mess){
	animPopupMess('#errorMessSimple', '#errorMessSimpleTxt', mess, '#errorMessSimpleImg', aContainImg[2][0])
}
//----------------------------------------------------------
// affiche message avec image (pas de bouton pour valider ou fermer)
function showErrorWithImg(mess){
	animPopupMess('#errorMessImgNoBtn', '#messErrorMessNoBtn', mess, '#imgErrorMessNoBtn', aContainImg[2][0])
}

//----------------------------------------------------------
const $messErrorMess=$('#messErrorMess');
const $containMessAndError = $('#containMessAndError');
const $imgErrorMess = $('#imgErrorMess');
const $errorMessImgWithBtn = $('#errorMessImgWithBtn');
const $bacgroundBlackWithBtn = $('#bacgroundBlackWithBtn');
const $containMessAndError_div = $('#containMessAndError > div');

// affiche message avec image ( avec bouton pour valider ou fermer)
function showMessWithImgAndBtn(mess, urlImg, altImg, idValidBtn, idAnnulBtn){
	blockBody();
	$messErrorMess.html(mess);
	$imgErrorMess.attr('src', urlImg);
	$imgErrorMess.attr('alt', altImg);
	$('#messageBtn p#confirmDivInfo').attr('id',idValidBtn);
	$('#messageBtn p#closeDivInfo').attr('id',idAnnulBtn);
	$errorMessImgWithBtn.css({'display':'block'});

	let widthDiv = $('body').width();
	let width2 = widthDiv * 70 / 100;

	$containMessAndError.delay(100).animate({'height':'5px'}, {'duration':0});
	$containMessAndError.delay(100).animate({'width':width2+40}, 200);

	setTimeout(function () {
		let heightAll = $errorMessImgWithBtn.outerHeight();
		$containMessAndError.delay(0).animate({'height': heightAll}, 300);
	}, 500);
	$bacgroundBlackWithBtn.fadeIn(300)
}

function closeErrorWithImgAndBtn(){
	closeAnimPopupMess();
}
//----------------------------------------------------------
function showAjax(mess){
	animPopupMess('#errorMessAjax', '#errorMessAjaxTxt', mess, '#errorMessAjaxImg', aContainImg[4][0])
}

//-----------------------------------------------------------
function animPopupMess(divSelect, divText, pText, divImg, numImg) {
	blockBody();
	$(divText).clearQueue();
	$(divImg).clearQueue();
	$(divSelect).clearQueue();
	$bacgroundBlackWithBtn.clearQueue();
	$containMessAndError.clearQueue();
	$(divText).html(pText);
	$(divImg).attr('src', numImg);
	$(divImg).attr('alt', 'image kajoo');
	$(divSelect).css({'display':'block'});

	let widthDiv = $('body').width();
	let width2 = widthDiv*70/100;

	$containMessAndError.delay(100).animate({'height':'5px'}, {'duration':0});
	$containMessAndError.delay(100).animate({'width':width2+40}, 200);

	setTimeout(function () {
		let heightAll = $(divSelect).outerHeight();
		$containMessAndError.delay(0).animate({'height': heightAll}, 300);
		
	}, 500);

	$bacgroundBlackWithBtn.fadeIn(300)	;
	$(divSelect).animate({'opacity': '1'}, 400);
}

function closeAnimPopupMess(){
	deleteBlockBody();
	let childDivClose = $containMessAndError_div;
	for(let i = 0 ; i < childDivClose.length ; i++){
		if($(childDivClose[i]).attr('id')==="errorMessImgWithBtn"){
			$messErrorMess.html('');
			$imgErrorMess.attr('src', "");
			$imgErrorMess.attr('alt', "");
			$('#messageBtn p:nth-child(1n)').attr('id','confirmDivInfo');
			$('#messageBtn p:nth-child(2n)').attr('id','closeDivInfo');
		}else{
			let idText = $(childDivClose[i]).children('div').children('p').attr('id');
			let idimg = $(childDivClose[i]).children('div').children('img').attr('id');
			let $idimg= $('#'+idimg);
			$('#'+idText).html('');
			$idimg.attr('src', '');
			$idimg.attr('alt', '');
		}
		$bacgroundBlackWithBtn.fadeOut(400);
		$containMessAndError.delay(150).animate({'height':'0px', 'width':'0px'}, {'duration':300});
		$(childDivClose[i]).css({'display':'none'});	
	}
}

$containMessAndError_div.click(function(){
	closeAnimPopupMess()
});
$bacgroundBlackWithBtn.click(function(){
	closeAnimPopupMess()
});
$('#popHeart').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[0][0],'#popImg', aContainImg[6][0]);
});
$('#popTitle').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[1][0],'#popImg', aContainImg[6][0]);
});
$('#popAlpha').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[2][0],'#popImg', aContainImg[6][0]);
});
$('#popCateg').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[3][0],'#popImg', aContainImg[6][0]);
});
$('#popPeople').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[4][0],'#popImg', aContainImg[6][0]);
});
$('#popTimeGlobal').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[5][0],'#popImg', aContainImg[6][0]);
});
$('#popPrice').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[6][0],'#popImg', aContainImg[6][0]);
});
$('#popEasy').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[7][0],'#popImg', aContainImg[6][0]);
});
$('#popIng').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[8][0],'#popImg', aContainImg[6][0]);
});
$('#popEtape').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[9][0],'#popImg', aContainImg[6][0]);
});
$('#popCam').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[10][0],'#popImg', aContainImg[6][0]);
});

$('#popPushIng').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[11][0],'#popImg', aContainImg[6][0]);
});
$('#popCreateIng').click(function(){
	animPopupMess('#popupInfo','#popTxt',aContainPopMess[12][0],'#popImg', aContainImg[6][0]);
});
$('div#contentNewFood').on('click', 'div.titleIngRecipe span#popSearch', function(){
	animPopupMess('#popupInfo','#popTxt', aContainPopMess[13][0], '#popImg',aContainImg[6][0]);
});
$('div#contentModifFood').on('click', 'div.titleIngRecipe span#popSearch', function(){
	animPopupMess('#popupInfo','#popTxt', aContainPopMess[13][0], '#popImg',aContainImg[6][0]);
});
$('#popPrivate').click(function(){
	animPopupMess('#popupInfo','#popTxt', aContainPopMess[14][0],'#popImg', aContainImg[6][0]);
});

//****************************************************************************************************************
                        //ANIMATIONS CATEGORIES
//****************************************************************************************************************

 // animation des div catégorie de la partie recette
function animMenuCateg(divSelect, divHideOne, divHideTwo){
	$(divSelect).clearQueue();
	$(divHideOne).clearQueue();
	$(divHideTwo).clearQueue();

	$(divSelect+' form').clearQueue();
	$(divHideOne+' form').clearQueue();
	$(divHideTwo+' form').clearQueue();
	
	let height = $(divSelect).css("height");
	
	if(height !== '0px'){
		$(divSelect+' form').animate({'opacity':'0'},500);
		$(divSelect).animate({'height':'0px'},500);
	}else{
		let heightForm = $(divSelect+' form').outerHeight();

		$(divSelect+' form').animate({'opacity':'9'},1500);
    	$(divSelect).animate({'height': heightForm+20},500);

		$(divHideOne).animate({'height':'0px'},500);
		$(divHideTwo).animate({'height':'0px'},500);
		$(divHideOne+' form').animate({'opacity':'0'},500);
		$(divHideTwo+' form').animate({'opacity':'0'},500);

		closeanimMenuRecipe();
		$('#contentModifViewRecipe').fadeOut(0);
		$('#contentViewRecipe').fadeOut(500);
		$('#contentNewViewRecipe').fadeOut(0);
	}
}
const $btnCategory = $('#btnCategory');
$('#actionCategory h2.divAddCateg').click(function(){
	animMenuCateg('#actionCategory > div:nth-child(2) > div', '#actionCategory > div:nth-child(3) > div', '#actionCategory > div:nth-child(4) > div')
});

$('#actionCategory h2.divModifCateg').click(function(){
	let childCateg = $btnCategory.children();
	let nbr = childCateg.length;
	if(nbr > 3){
		animMenuCateg('#actionCategory > div:nth-child(3) > div','#actionCategory > div:nth-child(4) > div',  '#actionCategory > div:nth-child(2) > div');
	}else{
		showError('Les catégories "Autres", Toutes" et "Privées", ne peuvent ni être modifiées, ni supprimées');
	}
});

$('#actionCategory h2.divDelCateg').click(function(){
	let childCateg = $btnCategory.children();
	let nbr = childCateg.length;
	if(nbr > 3){
		animMenuCateg( '#actionCategory > div:nth-child(4) > div', '#actionCategory > div:nth-child(3) > div', '#actionCategory > div:nth-child(2) > div');
	}else{
		showError('Les catégories "Autres", Toutes" et "Privées", ne peuvent ni être modifiées, ni supprimées');
	}
});

$('#errorMessAjax').click(function(){
	$('#errorMessAjax').fadeOut(100);
});

function closeCateg(){
	$('#divAddCateg').animate({'height':'0px'},500);
	$('#divAddCateg form').animate({'opacity':'0'},500);

	$('#divModifCateg').animate({'height':'0px'},500);
	$('#divModifCateg form').animate({'opacity':'0'},500);

	$('#divDelCateg').animate({'height':'0px'},500);
	$('#divDelCateg form').animate({'opacity':'0'},500);
}
//****************************************************************************************************************
                        //ANIMATIONS MENU RECETTE
//****************************************************************************************************************
const $contentRecipesMenu_recipesAlpha = $('#contentRecipesMenu #recipesAlpha');
const $contentRecipesMenu_paginationRecipe = $('#contentRecipesMenu #paginationRecipe');
const $contentRecipesMenu_recipes =$('#contentRecipesMenu #recipes');
const $contentRecipesMenu = $('#contentRecipesMenu');

function animMenuRecipe(){
	$contentRecipesMenu_recipesAlpha.clearQueue();
	$contentRecipesMenu_paginationRecipe.clearQueue();
	$contentRecipesMenu_recipes.clearQueue();
	$contentRecipesMenu.clearQueue();

	let heightForm = $contentRecipesMenu_recipesAlpha.outerHeight();
	heightForm += $contentRecipesMenu_paginationRecipe.outerHeight();
	heightForm += $contentRecipesMenu_recipes.outerHeight();
let opacAlpha = $contentRecipesMenu_recipesAlpha.css('opacity');
//console.log(opacAlpha)
	$contentRecipesMenu.animate({'height': heightForm+40},200);
if(opacAlpha < 1){
	$contentRecipesMenu_recipesAlpha.animate({'opacity':'1'},500);
}

	$contentRecipesMenu_paginationRecipe.animate({'opacity':'1'},500);
	$contentRecipesMenu_recipes.animate({'opacity':'9'},500);
}
function closeanimMenuRecipe(){
	$contentRecipesMenu_recipesAlpha.clearQueue();
	$contentRecipesMenu_paginationRecipe.clearQueue();
	$contentRecipesMenu_recipes.clearQueue();
	$contentRecipesMenu.clearQueue();

	$contentRecipesMenu_recipesAlpha.animate({'opacity':'0'},200);
	$contentRecipesMenu_paginationRecipe.animate({'opacity':'0'},200);
	$contentRecipesMenu_recipes.animate({'opacity':'0'},200);

	$contentRecipesMenu.animate({'height':'40px'},200);
}

$('#newBlockTwoTitle').click(function(){
	defillement($(this).children('a'));
	animNewRecipeTwo('#newBlockTwo', this, '#newBlockTwo div.hideDivAnim');
});
$('#newBlockThreeTitle').click(function(){
	defillement($(this).children('a'));
	animNewRecipeTwo('#newBlockThree', this, '#newBlockThree div.hideDivAnim');
});
$('#newBlockFourTitle').click(function(){
	defillement($(this).children('a'));
	animNewRecipeTwo('#newBlockFour', this, '#newBlockFour div.hideDivAnim');
});

$('#modifBlockTwoTitle').click(function(){
	defillement($(this).children('a'));
	animNewRecipeTwo('#modifBlockTwo', this, '#modifBlockTwo div.hideDivAnim');
});
$('#modifBlockThreeTitle').click(function(){
	defillement($(this).children('a'));
	animNewRecipeTwo('#modifBlockThree', this, '#modifBlockThree div.hideDivAnim');
});
$('#modifBlockFourTitle').click(function(){
	defillement($(this).children('a'));
	animNewRecipeTwo('#modifBlockFour', this, '#modifBlockFour div.hideDivAnim');
});


function animNewRecipeTwo(block, btn, divHide){
	$(block).clearQueue();
	$(btn).next('span').clearQueue();
	$(divHide).clearQueue();

	let height = $(block).css("height");
	if(height !== '0px'){
		$(block).animate({'height': '0px'},400);
		$(btn).children('span').attr('class', "fas fa-sort-down");
		$(divHide).animate({'opacity':'0'},500)
	}else{
		let heightForm = $(block+' div.hideDivAnim').outerHeight();
		$(block).animate({'height': heightForm+20},400);
		$(btn).children('span').attr('class', "fas fa-caret-up");
		$(divHide).animate({'opacity':'9'},500);
	}
}
function resizeDivEtapeFood(block, divHide){
	let heightForm = $(divHide).outerHeight();
	$(block).animate({'height': heightForm+40},400);
}
function resizeDivImg(block, divHide){
	setTimeout(function () {
		let heightForm = $(divHide).outerHeight();
		$(block).animate({'height': heightForm+40},400)
	}, 500);

}

//adapte textarea
function updateTextareaHeight(input) {
	let parent = $(input).parent().parent().parent().parent().parent().parent().parent();
	let gParent = $(parent).parent();
	let heightBefore = $(input).outerHeight();

	input.style.height = 'auto';
	input.style.height = input.scrollHeight+'px';
	let heightAfter = $(input).outerHeight();

	if(heightBefore !== heightAfter){
		let heightDiv = parent.outerHeight();
		gParent.animate({'height': heightDiv+40},400);
	}
}

function updateTextareaHeightInit(divTextArea){
	let div=$('#'+divTextArea);
	let child = $(div).children('div.flexColumn');
	for(let i = 0 ; i < child.length ; i++){
		let divId = $(child[i]).children('div:nth-child(2)').children('textarea').attr('id');
		let divText=document.getElementById(divId);
		updateTextareaHeight(divText);
	}

}

//****************************************************************************************************************
                        //FORMULAIRE
//****************************************************************************************************************

	// regex pour le controle côté client des formulaire avant soumission
const regMail    = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
const regPsw     = /^(?=.*[A-Z])(?=.*[0-9]).{8,}$/;
const regPseudo  = /^[a-zA-Z0-9]{3,}$/;
const regNbr     = /^([0-9]){1,2}$/;
const regNbrIng     = /^\d+(?:[.,]\d+)?$/;
//const regIng =  /^[a-zA-Z]{3,}$/;
const regIng = /^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._'\s-]{5,60}$/;
//const btnSub     = document.getElementsByName('registration');

function numberInput(el){
	let value = el.value;
	if(!regNbrIng.test(value)){
		el.value = 1
	}else{
		let chars = value.split("");
		//let size = chars.length;
		let stringValue = "";
		for(let i = 0 ; i < chars.length ; i++){
			if(chars[i] === ","){
				chars[i] = ".";
			}
			stringValue += chars[i];
		}
		let valueInt = parseFloat(stringValue);
		el.value = Math.round(valueInt*100)/100
	}
}

function verifFormatIng(el){
	let value = el.value;
	if(!regIng.test(value)){
		el.value = "";
		$('#addNewIngInBdd p.errorFormatIng').html('Le format de l\'ingrédient est invalide');
	}else{
		$('#addNewIngInBdd p.errorFormatIng').html('');
	}
}

$('#newTitleRecipe').change(function(){
	let titleNew = $('#newTitleRecipe').val();
	$('#newAlphaRecipe').val(titleNew.charAt(0).toUpperCase())
});
$('#titleNewModifRecipe').change(function(){
	let title = $('#titleNewModifRecipe').val();
	$('#alphaNewModifRecipe').val(title.charAt(0).toUpperCase())
});
//----------------------------------------------------
	$('#subEmail').change(function(){
		let value = $('#subEmail').val();
		if(value.length === 0){
			$('p.subEmail').text('Veuillez saisir un mot de pass');
		}
		else if(!regMail.test(value)){
			$('p.subEmail').text('Le format du mail n\'est pas valide');
		}
		else
		{
			$('p.subEmail').text('');
		}		
	});
//----------------------------------------------------
	$('#subPseudo').change(function(){
		let value = $('#subPseudo').val();
		if(value.length === 0)
		{
			$('p.subPseudo').text('Veuillez renseigner un pseudo');
		}
		else if(!regPseudo.test(value))
		{
			$('p.subPseudo').text('Le pseudo doit avoir au moins 3 caractères valides');
		}
		else{
			$('p.subPseudo').text('');

		}		
	});
//-----------------------------------------------------
	$('#subPsw').change(function(){
		let value = $('#subPsw').val();
		if(value.length === 0)
		{
			$('p.subPsw').text('Veuillez saisir un mot de pass');
		}
		else if(!regPsw.test(value))
		{
			$('p.subPsw').text('Le mot de passe n\'est pas assez sécurisé. Veuillez utiliser 8 caractères minimum avec au moins une majuscule et un chiffre');
		}
		else
		{
			$('p.subPsw').text('');

		}
	});
//------------------------------------------------------
	$('#subPswConfirm').change(function(){
		let valuePsw = $('#subPsw').val();
		let value = $('#subPswConfirm').val();
		if(value.length === 0)
		{
			$('p.subPswConfirm').text('Veuillez confirmer le mot de pass');
		}
		else if(value !== valuePsw)
		{
			$('p.subPswConfirm').text('Les deux mots de pass sont différents');

		}		
	});

//------------------------------------------------------
//------------------------------------------------------

	$('#newEmail').change(function(){
		let value = $('#newEmail').val();
		if(value.length === 0) // poour chrome
		{
		}
		if((value.length !== 0)&&(!regMail.test(value))){
			$('p.newEmail').text('Le format du mail n\'est pas valide');
		}
		else
		{
			$('p.newEmail').text('');

		}		
	});
//-------------------------------------------------
	$('#newPseudo').change(function(){
		let value = $('#newPseudo').val();
		if(!regPseudo.test(value))
		{
			$('p.newPseudo').text('Le pseudo doit avoir au moins 3 caractères valides');
		}
		else{
			$('p.newPseudo').text('');

		}		
	});
//--------------------------------------------------
	$('#newPsw').change(function(){
		let value = $('#newPsw').val();
		if(value.length === 0) // poour chrome
		{
		}
		if((value.length !== 0)&&(!regPsw.test(value)))
		{
			$('p.newPsw').text('Le mot de passe n\'est pas assez sécurisé. Veuillez utiliser 8 caractères minimum avec au moins une majuscule et un chiffre');
		}
		else
		{
			$('p.newPsw').text('');

		}
	});
//---------------------------------------------------
	$('#newPswConfirm').change(function(){
		let valuePsw = $('#newPsw').val();
		let value = $('#newPswConfirm').val();

		if(value !== valuePsw)
		{
			$('p.newPswConfirm').text('Les deux mots de pass sont différents');

		}		
	});

//--------------------------------------------------------
	$('#nbrPeople').change(function(){

		let value = $('#nbrPeople').val();
				//console.log(value)
		if(value.length === 0)
		{
			$('p.nbrPeople').text('Veuillez saisir un nombre');
		}
		else if((!regNbr.test(value)) ||(value > 10) ||(value < 1))
		{
			$('p.nbrPeople').text('Veuillez choisir un nombre entre 1 et 10');
		}
		else
		{
			$('p.nbrPeople').text('');
		}
	});
//--------------------------------------------------------
$('#nbrPagination').change(function(){

	let value = $('#nbrPagination').val();
	//console.log(value)
	if(value.length === 0)
	{
		$('p.nbrPagination').text('Veuillez saisir un nombre');
	}
	else if((!regNbr.test(value)) ||(value > 30)||(value < 1))
	{
		$('p.nbrPagination').text('Veuillez choisir un nombre entre 1 et 30');
	}
	else
	{
		$('p.nbrPagination').text('');
	}
});
//*****************************************************************************************************************
//AJAX pour supprimer une invitation
//*****************************************************************************************************************
$('#containAllInvitation button').click(function(){
	$('#errorMessInvitation').html('');
	let friendId = $(this).attr('class');
	showMessWithImgAndBtn(aContainNotice[12][0], aContainImg[0][0], aContainImg[0][1], aContainNotice[12][1], aContainNotice[12][2]);

	$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][2]).click(function(){
		$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][2]).unbind('click').click(function(){});
		closeErrorWithImgAndBtn(aContainNotice[12][1], aContainNotice[12][2]);
	});
	$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][1]).click(function(){
		$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][1]).unbind('click').click(function(){});
		//let idcategory = $('#selectDelCateg').val();
		useAjaxReqestJson('index.php?action=annulInviteFriend', 'POST', 'json', {friendId:friendId}, true,true,function(data){
			closeErrorWithImgAndBtn(aContainNotice[12][1], aContainNotice[12][2]);
			if((Object.keys(data).length === 1)&&("false" in data)){
				showErrorWithImg('Linviation a bien été supprimée !', aContainImg[1][0], aContainImg[1][1]);
				const $invitationSendContain = $('#invitationSendContain');
				let nbrInvit = $invitationSendContain.attr('class');

				if(nbrInvit ==="1"){
					$('#invitationSendTitle').html("<p>Vous n'avez pas d'inviation envoyées en attente.</p>");
					$invitationSendContain.attr('class', 0);
					$('#invitationSend').remove();
					$('#invitationSendContain > p').remove();
				}else{
					$('#invitationSend #containAllInvitation div#'+friendId).remove();
					let nbrChildInvit = $('#invitationSend #containAllInvitation').children('div.childInvit');
					let newClass = nbrChildInvit.length;
					$invitationSendContain.attr('class', newClass);
					$('#invitationSendContain > p').html("Vous avez envoyé "+newClass+" inviation(s) qui est en attente de réponse.");
				}
			}else{
				showError('Oups ! L\'invitation n\'a pas pu être suppimée...');
			}

		});
	});
});
//*****************************************************************************************************************
//animation compte utilisateur
//*****************************************************************************************************************
$('#relationShipTitle').click(function(){
	animFriendUserProfil('#relationShipContain #relationShip', this, '#relationShipContain #containAllRelation');
});
$('#invitationSendTitle').click(function(){
	animFriendUserProfil('#invitationSend', this, '#containAllInvitation');
});
$('#invitationReceiveTitle').click(function(){
	animFriendUserProfil('#invitationReceive', this, '#containAllInvitationReceive');
});

function animFriendUserProfil(block, btn, divHide){
	$(block).clearQueue();
	$(btn).next('span').clearQueue();
	$(divHide).clearQueue();

	let height = $(block).css("height");
	if(height !== '0px'){
		$(block).animate({'height': '0px'},400);
		$(btn).children('span').attr('class', "fas fa-sort-down");
		$(divHide).animate({'opacity':'0'},500);
	}else{
		let heightForm = $(divHide).outerHeight();
		$(block).animate({'height': heightForm+20},400);
		$(btn).children('span').attr('class', "fas fa-caret-up");
		$(divHide).animate({'opacity':'9'},500);
	}
}


/*$('#changePrefUser').click(function(){

	let newEmail = $('#newEmail').val();
	let newPseudo = $('#newPseudo').val();
	let newPsw = $('#newPsw').val();
	let newPswConfirm = $('#newPswConfirm').val();
	let nbrPeople =$('#nbrPeople').val();
	let nbrPagination=$('#nbrPagination').val();

	useAjaxReqestJson('index.php?action=changePref', 'POST', 'json', {	newEmail:newEmail, newPseudo:newPseudo, newPsw:newPsw, newPswConfirm:newPswConfirm, nbrPeople:nbrPeople, nbrPagination:nbrPagination}, true,true,function(data){

	});
});*/
//****************************************************************************************************************
                        //MENU MOBILE
//****************************************************************************************************************
const $fondMenuMobile = $('#fondMenuMobile');
const $btnMenuMobile =$('#btnMenuMobile');
const $btnMenuMobileOff =$('#btnMenuMobileOff');
const $bacgroundBlack = $('#bacgroundBlack');
const $menuMobile_ul= $('#menuMobile ul');
// animation du menu sur mobile
$bacgroundBlack.click(function(){
	$btnMenuMobileOff.click();
	closeAnimPopupMess();
});
$('#menuMobile li#btnRecette').click(function(e){
	e.stopPropagation();
	$(this).find('a')[0].click();
});

$('#menuMobile li#btnHome').click(function(e){
	e.stopPropagation();
	$(this).find('a')[0].click();
});
$('#menuMobile li#btnPlaning').click(function(e){
	e.stopPropagation();
	$(this).find('a')[0].click();
});
$('#menuMobile li#btnCourse').click(function(e){
	e.stopPropagation();
	$(this).find('a')[0].click();
});
$('#menuMobile li#btnHelp').click(function(e){
	e.stopPropagation();
	$(this).find('a')[0].click();
});
$('#menuMobile li#btnUser').click(function(e){
	e.stopPropagation();
	$(this).find('a')[0].click();
});

$btnMenuMobile.click(function(){
	blockBody();
	$btnMenuMobileOff.fadeIn(100);
	$bacgroundBlack.fadeIn(100);
	$btnMenuMobile.fadeOut(0);
	$fondMenuMobile.fadeIn(100);
	$fondMenuMobile.delay(100).animate({'height':'5px'}, {'duration':0});
	$fondMenuMobile.delay(100).animate({'width':'280px'}, {'duration':200});
	$fondMenuMobile.delay(200).animate({'height':'500px'}, {'duration':300});
	$menuMobile_ul.delay(800).animate({'opacity':'1'}, {'duration':400});
});
$btnMenuMobileOff.click(function(){
	deleteBlockBody();
	$btnMenuMobile.fadeIn(100);
	$btnMenuMobileOff.fadeOut(0);
	$fondMenuMobile.fadeOut(100);
	$bacgroundBlack.fadeOut(100);
	$fondMenuMobile.delay(150).animate({'height':'0px', 'width':'0px'}, {'duration':0});
	$menuMobile_ul.delay(150).animate({'opacity':'0'}, {'duration':0});
});

//****************************************************************************************************************
                        //ANIMATION FOND HEADER
//****************************************************************************************************************
const repairTab = $('#repairTab').css("display");
//const repairMob = $('#repairMob').css("display");
//const repairMobXs = $('#repairMobXs').css("display");

$('#btnRecette').hover(function(){
	changeImgMenuHover($(this), "public/img/btn/bouton12.png")
},function(){
	changeImgMenuHover($(this), "public/img/btn/bouton10.png")
});
$('#btnHome').hover(function(){
	changeImgMenuHover($(this), "public/img/btn/home2.png")
},function(){
	changeImgMenuHover($(this), "public/img/btn/home.png")
});
$('#btnPlaning').hover(function(){
	changeImgMenuHover($(this), "public/img/btn/bouton22.png")
},function(){
	changeImgMenuHover($(this), "public/img/btn/bouton21.png")
});
$('#btnCourse').hover(function(){
	changeImgMenuHover($(this), "public/img/btn/bouton32.png")
},function(){
	changeImgMenuHover($(this), "public/img/btn/bouton31.png")
});
$('#btnHelp').hover(function(){
	changeImgMenuHover($(this), "public/img/btn/aide2.png")
},function(){
	changeImgMenuHover($(this), "public/img/btn/aide.png")
});
$('#btnUser').hover(function(){
	changeImgMenuHover($(this), "public/img/btn/compte2.png")
},function(){
	changeImgMenuHover($(this), "public/img/btn/compte.png")
});

function changeImgMenuHover(btn, imgUrl){
	$(btn).children('img').clearQueue();
	$(btn).css({'box-shadow': 'none'});
	$(btn).children('img').stop(false,true);
	$(btn).children('img').animate({'width': '0px'}, 200);
	let cible = $(btn).children('img');
	setTimeout(function () {
		$(cible).attr('src', imgUrl);
		$(btn).css({'box-shadow': '2px 2px 5px black'})
	}, 200);
	if(repairTab === "block") {
		$(btn).children('img').animate({'width': '70px'}, 200);
	}else{
		$(btn).children('img').animate({'width': '90px'}, 200);
	}
}

