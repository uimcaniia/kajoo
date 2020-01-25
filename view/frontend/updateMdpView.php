	<?php $headTitle = 'Réinitialisé votre mot de pass'; ?>
<?php ob_start(); ?>
<section>
	<div class="homePresentation">
		<h2>Réinitialisé votre mot de pass?</h2>
	</div>

	<form method="post" class="formLogin"
		action="index.php?action=updateMdp">
		<fieldset>
			<legend></legend>

			<p class='updateEmail'><?= $alertUpdate ?></p>
			<label for="updateEmail"></label> <input type="text" id="updateEmail"
				name="updateEmail" value="" placeholder="Votre adresse mail"
				contenteditable="true" autocomplete="off">

			<p class='updatePsw'></p>
			<label for="updatePsw"></label> <input type="password" id="updatePsw"
				name="updatePsw" value="" placeholder="Votre mot de pass"
				contenteditable="true" autocomplete="off"> <br> <input type="submit"
				value="Go !" name='update'>
		</fieldset>
	</form>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>