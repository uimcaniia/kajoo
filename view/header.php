<?php if (isset($_SESSION['idUser'])): ?>

<div id='menuLoging' class="flexColumn">
	<nav id='menu'>
		<ul class='flexrow'>
			<li id='btnHome' class="img1"><img src='public/img/btn/home.png'
				alt='pain du site Kajoo'> <a href="index.php"></a></li>
			<li id='btnRecette' class="img1"><img
				src='public/img/btn/bouton10.png' alt='pain du site Kajoo'> <a
				href="index.php?action=showRecipeView"></a></li>
			<li id='btnPlaning' class="img1"><img
				src='public/img/btn/bouton21.png' alt='pain du site Kajoo'> <a
				href="index.php?action=showPlanningMonth"></a></li>
			<li id='btnCourse' class="img1"><img
				src='public/img/btn/bouton31.png' alt='pain du site Kajoo'> <a
				href="index.php?action=showListShop"></a></li>
			<li id='btnHelp' class="img1"><img src='public/img/btn/aide.png'
				alt='pain du site Kajoo'> <a href="index.php?action=showListShop"></a>
			</li>
			<li id='btnUser' class="img1"><img src='public/img/btn/compte.png'
				alt='pain du site Kajoo'> <a href="index.php?action=space"></a></li>
		</ul>
	</nav>
</div>

<div id='loginContain'>
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
<div id='menuLoging' class="flexColumn">
	<nav id='menu'>
		<ul class='flexrow'>
			<li id='btnHome' class="img1"><img src='public/img/btn/home.png'
				alt='pain du site Kajoo'> <a href="index.php"></a></li>
			<li id='btnRecette' class="img1"><img
				src='public/img/btn/bouton10.png' alt='pain du site Kajoo'> <a
				href="index.php?action=spaceConnect"></a></li>
			<li id='btnPlaning' class="img1"><img
				src='public/img/btn/bouton21.png' alt='pain du site Kajoo'> <a
				href="index.php?action=spaceConnect"></a></li>
			<li id='btnCourse' class="img1"><img
				src='public/img/btn/bouton31.png' alt='pain du site Kajoo'> <a
				href="index.php?action=spaceConnect"></a></li>
			<li id='btnHelp' class="img1"><img src='public/img/btn/aide.png'
				alt='pain du site Kajoo'> <a href="index.php?action=spaceConnect"></a>
			</li>
		</ul>
	</nav>
</div>


<div id='loginContain'>
	<nav>
		<ul>
			<li id='login' class="img1"><img src='public/img/btn/logout2.png'
				alt='pain du site Kajoo'> <a href="index.php?action=spaceConnect"></a>

			</li>

		</ul>
	</nav>

            
<?php endif; ?>

