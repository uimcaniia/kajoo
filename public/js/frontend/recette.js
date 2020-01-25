// recréer et met à jour la zone de catégorie/ changement/suppression
function createCategMenu(data, idCateg){
	//var data                   = aData;
	var btnMenu                ='';
	var selectModifCateg       ='';
	var selectRangNewCateg     ='';
	var selectRangModifCateg   ='';
	var selectDelCateg         ='';
	var selectModifCategRecipe ='';
	var selectAnimItem         = "";

	for(var i = 0 ; i < data.length ; i++){
		btnMenu   = btnMenu+'<button id ="'+escapeHtml(data[i]['title'])+'" class="'+data[i]['id_category']+'" type="submit" name="'+escapeHtml(data[i]['title'])+'">'+escapeHtml(data[i]['title'])+'</button>';

		var nbr   = parseFloat(i)+1; // identifiant des options du select du rang d'affichage
		var libel = 'place '+nbr+''; // libel de l'option du select

		selectRangNewCateg     += '<option value="'+nbr+'">'+libel+'</option>';
		selectModifCateg       += '<option value="'+ data[i]['id_category']+'">'+escapeHtml(data[i]['title'])+'</option>';
		selectRangModifCateg   += '<option value="'+nbr+'">'+libel+'</option>';
		selectDelCateg         += '<option value="'+ data[i]['id_category']+'">'+escapeHtml(data[i]['title'])+'</option>';
		selectModifCategRecipe += '<option value="'+ data[i]['id_category']+'">'+escapeHtml(data[i]['title'])+'</option>';
	}
	// on actualise les select des autres section de la page recette
	$('#btnCategory').html(btnMenu +'<button class="otherRecipe" type="submit" name="otherRecipe">Autres</button><button class="allrecipes" type="submit" name="allrecipes">Toutes</button><button class="privateRecipes" type="submit" name="privateRecipes">Privées</button>');
	$('#selectRangNewCateg').html(selectRangNewCateg);
	$('#selectModifCateg').html(selectModifCateg);
	$('#selectRangModifCateg').html(selectRangModifCateg);
	$('input#modifCateg').val('')
	$('input#addCateg').val('')
	$('#selectDelCateg').html(selectDelCateg);
	$('#selectModifCategRecipe').html(selectModifCategRecipe);
	$('#contentNewViewRecipe select#selectNewCategRecipe').html('<option value="0" selected disabled>--Catégorie--</option>'+selectModifCategRecipe+ '<option value="0">Autres</option>');
	$('#contentModifViewRecipe select#selectModifCategRecipe').html(selectModifCategRecipe+ '<option value="0">Autres</option>');
}

//*****************************************************************************************************************
//AJAX pour ajouter une catégorie . 
//*****************************************************************************************************************
	$('#validAddCateg').click(function(){
		var newCateg = $('#addCateg').val(); 
		var rangNewCateg = $('#selectRangNewCateg').val(); 

		newCategClean = newCateg.replace(/ |\n|\r|\t/g, ''); // supprime les blancs les retours chariots saut de ligne

		if(newCategClean.length > 2){ // on vérifie qu'il y a plus de 2 caractère minimum
			useAjaxReqestJson('index.php?action=addCategorie', 'POST', 'json', {newCateg:newCategClean, rangNewCateg:rangNewCateg}, true,true,function(aData){
				createCategMenu(aData);
				$('#actionCategory h2.divAddCateg').click();
			});
		}else{
			showError( "Le nom de la catégorie doit avoir plus de 2 caractères.")
		}
	});

//*****************************************************************************************************************
//AJAX pour modifier le libel d'une catégorie
//*****************************************************************************************************************
	$('#validModifLibelCateg').click(function(){

		var idCategory  = $('#selectModifCateg').val(); 
		var labelCateg  = $('#modifCateg').val(); 

		labelCategClean = labelCateg.replace(/ |\n|\r|\t/g, '');

		if(labelCategClean.length > 2){

			useAjaxReqestJson('index.php?action=modifLibelCategorie', 'POST', 'json', {idCategory:idCategory, labelCateg:labelCateg}, true,true,function(aData){
				createCategMenu(aData, idCategory);
				$('#actionCategory h2.divModifCateg').click();
			});
		}else{
			showError("Le nom de la catégorie doit avoir plus de 2 caractères.")
		}
	});

