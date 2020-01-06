
<div id="contentViewRecipe">
	<div id="idRecetteSelectToShow"></div>
	<div id="actionRecipe" class="flexrow">
        <div id="actionRecipeMenuUser"  class="flexrow">
            <span id="closeRecipe" class="fas fa-reply flexrow"><p>Retour</p></span>
            <span class="far fa-edit flexrow" id="modifRecipe"><p>Modifier la recette</p></span>
            <span class="far fa-trash-alt flexrow" id="delRecipe"><p>Supprimer la recette</p></span>
        </div>
        <div id="actionRecipeMenuFriend"  class="flexrow">
            <span id="closeRecipe" class="fas fa-reply flexrow"><p>Retour</p></span>
            <span class="far fa-copy flexrow" id="copyRecipe"><p>Copier la recette</p></span>
        </div>
    </div>

	
	<div class="flexColumn">

		<div class="flexrow">
			<div id="love"></div>
			<div id="titleRecipe"></div>
            <div id="privateRecipe"></div>
		</div>

		<div class="flexrow">

			<div id="contentRecipe" class="flexColumn">
				<div class="flexrow">
					<p>Nombre de personne :</p>
					<p id="nbrPeopleRecipe"></p>
				</div>
				<div class="flexrow">
					<p>Temps de préparation :</p>
					<p id="timePrepareRecipe"></p>
					
				</div>

				<div class="flexrow">
					<p>Coût de la recette :</p>
					<div id="PriceRecipe"></div>
				</div>
				<div class="flexrow">
					<p>Difficulté :</p>
					<div id="easyRecipe"></div>
				</div>

			</div>

			<div id="imgViewRecipe">
				<img src="" id="img">
			</div>

		</div>

		<div id="contentFoodEtape" class="flexrow">
			<div id="contentFood" class="flexColumn"></div>
			<div id="contentEtape" class="flexColumn">
				<div class="etapeRecipeFlex">
					<div></div>
				</div>

			</div>
		</div>
	</div>

</div>