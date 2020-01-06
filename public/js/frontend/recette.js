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
	//console.log(idCateg);
	for(var i = 0 ; i < data.length ; i++){
/*		if((idCateg != "") && (idCateg == data[i]['id_category'])){
			selectAnimItem = escapeHtml(data[i]['title']);
			btnMenu   = btnMenu+'<button id ="'+escapeHtml(data[i]['title'])+'"  class="'+data[i]['id_category']+'" type="submit" name="'+escapeHtml(data[i]['title'])+'">'+escapeHtml(data[i]['title'])+'</button>';
		}else{*/
			btnMenu   = btnMenu+'<button id ="'+escapeHtml(data[i]['title'])+'" class="'+data[i]['id_category']+'" type="submit" name="'+escapeHtml(data[i]['title'])+'">'+escapeHtml(data[i]['title'])+'</button>';
		//}
		var nbr   = parseFloat(i)+1; // identifiant des options du select du rang d'affichage
		var libel = 'place '+nbr+''; // libel de l'option du select

		selectRangNewCateg     = selectRangNewCateg + '<option value="'+nbr+'">'+libel+'</option>';
		selectModifCateg       = selectModifCateg + '<option value="'+ data[i]['id_category']+'">'+escapeHtml(data[i]['title'])+'</option>';
		selectRangModifCateg   = selectRangModifCateg+'<option value="'+nbr+'">'+libel+'</option>';
		selectDelCateg         = selectDelCateg+ '<option value="'+ data[i]['id_category']+'">'+escapeHtml(data[i]['title'])+'</option>';
		selectModifCategRecipe = selectModifCategRecipe+ '<option value="'+ data[i]['id_category']+'">'+escapeHtml(data[i]['title'])+'</option>';
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
	$('#contentNewViewRecipe select#selectNewCategRecipe').html(selectModifCategRecipe);
	$('#contentModifViewRecipe select#selectModifCategRecipe').html(selectModifCategRecipe);
	//$('#'+selectAnimItem).delay(200).animate({'opacity':'9'},3000)
}