//*****************************************************************************************************************
//AJAX pour modifier le rang d'une catégorie
//*****************************************************************************************************************
	$('#validModifRangCateg').click(function(){

		var idCategory = $('#selectModifCateg').val(); 
		var rangCateg  = $('#selectRangModifCateg').val();

		useAjaxReqestJson('index.php?action=modifRangCategorie', 'POST', 'json', {idCategory:idCategory, rangCateg:rangCateg}, true,true,function(aData){
			createCategMenu(aData);
			$('#actionCategory h2.divModifCateg').click();
		})
	
	});

//*****************************************************************************************************************
//AJAX pour supprimer une catégorie
//*****************************************************************************************************************
	$('#validDelCateg').click(function(){
		showMessWithImgAndBtn(aContainNotice[1][0], aContainImg[0][0], aContainImg[0][1], 'confirmDelCateg', 'annulDelCateg')

		$('#errorMessImgWithBtn #messageBtn #annulDelCateg').click(function(){
			$('#errorMessImgWithBtn #messageBtn #annulDelCateg').unbind('click').click(function(){});
			closeErrorWithImgAndBtn('confirmDivInfo', 'closeDivInfo');
		});
		$('#errorMessImgWithBtn #messageBtn #confirmDelCateg').click(function(){
			$('#actionCategory h2.divDelCateg').click();
			$('#errorMessImgWithBtn #messageBtn #confirmDelCateg').unbind('click').click(function(){});
			var idcategory = $('#selectDelCateg').val(); 
			useAjaxReqestJson('index.php?action=delCategorie', 'POST', 'json', {idcategory:idcategory}, true,true,function(aData){
				createCategMenu(aData);
				closeErrorWithImgAndBtn('confirmDivInfo', 'closeDivInfo');

			});
		});
	});


//*****************************************************************************************************************
//AJAX pour afficher les recettes suivant la catégorie sélectionné
//*****************************************************************************************************************
	$('#btnCategory').on('click','button',function(){

		$('#contentRecipesMenu').fadeIn(500);
		$('#contentModifViewRecipe').fadeOut(0);
		$('#contentViewRecipe').fadeOut(0);
		$('#contentNewViewRecipe').fadeOut(0);
		$('#recipes').fadeIn(0);

		closeCateg();

		var offset = 0;
		var idcategory = $(this).attr('class');
		//console.log(idcategory)
		callToRecupRecipe(idcategory, offset, 1, "", "");
	});
	//-------------------------------------------------------------
