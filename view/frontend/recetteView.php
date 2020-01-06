<?php $headTitle = 'Vos recettes'; ?>
<?php ob_start(); ?>
<section id='recetteContainDiv' class='flexColumn'>
	<h1>Vos recettes</h1>
	<hr class="barreTitle">
	<div id="btnCategory">

<?php if( $aUserCategory != false):
		for($i = 0 ; $i <count($aUserCategory) ; $i++): ?>

		<button class="<?=$aUserCategory[$i]['id_category']?>" type="submit" name="<?=$aUserCategory[$i]['title']?>"><?=htmlspecialchars($aUserCategory[$i]['title'])?></button>
<?php endfor; ?>
<?php endif; ?>


		<button class="otherRecipe" type="submit" name="otherRecipe">Autres</button>
		<button class="allrecipes" type="submit" name="allrecipes">Toutes</button>
        <button class="privateRecipes" type="submit" name="privateRecipes">Privées</button>
	</div>
<?php     if($getRelationShip != false): ?>
    <div id="btnCategoryFriend">
<?php   for($i = 0 ; $i <count($getRelationShip) ; $i++): ?>
        <button class="<?=$getRelationShip[$i]['id_friend']?>" type="submit" name="<?=$getRelationShip[$i]['pseudo']?>"><?=htmlspecialchars($getRelationShip[$i]['pseudo'])?></button>
<?php endfor; ?>
    </div>
<?php endif; ?>

	<div id='actionCategory'>
		<div id="menuCategChoice" class="flexrow">
			<h2 class="divAddCateg">Ajouter une catégorie </h2>
			<h2 class="divModifCateg">Modifier le nom d'une catégorie </h2>
			<h2 class="divDelCateg">Supprimer une catégorie </h2>
		</div>
		<div class='flexrow'>
			
			<div id='divAddCateg'>
				<form method="post" class="formLogin">

						<p class='addCateg'></p>
						<label for="addCateg">Choisissez un titre pour votre nouvelle catégorie.</label>
						<input type ="text" id ="addCateg" name ="addCateg" value="" contenteditable ="true" autocomplete="off">
						<label for="selectRangNewCateg">Emplacement</label>
						<select id="selectRangNewCateg" name="selectRangNewCateg">
<?php if(($aUserCategory!=false) && (count($aUserCategory) >0)):
for($i = 0 ; $i <= count($aUserCategory) ; $i++):
		$rang = $i+1;
		$place = $i + 1;
		$libel = 'Place '.$place.''; ?>

							<option value="<?=$rang?>"><?=htmlspecialchars($libel)?></option>
<?php endfor;
 else:?>
                            <option value="1">Place 1</option>
<?php endif; ?>

						</select>

						<span id='validAddCateg' class="divAddCateg">Valider</span>
		
				</form>
			</div>
		</div>

		<div class='flexrow'>
			<div id='divModifCateg'>
				<form method="post">

						<p class='selectModifCateg'></p>
						<label for="selectModifCateg">Choisissez le nom de la catégorie à modifier.</label>
						<select id="selectModifCateg" name="selectModifCateg">

<?php  for($i = 0 ; $i < count($aUserCategory) ; $i++):
		$id_category = $aUserCategory[$i]['id_category'];
		$title = $aUserCategory[$i]['title']; ?>
							<option value="<?=$id_category?>"><?=htmlspecialchars($title)?></option>
<?php endfor;?>

						</select>
						
						<label for="modifCateg">Le modifier en :</label>
						<input type ="text" id ="modifCateg" name="modifCateg" value="" contenteditable ="true" autocomplete="off">
						<span id='validModifLibelCateg' class="divAddCateg">Valider</span>

<?php if(($aUserCategory!=false) && (count($aUserCategory) >1)): ?>
						<label for="selectRangModifCateg">Changer l'emplacement de la catégorie sélectionnée ?</label>
						<select id="selectRangModifCateg" name="selectRangModifCateg">

<?php for($i = 0 ; $i < count($aUserCategory) ; $i++):
		$rang = $i+1;
		$place = $i + 1;
		$libel = 'place '.$place.''; ?>
							<option value="<?=$rang?>"><?=htmlspecialchars($libel)?></option>

<?php endfor; ?>
						</select>
						<span id='validModifRangCateg' class="divAddCateg">Valider</span>
<?php endif; ?>
					

				</form>
			</div>
		</div>


		<div class='flexrow'>
			<div id='divDelCateg'>
				<form method="post">
					
						<p class='selectDelCateg'></p>
						<label for="selectDelCateg">Choisissez la catégorie à supprimer</label>
						<select id="selectDelCateg" name="selectDelCateg">

<?php for($i = 0 ; $i < count($aUserCategory) ; $i++):
		$id_category = $aUserCategory[$i]['id_category'];
		$title = $aUserCategory[$i]['title']; ?>
							<option value="<?=$id_category?>"><?=htmlspecialchars($title)?></option>
<?php endfor; ?>
						</select>
						<span id='validDelCateg' class="divAddCateg">Supprimer</span>
					
				</form>
			</div>
		</div>
	</div>

	<div id='contentNewRecipe'>
		<h2>Nouvelle recette</h2>
		<hr>

		<?php include ('newRecetteView.php'); ?>
	</div>
	<div id='contentRecipesMenu'>
		<div id='recipesAlpha'></div>
		<div id="paginationRecipe"></div>
		<div id='recipes' class="flexColumn">
			<div id="listRecipeGroup"></div>
		</div>
	</div>
	<?php include ('showRecetteView.php'); ?>
	<?php include ('modifRecetteView.php'); ?>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>