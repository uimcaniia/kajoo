<?php $headTitle = 'Error Kajoo'; ?>
<?php ob_start(); ?>

<section id='errorSection' class='flexColumn'>
	<div>
		<div>
			<p>Oups ! <?= $errorPhpMess ?></p>
		</div>
		<div id="imgErrorPhpView">
			<img src="public/img/kajoo/kajoo5.png">
		</div>
	</div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>