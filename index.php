<?php
session_start();
require "vendor/autoload.php";

require ('controller/frontend.php');
require ('controller/categories.php');
require ('controller/load.php');
require ('controller/recettes.php');
require ('controller/planning.php');

try {
    if (isset($_GET['action'])) {
        // *******************************************************************************
        // si on veut consulter la FAQ
        // *******************************************************************************
        if ($_GET['action'] == 'help') {
            showListShop();
        }
        // *******************************************************************************
        // accueil du site
        // *******************************************************************************
        if ($_GET['action'] == 'spaceHome') {
            spaceHome();
        }
        // *******************************************************************************
        // espace client
        // *******************************************************************************
        if ($_GET['action'] == 'spaceConnect') {
            spaceConnect();
        }
        // *******************************************************************************
        // pour afficher l'espace pour changer son mdp
        // *******************************************************************************
        if ($_GET['action'] == 'spaceUpdatePsw') {
            spaceUpdatePsw();
        } // *******************************************************************************
          // pour envoyer un mail avec un lien pour refaire son mot de passe
          // *******************************************************************************
        elseif ($_GET['action'] == 'lostMdp') {
            if (isset($_POST['lostMdpEmail'])) {
                lostMdp($_POST['lostMdpEmail']);
            } else {
                throw new Exception('Aucun mail envoyé pour récupérer le mot de passe');
            }
        } // *******************************************************************************
          // pour changer son mdp
          // *******************************************************************************
        elseif ($_GET['action'] == 'updateMdp') {
            if (isset($_POST['updateEmail']) && isset($_POST['updatePsw'])) {
                updateMdp($_POST['updateEmail'], $_POST['updatePsw']);
            } else {
                throw new Exception('Aucun mail ou mdp envoyé pour réinitialiser le mot de passe');
            }
        } // *******************************************************************************
          // pour se connecter
          // *******************************************************************************
        elseif ($_GET['action'] == 'connect') {
            if (isset($_POST['logEmail']) && isset($_POST['logPsw'])) {
               testErrorLog($_POST['logEmail'], $_POST['logPsw']);
            } else {
                throw new Exception('Aucun mail ou mdp envoyé pour se connecter');
            }
        }

         elseif ($_GET['action'] == 'registration') // ou créer son compte
        {
            if (isset($_POST['subEmail']) && isset($_POST['subPsw']) && isset($_POST['subPseudo']) && isset($_POST['subPswConfirm'])) {
                testErrorSubscribe($_POST['subEmail'], $_POST['subPseudo'], $_POST['subPsw'], $_POST['subPswConfirm']);
            } else {
                throw new Exception('Aucun mail ou mdp envoyé pour s\'inscrire');
            }
        } // *******************************************************************************
          // ESPACE POUR SE DECONNECTER
          // *******************************************************************************
        elseif ($_GET['action'] == 'disconnect') {
            disconnect();
            // spaceConnect();
        } // *******************************************************************************
          // ESPACE CONNECTE
        elseif ($_GET['action'] == 'space') // si on veut aller dans son espace.
        {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) // test id pour les utilisateur
            {
                spaceUser("", "", "", "", "", "", ""); // va dans l'espace utilisateur
            } elseif (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                admin(); // va dans l'espace admin
            } else {
                throw new Exception('Aucun compte n\'a été trouvé');
            }
        } // *******************************************************************************
          // Changer les préférence du compte
        elseif ($_GET['action'] == 'changePref') {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
                if (isset($_POST['newEmail']) && isset($_POST['nbrPagination']) && isset($_POST['newPseudo']) && isset($_POST['newPsw']) && isset($_POST['newPswConfirm']) && isset($_POST['nbrPeople'])) // test text de la nouvelle catégorie
                {
                    changePref($_POST['newEmail'], $_POST['newPseudo'], $_POST['newPsw'], $_POST['newPswConfirm'], $_POST['nbrPeople'], $_POST['nbrPagination']);
                } else {
                    throw new Exception('Aucune données pour la mise à jour des préférences');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé');
            }
        } // *******************************************************************************
          // inviter un ami kajoo
        elseif ($_GET['action'] == 'inviteFriend') {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
                if (isset($_POST['friendEmail'])) {
                    inviteFriend($_POST['friendEmail']);
                } else {
                    throw new Exception('Aucun mail n\'est trouvé pour envoyer l\'invitation');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour envoyer l\'invitaion');
            }
        } // *******************************************************************************
          // inviter un ami kajoo
        elseif ($_GET['action'] == 'annulInviteFriend') {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
                if (isset($_POST['friendId'])) {
                    annulInviteFriend($_POST['friendId']);
                } else {
                    throw new Exception('Aucun compte ami n\'est trouvé pour annuler l\'invitation');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour envoyer l\'invitaion');
            }
        } // *******************************************************************************
          // accepter la demande d'ami d'un ami kajoo
        elseif ($_GET['action'] == 'acceptFriend') {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
                if (isset($_POST['friendIdToAccept'])) {
                    acceptFriend($_POST['friendIdToAccept']);
                } else {
                    throw new Exception('Aucun compte ami n\'est trouvé pour accepter son invitation');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour accepter l\'invitaion');
            }
        } // *******************************************************************************
          // refuser la demande d'ami d'un ami kajoo
        elseif ($_GET['action'] == 'refuseFriend') {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
                if (isset($_POST['friendIdToRefuse'])) {
                    refuseFriend($_POST['friendIdToRefuse']);
                } else {
                    throw new Exception('Aucun compte ami n\'est trouvé pour refuser son invitation');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour refuser l\'invitaion');
            }
        } // *******************************************************************************
          // supprimer un ami kajoo
        elseif ($_GET['action'] == 'delFriend') {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
                if (isset($_POST['friendIdToDelete'])) {
                    delFriend($_POST['friendIdToDelete']);
                } else {
                    throw new Exception('Aucun compte ami n\'est trouvé pour supprimer cette invitation');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer cette invitation');
            }
        } // *******************************************************************************
          // ESPACE CONNECTE
        elseif ($_GET['action'] == 'showRecipeView') // zone recette
        {
            if (isset($_SESSION['idUser']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 0) // test id pour les utilisateur
            {
                showRecipeView(); // va dans l'espace utilisateur
            } else {
                throw new Exception('Aucun compte n\'a été trouvé');
            }
        } // *******************************************************************************
          // Ajouter une catégorie de recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'addCategorie') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['newCateg']) && isset($_POST['rangNewCateg'])) // test text de la nouvelle catégorie
                {
                    addCategorie($_POST['newCateg'], $_POST['rangNewCateg']);
                } else {
                    throw new Exception('Aucun nom n\'est trouvé pour la nouvelle catégorie');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour ajouter une catégorie, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // modifier une catégorie de recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'modifLibelCategorie') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idCategory']) && isset($_POST['labelCateg'])) // test id de la recette a modifier
                {
                    modifLibelCategorie($_POST['idCategory'], $_POST['labelCateg']);
                } else {
                    throw new Exception('Aucune categorie n\'est trouvée pour la modifier');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour modifier une catégorie, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // modifier le rang d'une catégorie de recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'modifRangCategorie') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idCategory']) && isset($_POST['rangCateg'])) // test id de la recette a modifier
                {
                    modifRangCategorie($_POST['idCategory'], $_POST['rangCateg']);
                } else {
                    throw new Exception('Aucune categorie n\'est trouvée pour modifier son rang');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour modifier le rang de la catégorie, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // Ajouter une catégorie de recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'delCategorie') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idcategory']) && $_POST['idcategory'] > 0) // test id de la recette a modifier
                {
                    delCategorie($_POST['idcategory']);
                } else {
                    throw new Exception('Aucune categorie n\'est trouvée pour la supprimer');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer une catégorie, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // voir les recettes de la catégorie
          // *******************************************************************************
        elseif ($_GET['action'] == 'showRecipesCateg') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idcategory']) && ($_POST['idcategory'] > 0) && (isset($_POST['offset'])) && (isset($_POST['alpha']))) // test id de la categorie
                {
                    showRecipesCateg($_POST['idcategory'], $_POST['offset'], $_POST['alpha']);
                } else {
                    throw new Exception('Aucune categorie n\'est trouvée pour sélectionner les recettes');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour afficher les recettes de la catégorie, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // voir les recettes des amis
          // *******************************************************************************
        elseif ($_GET['action'] == 'showFriendRecipes') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idFriend']) && ($_POST['idFriend'] > 0) && (isset($_POST['offset'])) && (isset($_POST['alpha']))) // test id de la categorie
                {
                    showFriendRecipes($_POST['idFriend'], $_POST['offset'], $_POST['alpha']);
                } else {
                    throw new Exception('Aucune categorie n\'est trouvée pour sélectionner les recettes');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour afficher les recettes de la catégorie, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // voir les recettes sans catégorie
          // *******************************************************************************
        elseif ($_GET['action'] == 'showOtherRecipes') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if ((isset($_POST['offset'])) && (isset($_POST['alpha']))) // test id pour les utilisateur
                {
                    showOtherRecipes($_POST['offset'], $_POST['alpha']);
                } else {
                    throw new Exception('Aucune categorie "autre" n\'est trouvée pour sélectionner les recettes');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour afficher les recettes sans catégorie, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // voir les recettes privée
          // *******************************************************************************
        elseif ($_GET['action'] == 'showPrivateRecipes') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if ((isset($_POST['offset'])) && (isset($_POST['alpha']))) // test id pour les utilisateur
                {
                    showPrivateRecipes($_POST['offset'], $_POST['alpha']);
                } else {
                    throw new Exception('Aucune categorie "privée" n\'est trouvée pour sélectionner les recettes');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour afficher les recettes privée, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // voir toutes les recettes
          // *******************************************************************************
        elseif ($_GET['action'] == 'showRecipes') {
            if (isset($_SESSION['idUser']) && ($_SESSION['idUser'] > 0) && (isset($_POST['offset'])) && (isset($_POST['alpha']))) // test id pour les utilisateur
            {
                showRecipes($_POST['offset'], $_POST['alpha']);
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour consulter la recette, Vous devez vous reconnecter');
            }
        } // *******************************************************************************
          // compte toutes les recettes privées et retourne le nombre de pages a afficher
          // *******************************************************************************
        elseif ($_GET['action'] == 'countNumberPrivateRecipe') {
            if (isset($_SESSION['idUser']) && ($_SESSION['idUser'] > 0) && (isset($_POST['alpha']))) // test id pour les utilisateur
            {
                countNumberPrivateRecipe($_POST['alpha']);
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour compter le nombre de recette privée de la catégorie');
            }
        } // *******************************************************************************
          // compte toutes les recettes des amis et retourne le nombre de pages a afficher
          // *******************************************************************************
        elseif ($_GET['action'] == 'countNumberFriendRecipe') {
            if (isset($_SESSION['idUser']) && ($_SESSION['idUser'] > 0) && (isset($_POST['idFriend'])) && (isset($_POST['alpha']))) // test id pour les utilisateur
            {
                countNumberFriendRecipe($_POST['idFriend'], $_POST['alpha']);
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour compter le nombre de recette des amis');
            }
        } // *******************************************************************************
          // compte toutes les recettes et retourne le nombre de pages a afficher
          // *******************************************************************************
        elseif ($_GET['action'] == 'countNumberRecipeInCategorie') {
            if (isset($_SESSION['idUser']) && ($_SESSION['idUser'] > 0) && (isset($_POST['idcategory'])) && (isset($_POST['alpha']))) // test id pour les utilisateur
            {
                countNumberRecipeInCategorie($_POST['idcategory'], $_POST['alpha']);
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour compter le nombre de recette de la catégorie');
            }
        } // *******************************************************************************
          // compte toutes les recettes de la categorie et retourne le nombre de pages a afficher
          // *******************************************************************************
        elseif ($_GET['action'] == 'countNumberRecipe') {
            if (isset($_SESSION['idUser']) && ($_SESSION['idUser'] > 0) && (isset($_POST['alpha']))) // test id pour les utilisateur
            {
                countNumberRecipe($_POST['alpha']);
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour compter le nombre de recette');
            }
        } // *******************************************************************************
          // compte toutes les recettes sans categorie et retourne le nombre de pages a afficher
          // *******************************************************************************
        elseif ($_GET['action'] == 'countNumberOtherRecipe') {
            if (isset($_SESSION['idUser']) && ($_SESSION['idUser'] > 0) && (isset($_POST['alpha']))) // test id pour les utilisateur
            {
                countNumberOtherRecipe($_POST['alpha']);
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour compter le nombre de recette sans catégorie');
            }
        } // *******************************************************************************
          // supprimer une recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'delRecipes') // supprimer une recette
        {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idRecette']) && $_POST['idRecette'] > 0) // test id de la recette a modifier
                {
                    delRecipes($_POST['idRecette']);
                } else {
                    throw new Exception('Aucune recette n\'est trouvée pour la supprimer');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer la recette');
            }
        } // *******************************************************************************
          // copier une recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'copyRecipes') // supprimer une recette
        {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idRecette']) && $_POST['idRecette'] > 0) // test id de la recette a modifier
                {
                    copyRecipes($_POST['idRecette']);
                } else {
                    throw new Exception('Aucune recette n\'est trouvée pour la copier');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour copier la recette');
            }
        } // *******************************************************************************
          // voir une recette sélectionnée
          // *******************************************************************************
        elseif ($_GET['action'] == 'showOneRecipes') // voir une recette
        {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idRecette']) && $_POST['idRecette'] > 0) // test id de la recette a voir
                {
                    showOneRecipes($_POST['idRecette']);
                } else {
                    throw new Exception('Aucune recette n\'est trouvée pour la consulter');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour consulter la recette');
            }
        } // *******************************************************************************
          // sauvegarde une recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'saveNewRecipes') // sauvegarder une recette
        {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['price']) && isset($_POST['private']) && isset($_POST['easy']) && isset($_POST['people']) && isset($_POST['love']) && isset($_POST['id_category']) && isset($_POST['title']) && isset($_POST['alpha']) && isset($_POST['prepare_time'])) {
                    saveNewRecipes($_POST['private'], $_POST['price'], $_POST['easy'], $_POST['people'], $_POST['love'], $_POST['id_category'], $_POST['title'], $_POST['alpha'], $_POST['prepare_time']);
                } else {
                    throw new Exception('Aucun renseignement pour créer la nouvelle recette n\'est trouvés');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour créer la recette');
            }
        } // *******************************************************************************
          // vérifie avant sauvegarde si le titre existe déjà en BDD
          // *******************************************************************************
        elseif ($_GET['action'] == 'verifTitle') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['title'])) {
                    verifTitle($_POST['title']);
                } else {
                    throw new Exception('Aucun titre n\'est renseigné');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour vérifier le titre');
            }
        } // *******************************************************************************
          // sauvegarde les ingrédients d'une recette existante (lors de modification)
          // *******************************************************************************
        elseif ($_GET['action'] == 'actualizeIngRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['arrIng'])) // test id de la recette a voir
                {
                    actualizeIngRecipe($_POST['arrIng']);
                } else {
                    throw new Exception('Aucun ingrédient n\'est trouvée pour sauvegarder');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder les ingrédients de la recette');
            }
        } // *******************************************************************************
          // supprime les ingrédients d'une recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'delIngRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['id_recette'])) {
                    delIngRecipe($_POST['id_recette']);
                } else {
                    throw new Exception('Aucune recette est trouvée pour supprimer ses ingrédients');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer les ingrédients de la recette');
            }
        } // *******************************************************************************
          // supprime les étapes d'une recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'delEtapeRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['id_recette'])) {
                    delEtapeRecipe($_POST['id_recette']);
                } else {
                    throw new Exception('Aucune recette est trouvée pour supprimer ses étapes');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer les étape de la recette');
            }
        } // *******************************************************************************
          // sauvegarde les étapes d'une recette existante (lors de modification)
          // *******************************************************************************
        elseif ($_GET['action'] == 'actualizeEtapeRecipe') // sauvegarder une recette
        {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['arrEtape'])) {
                    actualizeEtapeRecipe($_POST['arrEtape']);
                } else {
                    throw new Exception('Aucune étapes n\'est trouvée pour sauvegarder');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder les étape de la recette');
            }
        } // *******************************************************************************
          // barre de recherche ingrédient lors d'une modification dans la recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'searchBarIngredient') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['value'])) {
                    searchBaringredient($_POST['value']);
                } else {
                    throw new Exception('Aucun ingrédient n\'est trouvée pour le sélectionner');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sélectionner un ingrédient');
            }
        } // *******************************************************************************
          // sauvegarde les indicateur d'une recette existante (lors de modification)
          // *******************************************************************************
        elseif ($_GET['action'] == 'actualizeRecipes') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) {
                if (isset($_POST['id_recette']) && isset($_POST['private']) && isset($_POST['price']) && isset($_POST['easy']) && isset($_POST['people']) && isset($_POST['love']) && isset($_POST['id_category']) && isset($_POST['title']) && isset($_POST['alpha']) && isset($_POST['prepare_time'])) {
                    actualizeRecipes($_POST['id_recette'], $_POST['price'], $_POST['easy'], $_POST['people'], $_POST['love'], $_POST['id_category'], $_POST['title'], $_POST['alpha'], $_POST['prepare_time'], $_POST['private']);
                } else {
                    throw new Exception('Aucun indicateur n\'est trouvés pour sauvegarder');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder les indicateurs de la recette');
            }
        } // *******************************************************************************
          // créer un nouvel ingrédient dans la BDD
          // *******************************************************************************
        elseif ($_GET['action'] == 'addNewIngBdd') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['newIngLabel']) && isset($_POST['newIngUnit'])) {
                    addNewIngBdd($_POST['newIngLabel'], $_POST['newIngUnit']);
                } else {
                    throw new Exception('Aucun ingrédient n\'est trouvée pour l\'ajouter en bdd');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour ajouter l\'ingrédient en bdd');
            }
        } // *******************************************************************************
          // ajouter un image à la recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'uploadImgRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {

                uploadImgRecipe();
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour ajouter l\'image à la recette');
            }
        } // *******************************************************************************
          // sauvegarder une image à la recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'saveImgRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                // echo var_dump($_FILES);
                saveImgRecipe();
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder l\'image à la recette');
            }
        } // *******************************************************************************
          // supprimer une image chargée
          // *******************************************************************************
        elseif ($_GET['action'] == 'delImgLoad') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                delImgLoad();
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer l\'image chargée');
            }
        } // *******************************************************************************
          // supprimer une image de la recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'deleteImgRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['id_recette'])) {
                    deleteImgRecipe($_POST['id_recette']);
                } else {
                    throw new Exception('Aucun ingrédient n\'est trouvée pour l\'ajouter en bdd');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder l\'image à la recette');
            }
        } // *******************************************************************************
          // afficher l'image de la recette
          // *******************************************************************************
        elseif ($_GET['action'] == 'loadImgRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idRecette'])) {
                    loadImgRecipe($_POST['idRecette']);
                } else {
                    throw new Exception('Aucun identifiant de recette n\'est trouvée pour trouver son image');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour afficher l\'image de la recette');
            }
        } /*
           * //*******************************************************************************
           * // ajouter le planning de la journee (partie planing calendrier)
           * //*******************************************************************************
           * elseif ($_GET['action'] == 'modifPlanningDay')
           * {
           * if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
           * {
           * if (isset($_POST['dateDay']) && $_POST['dateDay'] > 0) // test de la date de la journée
           * {
           * modifPlanningDay($_POST['dateDay']);
           * }
           * else
           * {
           * throw new Exception('Aucune date du planning journalier est trouvé');
           * }
           * }
           * else
           * {
           * throw new Exception('Aucun compte n\'a été trouvé pour modifier le planning de la journée');
           * }
           * }
           */

        // *******************************************************************************
        // barre de recherche recette lors d'une modification dans le planning
        // *******************************************************************************
        elseif ($_GET['action'] == 'searchBarRecipe') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_GET['value'])) {
                    searchBarRecipe($_GET['value']);
                } else {
                    throw new Exception('Aucune recette n\'est trouvée pour la sélectionner');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sélectionner une recette');
                // spaceConnect();
            }
        } // *******************************************************************************
          // voir le planning
          // *******************************************************************************
        elseif ($_GET['action'] == 'showPlanningMonth') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                showPlanningMonth();
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour voir le planning du mois');
            }
        } // *******************************************************************************
          // voir le planning du mois pour l'afficher sur le calendrier
          // *******************************************************************************
        elseif ($_GET['action'] == 'loadPlanningMonth') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['month'])) {
                    loadPlanningMonth($_POST['month']);
                } else {
                    throw new Exception('Aucun id du mois est trouvé pour afficher dans le calendrier');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour voir le planning du mois dans le calendrier');
            }
        } // *******************************************************************************
          // voir le planning du mois pour l'afficher sur le calendrier
          // *******************************************************************************
        elseif ($_GET['action'] == 'loadPlanningDay') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['day']) && isset($_POST['month'])) {
                    loadPlanningDay($_POST['day'], $_POST['month']);
                } else {
                    throw new Exception('Aucun id du jour est trouvé pour afficher dans le calendrier');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour voir le planning du jour dans le calendrier');
            }
        } // *******************************************************************************
          // voir le premier jour du mois
          // *******************************************************************************
        elseif ($_GET['action'] == 'giveFirstDayMonth') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['jour']) && isset($_POST['mois']) && isset($_POST['annee'])) // test id de la semaine a voir
                {
                    giveFirstDayMonth($_POST['jour'], $_POST['mois'], $_POST['annee']);
                } else {
                    throw new Exception('Aucune date est trouvé');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour voir le jour demandé');
            }
        } /*
           * //*******************************************************************************
           * // voir le planning de la semaine
           * //*******************************************************************************
           * elseif ($_GET['action'] == 'showPlanningWeek')
           * {
           * if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
           * {
           * if (isset($_POST['idWeek']) && $_POST['idWeek'] > 0) // test id de la semaine a voir
           * {
           * showPlanningWeek();
           * }
           * else
           * {
           * throw new Exception('Aucun id de la semaine est trouvé');
           * }
           * }
           * else
           * {
           * throw new Exception('Aucun compte n\'a été trouvé pour voir le planning de la semaine');
           *
           * }
           * }
           */

        // *******************************************************************************
        // créer un nouveau planning
        // *******************************************************************************
        elseif ($_GET['action'] == 'createPlanning') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['arrWeek'])) // test de la date de la journée
                {
                    createPlanning($_POST['arrWeek']);
                } else {
                    throw new Exception('Aucune date du planning  est trouvé pour le sauvegarder');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder le planning');
            }
        } // *******************************************************************************
          // afficher les listes de course existante
          // *******************************************************************************
        elseif ($_GET['action'] == 'showListShop') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) {
                showListShop();
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour voir les listes de course');
            }
        } // *******************************************************************************
          // afficher les mentions légales
          // *******************************************************************************
        elseif ($_GET['action'] == 'mention') {
            mention();
        } // *******************************************************************************
          // afficher la politique de confidentialité
          // *******************************************************************************
        elseif ($_GET['action'] == 'politique') {
            politique();
        } // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          // EN ATTENTE

        // *******************************************************************************
        // cloner le planing d'une autre journée
        // *******************************************************************************
        elseif ($_GET['action'] == 'clonePlanningDay') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['dateDayClone']) && $_POST['dateDayClone'] > 0 && isset($_POST['dateDay']) && $_POST['dateDay'] > 0) // test de la date de la journée
                {
                    clonePlanningDay($_POST['dateDay'], $_POST['dateDayClone']);
                } else {
                    throw new Exception('Aucune date du planning a cloner est trouvé');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour cloner le planning de la journée');
            }
        } // *******************************************************************************
          // cloner le planing d'une autre semaine
          // *******************************************************************************
        elseif ($_GET['action'] == 'clonePlanningWeek') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idWeekClone']) && $_POST['idWeekClone'] > 0 && isset($_POST['idWeek']) && $_POST['idWeek'] > 0) // test de la date de la journée
                {
                    clonePlanningWeek($_POST['idWeek'], $_POST['idWeekClone']);
                } else {
                    throw new Exception('Aucune semaine du planning a cloner est trouvé');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour cloner le planning de la semaine');
                spaceConnect();
            }
        } // *******************************************************************************
          // ajouter le planning d'une journée à une nouvelle liste de course
          // *******************************************************************************
        elseif ($_GET['action'] == 'addPlanninNewShop') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idWeek']) && $_POST['idWeek'] > 0) {
                    addPlanninNewShop($_POST['idWeek']);
                } else {
                    throw new Exception('Aucune semaine du planning a insérer dans une nouvelle liste de course');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour insérer dans la nouvelle liste de courses');
            }
        } // *******************************************************************************
          // ajouter le planning d'une journée à une liste de course existante
          // *******************************************************************************
        elseif ($_GET['action'] == 'addPlanninShop') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) // test id pour les utilisateur
            {
                if (isset($_POST['idlisteShop']) && $_POST['idlisteShop'] > 0 && isset($_POST['idWeek']) && $_POST['idWeek'] > 0) // test de la date de la journée et de la liste existante
                {
                    addPlanninShop($_POST['idWeek'], $_POST['idlisteShop']);
                } else {
                    throw new Exception('Aucune semaine du planning a insérer en liste de course');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour insérer les courses dans la liste');
            }
        } // *******************************************************************************
          // ajouter une liste de course existante
          // *******************************************************************************
        elseif ($_GET['action'] == 'addListShop') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) {
                addListShop($_POST['idlisteShop']);
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer la liste de course');
            }
        } // *******************************************************************************
          // supprimer une liste de course existante
          // *******************************************************************************
        elseif ($_GET['action'] == 'delListShop') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) {
                if (isset($_POST['idlisteShop']) && $_POST['idlisteShop']) {
                    delListShop($_POST['idlisteShop']);
                } else {
                    throw new Exception('Aucune liste de course a supprimer a été trouvée');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour supprimer la liste de course');
            }
        } // *******************************************************************************
          // sauvegarder une nouvelle liste de course
          // *******************************************************************************
        elseif ($_GET['action'] == 'saveNewListShop') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) {
                saveNewListShop();
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder la nouvelle liste de course');
            }
        } // *******************************************************************************
          // sauvegarder une liste de course existante
          // *******************************************************************************
        elseif ($_GET['action'] == 'saveListShop') {
            if (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0) {
                if (isset($_POST['idlisteShop']) && $_POST['idlisteShop']) {
                    saveListShop($_POST['idlisteShop']);
                } else {
                    throw new Exception('Aucune liste de course a sauvegarder a été trouvée');
                }
            } else {
                throw new Exception('Aucun compte n\'a été trouvé pour sauvegarder la liste de course');
            }
        }
    } else {
        spaceHome("");
    }
} catch (Exception $e) { // S'il y a eu une erreur, alors...
    showErrorPhp($e->getMessage());
    /*
     * echo 'Une erreur est survenue: ' . $e->getMessage().' . OUPS! Vous allez être redirigé!';
     * header("Refresh: 4;url=http://www.kajoo.uimainon.com/index.php?action=spaceConnect");
     */
}