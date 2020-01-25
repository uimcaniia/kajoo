	<?php $headTitle = 'se connecter sur Kajoo'; ?>
<?php ob_start(); ?>
<section id='loginSection' class='flexColumn'>
	<div class="homePresentation">
		<h2>Déjà sur Kajoo?</h2>
	</div>

	<form method="post" class="formLogin" action="index.php?action=connect">
		<fieldset>
			<legend>
				Connectez vous <span class='fas fa-user'></span>
			</legend>

			<p class='logEmail'><?= $alert ?></p>
			<label for="logEmail">E-mail</label> <input type="email"
				id="logEmail" name="logEmail" value=""
				placeholder="Votre adresse mail" contenteditable="true"
				autocomplete="off">

			<p class='logPsw'></p>
			<label for="logPsw">Mot de pass</label> <input type="password"
				id="logPsw" name="logPsw" value="" placeholder="Votre mot de pass"
				contenteditable="true" autocomplete="off"> <br> <input type="submit"
				value="Envoyer" name='connect'>
		</fieldset>
	</form>
	<div class="homePresentation">
		<h2>Mot de pass perdu?</h2>
	</div>
	<form method="post" class="formLogin" action="index.php?action=lostMdp">
		<fieldset>
			<p class='logEmail'><?= $alertLost ?></p>
			<label for="lostMdpEmail">E-mail</label> <input type="email"
				id="lostMdpEmail" name="lostMdpEmail" value=""
				placeholder="Votre adresse mail" contenteditable="true"
				autocomplete="off"> <br> <input type="submit" value="Envoyer"
				name='lostMdp'>
		</fieldset>
	</form>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>