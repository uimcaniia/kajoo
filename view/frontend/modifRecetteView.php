
<div id="contentModifViewRecipe">

	<div class="flexColumn">
		<div id='modifIdRecette'></div>

		<div id="modifBlockOne" class="flexrow">
			<div id="titleModifRecipe">
				<label for="titleNewModifRecipe"></label> <input type="texte"
					id="titleNewModifRecipe" name="titleNewModifRecipe" value=""
					placeholder="Titre de la recette">
			</div>




		</div>
		<div id="modifBlockTwoTitle" class="flexrow">
            <a href="#modifBlockTwo">INFOS DE LA RECETTE</a>
			<span class="fas fa-sort-down"></span>
		</div>
		<div id="modifBlockTwo">
			<div class="flexrow hideDivAnim">
				<div id="Modiflove"></div>
				<div class="flexrow">
					<p id="categRecipeActuelle"></p>
					<label for="selectModifCateg"></label> <select
						id="selectModifCategRecipe" name="selectModifCateg">
						<option value="0" selected disabled>--Catégorie--</option>

                        <?php
                        if ($aUserCategory != false) {
                            for ($i = 0; $i < count($aUserCategory); $i ++) {
                                $id_category = $aUserCategory[$i]['id_category'];
                                $title = $aUserCategory[$i]['title'];
                                ?>

                                <option value="<?= $id_category ?>"><?= htmlspecialchars($title) ?></option>

                            <?php
                            }
                        }
                        ?>
                        <option value="0">Autres</option>
					</select>
				</div>
				<div id="alphaModifRecipe">
					<label for="alphaNewModifRecipe"> Lettre de récférence : </label>
					<input type="texte" id="alphaNewModifRecipe"
						name="alphaNewModifRecipe" value="" maxlength="1">
				</div>
				<div id="modifPrivateRecipe">
					<span class="fas fa-lock-open"></span>
				</div>
			</div>
		</div>


		<div id="modifBlockThreeTitle" class="flexrow">
            <a href="#modifBlockThree">ATTRIBUTS DE LA RECETTE</a>
			<span class="fas fa-sort-down"></span>
		</div>
		<div id="modifBlockThree">
			<div class="flexrow hideDivAnim">

				<div id="contentModifRecipe" class="flexColumn">
					<div class="flexrow">
						<p>Nombre de personne :</p>
						<span class="fas fa-minus"></span> <span class="fas fa-plus"></span>
						<p id="ModifnbrPeopleRecipe"></p>
					</div>
					<div class="flexrow">
						<p>Temps de préparation :</p>
						<div id="ModiftimePrepareRecipe" class="flexrow"></div>
					</div>
					<div class="flexrow">
						<p>Coût de la recette :</p>
						<span class="fas fa-minus"></span> <span class="fas fa-plus"></span>
						<div id="ModifPriceRecipe" class="flexrow"></div>
					</div>
					<div class="flexrow">
						<p>Difficulté :</p>
						<span class="fas fa-minus"></span> <span class="fas fa-plus"></span>
						<div id="ModifeasyRecipe" class="flexrow"></div>
					</div>
				</div>

				<div id="imgModifRecipe">
					<span class="fas fa-camera"></span>
					<form action="" method="post" enctype="multipart/form-data"
						id="modifFormImgRecipe">
						<input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
						<div id="imgRecipeModif">
							<img src="" id="imgModif">
						</div>
						<div class="flexrow">
							<label for="fileModif"></label> <input type="file" id="fileModif"
								accept="image/*" name="file" /> <span class="flexrow"
								id="parcourirImgRecipeModif">Sélectionner l'image</span> <span
								class="flexrow" id="submitImgRecipeModif" name="valider">Importer
								l'image</span>
							<p></p>
						</div>

						<div></div>
					</form>
				</div>
			</div>
		</div>



		<div id="modifBlockFourTitle" class="flexrow">
            <a href="#modifBlockFour">INGREDIENTS ET ETAPES</a>
			<span class="fas fa-sort-down"></span>
		</div>
		<div id="modifBlockFour">
			<div class="flexrow hideDivAnim">
				<div id="contentModifFoodEtape" class="flexrow">

					<div id="contentModifFood" class="flexColumn">
						<div>
							<p>Ingrédient :</p>
						</div>
						<div id="contentAllOfModifIng">
							<p id="pushIng" class="flexrow"><span class="fas fa-plus"></span>Ajouter un ingrédient à la recette</p>
						</div>
					</div>
					
					<div id="contentModifEtape" class="flexColumn">
						<div class="etapeRecipeFlex">
							<div></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="actionModifRecipe" class="flexColumn">
			<button class="flexrow" id="validModifRecipe">Sauvegarder la recette</button>
			<button class="flexrow" id="annulModifRecipe">Retour</button>
		</div>
	</div>

</div>
