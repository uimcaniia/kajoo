<?php if (isset($_SESSION['idUser'])): ?>


<span id='btnMenuMobile' class="fas fa-bars"></span>
<span id='btnMenuMobileOff' class="fas fa-minus"></span>
<div id='fondMenuMobile'>
	<nav id='menuMobile'>
		<ul class='flexColumn'>
			<li id='btnHome' class="img1"><img src='public/img/btn/home.png'
				alt='pain du site Kajoo'>
				<hr> <a href="index.php">ACCUEIL</a>
				<hr></li>
			<li id='btnRecette' class="img1"><img
				src='public/img/btn/bouton10.png' alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=showRecipeView">RECETTES</a>
				<hr></li>
			<li id='btnPlaning' class="img1"><img
				src='public/img/btn/bouton21.png' alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=showPlanningMonth">PLANNING</a>
				<hr></li>
			<li id='btnCourse' class="img1"><img
				src='public/img/btn/bouton31.png' alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=showListShop">COURSE</a>
				<hr></li>
			<li id='btnHelp' class="img1"><img src='public/img/btn/aide.png'
				alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=showListShop">AIDE</a>
				<hr></li>
			<li id='btnUser' class="img1"><img src='public/img/btn/compte.png'
				alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=space">COMPTE</a>
				<hr></li>
		</ul>
	</nav>
</div>

<div id='loginMobile'>
	<nav>
		<ul>
			<li id='login' class="img1"><img src='public/img/btn/logout.png'
				alt='pain du site Kajoo'> <a href="index.php?action=disconnect"></a>

			</li>
		</ul>
	</nav>
</div>


<?php endif; ?>
<?php if (!isset($_SESSION['idUser'])): ?>



<span id='btnMenuMobile' class="fas fa-bars"></span>
<span id='btnMenuMobileOff' class="fas fa-minus"></span>
<div id='fondMenuMobile'>
	<nav id='menuMobile'>
		<ul class='flexColumn'>
			<li id='btnHome' class="img1"><img src='public/img/btn/home.png'
				alt='pain du site Kajoo'>
				<hr> <a href="index.php">ACCUEIL</a>
				<hr></li>
			<li id='btnRecette' class="img1"><img
				src='public/img/btn/bouton10.png' alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=spaceConnect">RECETTES</a>
				<hr></li>
			<li id='btnPlaning' class="img1"><img
				src='public/img/btn/bouton21.png' alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=spaceConnect">PLANNING</a>
				<hr></li>
			<li id='btnCourse' class="img1"><img
				src='public/img/btn/bouton31.png' alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=spaceConnect">COURSE</a>
				<hr></li>
			<li id='btnHelp' class="img1"><img src='public/img/btn/aide.png'
				alt='pain du site Kajoo'>
				<hr> <a href="index.php?action=spaceConnect">AIDE</a>
				<hr></li>
		</ul>
	</nav>
</div>


<div id='loginMobile'>
	<nav>
		<ul>
			<li id='login' class="img1"><img src='public/img/btn/logout2.png'
				alt='pain du site Kajoo'> <a href="index.php?action=spaceConnect"></a>

			</li>
		</ul>
	</nav>
</div>


<?php endif; ?>

