
<div id="contentModifViewRecipe">

	<div class="flexColumn">
		<div id='modifIdRecette'></div>

		<div  id="modifBlockOne" class="flexrow">			
			<div id="titleModifRecipe">
				<label for="titleNewModifRecipe"></label>
				<input type="texte" id="titleNewModifRecipe" name="titleNewModifRecipe" value="" placeholder="Titre de la recette">
			</div>

			
		
			
		</div>
        <div id="modifBlockTwoTitle" class="flexrow"><h4> INFOS DE LA RECETTE</h4><span class="fas fa-sort-down"></span></div>
		<div id="modifBlockTwo">
			<div class="flexrow hideDivAnim">
				<div id="Modiflove"></div>
				<div class="flexrow">
					<p id="categRecipeActuelle"></p>
					<label for="selectModifCateg"></label>
					<select id="selectModifCategRecipe" name="selectModifCateg">

<?php if ($aUserCategory != false):
	for($i = 0 ; $i < count($aUserCategory) ; $i++):
			$id_category = $aUserCategory[$i]['id_category'];
			$title = $aUserCategory[$i]['title']; ?>
						<option value="<?=$id_category?>"><?=htmlspecialchars($title)?></option>
	<?php endfor;
	endif;?>
                        <option value="0">Autres</option>
					</select>
				</div>
				<div id="alphaModifRecipe">
					<label for="alphaNewModifRecipe"> Lettre de récférence : </label>
					<input type="texte" id="alphaNewModifRecipe" name="alphaNewModifRecipe" value="">
				</div>
                <div id="modifPrivateRecipe">
                    <span class="fas fa-lock-open"></span>
                </div>
			</div>
		</div>


        <div id="modifBlockThreeTitle" class="flexrow"><h4> ATTRIBUTS DE LA RECETTE</h4><span class="fas fa-sort-down"></span></div>
        <div  id="modifBlockThree">
			<div class="flexrow hideDivAnim">

				<div id="contentModifRecipe" class="flexColumn">
					<div class="flexrow">
						<p>Nombre de personne :</p>
						<span class="fas fa-minus"></span>
						<span class="fas fa-plus"></span>
						<p id="ModifnbrPeopleRecipe"></p>
					</div>
					<div class="flexrow">
						<p>Temps de préparation :</p>
						<div id="ModiftimePrepareRecipe" class="flexrow">
						</div>
					</div>
					<div class="flexrow">
						<p>Coût de la recette :</p>
						<span class="fas fa-minus"></span>
						<span class="fas fa-plus"></span>
						<div id="ModifPriceRecipe"></div>
					</div>
					<div class="flexrow">
						<p>Difficulté :</p>
						<span class="fas fa-minus"></span>
						<span class="fas fa-plus"></span>
						<div id="ModifeasyRecipe"></div>
					</div>
				</div>

				<div id="imgModifRecipe">
					<span class="fas fa-camera"></span>
					<form action="" method="post" enctype="multipart/form-data" id="modifFormImgRecipe">
						<input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
						 <div id="imgRecipeModif">
	            			<img src="" id="img">
	        			</div>
                        <div class="flexColumn">
                            <label for="file"></label>
                            <input type="file" id="file" accept="image/*" name="file"/>

                            <span id="submitImgRecipeModif" name="valider">charger</span>
                            <p></p>
                        </div>

						<div>
						</div>
					</form>
				</div>
			</div>
		</div>



        <div id="modifBlockFourTitle" class="flexrow"><h4>INGREDIENTS ET ETAPES</h4><span class="fas fa-sort-down"></span></div>
		<div  id="modifBlockFour">
			<div class="flexrow hideDivAnim">
				<div id="contentModifFoodEtape" class="flexrow">

					<div id="contentModifFood" class="flexColumn">
					</div>
					<div id="contentModifEtape" class="flexColumn">
						<div class="etapeRecipeFlex">
							<div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="actionModifRecipe" class="flexColumn">
			<span class="flexrow" id="validModifRecipe"><p>Sauvegarder la recette</p></span>
			<span class="flexrow" id="annulModifRecipe"><p>Retour</p></span>
		</div>
	</div>

</div>