$('#btnCategoryFriend').on('click','button',function(){

	$('#contentRecipesMenu').fadeIn(500);
	$('#contentModifViewRecipe').fadeOut(0);
	$('#contentViewRecipe').fadeOut(0);
	$('#contentNewViewRecipe').fadeOut(0);
	$('#recipes').fadeIn(0);

	closeCateg();

	var offset = 0;
	var friend = $(this).attr('class');
	callToRecupRecipe("", offset, 1, "", friend);
});
//-------------------------------------------------------------------

	function callToRecupRecipe(idcategory, offset, pageSelect, alpha, friend){
		closeanimMenuRecipe();
		$('#paginationRecipe').html('');
		$('#recipesAlpha').html('');

		if((idcategory === 'allrecipes')&&(friend==="")){ // si on a cliqué sur le bouton pour tout afficher
			useAjaxReqestJson('index.php?action=countNumberRecipe', 'POST', 'json', {alpha:alpha}, true,true,function(dataNumber){
				useAjaxReqestJson('index.php?action=showRecipes', 'POST', 'json', {alpha:alpha, offset:offset}, true,true,function(data){
					
 					if((Object.keys(data).length === 1)&&("false" in data)){
						makeListRecipe(data);
 					}else{
 						makePaginationRecipe(idcategory, offset, dataNumber["nbrPage"], dataNumber["pagination"], pageSelect, "");
 						makePaginationAlpha(dataNumber["letterPage"], idcategory, "");
 						makeListRecipe(data);
						showRecipeSelect();
 					}
				});
			});
		}
		else if((idcategory === '')&&(friend !== "")){ // recette amis
			useAjaxReqestJson('index.php?action=countNumberFriendRecipe', 'POST', 'json', {alpha:alpha, idFriend:friend}, true,true,function(dataNumber){
				useAjaxReqestJson('index.php?action=showFriendRecipes', 'POST', 'json', {alpha:alpha, idFriend:friend, offset:offset}, true,true,function(data){
					if((Object.keys(data).length === 1)&&("false" in data)){
						makeListRecipe(data);
					}else{
						makePaginationRecipe("", offset, dataNumber["nbrPage"], dataNumber["pagination"], pageSelect, friend);
						makePaginationAlpha(dataNumber["letterPage"], "",  friend);
						makeListRecipe(data);
						showRecipeSelect();
					}
				});
			});
		}
		else if((idcategory === 'privateRecipes')&&(friend==="")){ // recette privée
			useAjaxReqestJson('index.php?action=countNumberPrivateRecipe', 'POST', 'json', {alpha:alpha}, true,true,function(dataNumber){
				useAjaxReqestJson('index.php?action=showPrivateRecipes', 'POST', 'json', {alpha:alpha, offset:offset}, true,true,function(data){

					if((Object.keys(data).length === 1)&&("false" in data)){
						makeListRecipe(data);
					}else{
						makePaginationRecipe(idcategory, offset, dataNumber["nbrPage"], dataNumber["pagination"], pageSelect, "");
						makePaginationAlpha(dataNumber["letterPage"], idcategory,   "");
						makeListRecipe(data);
						showRecipeSelect();
					}
				});
			});
		}
		else if((idcategory === 'otherRecipe')&&(friend==="")){ // categorie par défault des recettes sans catégorie
			useAjaxReqestJson('index.php?action=countNumberOtherRecipe', 'POST', 'json', {alpha:alpha}, true,true,function(dataNumber){
				useAjaxReqestJson('index.php?action=showOtherRecipes', 'POST', 'json', {alpha:alpha, offset:offset}, true,true,function(data){
					
 					if((Object.keys(data).length === 1)&&("false" in data)){
						makeListRecipe(data);
 					}else{
 						makePaginationRecipe(idcategory, offset, dataNumber["nbrPage"], dataNumber["pagination"], pageSelect, "");
 						makePaginationAlpha(dataNumber["letterPage"], idcategory, "");
 						makeListRecipe(data);
						showRecipeSelect();
 					}
				});
			});
		}
		else{// categorie  des recettes
			useAjaxReqestJson('index.php?action=countNumberRecipeInCategorie', 'POST', 'json', {alpha:alpha, idcategory:idcategory}, true,true,function(dataNumber){
				useAjaxReqestJson('index.php?action=showRecipesCateg', 'POST', 'json', {alpha:alpha, idcategory:idcategory, offset:offset}, true,true,function(data){
 				
 					if((Object.keys(data).length === 1)&&("false" in data)){
						makeListRecipe(data);
 					}else{
 						makePaginationRecipe(idcategory, offset, dataNumber["nbrPage"], dataNumber["pagination"], pageSelect, "");
 						makePaginationAlpha(dataNumber["letterPage"], idcategory, "");
 						makeListRecipe(data);
						showRecipeSelect();
 					}
				});

			});
		}
	};

//*****************************************************************************************************************
//pagination des recettes
//*****************************************************************************************************************
	function makePaginationRecipe(idCateg, offset, nbrPage, nbrData, pageSelect, friend){
		let classUl;
		let index;
		if (idCateg === "") {
			index = friend;
			classUl = friend;
		} else {
			index = idCateg;
			classUl = 0;
		}
		if(nbrPage > 1){
			
			var page = '<nav><ul class="'+classUl+'">';
			for(var i = 0 ; i < nbrPage ; i++ ){
				var spanNumber = i+1;
				if(pageSelect === i+1){
					page += '<li class="'+index+' '+nbrData+'"><span class="active"> '+spanNumber+' </span></li>';
				}else{
					page += '<li class="'+index+' '+nbrData+'"><span class=""> '+spanNumber+' </span></li>';
				}
			}
			$('#paginationRecipe').html(page);
		}
	}
//*****************************************************************************************************************
//pagination de TOUTES les lettres de référence
//*****************************************************************************************************************
	function makePaginationAlpha(aLetterPage, idCateg, friend){
		let classUl;
		let classLi;
		if (idCateg === "") {
			classLi = friend;
			classUl = friend;
		} else {
			classLi = idCateg;
			classUl = 0;
		}
		var page = '<nav><ul class="'+classUl+'">';
		for(var i = 0 ; i < aLetterPage.length ; i++){
			var index = aLetterPage[i]['alpha']; 
			page += '<li class="'+classLi+' '+index+'"><span title="voir les recettes commençant par la lettre '+index+'">'+escapeHtml(index)+'</span></li>';
		}
		page +='</ul></nav>';
		$('#recipesAlpha').html(page);

	}

