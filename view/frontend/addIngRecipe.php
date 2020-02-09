
	<div id="contentSearchIng">
			<div  id="contentSearchAndQt" class="flexColumn">
				<div id="annulInsertNewIngAndQt">
					<span class="fa fa-times-circle"></span>
				</div>
				<div id="contentInputAddIng" class="flexrow">
					<label for="insertNewQtIng">Quantité : </label>
					<input type="text" placeholder="QT" class="noSearchBarr" id="insertNewQtIng" name="insertNewQtIng" value="1" autocomplete="off" onblur="numberInput(this);">
					<p id="unitNewIng"></p>
					<label for="insertNewIng">Ingrédient à ajouter : </label>
					<input class="" type="text" name ="insertNewIng" id="insertNewIng" placeholder="Ingrédient à ajouter" autocomplete="off">
				</div>
				<p class="legende">Ecrivez le nom de votre ingrédient, et le lexique de Kajoo vous présentera les ingrédients déjà présent que vous pouvez sélectionnez</p>
					
				<div id="listIngOffBdd">

					<ul id="navListIng" class="flexColumn">
					</ul>
					
				</div>
				<button id="validAddNewIngInRecipe">Ajouter !</button>
				

				<div id="contentActionNewIngInBdd">
					<div id="actionNewIngInBdd" class="flexColumn">
						<p id="MessNoExistInBdd">Oups ! Votre ingrédient n'est pas encore enregistré dans notre base de donnée !</p>
						<div id="actionAddNewIngInBdd"  class="flexrow">
							<button class="flexrow" id="validAddNewIngInBdd">Créer un nouvel ingrédient ?</button>
						</div>
					</div>
				</div>

				<div id="addNewIngInBdd">
					<div class="flexColumn">
						<p class="legende">L'ajout d'un nouvel ingrédient dans le lexique doit être au singulier.<p>
						<p class="legende">L'unité de mesure doit être adéquat. Les liquides doivent être en "cl" et les aliments qui s'achète en général à l'unité comme certain fruits et légumes doivent être en "unit". Sinon indiqué "gr" pour la majorité des aliments où si vous ne savez pas quoi mettre.<p>
						<div id="contentInputAddIngInBdd" class="flexrow">
							<label for="createIngUnit">Unité de mesure : </label>
							<select id="createIngUnit" name="createIngUnit"><option value="unit">unit</option><option value="gr">gr</option><option value="cl">cl</option></select>
							<label for="createIngLabel">Ingrédient à créer : </label>
							<input class="" type="text" name ="createIngLabel" id="createIngLabel" placeholder="" autocomplete="off" onblur="verifFormatIng(this);">
						</div>
						<p class=" errorFormatIng"></p>
						<p class="errorPushIngInBdd"></p>
						<p class="legende">L'ajout d'un nouvel ingrédient dans le lexique vous permet de pouvoir l'utiliser directement. Néanmoins, sa création sera signalé à un administrateur et il pourra, suivant certaine condition, modifier (ex : la conjugaison pour éviter un doublon) ou retirer votre ingrédient du lexique (ex : "une chaussure" n'est pas acceptée en tant qu'ingrédient) !<p>
						<div>
							<button id="validInsertNewIngAndQt">Ajouter l'ingrédient !</button>
							<button id="annulInsertNewIngInBdd">Annuler !</button>
						</div>

					</div>

				</div>
			</div>
	</div>


