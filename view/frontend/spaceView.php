<?php $headTitle = 'Mon compte Kajoo'; ?>
<?php ob_start(); ?>
<section id='userAccompte' class='flexColumn'>

	<h1>Votre compte Kajoo!</h1>
	<hr class="barreTitle">

	<div class="homePresentation">
        <h2>Gérer vos préférences, vos informations et vos comptes associés</h2>
		<p>Kajoo vous permet également d'inviter des amis à vous rejoindre !</p>
        <p>Une fois vos amis associés à votre compte, vos recettes seront ainsi partagées ! Vous pourrez non seulement les consultées,
        mais également les copier sur votre compte pour pouvoir les modifier à votre sauce, où changer le titre ou même la photo !</p>
        <p>Bien sûr, les recettes secrètes peuvent être mises en "privée" et ne seront visible que par vous !</p>
		<div>
           <a href="index.php?action=help">N'hésitez pas à consulter notre aide pour découvrir toutes ses fonctionnalités!</a>
        </div>
    </div>

	<div id='newChangeRefreshSpaceUser'>
		<p><?= $alertOkChange ?></p>
	</div>


	<div id="containSpaceInfoDiv">
<!-- -------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------- -->
		<div id="partOneSpaceUser" class="fleColumn">
<!-- -------------------------------------------------------------------------------------------- -->
			<div id="invitationReceiveContain">
		<?php if( $getInviationReceive != false){?>
                <p>Vous avez <?=count($getInviationReceive)?> inviation(s) <span class="far fa-envelope"></span></p>
				<div id="invitationReceiveTitle" class="flexrow">
					<p>Vos invitations reçue :</p><span class="fas fa-sort-down"></span>
				</div>
				<div id="invitationReceive">
                    <div id="containAllInvitationReceive">

		<?php for($i = 0 ; $i < count($getInviationReceive) ; $i++){ ?>

                        <div class="flexColumn">
                            <p>De <?=htmlspecialchars($getInviationReceive[0]['pseudo'])?> : <?=htmlspecialchars($getInviationReceive[0]['email'])?></p>
                             <div class="flexrow">
                                 <form method="post" class="formLogin" action="index.php?action=acceptFriend">
                                     <input type="hidden" value="<?=$getInviationReceive[0]['id_send']?>" id ="friendIdToAccept" name ="friendIdToAccept">
                                <button type="submit" id="acceptInvit<?=$i?>" name="acceptInvit<?=$i?>">Accepter</button>
                                 </form>
                                 <form method="post" class="formLogin" action="index.php?action=refuseFriend">
                                     <input type="hidden" value="<?=$getInviationReceive[0]['id_send']?>" id ="friendIdToRefuse" name ="friendIdToRefuse">
                                     <button type="submit" id="delInvit<?=$i?>" name="delInvit<?=$i?>">Refuser</button>
                                 </form>
                            </div>
                        </div>

        <?php };?>
                    </div>
				</div>
        <?php }else{ ?>
				<div id="invitationReceiveTitle" class="flexrow">
					<p>Vous n'avez pas reçue d'inviation pour le moment.</p>
				</div>
				<div id="invitationReceive" class="flexColumn"></div>
			<?php }?>
			</div>
<!-- -------------------------------------------------------------------------------------------- -->
         <?php if( $getInviationSend != false){?>
			<div id="invitationSendContain" class="<?=count($getInviationSend)?>">

                <p class="legende">Vous avez envoyé <?=count($getInviationSend)?> inviation(s) qui est en attente de réponse.</p>
				<div id="invitationSendTitle" class="flexrow">
					<p>Vos invitations envoyées :</p><span class="fas fa-sort-down"></span>
				</div>
				<div id="invitationSend">
                    <div id="containAllInvitation">
		<?php
        for($i = 0 ; $i < count($getInviationSend) ; $i++){ ?>
                        <div id="<?=$getInviationSend[$i]['id_receive']?>" class="flexColumn childInvit" >
                            <p>Pour <?=htmlspecialchars($getInviationSend[$i]['pseudo'])?> : <?=htmlspecialchars($getInviationSend[$i]['email'])?></p>
                            <div class="flexrow">
                                <p>Voulez-vous l'annuler?</p>
                                <button type="submit" class="<?=$getInviationSend[$i]['id_receive']?>" id="annulInvit<?=$i?>" name="annulInvit<?=$i?>">Annuler</button>
                            </div>
                        </div>
		<?php };?>

                    </div>
                </div>
            </div>
           <?php  }else{ ?>
            <div id="invitationSendContain" class="0">
				<div id="invitationSendTitle" class="flexrow">
					<p>Vous n'avez pas d'inviation envoyées en attente.</p>
				</div>
		<?php }?>
				<div>
					<p>Voulez-vous envoyer une invitation?</p>
                    <form method="post" id="formInvitationToSend" class="formLogin" action="index.php?action=inviteFriend">
                        <div >
                            <label for="friendEmail"  class="legende">E-mail de votre ami(e) :</label><br>
                            <div class="flexrow">
                                <input type ="email" id ="friendEmail" name ="friendEmail" value="" placeholder="" contenteditable ="true" autocomplete="off">
                                <button type="submit" id="sendInvitationToFriend" name="sendInvitationToFriend">Inviter</button>
                            </div>
                            <p id="errorMessInvitation"><?=$errorInvitMailFriend?></p>
                        </div>
                    </form>
				</div>
			</div>
			

