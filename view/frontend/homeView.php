<?php $headTitle = 'Accueil Kajoo'; ?>
<?php ob_start(); ?>

<section id='homeSection' class='flexColumn'>
	<p class="errorRouteur"><?=$alertMessRouteur?></p>
	<div class="flexrow" id="friseKajoo">
		<img src="public/img/kajoo/kajoo2.png" alt="kajoo bienvenue">
		<img src="public/img/kajoo/kajoo2.png" alt="kajoo bienvenue">
		<img src="public/img/kajoo/kajoo2.png" alt="kajoo bienvenue">
		<img src="public/img/kajoo/kajoo2.png" alt="kajoo bienvenue">
		<img src="public/img/kajoo/kajoo2.png" alt="kajoo bienvenue">
	</div>
	<h1>Bienvenue sur Kajoo!</h1>
	<hr class="barreTitle">

	<div class="homePresentation"><h2>Comment fonctionne Kajoo?</h2>
		<p>Kajoo c'est avant tout une application qui vous aide à mieux gérer vos plannings alimentaires</p><br>
		<p>Que ce soit pour l'alimentation de la famille, vos recettes préférerées, une gestion de votre programme alimentaire, les courses à prévoir pour vous où votre famille... Kajoo est là pour se souvenir pour vous!</p><br>
		<p> Plus besoin de liste de course papier qui va se perdre dans la poche, plus besoin de livre de recette qui remplis tous les placards...</p>
		<p>On conçoit son programme sur son ordinateur, tablette ou smartphone, et on l'emmène ensuite avec nous!</p><br>
		<div>
            <a href="index.php?action=help">N'hésitez pas à consulter notre aide pour découvrir ses fonctionnalités!</a>
        </div>
	</div>

	<div class="homePresentation">
		<h2>Nouveau sur Kajoo?</h2>
		<p>Afin de vous faire profiter pleinement de l'application "Kajoo", nous avons besoin de vous créer un compte.</p><br>
		<p>Ce compte nous permettra de sauvegarder vos recettes, votre planning ainsi que vos listes de course.</p>
	</div>

	<form method="post"  class="formLogin" action="index.php?action=registration">
		

			<p class='subEmail'><?= $alertConnectionMail ?></p>
			<label for="subEmail">E-mail</label>
			<input type ="email" id ="subEmail" name ="subEmail" value="" placeholder="Votre adresse mail" contenteditable ="true" autocomplete="off">

			<p class='subPseudo'><?= $alertConnectionPseudo ?></p>
			<label for="subPseudo">Pseudo</label>
			<input type ="text" id ="subPseudo" name ="subPseudo" value="" placeholder="Votre pseudo" contenteditable ="true" autocomplete="off">

			<p class='subPsw'><?= $alertConnectionPsw ?></p>
			<label for="subPsw">Mot de pass</label>
			<input type ="password" id ="subPsw" name ="subPsw" value="" placeholder="Votre mot de pass" contenteditable ="true" autocomplete="off">

			<p class='subPswConfirm'></p>
			<label for="subPswConfirm">Confirmer</label>
			<input type ="password" id ="subPswConfirm" name ="subPswConfirm" value="" placeholder="répéter votre mot de pass" contenteditable ="true" autocomplete="off">
			<br>
			<input type="submit" value="Envoyer" name='registration'>
		
	</form>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>