//***************************************************************************
// action de la pagination des recettes
$('#paginationRecipe').on('click','span',function(){
	
	var classRecup = $(this).parent('li').attr('class');
	var classRecupFriend = $(this).parent('li').parent('ul').attr('class');
	var aClass = classRecup.split(' ');
	var idCateg = "";
	var nbrData = aClass[1];
	var friend = "";

	if(classRecupFriend === "0"){
		friend = "";
		idCateg = aClass[0];
	}else{
		friend =classRecupFriend;
		idCateg = "";
	}

	var offsetSpan = $(this).html();
	var offsetChange = (offsetSpan-1)*nbrData;

	callToRecupRecipe (idCateg, offsetChange, offsetSpan, "", friend);
});
//***************************************************************************
// action de la pagination des lettres des recettes
$('#recipesAlpha').on('click','span',function(){
	
	var classRecup = $(this).parent('li').attr('class');
	var classRecupFriend = $(this).parent('li').parent('ul').attr('class');
	var aClass = classRecup.split(' ');
	var idCateg = "";
	var alpha = aClass[1];
	var friend = "";

	if(classRecupFriend === "0"){
		friend = "";
		idCateg = aClass[0];
	}else{
		friend = classRecupFriend;
		idCateg = "";
	}
	callToRecupRecipe (idCateg, 0, 1, alpha, friend);
});
//***************************************************************************
// affichage de la liste des recettes
function makeListRecipe(data){
	$('#recipes div#listRecipeGroup').empty();
	var recipes = '';
	if((Object.keys(data).length === 1)&&("false" in data)){ // on vérifie si c'est juste un object et si la clé false existe
		recipes = recipes+'<p>Vous n\'avez aucune recette dans cette catégorie.</p>';
	}else{ 
		recipes = '<nav><ul>';
		recipes = recipes +'<div>';

		for(var j = 0 ; j < data.length ; j++){

			if(data[j]['love']==="1"){
				recipes = recipes+'<li class="'+data[j]['id_recette']+'"><img src="public/img/fraise.png" alt="fraise"><span >'+escapeHtml(data[j]['title']).charAt(0).toUpperCase()+escapeHtml(data[j]['title']).substring(1).toLowerCase()+'</span></li>';
			}else{
				recipes = recipes+'<li class="'+data[j]['id_recette']+'"><span class="espace"></span><span >'+escapeHtml(data[j]['title']).charAt(0).toUpperCase()+escapeHtml(data[j]['title']).substring(1).toLowerCase()+'</span></li>';
			}
		}
		recipes = recipes +'</div>'
		//}
		recipes = recipes+'</ul></nav>';
	}
	$('#recipes div#listRecipeGroup').html(recipes);
						animMenuRecipe();

}

