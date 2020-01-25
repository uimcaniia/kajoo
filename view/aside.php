<?php if (isset($_SESSION['idUser'])): ?>

<div id='rappelCookToday'>

<?php
    if ($aPlanningToday == false) :
        ?>

			<div id="suiteRappelMobile" class="flexrow">
		<p>
			Aucun planing de <br>prévus aujourd'hui
		</p>
	</div>
	<div id="suiteRappel" class="flexrow">
		<p>
			<br> <br> <br>Aucun planing de prévus aujourd'hui
		</p>
	</div>

<?php endif;

    if ($aPlanningToday != false) :
        ?>
			<div id="suiteRappelMobile" class="flexrow">
		<p>....... Voir le planning</p>
		<span class="far fa-eye"> </span>
	</div>
	<div id='txtRappelCookToday'>
<?php
        if ($aPlanningToday[0]['title'] != '') :
            ?>

				<p id="titleRappel"><?=$aPlanningToday[0]['title']?></p>

	<?php endif; ?>	

				<p>Petit dej' :</p>
		<div class="listIngRappel flexColumn">

<?php
        for ($i = 0; $i < count($aPlanningToday[0]['id_planningDay']); $i ++) :

            foreach ($aPlanningToday[0]['id_planningDay'][$i] as $key => $value) :
                if (($key == 'rang') && ($value == 0)) :
                    ?>

					<p><?=$aPlanningToday[0]['id_planningDay'][$i]['other']?>, </p>

<?php
			endif;

            endforeach
            ;
        endfor
        ;
        ?>

				</div>
		<p>Déjeuner :</p>
		<div class="listIngRappel flexColumn">

<?php
        for ($i = 0; $i < count($aPlanningToday[0]['id_planningDay']); $i ++) :
            foreach ($aPlanningToday[0]['id_planningDay'][$i] as $key => $value) :
                if (($key == 'rang') && ($value == 1)) :
                    ?>
					<p><?=$aPlanningToday[0]['id_planningDay'][$i]['other']?>, </p>
<?php
			endif;

            endforeach
            ;
        endfor
        ;
        ?>

				</div>
		<p>Dînner :</p>
		<div class="listIngRappel flexColumn">

<?php
        for ($i = 0; $i < count($aPlanningToday[0]['id_planningDay']); $i ++) :
            foreach ($aPlanningToday[0]['id_planningDay'][$i] as $key => $value) :
                if (($key == 'rang') && ($value == 2)) :
                    ?>

					<p><?=$aPlanningToday[0]['id_planningDay'][$i]['other']?>, </p>

<?php
			endif;

            endforeach
            ;
        endfor
        ;
        ?>

				</div>
	</div>
	<div id="suiteRappel" class="flexrow">
		<p>....... Voir le planning</p>
		<span class="far fa-eye"> </span>
	</div>

<?php
endif;

    ?>
	       
	    </div>


<?php endif; ?>
    <?php if (!isset($_SESSION['idUser'])): ?>
   	<?php endif; ?>