<!-- -------------------------------------------------------------------------------------------- -->
			<div id="relationShipContain">
	<?php if( $getRelationShip != false){?>

				<div id="relationShipTitle" class="flexrow">
					<p>Vos amis (<?=count($getRelationShip)?>):</p><span class="fas fa-sort-down"></span>
				</div>
				<div id="relationShip">
                     <div id="containAllRelation">

		<?php for($i = 0 ; $i < count($getRelationShip) ; $i++){ ?>

                        <div id="relationShip<?=$i?>" class="<?=$getRelationShip[$i]['id_friend']?>">
                            <div>
                                <p>Pseudo : <?=htmlspecialchars($getRelationShip[$i]['pseudo'])?></p>
                                <p>Mail :  <?=htmlspecialchars($getRelationShip[$i]['email'])?></p>
                            </div>
<!--                            <div id="autorisation<?/*=$i*/?>">
                                <label for="modifPlanning">Autoriser à modifier votre planning ?</label>
                                <input type="checkbox" id="modifPlanning" name="modifPlanning" value="modifPlanning">
                                <label for="modifRecipe">Autoriser à modifier vos recettes ?</label>
                                <input type="checkbox" id="modifRecipe" name="modifRecipe" value="modifRecipe">
                                <button type="submit" id="validRelation<?/*=$i*/?>" name="validRelation<?/*=$i*/?>"></button>
                            </div>-->

                            <div id="deleteRelation<?=$i?>">
                                <form method="post" class="formLogin" action="index.php?action=delFriend">
                                    <input type="hidden" value="<?=$getRelationShip[$i]['id_friend']?>" id ="friendIdToDelete" name ="friendIdToDelete">
                                    <p>Supprimer cet ami(e) de vos partages?</p>
                                    <button type="submit" id="delFriendRelation<?=$i?>" name="delFriendRelation<?=$i?>">Supprimer</button>
                                </form>
                            </div>
                        </div>

		<?php }; 
		}else{ ?>
                        <div id="relationShipTitle" class="flexrow">
                            <p>Vous n'avez pas encore de compte ami Kajoo associé.</p>
                        </div>
				<?php }; ?>
                     </div>
                </div>
			</div>
<!-- -------------------------------------------------------------------------------------------- -->
		</div>
<!-- -------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------- -->




		<div id="partTwoSpaceUser" class="fleColumn">

			<form method="post" class="formLogin" action="index.php?action=changePref">
				<fieldset>
					<legend> Gérer vos infos !</legend>
					<!-- fake inputs to avoid chrome autofills the wrong fields -->
					<input style="display:none" type="password" name="fakepasswordremembered"/>

					<p class='newEmail'><?= $alertErrorMail ?></p>
					<label for="newEmail">Votre nouvel e-mail</label><br>
					<input type ="email" id ="newEmail" name ="newEmail" value="" placeholder="<?=htmlspecialchars($getInfosUser[0]['email'])?>" contenteditable ="true" autocomplete="off">


					<p class='newPseudo'><?= $alertErrorPseudo ?></p>
					<label for="newPseudo">Votre nouveau pseudo</label><br>
                    <p class="legende">3 caractères minimum.</p>
					<input type ="text" id ="newPseudo" name ="newPseudo" value="" placeholder="<?=htmlspecialchars($getInfosUser[0]['pseudo'])?>" contenteditable ="true" autocomplete="off">

					<p class='newPsw'><?= $alertErrorPsw ?></p>
					<label for="newPsw">Votre nouveau mot de pass</label><br>
                    <p class="legende">8 caractères minimum avec au moins une majuscule et un chiffre</p>
					<input type ="password" id ="newPsw" name ="newPsw" value="" placeholder="" contenteditable ="true" autocomplete="off">

					<p class='newPswConfirm'></p>
					<label for="newPswConfirm">répéter votre mot de pass</label><br>
					<input type ="password" id ="newPswConfirm" name ="newPswConfirm" value="" placeholder="" contenteditable ="true" autocomplete="off">
				</fieldset>

				<fieldset>
					<legend> Gérer vos paramètres comme un grand !</legend>

					<p class='nbrPeople'><?= $alertErrorNbrPeople ?></p>
					<label for="nbrPeople">Nombre de personne par défault pour la créations de recette</label><br>
                    <p class="legende">Ce nombre pourra être si besoin, changé lors de l'édition de recette.</p>
					<input type ="text" id ="nbrPeople" name ="nbrPeople" value="" placeholder="<?=$_SESSION['people_recipe']?>" contenteditable ="true" autocomplete="off">
					<br>
                    <p class='nbrPagination'><?= $alertErrorPagination ?></p>
                    <label for="nbrPagination">Nombre de recette par pages</label><br>
                    <p class="legende"></p>
                    <input type ="text" id ="nbrPagination" name ="nbrPagination" value="" placeholder="<?=$_SESSION['limit_pagination']?>" contenteditable ="true" autocomplete="off">
                    <br>
				</fieldset>

					<input type="submit" value="Envoyer" name='changePref'>
				
			</form>
		</div>
	</div>



</section>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>