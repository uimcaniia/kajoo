<!doctype html>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
        <?php include('head.php') ?>
    	<title> <?= $headTitle ?></title>

</head>
<body>

	<header>

		<div id="repairTab"></div>
		<div id="repairMob"></div>
		<div id="repairMobXs"></div>
		<div id='logo'>
			<a href="index.php?"><img src='public/img/logo.png'
				alt='logo du site Kajoo'></a>
			<div></div>
		</div>
                <?php include('header.php') ?>
	</header>
        <?php include('headerMobile.php') ?>

        <div id="loading">
		<img src="public/img/loading.gif" alt="loading kajoo">
	</div>

	<div id="containMessAndError">
		<div id="popupInfo">
			<div class="flexrow">
				<img src="public/img/kajoo/kajoo4.png" id="popImg" alt="image kajoo">
				<p id="popTxt"></p>
			</div>
		</div>
		<div id="errorMessAjax">
			<div class="flexrow">
				<img src="public/img/kajoo/kajoo4.png" id="errorMessAjaxImg" alt="image kajoo">
				<p id="errorMessAjaxTxt"></p>
			</div>
		</div>
		<div id="errorMessSimple">
			<div class="flexrow">
				<img src="public/img/kajoo/kajoo4.png" id="errorMessSimpleImg" alt="image kajoo">
				<p id="errorMessSimpleTxt"></p>
			</div>
		</div>
		<div id="errorMessImgWithBtn">
			<div class="flexrow">
				<img id="imgErrorMess" src="public/img/kajoo/kajoo4.png" alt="image kajoo">
				<p id="messErrorMess"></p>
			</div>
			<div id="messageBtn" class="flexrow">
				<p id='confirmDivInfo'>
					<span class="fas fa-check"></span> Valider
				</p>
				<p id='closeDivInfo'>
					<span class="fas fa-times"></span> Annuler
				</p>
			</div>
		</div>
		<div id="errorMessImgNoBtn">
			<div class="flexrow">
				<img id="imgErrorMessNoBtn" src="public/img/kajoo/kajoo4.png" alt="image kajoo">
				<p id="messErrorMessNoBtn"></p>
			</div>
		</div>
	</div>

<?php include('frontend/addIngRecipe.php') ?>


	<div id="bacgroundBlackWithBtn"></div>
	<div id="bacgroundSearchIng"></div>
	<div id="bacgroundBlack"></div>

             <?= $content ?>

        <footer>
             <?php include('footer.php') ?>
        </footer>



	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>



	<script src="public/js/frontend/script.js"></script>

	<script src="public/js/frontend/recette.js"></script>
	<script src="public/js/frontend/newRecette.js"></script>
	<script src="public/js/frontend/modifRecette.js"></script>

	<script src="public/js/frontend/calendrier.js"></script>
	<script src="public/js/frontend/hebdo.js"></script>

</body>
</html>

