//****************************************************************************************************************
                        //UTILS
//****************************************************************************************************************
// array des textes
var aContainNotice = [
					['Êtes-vous sûr(e) de vouloir supprimer cette recette ?','confirmDelRecipe', 'annulDelRecipe'],
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
    				
  var srcImgMess = "public/img/kajoo/";

  var aContainImg = [
  					[srcImgMess+"kajoo1.png", "Kajoo, la noix de cajou"], // pas content
  					[srcImgMess+"kajoo2.png", "Kajoo, la noix de cajou"], // content
  					[srcImgMess+"kajoo3.png", "Kajoo, la noix de cajou"], // attention
  					[srcImgMess+"kajoo4.png", "Kajoo, la noix de cajou"] // neutre
  					];

//remplace le htmlspecialchar de php pour éviter les injections XSS lors de l'affichage (échappement)
function escapeHtml(text) {
	var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
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
function useAjaxReqestJson(urlRequest, typeSend, typeReturn, dataToSend, callback){
	//console.log(dataToSend)  
	//var data = false;
	$.ajax({url:urlRequest, type:typeSend, dataType:typeReturn, data: dataToSend}) //data: "{cle:'" + valeur + "'}"
// Appel réussi : on réagit à la valeur de retour du code serveur contenue dans le paramètre response (ou response.d avec ASP.NET)
//response : un objet représentant les données retournées par le code serveur
//textStatus : une chaîne indiquant l'état de l'opération (valeur : success)
//l'objet jqXHR : un objet contenant des informations sur l'appel AJAX.
		.done(function (response, textStatus, jqXHR) {	
			console.log(response)			
			if((Array.isArray(response))||(typeof response == 'object')){	
				callback.call(this, response);
			}
		})
//Un appel AJAX ne sera pas réussi si les éléments de configuration de jQuery.ajax() ne sont pas corrects ou encore si le code serveur plante.
// l'objet jqXHR : un objet contenant des informations sur l'appel AJAX. La propriété jqXHR.responseText contient le code HTML donnant de l'information complète sur l'erreur. Faites bien attention de ne jamais afficher ce texte à l'écran. Le débogueur JavaScript sera votre meilleur outil pour vérifier le contenu de cette propriété.
//  textStatus : une chaîne indiquant l'état de l'erreur. Les valeurs possibles sont null, « timeout », « error », « abort » et« parsererror ».
// errorThrown : texte donnant de l'information sur l'erreur. Ex : « Not Found », « Internal Server Error ».
		.fail(function (jqXHR, textStatus, errorThrown) {
	 		console.log(textStatus +   "errorThrown " +errorThrown+  "jqXHR " + jqXHR.responseText) // code erreur connexion réussis (resultat.status) : 200
	 		if(jqXHR.status == 200){
	 			showAjax("Oups ! "+jqXHR.responseText);
				callback.call(this, jqXHR.responseText);
	 		}
	 	})
//La fonction jqXHR.always() reçoit en paramètre une fonction de rappel qui permet de préciser le comportement du programme après l'appel AJAX, que l'appel ait été réussi ou non. 
	 	.always(function (jqXHR, textStatus, errorThrown) { 
		});
	 //return data;
}
//----------------------------------------------------------
// affiche messahe d'erreur
function showError(mess){
	console.log('ok')
	$('#errorMessSimple').clearQueue();
	//$('#errorMessSimple').fadeOut(0);
	$('#errorMessSimple').html('');
	$('#errorMessSimple').html('<p>'+mess+'</p>');
	$('#errorMessSimple').fadeIn(500);
	$('#errorMessSimple').delay(2000).fadeOut(500);
}
function closeError(){
	$('#errorMessSimple').fadeOut(0);
	$('#errorMessSimple').html('');
};

/*$(document).on( "click", function(e){
	//console.log(e.target.id)
		if ( e.target.id != ""){
			if($('#errorMessSimple:visible')){
				closeError();
			}if($('#errorMessImgNoBtn:visible')){
				closeErrorWithImg();
			}
	}
});*/

//----------------------------------------------------------
// affiche message avec image (pas de bouton pour valider ou fermer)
function showErrorWithImg(mess, urlImg, altImg){
	$('#messErrorMessNoBtn').html(mess);
	$('#imgErrorMessNoBtn').attr('src', urlImg);
	$('#imgErrorMessNoBtn').attr('alt', altImg);
	$('#errorMessImgNoBtn').fadeIn(500);
	setTimeout(closeErrorWithImg,5000);
}
function closeErrorWithImg(){
	$('#messErrorMessNoBtn').html('');
	$('#imgErrorMessNoBtn').attr('src', "");
	$('#imgErrorMessNoBtn').attr('alt', "");
	$('#errorMessImgNoBtn').fadeOut(300);
}
//----------------------------------------------------------
// affiche message avec image ( avec bouton pour valider ou fermer)
function showMessWithImgAndBtn(mess, urlImg, altImg, idValidBtn, idAnnulBtn){
	$('#messErrorMess').html(mess);
	$('#imgErrorMess').attr('src', urlImg);
	$('#imgErrorMess').attr('alt', altImg);
	$('#messageBtn p#confirmDivInfo').attr('id',idValidBtn);
	$('#messageBtn p#closeDivInfo').attr('id',idAnnulBtn);
	$('#errorMessImgWithBtn').fadeIn(500);
}

function closeErrorWithImgAndBtn(idValidBtn, idAnnulBtn){
	$('#messErrorMess').html('');
	$('#imgErrorMess').attr('src', "");
	$('#imgErrorMess').attr('alt', "");
	$('#messageBtn p#'+idValidBtn).attr('id','confirmDivInfo');
	$('#messageBtn p#'+idAnnulBtn).attr('id','closeDivInfo');
	$('#errorMessImgWithBtn').fadeOut(100);
}
//----------------------------------------------------------
function showAjax(mess){
	$('#errorMessAjax').html('<p>'+mess+'</p>');
	$('#errorMessAjax').fadeIn(500);
	$('#errorMessAjax').click(function(){
		$('#errorMessAjax').html('');
		$('#errorMessAjax').fadeOut(100);
	})
}

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
	
	var height = $(divSelect).css("height");
	
	if(height != '0px'){ 
		$(divSelect+' form').animate({'opacity':'0'},500)
		$(divSelect).animate({'height':'0px'},500)
	}else{
		var heightForm = $(divSelect+' form').outerHeight()

		$(divSelect+' form').animate({'opacity':'9'},1500)
    	$(divSelect).animate({'height': heightForm+20},500)

		$(divHideOne).animate({'height':'0px'},500)
		$(divHideTwo).animate({'height':'0px'},500)
		$(divHideOne+' form').animate({'opacity':'0'},500)
		$(divHideTwo+' form').animate({'opacity':'0'},500)

		closeanimMenuRecipe()
		$('#contentModifViewRecipe').fadeOut(0);
		$('#contentViewRecipe').fadeOut(500);
		$('#contentNewViewRecipe').fadeOut(0);
	}
}

$('#actionCategory h2.divAddCateg').click(function(){
	animMenuCateg('#actionCategory > div:nth-child(2) > div', '#actionCategory > div:nth-child(3) > div', '#actionCategory > div:nth-child(4) > div')
});

$('#actionCategory h2.divModifCateg').click(function(){
	var childCateg = $('#btnCategory').children()
	var nbr = childCateg.length;
	if(nbr > 3){
		animMenuCateg('#actionCategory > div:nth-child(3) > div','#actionCategory > div:nth-child(4) > div',  '#actionCategory > div:nth-child(2) > div');
	}else{
		showError('Les catégories "Autres", Toutes" et "Privées", ne peuvent ni être modifiées, ni supprimées');
	}

});

$('#actionCategory h2.divDelCateg').click(function(){
	var childCateg = $('#btnCategory').children()
	var nbr = childCateg.length;
	if(nbr > 3){
		animMenuCateg( '#actionCategory > div:nth-child(4) > div', '#actionCategory > div:nth-child(3) > div', '#actionCategory > div:nth-child(2) > div');
	}else{
		showError('Les catégories "Autres", Toutes" et "Privées", ne peuvent ni être modifiées, ni supprimées');
	}
});

$('#errorMessAjax').click(function(){
	$('#errorMessAjax').fadeOut(100);
})

function closeCateg(){
	$('#divAddCateg').animate({'height':'0px'},500)
	$('#divAddCateg form').animate({'opacity':'0'},500)

	$('#divModifCateg').animate({'height':'0px'},500)
	$('#divModifCateg form').animate({'opacity':'0'},500)

	$('#divDelCateg').animate({'height':'0px'},500)
	$('#divDelCateg form').animate({'opacity':'0'},500)
}
//****************************************************************************************************************
                        //ANIMATIONS MENU RECETTE
//****************************************************************************************************************
function animMenuRecipe(){
	$('#contentRecipesMenu #recipesAlpha').clearQueue();
	$('#contentRecipesMenu #paginationRecipe').clearQueue();
	$('#contentRecipesMenu #recipes').clearQueue();
	$('#contentRecipesMenu').clearQueue();
	
	var heightForm = $('#contentRecipesMenu #recipesAlpha').outerHeight();
	heightForm += $('#contentRecipesMenu #paginationRecipe').outerHeight();
	heightForm += $('#contentRecipesMenu #recipes').outerHeight();

	$('#contentRecipesMenu').animate({'height': heightForm+20},500)

	$('#contentRecipesMenu #recipesAlpha').animate({'opacity':'9'},1500)
	$('#contentRecipesMenu #paginationRecipe').animate({'opacity':'9'},1500)
	$('#contentRecipesMenu #recipes').animate({'opacity':'9'},1500)
	
}
function closeanimMenuRecipe(){
	$('#contentRecipesMenu #recipesAlpha').clearQueue();
	$('#contentRecipesMenu #paginationRecipe').clearQueue();
	$('#contentRecipesMenu #recipes').clearQueue();
	$('#contentRecipesMenu').clearQueue();
	
	$('#contentRecipesMenu #recipesAlpha').animate({'opacity':'0'},500)
	$('#contentRecipesMenu #paginationRecipe').animate({'opacity':'0'},500)
	$('#contentRecipesMenu #recipes').animate({'opacity':'0'},500)

	$('#contentRecipesMenu').animate({'height':'0px'},500)
}

$('#newBlockTwoTitle').click(function(){
	animNewRecipeTwo('#newBlockTwo', this, '#newBlockTwo div.hideDivAnim');
});
$('#newBlockThreeTitle').click(function(){
	animNewRecipeTwo('#newBlockThree', this, '#newBlockThree div.hideDivAnim');
});
$('#newBlockFourTitle').click(function(){
	animNewRecipeTwo('#newBlockFour', this, '#newBlockFour div.hideDivAnim');
});
$('#modifBlockTwoTitle').click(function(){
	animNewRecipeTwo('#modifBlockTwo', this, '#modifBlockTwo div.hideDivAnim');
});
$('#modifBlockThreeTitle').click(function(){
	animNewRecipeTwo('#modifBlockThree', this, '#modifBlockThree div.hideDivAnim');
});
$('#modifBlockFourTitle').click(function(){
	animNewRecipeTwo('#modifBlockFour', this, '#modifBlockFour div.hideDivAnim');
});


function animNewRecipeTwo(block, btn, divHide){
	$(block).clearQueue();
	$(btn).next('span').clearQueue();
	$(divHide).clearQueue();

	var height = $(block).css("height");
	if(height != '0px'){
		$(block).animate({'height': '0px'},400)
		$(btn).children('span').attr('class', "fas fa-sort-down");
		$(divHide).animate({'opacity':'0'},500)
	}else{
		var heightForm = $(block+' div.hideDivAnim').outerHeight()
		$(block).animate({'height': heightForm+20},400)
		$(btn).children('span').attr('class', "fas fa-caret-up");
		$(divHide).animate({'opacity':'9'},500)
	}
}
function resizeDivEtapeFood(block, divHide){
	var heightForm = $(divHide).outerHeight();
	$(block).animate({'height': heightForm+40},400)
}
function resizeDivImg(block, divHide){
	var heightForm = $(divHide).outerHeight();
	$(block).animate({'height': heightForm+200},400)
}

//****************************************************************************************************************
                        //FORMULAIRE
//****************************************************************************************************************

	// regex pour le controle côté client des formulaire avant soumission
	var regMail    = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
	var regPsw     = /^(?=.*[A-Z])(?=.*[0-9]).{8,}$/; 
	var regPseudo  = /^[a-zA-Z0-9]{3,}$/; 
	var regNbr     = /^([0-9]){1,2}$/;

	var btnSub     = document.getElementsByName('registration');
//----------------------------------------------------
	$('#subEmail').change(function(){
		var value = $('#subEmail').val();
		if(value.length == 0){
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
		var value = $('#subPseudo').val();
		if(value.length == 0)
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
		var value = $('#subPsw').val();
		if(value.length == 0)
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
		var valuePsw = $('#subPsw').val();
		var value = $('#subPswConfirm').val();
		if(value.length == 0)
		{
			$('p.subPswConfirm').text('Veuillez confirmer le mot de pass');
		}
		else if(value != valuePsw)
		{
			$('p.subPswConfirm').text('Les deux mots de pass sont différents');

		}		
	});

//------------------------------------------------------
//------------------------------------------------------

	$('#newEmail').change(function(){
		var value = $('#newEmail').val();
		if(value.length == 0) // poour chrome
		{
		}
		if((value.length != 0)&&(!regMail.test(value))){
			$('p.newEmail').text('Le format du mail n\'est pas valide');
		}
		else
		{
			$('p.newEmail').text('');

		}		
	});
//-------------------------------------------------
		$('#newPseudo').change(function(){
		var value = $('#newPseudo').val();
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
		var value = $('#newPsw').val();
		if(value.length == 0) // poour chrome
		{
		}
		if((value.length != 0)&&(!regPsw.test(value)))
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
		var valuePsw = $('#newPsw').val();
		var value = $('#newPswConfirm').val();

		if(value != valuePsw)
		{
			$('p.newPswConfirm').text('Les deux mots de pass sont différents');

		}		
	});

//--------------------------------------------------------
	$('#nbrPeople').change(function(){

		var value = $('#nbrPeople').val();
				//console.log(value)
		if(value.length == 0)
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

	var value = $('#nbrPagination').val();
	//console.log(value)
	if(value.length == 0)
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
	var friendId = $(this).attr('class');
	showMessWithImgAndBtn(aContainNotice[12][0], aContainImg[0][0], aContainImg[0][1], aContainNotice[12][1], aContainNotice[12][2])

	$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][2]).click(function(){
		$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][2]).unbind('click').click(function(){});
		closeErrorWithImgAndBtn(aContainNotice[12][1], aContainNotice[12][2]);
	});
	$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][1]).click(function(){
		$('#errorMessImgWithBtn #messageBtn #'+aContainNotice[12][1]).unbind('click').click(function(){});
		var idcategory = $('#selectDelCateg').val();
		useAjaxReqestJson('index.php?action=annulInviteFriend', 'POST', 'json', {friendId:friendId}, function(data){
			closeErrorWithImgAndBtn(aContainNotice[12][1], aContainNotice[12][2]);
			if((Object.keys(data).length === 1)&&("false" in data)){
				showErrorWithImg('Linviation a bien été supprimée !', aContainImg[1][0], aContainImg[1][1]);
				var nbrInvit = $('#invitationSendContain').attr('class');

				if(nbrInvit ==="1"){
					$('#invitationSendTitle').html("<p>Vous n'avez pas d'inviation envoyées en attente.</p>");
					$('#invitationSendContain').attr('class', 0);
					$('#invitationSend').remove();
					$('#invitationSendContain > p').remove();
				}else{
					$('#invitationSend #containAllInvitation div#'+friendId).remove();
					var nbrChildInvit = $('#invitationSend #containAllInvitation').children('div.childInvit')
					var newClass = nbrChildInvit.length;
					$('#invitationSendContain').attr('class', newClass);
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

	var height = $(block).css("height");
	if(height != '0px'){
		$(block).animate({'height': '0px'},400)
		$(btn).children('span').attr('class', "fas fa-sort-down");
		$(divHide).animate({'opacity':'0'},500)
	}else{
		var heightForm = $(divHide).outerHeight()
		$(block).animate({'height': heightForm+20},400)
		$(btn).children('span').attr('class', "fas fa-caret-up");
		$(divHide).animate({'opacity':'9'},500)
	}
}
//****************************************************************************************************************
                        //MENU MOBILE
//****************************************************************************************************************

// animation du menu sur mobile
$('#btnMenuMobile').click(function(){
	$('#btnMenuMobileOff').fadeIn(100);
	$('#btnMenuMobile').fadeOut(0);
	$('#fondMenuMobile').delay(0).animate({'right':'-50px'}, {'duration':400});
	$('#menuMobile').delay(0).animate({'right':'15px'}, {'duration':400});
});
$('#btnMenuMobileOff').click(function(){
	$('#btnMenuMobile').fadeIn(100)
	$('#btnMenuMobileOff').fadeOut(0);
	$('#fondMenuMobile').delay(0).animate({'right':'-150px'}, {'duration':400});
	$('#menuMobile').delay(0).animate({'right':'-80px'}, {'duration':400});
		
});

//****************************************************************************************************************
                        //ANIMATION FOND HEADER
//****************************************************************************************************************
var repairTab = $('#repairTab').css("display");
var repairMob = $('#repairMob').css("display");
var repairMobXs = $('#repairMobXs').css("display");

var hauteur = 50; // 100, c'est le nombre de pixels à partir duquel on déclenche le tout

$(window).resize(function() {
	if(repairTab == 'block'){
		$('header').css({'height':'150px'}); // "et vice et versa"
		$('header #logo img').css({'width':'200px', 'height':'150px','margin-left': '0px', 'margin-top': '0px'});
		$('header #logo').css({'width':'200px', 'height':'150px'});
		$('header #logo div').css({'width':'200px', 'height':'200px', 'top':'-20px', 'left':'0px'});
		$('header #baniere').css({'height':'150px'});
		$('header #login').css({'top':'30px', 'right':'25px'});
		$('header #login div').css({'top':'-100px','width':'300px', 'height':'300px'});
		$('header div#login img').css({'width':'130px'});
		$('aside#planningRapel').css({'top':'250px','width':'40px'})
		$('aside#shopRapel').css({'top':'350px','width':'40px'});
		$('#menuLoging').css({'top':'80px', 'z-index':'9000'});
		$('header nav#menu').css({'width':'350px'});
		$('header nav#menu li').css({'height':'105px'});
		$('header #login a:nth-child(2)').css({'top':'130px', 'right':'50px'});
		$('#validAllPlanningWeek').css({'top':'240px'});

	}else if(repairMob == 'block'){
		$('header').css({'height':'100px'}); // "et vice et versa"
		$('header #logo img').css({'width':'200px', 'height':'150px','margin-left': '0px', 'margin-top': '0px'});
		$('header #logo').css({'width':'200px', 'height':'200px'});
		$('header #logo div').css({'width':'200px', 'height':'200px', 'top':'-40px', 'left':'0px'});
		$('header #baniere').css({'height':'100px'});
		$('#validAllPlanningWeek').css({'top':'200px'});
		$('#validAllPlanningWeek').css({'top':'120px'});
	}else if(repairMobXs == 'block'){
		$('header').css({'height':'80px'}); // "et vice et versa"
		$('header #logo img').css({'width':'150px', 'height':'100px','margin-left': '0px', 'margin-top': '0px'});
		$('header #logo').css({'width':'200px', 'height':'200px'});
		$('header #logo div').css({'width':'150px', 'height':'150px', 'top':'-20px', 'left':'0px'});
		$('header #baniere').css({'height':'80px'});
		$('#validAllPlanningWeek').css({'top':'120px'});
	}else{
		$('header').css({'height':'180px'}); // "et vice et versa"
		$('header #logo img').css({'width':'300px', 'height':'200px','margin-left': '0px', 'margin-top': '0px'});
		$('header #logo').css({'width':'300px', 'height':'260px'});
		$('header #logo div').css({'width':'300px', 'height':'300px', 'top':'-50px', 'left':'0px'});
		$('header #baniere').css({'height':'180px'});
		$('header #login').css({'top':'50px', 'right':'55px'});
		$('header #login div').css({'top':'-150px','width':'350px', 'height':'350px'});
		$('header div#login img').css({'width':'130px'});
		$('aside#planningRapel').css({'top':'280px','width':'70px'})
		$('aside#shopRapel').css({'top':'410px','width':'70px'});
		$('#menuLoging').css({'top':'80px'});
		$('header nav#menu li').css({'height':'125px'});
		$('header #login a:nth-child(2)').css({'color': '#d2cebe', 'top':'130px', 'right':'50px'});
		$('#validAllPlanningWeek').css({'top':'200px'});
	}
});


   $(function(){
       $(window).scroll(function () {//Au scroll dans la fenetre on déclenche la fonction
          if ($(this).scrollTop() > hauteur) { //si on a défile de plus de XXX (variable "hauteur) pixels du haut vers le bas
            if(repairTab == 'block'){ 
                $('header').css({'height':'80px'}); // "et vice et versa"
                $('header #logo img').css({'width':'150px', 'height':'100px','margin-left': '20px', 'margin-top': '17px'});
                $('header #logo').css({'width':'150px', 'height':'100px'});
                $('header #logo div').css({'width':'350px', 'height':'400px', 'top':'-250px', 'left':'-130px'});
                $('header #baniere').css({'height':'80px'});
                $('header #login').css({'top':'10px', 'right':'15px'});
                $('header #login div').css({'top':'-100px','width':'250px', 'height':'250px'});
                $('header div#login img').css({'width':'120px'});
                $('aside#planningRapel').css({'top':'170px','width':'40px'})
                $('aside#shopRapel').css({'top':'280px','width':'40px'});
                $('#menuLoging').css({'top':'5px'});
                $('header nav#menu').css({'width':'320px'});
                $('header nav#menu li').css({'height':'85px'});
                $('header #login a:nth-child(2)').css({'top':'160px', 'right':'0px'});
                $('#validAllPlanningWeek').css({'top':'120px'});
            }else if(repairMob == 'block'){
                $('header').css({'height':'60px'}); // "et vice et versa"
                $('header #logo img').css({'width':'150px', 'height':'100px','margin-left': '0px', 'margin-top': '0px'});
                $('header #logo').css({'width':'150px', 'height':'100px'});
                $('header #logo div').css({'width':'350px', 'height':'400px', 'top':'-300px', 'left':'-130px'});
                $('header #baniere').css({'height':'60px'});
                $('header #login').css({'top':'10px', 'right':'15px'});
                $('header #login div').css({'top':'-100px','width':'250px', 'height':'250px'});
                $('header div#login img').css({'width':'120px'});
                $('#validAllPlanningWeek').css({'top':'90px'});
            }else if(repairMobXs == 'block'){
                $('header').css({'height':'60px'}); // "et vice et versa"
                $('header #logo img').css({'width':'120px', 'height':'80px','margin-left': '0px', 'margin-top': '0px'});
                $('header #logo').css({'width':'150px', 'height':'100px'});
                $('header #logo div').css({'width':'300px', 'height':'400px', 'top':'-300px', 'left':'-130px'});
                $('header #baniere').css({'height':'60px'});
                $('#validAllPlanningWeek').css({'top':'90px'});
            }else{
                $('header').css({'height':'80px'}); // "et vice et versa"
                $('header #logo img').css({'width':'150px', 'height':'100px','margin-left': '20px', 'margin-top': '17px'});
                $('header #logo').css({'width':'150px', 'height':'100px'});
                $('header #logo div').css({'width':'400px', 'height':'400px', 'top':'-250px', 'left':'-150px'});
                $('header #baniere').css({'height':'80px'});
                $('header #login').css({'top':'20px', 'right':'35px'});
              	$('header #login div').css({'top':'-150px','width':'300px', 'height':'300px'});
              	$('header div#login img').css({'width':'120px'});
                $('aside#planningRapel').css({'top':'200px','width':'60px'})
                $('aside#shopRapel').css({'top':'330px','width':'60px'});
                $('#menuLoging').css({'top':'5px'});
                $('header nav#menu li').css({'height':'105px'});
                $('header #login a:nth-child(2)').css({'color': '#864002', 'top':'160px', 'right':'0px'});
                $('#validAllPlanningWeek').css({'top':'120px'});
            }

          }else {
            if(repairTab == 'block'){ 
               $('header').css({'height':'150px'}); // "et vice et versa"
              $('header #logo img').css({'width':'200px', 'height':'150px','margin-left': '0px', 'margin-top': '0px'});
              $('header #logo').css({'width':'200px', 'height':'150px'});
              $('header #logo div').css({'width':'200px', 'height':'200px', 'top':'-20px', 'left':'0px'});
              $('header #baniere').css({'height':'150px'});
              $('header #login').css({'top':'30px', 'right':'25px'});
              $('header #login div').css({'top':'-100px','width':'300px', 'height':'300px'});
              $('header div#login img').css({'width':'130px'});
              $('aside#planningRapel').css({'top':'250px','width':'40px'})
              $('aside#shopRapel').css({'top':'350px','width':'40px'});
              $('#menuLoging').css({'top':'80px', 'z-index':'9000'});
              $('header nav#menu').css({'width':'350px'});
              $('header nav#menu li').css({'height':'105px'});
              $('header #login a:nth-child(2)').css({'top':'130px', 'right':'50px'});
              $('#validAllPlanningWeek').css({'top':'240px'});

            }else if(repairMob == 'block'){
               $('header').css({'height':'100px'}); // "et vice et versa"
              $('header #logo img').css({'width':'200px', 'height':'150px','margin-left': '0px', 'margin-top': '0px'});
              $('header #logo').css({'width':'200px', 'height':'200px'});
              $('header #logo div').css({'width':'200px', 'height':'200px', 'top':'-40px', 'left':'0px'});
              $('header #baniere').css({'height':'100px'});
              $('#validAllPlanningWeek').css({'top':'200px'});
              $('#validAllPlanningWeek').css({'top':'120px'});
            }else if(repairMobXs == 'block'){
               $('header').css({'height':'80px'}); // "et vice et versa"
              $('header #logo img').css({'width':'150px', 'height':'100px','margin-left': '0px', 'margin-top': '0px'});
              $('header #logo').css({'width':'200px', 'height':'200px'});
              $('header #logo div').css({'width':'150px', 'height':'150px', 'top':'-20px', 'left':'0px'});
              $('header #baniere').css({'height':'80px'});
              $('#validAllPlanningWeek').css({'top':'120px'});
            }else{
              $('header').css({'height':'180px'}); // "et vice et versa"
              $('header #logo img').css({'width':'300px', 'height':'200px','margin-left': '0px', 'margin-top': '0px'});
              $('header #logo').css({'width':'300px', 'height':'260px'});
              $('header #logo div').css({'width':'300px', 'height':'300px', 'top':'-50px', 'left':'0px'});
              $('header #baniere').css({'height':'180px'});
              $('header #login').css({'top':'50px', 'right':'55px'});
              $('header #login div').css({'top':'-150px','width':'350px', 'height':'350px'});
              $('header div#login img').css({'width':'130px'});
              $('aside#planningRapel').css({'top':'280px','width':'70px'})
              $('aside#shopRapel').css({'top':'410px','width':'70px'});
              $('#menuLoging').css({'top':'80px'});
              $('header nav#menu li').css({'height':'125px'});
              $('header #login a:nth-child(2)').css({'color': '#d2cebe', 'top':'130px', 'right':'50px'});
              $('#validAllPlanningWeek').css({'top':'200px'});
            }
          }
       });
     });

//****************************************************************************************************************
                        //POPUP KAJOO
//****************************************************************************************************************
// animation de la pop-up info

function animPopupRecipe(txt, heightDiv){
	$('#popupInfo div').clearQueue();
	$('#popupInfo #popTxt').clearQueue();
	$('#popupInfo > div').clearQueue();
	$('#popupInfo').clearQueue();
	$('#popupInfo div div#popTxt').clearQueue();

	if($('#popupInfo div').is(":visible")){ 	
		$('#popupInfo #popTxt').fadeOut(100);
		$('#popupInfo > div').fadeOut(200);
		$('#popupInfo').delay(200).animate({'height':'0px', 'padding':'0px', 'width':'0px'}, {'duration':500});	
		$('#popupInfo div div#popTxt').html('');
	}else{
		$('#popupInfo div div#popImg').html('<img src="public/img/kajoo/kajoo3.png">')
		$('#popupInfo div div#popTxt').html(txt);
		$('#popupInfo').delay(0).animate({'height':heightDiv, 'padding':'10px', 'width':'300px'}, {'duration':500});
		$('#popupInfo > div').delay(800).fadeIn(400);
		$('#popupInfo #popTxt').delay(0).fadeIn(200)
	}
}
$('#popupInfo').click(function(){
	$('#popupInfo #popTxt').fadeOut(100);
	$('#popupInfo > div').fadeOut(200);
	$('#popupInfo').delay(200).animate({'height':'0px', 'padding':'0px', 'width':'0px'}, {'duration':500});	
	$('#popupInfo div div#popTxt').html('');
});
$('#popHeart').click(function(){
	animPopupRecipe('<p>Activer la fraise pour repérer vos recettes préférées que vous avez déjà essayé!</p>', '90px');
})
$('#popTitle').click(function(){
		animPopupRecipe('<p>Le moteur de recherche utilise les titres de vos recettes pour vous aidez à les retrouvez plus facilement. Choisissez les bien!</p>', '120px');
})
$('#popAlpha').click(function(){
		animPopupRecipe('<p>Utilisez la première lettre de votre titre </p>', '90px');
})
$('#popCateg').click(function(){
		animPopupRecipe('<p>Choisissez la catégorie où ranger votre recette</p>', '90px');
})
$('#popPeople').click(function(){
		animPopupRecipe('<p>Votre recette sera pour combien de personne?</p>', '100px');
})
$('#popTimeGlobal').click(function(){
		animPopupRecipe('<p>Le temps total pour la réalisation de votre recette. Elle se calcul automatiquement suivant le temps de chacune des étape de votre recette</p>', '120px');
})
$('#popPrice').click(function(){
	animPopupRecipe('<p>Indiquez le coût financier de votre recette</p>', '90px');
})
$('#popEasy').click(function(){
	animPopupRecipe('<p>Indiquez le niveau de difficulté de votre recette</p>', '90px');
})

$('#popIng').click(function(){
	animPopupRecipe('<p>Cette partie est consacrées au regroupement de vos ingrédients necessaire pour cette recette. Ce sera cette même liste qui sera utilisez pour compléter vos liste de course!</p>', '165px');
})

$('#popEtape').click(function(){
	animPopupRecipe('<p>Ajoutez des étapes de préaparation à votre recette pour vous faciliter la lecture! Pensez à notter le temps de ces étapes !</p>', '125px');
})
$('#popCam').click(function(){
	animPopupRecipe('<p>Ajoutez une photo pour illustrer votre recette.</p>', '90px');
})

$('#popPushIng').click(function(){
	animPopupRecipe('<p>Ajoutez un ingrédient dans la zone indiquée. Le moteur de recherche va vous présenter les ingrédients existant que vous pourrez utiliser. Si un ingrédient n\'existe pas, vous pouvez l\'enregister dans le lexique pour l\'utilisez ensuite.</p>', '195px');
})

$('#popCreateIng').click(function(){
	animPopupRecipe('<p>Vous pouvez enregistrer des ingrédients et leur unité de mesure dans le lexique de Kajoo!</p>', '100px');
})

$('#popSearch').click(function(){
	animPopupRecipe('<p>Choisissez un ingrédient dans la liste ci-dessous.</p>', '100px');
})