//*****************************************************************************************************************
//AJAX pour afficher la recette sélectionnée
//*****************************************************************************************************************
function showRecipeSelect(){

	$('#recipes #listRecipeGroup span').click(function(){

		var idRecette = $(this).parent().attr('class');  // on récupère l'id de la recette sélectionnée
		$('#idRecetteSelectToShow').html(idRecette);
		closeanimMenuRecipe();
		$('#contentNewViewRecipe').fadeOut(0);

		//------------------------------------------------------
		useAjaxReqestJson('index.php?action=showOneRecipes', 'POST', 'json', {idRecette:idRecette}, true,true,function(data){
				//console.log(data)
			// on récupère les données et on les affiche
			$('#contentViewRecipe').fadeIn(500);
			//console.log(data[0]['lecteur']);
			if (!data[0]['lecteur']) { // si ce n'est pas le créateur de la recette, on empeche la modification et on propose la copy de la recette
				$('#actionRecipe div#actionRecipeMenuUser').fadeOut(0);
				$('#actionRecipe div#actionRecipeMenuFriend').css({'display':'flex'});
				//$('#actionRecipe').html('<span id="closeRecipe" class="fas fa-reply flexrow"><p>Retour</p></span><span class="far fa-copy flexrow" id="copyRecipe"><p>Copier la recette</p></span>');
			}else{
				$('#actionRecipe div#actionRecipeMenuUser').css({'display':'flex'});
				$('#actionRecipe div#actionRecipeMenuFriend').fadeOut(0);
				//$('#actionRecipe').html('<span id="closeRecipe" class="fas fa-reply flexrow"><p>Retour</p></span>	<span class="far fa-edit flexrow" id="modifRecipe"><p>Modifier la recette</p></span><span class="far fa-trash-alt flexrow" id="delRecipe"><p>Supprimer la recette</p></span>');
			}

			$('#closeRecipe').click(function(){
				$('#contentViewRecipe').fadeOut(0);
				animMenuRecipe()
			});


			$('#titleRecipe').html(escapeHtml(data[0]['title'])); // titre de la recette
			if (data[0]['private'] === "1") {
				$('#privateRecipe').html('<span class="fas fa-lock"></span>');
			}else{
				$('#privateRecipe').html('<span class="fas fa-lock-open"></span>');
			}
			$('#imgViewRecipe').html('<img src="" id="img">');

			// on charge l'image de la recette
			useAjaxReqestJson('index.php?action=loadImgRecipe', 'POST', 'json', {idRecette:idRecette}, true,true,function(dataImg){
				//console.log(dataImg)
				if(Array.isArray(dataImg)){
					$('#imgViewRecipe img').attr("src", dataImg[0]['img_src']+'.png');
				}
			});
			//------------------------------------------------------
			$('#nbrPeopleRecipe').html(data[0]['people']); // nombre de personne pour la recette
			$('#timePrepareRecipe').html(data[0]['prepare_time']); // titre
			//------------------------------------------------------

			var spanPrice = ''; // cout de la recette
			if (data[0]['price'] === "1"){
				spanPrice = '<div class="price"></div>';
			}
			else{
				spanPrice = '';
				for(var i = 0 ; i < data[0]['price'] ; i++){
					spanPrice = spanPrice + '<div class="price"></div>';
				}
			}
			$('#PriceRecipe').html(spanPrice);
			//------------------------------------------------------
			if (data[0]['love'] === "0"){ // aime ou non
				$('#love').html('<span class="fas fa-heart emptySpan"></span>');
			}else{
				$('#love').html('<img src="public/img/fraise.png" alt="fraise">');
			}
			//------------------------------------------------------

			var spanEasy = '';// difficulté de la recette
			if (data[0]['easy'] === "1"){
				spanEasy = '<div class="hard"></div>';
			}
			else{
				spanEasy = '';
				for(var i = 0 ; i < data[0]['easy'] ; i++){
					spanEasy = spanEasy + '<div class="hard"></div>';
				}
			}
			$('#easyRecipe').html(spanEasy); // facilité
			//------------------------------------------------------
			var ingredient = '<p>Ingrédient :</p>'; // ingrédient de la recette

			for(var i = 0 ; i < data[0]['id_ingredient_recette'].length ; i++){
				var ajout = data[0]['id_ingredient_recette'][i]['ajout_recette'];
				if(ajout == ""){
					ingredient = ingredient + '<div class=" flexrow whiteSpace"><img src="'+data[0]['id_ingredient_recette'][i]['thumb']+'" alt=""><p>'+escapeHtml(data[0]['id_ingredient_recette'][i]['quantity'])+' '+data[0]['id_ingredient_recette'][i]['unit']+' '+escapeHtml(data[0]['id_ingredient_recette'][i]['title'])+'</p></div>';
		
				}else{
					ingredient = ingredient + '<div class=" flexrow whiteSpace"><img src="'+data[0]['id_ingredient_recette'][i]['thumb']+'" alt=""><p>'+escapeHtml(data[0]['id_ingredient_recette'][i]['quantity'])+' '+data[0]['id_ingredient_recette'][i]['unit']+' '+escapeHtml(data[0]['id_ingredient_recette'][i]['title'])+'</p><p class="ingredien_ajout"> ('+escapeHtml(data[0]['id_ingredient_recette'][i]['ajout_recette'])+')</p></div>';
				}
			}
			$('#contentFood').html(ingredient);
			//------------------------------------------------------
			var etape = ''; // étape de la recette
			for(var i = 0 ; i < data[0]['id_etape'].length ; i++){
				etape = etape + '<p class="timeEtape"> temps : '+data[0]['id_etape'][i]['time']+' </p><br><p>'+escapeHtml(data[0]['id_etape'][i]['text'])+'</p><img src="'+data[0]['id_etape'][i]['img']+'" alt=""><hr>';
			}

			$('#contentEtape .etapeRecipeFlex div').html(etape);
			$('#modifRecipe').removeClass();
			$('#modifRecipe').addClass(idRecette);
			return false;
		});
	});
}
//*****************************************************************************************************************
//pour quitter le visionnage de la recette
//*****************************************************************************************************************
$('#actionRecipeMenuUser #closeRecipe').click(function(){
	$('#contentViewRecipe').fadeOut(0);
	animMenuRecipe()
	$('#idRecetteSelectToShow').html('');
});
$('#actionRecipeMenuFriend #closeRecipe').click(function(){
	$('#contentViewRecipe').fadeOut(0);
	animMenuRecipe()
	$('#idRecetteSelectToShow').html('');
});
//*****************************************************************************************************************
//pour copier une recette
//*****************************************************************************************************************

