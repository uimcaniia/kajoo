<?php $headTitle = 'Votre planning du mois'; ?>
<?php ob_start(); ?>

<section id="planningContainer" class="flexColumn">
	<div id="divPlanningMonthAndWeek" class='flexrow'>
		<span id="ShowCurentMonth" class="far fa-calendar-alt flexrow"><p>Afficher
				le mois en cour</p></span> <span id="ShowCurentWeek"
			class="far fa-calendar-alt flexrow"><p>Afficher la semaine en cour</p></span>
	</div>
	<div class="flexrow calendrier">
		<div id="calendar" class="calendar"></div>
		<div id="calendarEvent">

			<div id="nothingEvent">
				<p>Rien de prévus</p>
				<div id="addEventCalendar" class="flexrow">
					<p>Modifier la journée?</p>
					<span class="far fa-eye"></span>
				</div>
			</div>
			<div id="contentPlaningMonthDay">
				<p id="titleEventView"></p>
				<p id="dateView"></p>

				<div class="breakfast flexColumn">
					<p>Petit déjeuner:</p>
					<div class="flexColumn"></div>

				</div>
				<div class="lunch flexColumn">
					<p>Déjeuner:</p>
					<div class="flexColumn"></div>

				</div>
				<div class="dinner flexColumn">
					<p>Dîner:</p>
					<div class="flexColumn"></div>

				</div>
				<div id="modiEventCalendar" class="flexrow">
					<p>Modifier la journée?</p>
					<span class="far fa-eye"></span>
				</div>
			</div>

		</div>
	</div>
<?php include ('planingweekView.php'); ?>
</section>



<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>