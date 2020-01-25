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
                <!--<div id="baniere"></div>-->

	</header>
        <?php include('headerMobile.php') ?>

        <div id="loading">
		<img src="public/img/loading.gif">
	</div>

	<div id="containMessAndError">
		<div id="popupInfo">
			<div class="flexrow">
				<img src="" id="popImg" alt="">
				<p id="popTxt"></p>
			</div>
		</div>
		<div id="errorMessAjax">
			<div class="flexrow">
				<img src="" id="errorMessAjaxImg" alt="">
				<p id="errorMessAjaxTxt"></p>
			</div>
		</div>
		<div id="errorMessSimple">
			<div class="flexrow">
				<img src="" id="errorMessSimpleImg" alt="">
				<p id="errorMessSimpleTxt"></p>
			</div>
		</div>
		<div id="errorMessImgWithBtn">
			<div class="flexrow">
				<img id="imgErrorMess" src="" alt="">
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
				<img id="imgErrorMessNoBtn" src="" alt="">
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