$('#copyRecipe').click(function() {
	showMessWithImgAndBtn(aContainNotice[11][0], aContainImg[5][0], aContainImg[0][1],'confirmCopyRecipe', 'annulCopyRecipe')
	$('#annulCopyRecipe').click(function () {
		$('#errorMessImgWithBtn #messageBtn #annulCopyRecipe').unbind('click').click(function(){
		});
		//console.log('annul copy')
		closeErrorWithImgAndBtn('confirmCopyRecipe', 'annulCopyRecipe');
	});
	$('#confirmCopyRecipe').click(function() {
		$('#errorMessImgWithBtn #messageBtn #confirmCopyRecipe').unbind('click').click(function(){
		});
		var idRecette = $('#idRecetteSelectToShow').html();
		useAjaxReqestJson('index.php?action=copyRecipes', 'POST', 'json', {idRecette: idRecette}, true,true,function (data) {
			if ((Object.keys(data).length === 1) && ("false" in data)) {
				showError("La recette n'a pas pu être copiée correctement !");
			} else {
				showError("La recette a bien été copiée !");
			}
			animMenuRecipe()
			$('#btnCategory button.allrecipes').click();
			closeErrorWithImgAndBtn('confirmCopyRecipe', 'annulCopyRecipe');
			$('#idRecetteSelectToShow').html('');
		});
	});
});


//*****************************************************************************************************************
//pour supprimer une recette
//*****************************************************************************************************************

	$('#delRecipe').click(function () {

		showMessWithImgAndBtn(aContainNotice[0][0], aContainImg[0][0], aContainImg[0][1], 'confirmDelRecipe', 'annulDelRecipe');
		$('#annulDelRecipe').click(function () {
			$('#errorMessImgWithBtn #messageBtn #annulDelRecipe').unbind('click').click(function(){

			});
			closeErrorWithImgAndBtn('confirmDelRecipe', 'annulDelRecipe');
		});
		$('#confirmDelRecipe').click(function () {
			$('#errorMessImgWithBtn #messageBtn #confirmDelRecipe').unbind('click').click(function(){

			});

			var idRecette = $('#idRecetteSelectToShow').html();
			useAjaxReqestJson('index.php?action=delRecipes', 'POST', 'json', {idRecette: idRecette}, true,true,function (data) {
				if ((Object.keys(data).length === 1) && ("false" in data)) {
					showError("La recette à bien été supprimée !");

				} else {
					showError("Oups ! La recette n'a pas pu être supprimée !");
				}
				animMenuRecipe()
				$('#btnCategory button.allrecipes').click();
				closeErrorWithImgAndBtn('confirmDelRecipe', 'annulDelRecipe');
				$('#idRecetteSelectToShow').html('');
			});
		});
	});
//}

function pushNewIngInRecipe(newOrModif, btnClick, remove, qt, search, annul, ajout, valQt, valIng, valIdIng, valUnit){
	if(newOrModif == 'new'){
		var nbrIng     = document.querySelectorAll('#contentNewFood #contentAllOfNewIng div.whiteSpace');
		var numBlock = '#newBlockFour';
		var numBlockHidden = '#newBlockFour div.hideDivAnim';
	}else{
		var nbrIng = document.querySelectorAll('#contentModifFood #contentAllOfModifIng div.whiteSpace');
		var numBlock = '#modifBlockFour';
		var numBlockHidden = '#modifBlockFour div.hideDivAnim';
	}
	var numId      = nbrIng.length;

var div='<div class="flexrow whiteSpace"><span id ="'+remove+numId+'" class="fa fa-times-circle"></span>';
var div1 = div + '<p id="'+qt+numId+'">'+valQt+'</p>';
var div2 = div1 +  '<p>'+valUnit+'</p>';
var div3 = div2 + '<p id="'+search+numId+'" class="'+valIdIng+'">'+valIng+'</p>';
var div4 = div3 + '<input id="'+ajout+numId+'" type="text" value="" placeholder="Une précision concernant l\'ingrédient ? ex : une marque, un parfum, une couleur..."></div>'

	$(div4).insertBefore($(btnClick));

	resizeDivEtapeFood(numBlock, numBlockHidden);
}
//*****************************************************************************************************************
// pour créer un ingrédient en bdd
//*****************************************************************************************************************
function closeFormToPushNewIng(){


		$('#contentSearchIng').delay(0).animate({'height':'0px'},500);
		$('#bacgroundSearchIng').fadeOut(500)
		$('#contentSearchAndQt').animate({'opacity': '0'}, 500);
		
		$('#contentActionNewIngInBdd').css({'display':'none'});
		$('#listIngOffBdd').css({'display':'none'});
		$('#contentInputAddIng').css({'display':'none'});
		$('#contentSearchAndQt p.legende').css({'display':'none'});
		$('#validAddNewIngInRecipe').css({'display':'none'});
		$('#addNewIngInBdd').css({'display':'none'});
		$('#addNewIngInBdd p.errorPushIngInBdd').css({'display':'none'});

		$('#unitNewIng').html('');
		document.getElementById("insertNewQtIng").value = "1";
		document.getElementById("insertNewIng").value = "";
		document.getElementById("createIngLabel").value = "";
		$('#insertNewIng').attr('class','');
}

