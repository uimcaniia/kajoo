
<div id="contentNewViewRecipe">

	<div class="flexColumn">

		<div id='newIdRecette' class=""></div>

		<div id="newBlockOne" class="flexrow">

			<span id="popTitle" class="fas fa-question-circle"></span>
			<div id="titleNewRecipe">
				<label for="newTitleRecipe"></label> <input type="texte"
					id="newTitleRecipe" name="newTitleRecipe" value=""
					placeholder="Titre de la recette">
			</div>
		</div>



		<div id="newBlockTwoTitle" class="flexrow">
			<h4>INFOS DE LA RECETTE</h4>
			<span class="fas fa-sort-down"></span>
		</div>
		<div id="newBlockTwo">
			<div class="flexrow hideDivAnim">
				<div class="flexrow">
					<span id="popHeart" class="fas fa-question-circle"></span>
					<div id="Newlove">
						<span class="fas fa-heart emptySpan"></span>
					</div>
				</div>
				<div class="flexrow">
					<span id="popCateg" class="fas fa-question-circle"></span>
					<p id="categNewRecipe"></p>
					<label for="selectNewCategRecipe"></label> <select
						id="selectNewCategRecipe" name="selectNewCategRecipe">
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
				<div class="flexrow">
					<span id="popAlpha" class="fas fa-question-circle"></span>
					<div id="alphaNewRecipe">
						<label for="newAlphaRecipe"> Lettre de récférence : </label> <input
							type="texte" id="newAlphaRecipe" name="newAlphaRecipe" value=""
							maxlength="1">
					</div>
				</div>
				<div class="flexrow">
					<span id="popPrivate" class="fas fa-question-circle"></span>
					<div id="newPrivateRecipe">
						<span class="fas fa-lock-open"></span>
					</div>
				</div>
			</div>
		</div>

		<div id="newBlockThreeTitle" class="flexrow">
			<h4>ATTRIBUTS DE LA RECETTE</h4>
			<span class="fas fa-sort-down"></span>
		</div>
		<div id="newBlockThree">
			<div class="flexrow hideDivAnim">

				<div id="contentNewRecipeInfos" class="flexColumn">
					<div class="flexrow">
						<span id="popPeople" class="fas fa-question-circle"></span>
						<p>Nombre de personne :</p>
						<span class="fas fa-minus"></span> <span class="fas fa-plus"></span>
						<p id="NewnbrPeopleRecipe"><?=$aUserPref[0]['people_recipe']?></p>

					</div>
					<div class="flexrow">
						<span id="popTimeGlobal" class="fas fa-question-circle"></span>
						<p>Temps de préparation :</p>
						<div id="NewtimePrepareRecipe" class="flexrow"></div>

					</div>
					<div class="flexrow">
						<span id="popPrice" class="fas fa-question-circle"></span>
						<p>Coût de la recette :</p>
						<span class="fas fa-minus"></span> <span class="fas fa-plus"></span>
						<div id="NewPriceRecipe" class="flexrow">
							<div class="price"></div>
						</div>

					</div>
					<div class="flexrow">
						<span id="popEasy" class="fas fa-question-circle"></span>
						<p>Difficulté :</p>
						<span class="fas fa-minus"></span> <span class="fas fa-plus"></span>
						<div id="NeweasyRecipe" class="flexrow">
							<div class="hard"></div>
						</div>

					</div>
				</div>

				<div id="imgNewRecipe">
					<span class="fas fa-camera"></span> <span id="popCam"
						class="fas fa-question-circle"></span>
					<form action="" method="post" enctype="multipart/form-data"
						id="formImgRecipe">
						<input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
						<div id="imgRecipeNew">
							<img src="" id="imgNew">
						</div>
						<div class="flexrow">
							<label for="file"></label> <input type="file" id="file"
								accept="image/*" name="file" /> <span class="flexrow"
								id="parcourirImgRecipeNew">Sélectionner l'image</span> <span
								class="flexrow" id="submitImgRecipeNew" name="valider">Importer
								l'image</span>
							<p></p>
						</div>

						<div></div>
					</form>
				</div>

			</div>
		</div>

		<div id="newBlockFourTitle" class="flexrow">
			<h4>INGREDIENTS ET ETAPES</h4>
			<span class="fas fa-sort-down"></span>
		</div>
		<div id="newBlockFour">
			<div class="flexrow hideDivAnim">
				<div id="contentNewFoodEtape" class="flexrow">

					<div id="contentNewFood" class="flexColumn">
						<div>
							<span id="popIng" class="fas fa-question-circle"></span>
							<p>Ingrédient :</p>
						</div>
						<div id="contentAllOfNewIng">
							<p id="pushNewIng" class="flexrow"><span class="fas fa-plus"></span>Ajouter un ingrédient à la recette</p>
						</div>
 						<!-- <span id="popPushIng" class="fas fa-question-circle"></span> -->
							
						
						
					</div>
					<div id="contentNewEtape" class="flexColumn">
						<span id="popEtape" class="fas fa-question-circle"></span>
						<div class="etapeRecipeFlex">
							<div>
								<div class="flexColumn">
									<div class="flexrow">
										<p>
											<span id="removeEtape0" class="fas fa-minus"></span>
										</p>
										<p>Etape n°</p>
										<p class="numEtape">1</p>
										<p>temps</p>
										<div class="flexrow">
											<label for="newEtapeHour0"></label> <select
												id="newEtapeHour0">
		<?php

for ($j = 0; $j <= 48; $j ++) :
    $dizaine = 0;
    if ($j > 9) :
        $dizaine = '';
        ?>
				<?php endif; ?>

				<?php if($j == 0):?>
												<option selected="selected" value="<?=$dizaine?><?=$j?>"><?=$j?></option>
				<?php else:?>
												<option value="<?=$dizaine?><?=$j?>"><?=$j?></option>
				<?php endif; ?>

		<?php endfor; ?>

											</select>
											<p>H</p>
											<label for="newEtapeMinute0"></label> <select
												id="newEtapeMinute0" class="flexrow">
		<?php

for ($j = 0; $j <= 60; $j ++) :
    $dizaine = 0;
    if ($j > 9) :
        $dizaine = '';
        ?>
				<?php endif; ?>

												<option value="<?=$dizaine?><?=$j?>"><?=$j?></option>
		<?php endfor; ?>				

											</select>
											<p>min</p>
											<label for="newEtapeSecond0"></label> <select
												id="newEtapeSecond0" class="flexrow">

		<?php

for ($j = 0; $j <= 60; $j ++) :
    $dizaine = 0;
    if ($j > 9) :
        $dizaine = '';
        ?>
				<?php endif; ?>
												<option value="<?=$dizaine?><?=$j?>"><?=$j?></option>
		<?php endfor; ?>
											</select>
											<p>sec</p>
										</div>
									</div>
									<div class="flexrow">
										<label for="newEtapeText0"></label>
										<textarea id="newEtapeText0" class="" name="newEtapeText0"
											autocomplete="off" oninput="updateTextareaHeight(this);"></textarea>
									</div>
									<hr>
									<span class="pushEtapeInside fas fa-plus flexrow"><p>Ajouter
											une étape ?</p></span>
									<hr>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="actionNewRecipe" class="flexColumn">
			<button class="flexrow" id="validNewRecipe">Sauvegarder la recette</button>
			<button class="flexrow" id="annulNewRecipe">Retour</button>
		</div>
	</div>

</div>