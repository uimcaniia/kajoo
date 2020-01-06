<?php if (isset($_SESSION['idUser'])): ?>

           <div id='menuLoging' class="flexColumn">
                <nav id='menu' class='flexrow'>
                    <li id='btnRecette' class="img1">
                        <a href="index.php?action=showRecipeView"></a>
                    </li>
                    <li id='btnPlaning' class="img1">
                        <a href="index.php?action=showPlanningMonth"></a>
                    </li>
                    <li id='btnCourse' class="img1">
                        <a href="index.php?action=showListShop"></a>
                    </li>
                </nav>

                <span id='btnMenuMobile' class="fas fa-bars"></span>
                <span id='btnMenuMobileOff' class="fas fa-minus"></span>
                <nav id='menuMobile' class='flexColumn'>

                    <li id='btnRecette' class="img1">
                        <a href="index.php?action=showRecipeView">Recettes</a>
                    </li>
                    <li id='btnPlaning' class="img1">
                        <a href="index.php?action=showPlanningMonth">Planning</a>
                    </li>
                    <li id='btnCourse' class="img1">
                        <a href="index.php?action=showListShop">Shop</a>
                    </li>
                    <li id='btnUser' class="img1">
                        <a href="index.php?action=space">Compte</a>
                    </li>
                </nav>
                <div id='fondMenuMobile'></div>

            
            </div>
            <div id='login'>
                    <a href="index.php?action=disconnect"><img src='public/img/cerise2.png' alt='pain du site Kajoo'></a>
                    <a href="index.php?action=space">Mon compte</a>
                    <div></div>
            </div>
            <div id='loginMobile'>
                    <a href="index.php?action=disconnect"><span class="fas fa-power-off"></span></a>
            </div>

<?php endif; ?>
<?php if (!isset($_SESSION['idUser'])): ?>

            <div id='menuLoging' class='flexrow'>
                <nav>
                </nav>
            </div>
            <div id='login'>
                    <a href="index.php?action=spaceConnect"><img src='public/img/cerise.png' alt='pain du site Kajoo'></a>

                    <div></div>
            </div>
            <div id='loginMobile'>
                    <a href="index.php?action=spaceConnect"><span class="fas fa-user"></span></a>
            </div>
            
<?php endif; ?>