function createIngInREcipe(newOrModif, btnClick, remove, qt, search, annul, ajout){
	$('#contentSearchIng').clearQueue();
	$('#contentSearchAndQt').clearQueue();
	$('#bacgroundSearchIng').clearQueue();

	$('#annulInsertNewIngAndQt').css({'display':'block'});	
	$('#contentSearchAndQt p.legende').css({'display':'block'});
	$('#contentInputAddIng').css({'display':'flex'})

	var heightAll = $('#contentSearchAndQt').outerHeight()
	$('#contentSearchIng').delay(0).animate({'height': heightAll}, 300);

	$('#bacgroundSearchIng').fadeIn(300)
	$('#contentSearchAndQt').animate({'opacity': '1'}, 400);

	$('#validAddNewIngInRecipe').click(function(){
		$('#validAddNewIngInRecipe').unbind('click').click(function(){});
			pushNewIngInRecipe(newOrModif, btnClick, remove, qt, search, annul,ajout, $('#insertNewQtIng').val(), $('#insertNewIng').val(), $('#insertNewIng').attr('class'), $('#unitNewIng').html());
			closeFormToPushNewIng()
		});


	$('#annulInsertNewIngAndQt span').click(function(){
		closeFormToPushNewIng()				
	});
	$('#validAddNewIngInBdd').click(function(){
		pushNewIngInBdd()
	});
}
//--------------------------------------------------
function pushNewIngInBdd(){
	$('#contentActionNewIngInBdd').css({'display':'none'});
	$('#MessNoExistInBdd').css({'display':'none'});
	$('#listIngOffBdd').css({'display':'none'});
	$('#contentInputAddIng').css({'display':'none'})
	$('#contentSearchAndQt p.legende').css({'display':'none'})
	$('#addNewIngInBdd p.errorPushIngInBdd').css({'display':'none'});

	$('#addNewIngInBdd').css({'display':'block'});
	$('#addNewIngInBdd p.legende').css({'display':'block'});
			
	resizeDivContentFormPushIng()

	$('#validInsertNewIngAndQt').click(function(){
	newIngUnit  =  document.getElementById("createIngUnit").value; 
	newIngLabel = document.getElementById("createIngLabel").value;

		useAjaxReqestJson('index.php?action=addNewIngBdd', 'POST', 'json', {newIngLabel:newIngLabel, newIngUnit:newIngUnit}, true,true,function(data){
			if((Object.keys(data).length === 1)&&("false" in data)){
				$('#addNewIngInBdd p.errorPushIngInBdd').css({'display':'block'});
				resizeDivContentFormPushIng()
			}else{
				$('#unitNewIng').html(data[0]['unit']);
				document.getElementById("insertNewIng").value = data[0]['title'];
				$('#insertNewIng').attr('class', data[0]['id_ingredient'])
				$('#annulInsertNewIngInBdd').click();
			}
		});
	})
	$('#annulInsertNewIngInBdd').click(function(){
		$('#addNewIngInBdd').css({'display':'none'});
		$('#addNewIngInBdd p.errorPushIngInBdd').css({'display':'none'});
		$('#contentInputAddIng').css({'display':'flex'})
		$('#contentSearchAndQt p.legende').css({'display':'block'});	
		$('#validAddNewIngInRecipe').css({'display':'block'});
		resizeDivContentFormPushIng()
	});

}
//--------------------------------------------------
function resizeListIngBdd(){	
	$('#listIngOffBdd').css({'display':'block'});	
	resizeDivContentFormPushIng()
}
function closeListInBdd(){
	$('#listIngOffBdd').css({'display':'none'});
	resizeDivContentFormPushIng()
}
//--------------------------------------------------
function resizeDivForShowAction(){	

	$('#validAddNewIngInRecipe').css({'display':'none'});
	$('#MessNoExistInBdd').css({'display':'block'});
	$('#contentActionNewIngInBdd').css({'display':'block'});
	resizeDivContentFormPushIng()
}
function closeDivForShowAction(){
	$('#contentActionNewIngInBdd').css({'display':'none'});
	$('#MessNoExistInBdd').css({'display':'none'});
	resizeDivContentFormPushIng()
}

