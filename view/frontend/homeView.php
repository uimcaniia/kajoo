<?php $headTitle = 'Accueil Kajoo'; ?>
<?php ob_start(); ?>

<section id='homeSection' class='flexColumn'>
	<p class="errorRouteur"><?=$alertMessRouteur?></p>

	<div class="fondTitle">
		<!--<h1>Bienvenue sur Kajoo!</h1>-->
		<!--<hr class="barreTitle">-->
	</div>
	<hr class="barreTitle">
	<div class="homePresentation">
		<!--<h1>Bienvenue sur Kajoo!</h1>-->
		<h2>Mais qu'est-ce donc?</h2>
		<img class="imgFloatL" src="public/img/kajoo/kajoo4.png"
			alt="kajoo mignon">
		<p>Rien à voir avec la noix qui sert de déco... aucun rapport avec
			elle !</p>
		<p>Et même avec des membres en plus et une bouille toute choupie, ce
			site ne lui est pas consacrée pour autant !</p>
		<br>
		<p>En fait, Kajoo c'est avant tout une interface web (responsive pour
			les mordus du tactile) et qui va vous aider (avec l'aide de la noix)
			à mieux organiser vos recettes de cuisine.</p>
		<br>
	</div>
	<hr class="barreTitle">

	<div class="homePresentation">
		<h2>Heu... c't'à dire?</h2>
		<p>Finis les fiches en vrac, les classeurs où le carnet de
			grand-mamie emplit de tout un tas de recette qui cherche a s'esquiver
			dès la première oportunité présente. Adieu livres aux tailles et
			épaisseurs tellement diversifiées, qu'il est impossible de les
			ranger avec harmonie et dont votre tiroir ressemble plus au dernier
			niveau de Tétris qu'à celui de la ménagère exemplaire.</p>
		<br>

		<p>
			<span class="fas fa-check"></span> Fichtre ! Je ne retrouve plus ma
			recette de muffins? Et on reperd 30 minutes a fouiller les 14
			pochettes avant de se rendre compte que le post-it où on l'avait
			écrit a l'arrache pendant la pub, à fuit votre champ de vision pour
			aller se perdre dans le fin fond du tiroir...
		</p>
		<br>

		<p>
			<span class="fas fa-check"></span>Diantre ! J'aime beaucoup tata
			Zezette, mais ses recettes sur les spécialités Cambodgienne à base
			de foetus de canard ou de tarentules frites, ne sont pas tout à fait
			à mon goût... et à vraie dire, sur les 212 recettes que compose le
			livre qu'elle m'a donné, seule 2 ou 3 me plaisent... 3kg de papier
			qui ne me serviront pas et 630 cm² de tiroir de perdu.
		</p>
		<br>

		<p>
			<span class="fas fa-check"></span>Encore une recette de poulet coco
			dans ce livre? Mais j'en ai déjà plusieurs et... la meilleure est
			quand même celle que j'ai subtilisé dans le magasine de la salle
			d'attente...
		</p>
		<br>

		<p>
			<span class="fas fa-check"></span>Cette recette de pâte à crêpes
			est superbe ! Pourtant, elle est bien meilleure avec du beurre salé
			et une lichette de rhum ! Allez hop ! Grabouillage de 2 ans sur la
			page et on modifie les ingrédients et les quantités ! Note pour
			l'artiste : -2/20.
		</p>
		<br>

		<p>Il est temps de prendre les choses en main ! Economisons notre
			énergie en organisant toutes nos richesses culinaire afin d'avoir
			plus de temps pour l'apéro !</p>
		<img class="imgFloatR" src="public/img/kajoo/kajoo6.png"
			alt="kajoo sournois">
	</div>
	<hr class="barreTitle">
	<div class="homePresentation">
		<h2>Mais que faire?</h2>
		<p>Kajoo est là pour vous aider.</p>
	</div>
	<hr class="barreTitle">
	<div class="homePresentation">
		<h2>Et?</h2>
		<p>En gros, l'application va vous permettre de créer et ranger vos
			recettes, de les modifier, d'ajuster les ingrédients ou le temps de
			préparation de chaque étape, associer une photo, ranger par
			catégories personnalisées selon vos choix etc...</p>
		<p>Vous pourrez les rechercher par ordre alphabétique ou catégorie,
			les partager avec des amis ou copier les leurs pour les modifier par
			la suite à votre sauce !</p>
		<br>
		<p>
			Bref, la flemme de tout expliquer ici... y'à la <a
				href="index.php?action=help">rubrique d'aide</a> qui a été faite
			pour ça.
		</p>
	</div>
	<hr class="barreTitle">

	<div class="homePresentation">
		<h2>Du coup? On se lance?</h2>
		<p>Afin de vous faire profiter pleinement de l'application "Kajoo" et
			de pouvoir sauvegarder vos recettes préférées, nous avons besoin
			de vous créer un tout petit compte de rien du tout.</p>
		<br>
	</div>

	<form method="post" id="formRegistration" class="formLogin"
		action="index.php?action=registration">

		<p class='subEmail'><?= $alertConnectionMail ?></p>
		<label for="subEmail">E-mail</label>
		<p class="legende"></p>
		<input type="email" id="subEmail" name="subEmail" value=""
			placeholder="Votre adresse mail" contenteditable="true"
			autocomplete="off">

		<p class='subPseudo'><?= $alertConnectionPseudo ?></p>
		<label for="subPseudo">Pseudo</label>
		<p class="legende">3 caractères minimum.</p>
		<input type="text" id="subPseudo" name="subPseudo" value=""
			placeholder="Votre pseudo" contenteditable="true" autocomplete="off">

		<p class='subPsw'><?= $alertConnectionPsw ?></p>
		<label for="subPsw">Mot de pass</label>
		<p class="legende">8 caractères minimum avec au moins une majuscule
			et un chiffre</p>
		<input type="password" id="subPsw" name="subPsw" value=""
			placeholder="Votre mot de pass" contenteditable="true"
			autocomplete="off">

		<p class='subPswConfirm'></p>
		<label for="subPswConfirm">Confirmer</label>
		<p class="legende"></p>
		<input type="password" id="subPswConfirm" name="subPswConfirm"
			value="" placeholder="répéter votre mot de pass"
			contenteditable="true" autocomplete="off"> <br> <input type="submit"
			value="Envoyer" name='registration'>

	</form>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>