//*****************************************************************************************************************
//AJAX pour ajouter une catégorie . 
//*****************************************************************************************************************
	$('#validAddCateg').click(function(){
		var newCateg = $('#addCateg').val(); 
		var rangNewCateg = $('#selectRangNewCateg').val(); 

		newCategClean = newCateg.replace(/ |\n|\r|\t/g, ''); // supprime les blancs les retours chariots saut de ligne

		if(newCategClean.length > 2){ // on vérifie qu'il y a plus de 2 caractère minimum
			useAjaxReqestJson('index.php?action=addCategorie', 'POST', 'json', {newCateg:newCategClean, rangNewCateg:rangNewCateg}, function(aData){
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

			useAjaxReqestJson('index.php?action=modifLibelCategorie', 'POST', 'json', {idCategory:idCategory, labelCateg:labelCateg}, function(aData){
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

		useAjaxReqestJson('index.php?action=modifRangCategorie', 'POST', 'json', {idCategory:idCategory, rangCateg:rangCateg}, function(aData){
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
			useAjaxReqestJson('index.php?action=delCategorie', 'POST', 'json', {idcategory:idcategory}, function(aData){
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
		//console.log("idcateg => "+ idcategory+" offset => "+offset+" pageSel => "+pageSelect+" alpha => "+alpha+" friend => "+friend)
				
				closeanimMenuRecipe();
				$('#paginationRecipe').html('');
				$('#recipesAlpha').html('');

		if((idcategory === 'allrecipes')&&(friend==="")){ // si on a cliqué sur le bouton pour tout afficher
			useAjaxReqestJson('index.php?action=countNumberRecipe', 'POST', 'json', {alpha:alpha}, function(dataNumber){
				useAjaxReqestJson('index.php?action=showRecipes', 'POST', 'json', {alpha:alpha, offset:offset}, function(data){
					
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
			//console.log('ok')
			useAjaxReqestJson('index.php?action=countNumberFriendRecipe', 'POST', 'json', {alpha:alpha, idFriend:friend}, function(dataNumber){
				//console.log(dataNumber)
				useAjaxReqestJson('index.php?action=showFriendRecipes', 'POST', 'json', {alpha:alpha, idFriend:friend, offset:offset}, function(data){

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
			useAjaxReqestJson('index.php?action=countNumberPrivateRecipe', 'POST', 'json', {alpha:alpha}, function(dataNumber){
				useAjaxReqestJson('index.php?action=showPrivateRecipes', 'POST', 'json', {alpha:alpha, offset:offset}, function(data){

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
			useAjaxReqestJson('index.php?action=countNumberOtherRecipe', 'POST', 'json', {alpha:alpha}, function(dataNumber){
				useAjaxReqestJson('index.php?action=showOtherRecipes', 'POST', 'json', {alpha:alpha, offset:offset}, function(data){
					
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
			useAjaxReqestJson('index.php?action=countNumberRecipeInCategorie', 'POST', 'json', {alpha:alpha, idcategory:idcategory}, function(dataNumber){
				useAjaxReqestJson('index.php?action=showRecipesCateg', 'POST', 'json', {alpha:alpha, idcategory:idcategory, offset:offset}, function(data){
 				
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
	//$('#recipes').fadeIn(300);
}
	

//*****************************************************************************************************************
//AJAX pour afficher la recette sélectionnée
//*****************************************************************************************************************
function showRecipeSelect(){

	$('#recipes #listRecipeGroup span').click(function(){

		var idRecette = $(this).parent().attr('class');  // on récupère l'id de la recette sélectionnée
		$('#idRecetteSelectToShow').html(idRecette);
		//$('#confirmDelRecipe').addClass(idRecette)
		closeanimMenuRecipe();
		$('#contentNewViewRecipe').fadeOut(0);
		//$('#actionRecipe').html('');

		//------------------------------------------------------
		useAjaxReqestJson('index.php?action=showOneRecipes', 'POST', 'json', {idRecette:idRecette}, function(data){
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
			useAjaxReqestJson('index.php?action=loadImgRecipe', 'POST', 'json', {idRecette:idRecette}, function(dataImg){
				//console.log(dataImg)
				if(Array.isArray(dataImg)){
					$('#imgViewRecipe img').attr("src", dataImg[0]['img_src']);
				}
			});
			//------------------------------------------------------
			$('#nbrPeopleRecipe').html(data[0]['people']); // nombre de personne pour la recette
			$('#timePrepareRecipe').html(data[0]['prepare_time']); // titre
			//------------------------------------------------------
			var spanPrice = '<span class="fas fa-coins emptySpan"></span>'; // cout de la recette
			if (data[0]['price'] === "1"){
				spanPrice = '<span class="fas fa-coins"></span>';
			}
			else{
				spanPrice = '';
				for(var i = 0 ; i < data[0]['price'] ; i++){
					spanPrice = spanPrice + '<span class="fas fa-coins"></span>';
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
			var spanEasy = '<span class="fas fa-pepper-hot emptySpan"></span>'; // difficulté de la recette
			if (data[0]['easy'] === "1"){
				spanEasy = '<span class="fas fa-pepper-hot"></span>';
			}
			else{
				spanEasy = '';
				for(var i = 0 ; i < data[0]['easy'] ; i++){
					spanEasy = spanEasy + '<span class="fas fa-pepper-hot"></span>';
				}
			}
			$('#easyRecipe').html(spanEasy); // facilité
			//------------------------------------------------------
			var ingredient = '<p>Ingrédient :</p>'; // ingrédient de la recette
			for(var i = 0 ; i < data[0]['id_ingredient_recette'].length ; i++){
				ingredient = ingredient + '<p class='+data[0]['id_ingredient_recette'][i]['id_ingredient_recette']+' '+data[0]['id_ingredient_recette'][i]['id_ingredient']+'>'+escapeHtml(data[0]['id_ingredient_recette'][i]['quantity'])+' '+data[0]['id_ingredient_recette'][i]['unit']+' '+escapeHtml(data[0]['id_ingredient_recette'][i]['title'])+'</p>';
			}
			$('#contentFood').html(ingredient);
			//------------------------------------------------------
			var etape = ''; // étape de la recette
			for(var i = 0 ; i < data[0]['id_etape'].length ; i++){
				etape = etape + '<p class='+data[0]['id_etape'][i]['id_etape']+'> temps : '+data[0]['id_etape'][i]['time']+' </p><br><p>'+escapeHtml(data[0]['id_etape'][i]['text'])+'</p><img src="'+data[0]['id_etape'][i]['img']+'" alt=""><hr>';
			}

			$('#contentEtape .etapeRecipeFlex div').html(etape);
			//$('#contentEtape').before('<p>Etapes :</p>')
			$('#modifRecipe').removeClass();
			$('#modifRecipe').addClass('far fa-edit flexrow '+idRecette);
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
});
$('#actionRecipeMenuFriend #closeRecipe').click(function(){
	$('#contentViewRecipe').fadeOut(0);
	animMenuRecipe()
});
//*****************************************************************************************************************
//pour copier une recette
//*****************************************************************************************************************
//function copyRecipe() {
$('#copyRecipe').click(function() {
	showMessWithImgAndBtn(aContainNotice[11][0], aContainImg[0][0], aContainImg[0][1],'confirmCopyRecipe', 'annulCopyRecipe')
	$('#annulCopyRecipe').click(function () {
		$('#errorMessImgWithBtn #messageBtn #annulCopyRecipe').unbind('click').click(function(){
		});
		console.log('annul copy')
		closeErrorWithImgAndBtn('confirmCopyRecipe', 'annulCopyRecipe');
	});
	$('#confirmCopyRecipe').click(function() {
		$('#errorMessImgWithBtn #messageBtn #confirmCopyRecipe').unbind('click').click(function(){
		});
		console.log('ok copy')
		var idRecette = $('#idRecetteSelectToShow').html();
		useAjaxReqestJson('index.php?action=copyRecipes', 'POST', 'json', {idRecette: idRecette}, function (data) {
			if ((Object.keys(data).length === 1) && ("false" in data)) {
				showError("La recette n'a pas pu être copiée correctement !");
			} else {
				showError("La recette a bien été copiée !");
			}
			animMenuRecipe()
			$('#btnCategory button.allrecipes').click();
			closeErrorWithImgAndBtn('confirmCopyRecipe', 'annulCopyRecipe');
		});
	});
});
//}

//*****************************************************************************************************************
//pour supprimer une recette
//*****************************************************************************************************************
//function delRecipe() {
	$('#delRecipe').click(function () {

		showMessWithImgAndBtn(aContainNotice[0][0], aContainImg[0][0], aContainImg[0][1], 'confirmDelRecipe', 'annulDelRecipe');
		$('#annulDelRecipe').click(function () {
			$('#errorMessImgWithBtn #messageBtn #annulDelRecipe').unbind('click').click(function(){

			});
			//console.log('annul del')
			closeErrorWithImgAndBtn('confirmDelRecipe', 'annulDelRecipe');
		});
		$('#confirmDelRecipe').click(function () {
			$('#errorMessImgWithBtn #messageBtn #confirmDelRecipe').unbind('click').click(function(){

			});

			//console.log('ok del')
			var idRecette = $('#idRecetteSelectToShow').html();
			useAjaxReqestJson('index.php?action=delRecipes', 'POST', 'json', {idRecette: idRecette}, function (data) {
				if ((Object.keys(data).length === 1) && ("false" in data)) {
					showError("La recette à bien été supprimée !");
				} else {
					showError("Oups ! La recette n'a pas pu être supprimée !");
				}
				animMenuRecipe()
				$('#btnCategory button.allrecipes').click();
				closeErrorWithImgAndBtn('confirmDelRecipe', 'annulDelRecipe');
			});
		});
	});
//}
//*****************************************************************************************************************
// pour créer un ingrédient en bdd
//*****************************************************************************************************************
function createIngBdd(spanCreate){
	var div = '<p class="borderTop">Enregistré l\'unité de mesure et l\'appelation de cet ingrédient :</p><div class="flexrow">';
	var div2 = div + '<br><label for="createIngUnit"></label><select id="createIngUnit" name="createIngUnit"><option value="unit">unit</option><option value="gr">gr</option><option value="cl">cl</option></select>';
	var div3 = div2 + '<label for="createIngLabel"></label><input type="texte" name ="createIngLabel" id="createIngLabel" placeholder="ingrédient à créer" autocomplete="off"></div>';
	var div4 = div3 + '<div class="flexrow"><span id ="annulCreateNewIng" class="fas fa-times"></span><span id ="validCreateNewIng" class="fas fa-check"></span></div>';
	
	$(div4).insertAfter($(spanCreate));
	$('#createIngLabel').focus();
	$(spanCreate).prev().fadeOut(0);
	$(spanCreate).fadeOut(0);

	$('#annulCreateNewIng').click(function(){ // lorsqu'on quitte, on supprime les div nouvellement créée
		$(spanCreate).prev().fadeIn(100);
		$(spanCreate).fadeIn(100);
		$(spanCreate).next().remove();
		$('#annulCreateNewIng').parent().prev().remove();
		$('#annulCreateNewIng').parent().remove();
	});

	$('#validCreateNewIng').click(function(){ // en cas de validation, on enregistre en BDD
		var regex   = /^\D+$/; 
		newIngUnit  = $('#createIngUnit').val(); 
		newIngLabel = $('#createIngLabel').val();

		if((regex.test(newIngLabel)) && (newIngLabel != '') && (newIngLabel.length>2)){
			useAjaxReqestJson('index.php?action=addNewIngBdd', 'POST', 'json', {newIngLabel:newIngLabel, newIngUnit:newIngUnit}, function(data){
/*			$.post('index.php?action=addNewIngBdd', {newIngLabel:newIngLabel, newIngUnit:newIngUnit}, function(aData){
				return false;*/
			});

		$('#annulCreateNewIng').click(); // on simule le click sur le span de fremeture
		}else{
			$('#validCreateNewIng').parent().prev().prev().html('<p>L\'ingrédient n\'est pas écrit correctement</p>');
		}
		resizeDivEtapeFood('#newBlockFour', '#newBlockFour div.hideDivAnim');
		resizeDivEtapeFood('#modifBlockFour', '#modifBlockFour div.hideDivAnim');
		
	});
}
//*****************************************************************************************************************
// barre de recherche
//*****************************************************************************************************************
function searchBar(idQuantity, idInput, idAnnulIng, idNewIng, idCreateIng){
	var classActelle = '';

	$('#'+idInput).focus(function() {

		classActelle  = $(this).attr('class');
		valueActuelle = $(this).val();
		var showIng   = $(this).parent().next();
		var valueNp   = $(this).val();
		var value     = escapeHtml(valueNp);
  		
		
		$('#'+idInput).keyup(function(){ // a chaque touche enfoncée

			var elemActuel = $(this);
			var valueNp    = $(this).val();
			var value      = escapeHtml(valueNp);
			$(this).removeClass();

			if(value.length > 1){
				useAjaxReqestJson('index.php?action=searchBarIngredient', 'POST', 'json', {value:value}, function(data){
					if((Object.keys(data).length === 1)&&("false" in data)){
						$(showIng).html('<p class="error">Cet ingrédient n\'existe pas dans le lexique...');
					}else{
						var list = '<div><i id="popSearch" class="far fa-question-circle"></i></div>'; // on les récupère

						for( var i = 0 ; i < data.length ; i++){
							list = list + '<span class="'+data[i]['id_ingredient']+' '+data[i]['unit']+'">'+escapeHtml(data[i]['title'])+'</span><br>';
							$(showIng).html(list);// on les affiche

							if(($(showIng).children('span').length === 1) && (data[i]['title'].toLowerCase() === value.toLowerCase())){ // si la saisie correspond a un des ingredient de la liste

								$(elemActuel).attr('value', escapeHtml(data[i]['title']));
								$(elemActuel).prev().prev().prev().attr('value', 1);

								$(elemActuel).prev().prev().html(data[i]['unit']);
								$(elemActuel).addClass(data[i]['id_ingredient']); // on ajoute l'id de l'ingredient en guise de classe

								$('#'+idInput).prev().prev().prev().prev().prev().fadeIn()// affiche le span minus devant l'input qt
								$('#'+idNewIng).fadeIn(100); // affiche "Ajouter un ingrédient à la recette"
								$('#'+idCreateIng).fadeIn(100); // affiche "ajouter un ingrédient au lexique"

								$('#'+idAnnulIng).parent().remove(); // supprime le bouton annulation d'ajout
								$(showIng).html('');
								break;
							}
						}

						var elemenSpanIng = $('#'+idInput).parent().next().children('span'); 

						$(elemenSpanIng).hover(function(){ // en cas de hover sur la liste, on pré-remplis les champs

							var classNewIng= $(this).attr('class');

							var newIdIngredient = classNewIng.split(' ')[0]; // on récupère l'id de l'ingrédient sélectionné
							var newUnitIngredient = classNewIng.split(' ')[1]; // on récupère sa mesure
							var newtitleIngredient = $(this).html();

							var parentQt = $('#'+idQuantity); // sélectionne le input des mesures
							var parentUnit = $(this).parent().prev().children('p');
							var parentLabel = $('#'+idInput); // selection le input pour insérer le nouvel ingrédient
							
							$(parentQt).attr('value', 1); // valeur par défault

							$(parentUnit).empty(); // supprime l'unité de mesure actuelle
							$(parentUnit).html(newUnitIngredient); // on affiche la nouvelle

							$(parentLabel).removeClass(); // on supprime la class actuelle
							$(parentLabel).addClass(newIdIngredient); // on ajoute à la place l'id du nouvel ingrédient
							$(parentLabel).val(newtitleIngredient); // on affiche la valeur
						});

						$(elemenSpanIng).click(function(){ // lors du click sur l'un des ingrédients, on remplis les champs

							var classNewIng= $(this).attr('class'); 

							var newIdIngredient = classNewIng.split(' ')[0]; // on récupère l'id de l'ingrédient sélectionné
							var newUnitIngredient = classNewIng.split(' ')[1]; // on récupère sa mesure
							var newtitleIngredient = $(this).html();

							var parentQt = $('#'+idQuantity); // sélectionne le input des mesures
							var parentUnit = $(this).parent().prev().children('p');
							var parentLabel = $('#'+idInput); // selection le input pour insérer le nouvel ingrédient

							$(parentQt).attr('value', 1);
							$(parentQt).prev().prev().fadeIn(0);
							$('#'+idAnnulIng).parent().remove();

							$('#'+idNewIng).fadeIn(100);
							$('#'+idCreateIng).fadeIn(100);

							$(parentUnit).html(newUnitIngredient);

							$(parentLabel).addClass(newIdIngredient);
							$(parentLabel).val(newtitleIngredient);

							$(this).parent().empty(); // on vide la liste des ingrédients

						});
					}
					return false;
				});
			}
		});
		$('#'+idInput).change(function() {
			if($(this).val().length < 3){
				$(this).attr('value', '');
				$(this).attr('class', '');
			}
			if(($(this).attr('class')=== '')&&($('#okCreateNewIng') === undefined)){
				$(this).addClass(classActelle);
				$(this).val(valueActuelle);
				$(showIng).empty();
			}
		});
	});
}