function resizeDivContentFormPushIng(){
		$('#contentSearchIng').clearQueue();
	setTimeout(function(){
		var heightDiv = $('#contentSearchAndQt').outerHeight();
		$('#contentSearchIng').animate({'height': heightDiv},200)
	}, 300)
}
//--------------------------------------------------

searchBar('#insertNewQtIng', '#insertNewIng', '#unitNewIng', '#navListIng', '#validAddNewIngInRecipe');
//*****************************************************************************************************************
// barre de recherche
//*****************************************************************************************************************
function searchBar(idQuantity, idInput, idUnit, ulListIngBdd, idBtnAddIngInrecipe){
		var classActelle = '';

		$(idInput).change(function() {
			if($(idInput).attr('class') == ""){
				$(idInput).attr('value',"")
			}
		});

		$(idInput).focus(function() {
			if($(idInput).attr('class') == ""){
				$(idInput).attr('value',"")
			}
		
			$(idInput).keyup(function(){ // a chaque touche enfoncée
				var valueNp    = $(idInput).val();
				var value      = escapeHtml(valueNp);
				$(idInput).removeClass();

				if(value.length > 1){
					useAjaxReqestJson('index.php?action=searchBarIngredient', 'POST', 'json', {value:value}, true,true,function(data){
						if((Object.keys(data).length === 1)&&("false" in data)){
							resizeDivForShowAction()
							closeListInBdd()
						}else{
							closeDivForShowAction()
							var list = ''; // on les récupère
							for( var i = 0 ; i < data.length ; i++){
								list = list + '<li class="'+data[i]['id_ingredient']+' '+data[i]['unit']+'"><p>'+escapeHtml(data[i]['title'])+'</p><img src=""></li>';
								$(ulListIngBdd).html(list);// on les affiche
								resizeListIngBdd()

								if(($(ulListIngBdd).children('li').length === 1) && (data[i]['title'].toLowerCase() === value.toLowerCase())){ // si la saisie correspond a un des ingredient de la liste

									$(idInput).attr('value', escapeHtml(data[i]['title']));
									$(idInput).attr('class', escapeHtml(data[i]['id_ingredient']));
									$(idUnit).html(data[i]['unit']);
									$(ulListIngBdd).html('');
									closeListInBdd()
									$(idBtnAddIngInrecipe).css({'display':'block'});
									break;
								}
							}
							var elementIng = $(ulListIngBdd).children('li'); 

							$(elementIng).hover(function(){ // en cas de hover sur la liste, on pré-remplis les champs

								var classNewIng= $(this).attr('class');

								var newIdIngredient = classNewIng.split(' ')[0]; // on récupère l'id de l'ingrédient sélectionné
								var newUnitIngredient = classNewIng.split(' ')[1]; // on récupère sa mesure
								var newtitleIngredient = $(this).children('p').html();

								$(idUnit).html(newUnitIngredient); // on affiche la nouvelle
								$(idInput).removeClass(); // on supprime la class actuelle
								$(idInput).addClass(newIdIngredient); // on ajoute à la place l'id du nouvel ingrédient
								$(idInput).val(newtitleIngredient); // on affiche la valeur
							});

							$(elementIng).click(function(){ // lors du click sur l'un des ingrédients, on remplis les champs

								var classNewIng= $(this).attr('class'); 

								var newIdIngredient = classNewIng.split(' ')[0]; // on récupère l'id de l'ingrédient sélectionné
								var newUnitIngredient = classNewIng.split(' ')[1]; // on récupère sa mesure
								var newtitleIngredient = $(this).children('p').html();

								$(idUnit).html(newUnitIngredient);
								$(idInput).removeClass(); // on supprime la class actuelle
								$(idInput).addClass(newIdIngredient); // on ajoute à la place l'id du nouvel ingrédient
								$(idInput).val(newtitleIngredient); // on affiche la valeur

								$(ulListIngBdd).html('');
								$(idBtnAddIngInrecipe).css({'display':'block'});
								closeListInBdd()
							

							});
						}
					});
				}else{
					$(ulListIngBdd).html('');
					closeListInBdd()
					closeDivForShowAction();
				}
			});

		
	});
}
