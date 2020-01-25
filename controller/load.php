<?php
use Model\EtapeRecette;
use Model\Calendar;
use Model\Category;
use Model\Form;
use Model\ImgRecipe;
use Model\Ingredient;
use Model\IngredientRecette;
use Model\Liste;
use Model\ListShop;
use Model\Planning;
use Model\PlanningDay;
use Model\Preference;
use Model\Recette;
use Model\Shop;
use Model\User;

// *********************************************************************
// download image recette
function loadImgRecipe($idRecette)
{
    $recette = new Recette();
    $aAllRecipe = $recette->get('id_recette', $idRecette);

    if ($aAllRecipe != false) {
        $img = new ImgRecipe();
        $aImg = $img->get('img_nom', $aAllRecipe[0]['id_user'] . '_' . $idRecette);
        if ($aImg != false) {
            $res = responseAjax($aImg); // on renvoie l'url de l'image
            echo json_encode($res);
        } else {
            $res = responseAjax(false);
            echo json_encode($res);
        }
    } else {
        $res = responseAjax(false);
        echo json_encode($res);
    }
}

// ************************************************************************
// AJAX
// upload image des recettes
function uploadImgRecipe()
{
    $img = $_POST['img'];
    $imgModel = new ImgRecipe();
    $content_dir = 'public/upload/';
    if (strpos($img, 'data:image/png;base64') === 0) {

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $nom_upload = $_SESSION['idUser'] . '_' . $_SESSION['idRecette'] . '_' . time();
        $file = $content_dir . $nom_upload . '.png';
        $img_blob = '';
        $img_taille = 0;
        $img_type = 'png';
        $img_nom = $_SESSION['idUser'] . '_' . $_SESSION['idRecette'];
        // $img_nom = $_SESSION['idUser'].'_'.$_SESSION['idRecette'];
        $img_src = $content_dir . $nom_upload;

        $aData = array(
            "img_type" => 'image/png',
            "img_nom" => $img_nom,
            "img_blob" => $img_blob,
            "img_taille" => $img_taille,
            "img_src" => $img_src
        );

        $imgModel->hydrate($aData);
        $verifAdd = $imgModel->vérif();

        if ($verifAdd == false) {
            $imgModel->add($imgModel);
            file_put_contents($file, $data);
        } else {
            $imgModel->update($img_nom, $img_taille, $img_type, $img_blob, $img_src, $verifAdd[0]['img_id']);
            if (file_exists($verifAdd[0]['img_src'] . '.png')) { // si le fichier existe déjà
                $test = unlink($verifAdd[0]['img_src'] . '.png'); // on supprime le lien
            }
            file_put_contents($file, $data);
        }
        $res = responseAjax(true);
        echo json_encode($res);
    } else {
        $res = responseAjax(false);
        echo json_encode($res);
    }
}

// *************************************************************************
// supprime image de la BDD (chemin) + fichier upload
function deleteImgRecipe($id_recette)
{
    $content_dir = 'public/upload/';
    $img = new ImgRecipe(); // on supprime de la BDD
    $verifAdd = $img->vérif();
    $img_nomBdd = $_SESSION['idUser'] . '_' . $id_recette;

    if ($verifAdd != false) {
        $img_nom = $verifAdd[0]['img_src'] . '.png';
        $img->delete($img_nomBdd); // on supprime de la BDD
        if (file_exists($img_nom)) { // si le fichier existe déjà
            $test = unlink($img_nom); // on supprime le lien
            $res = responseAjax(true);
            echo json_encode($res);
        } else {
            $res = responseAjax(false);
            echo json_encode($res);
        }
    } else {
        $res = responseAjax(true);
        echo json_encode($res);
    }
}

// *************************************************************************
// copie image de la BDD (chemin)
function copyImgRecipe($userCreate, $id_recette, $newId_recette)
{
    $content_dir = 'public/upload/';
    $img_nom = $userCreate . '_' . $id_recette;
    $img_Newnom = $_SESSION['idUser'] . '_' . $newId_recette;

    copy($content_dir . $img_nom . '.png', $content_dir . $img_Newnom . '.png');
    if (! copy($content_dir . $img_nom . '.png', $content_dir . $img_Newnom . '.png')) {
        // echo "La copie $img_nom du fichier a échoué...\n";
        return false;
    } else {
        $img = new ImgRecipe();
        return $img->copy($img_nom, $img_Newnom, $content_dir . $img_Newnom);
    }
}
//*************************************************************************
/*        if(file_exists($content_dir . $img_nom.'.png')){ // si le fichier existe déjà
            $test = unlink($content_dir . $img_nom.'.png'); // on supprime le lien
        }*/
       // if (file_put_contents($file, $data)) {



            //print_r($verifAdd);

/*            $aRes = array(
                "src" => $file,
                "error" => false);
            echo json_encode($aRes);
        } else {
            $aRes = array(
                "src" => false,
                "error" => 'Une erreur est survenue...');
            echo json_encode($aRes);
        }


    }*/


    // fileinfo = self.request.files['myfile'][0];
/*    $content_dir = 'public/upload/';
    $aRes = array(
        "src"  => $content_dir . $imgBlob,
        "error"=>false);
    echo json_encode($aRes);*/
    //print_r($_POST);
	/*$content_dir = 'public/upload/';
    $ret        = false;
    $img_blob   = '';
    $img_taille = 0;
    $img_type   = '';
    $img_nom    = '';
    $img_src    = '';
    $taille_max = 16000000;
    $ret        = is_uploaded_file($_POST['myfile']['tmp_name']);
    $extensions_valides = 'jpg,jpeg,gif,png';
    $mimes_valides = 'image/jpg,image/jpeg,image/gif,image/png';
    $msgErreurPhoto = ''; 
    if (!$ret)
    {
        switch($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                $response="rien";
                break;
            case UPLOAD_ERR_NO_FILE:
                $response='Aucun fichier n\'a été téléchargé. ';
            case UPLOAD_ERR_INI_SIZE:
                $response='La taille du fichier téléchargé excède la valeur de  upload_max_filesize,.';
            case UPLOAD_ERR_FORM_SIZE:
            $response='La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE.';
            case UPLOAD_ERR_PARTIAL:
                $response='Le fichier n\'a été que partiellement téléchargé.';
            case UPLOAD_ERR_NO_TMP_DIR:
                $response='Un dossier temporaire est manquant. Introduit en PHP 5.0.3. ';
            case UPLOAD_ERR_CANT_WRITE:
                $response=' Échec de l\'écriture du fichier sur le disque. Introduit en PHP 5.1.0. ';
            case UPLOAD_ERR_EXTENSION:
                $response='Une extension PHP a arrêté l\'envoi de fichier. PHP ne propose aucun moyen de déterminer quelle extension est en cause';
            default:
                $response='erreur inconnue.';
        }
        	$aRes = array(
	    		"src"  => false,
	    		"error"=> $response.' '.$_FILES['file']['size']);
	    	echo json_encode($aRes);
    }
    else
    {
    	$img_type = $_FILES['file']['type'];
    	$img_taille = $_FILES['file']['size'];
	    // extension du fichier uploadé (en minuscule)
		$file_Extension = strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));
		// Type MIME réel du fichier (important : évite les fichiers NON valides, dont l'extension a été renommée)
		$finfo 			= new finfo(FILEINFO_MIME_TYPE, NULL); // Retourne le type mime
		$file_MimeType 	= $finfo->file($_FILES['file']['tmp_name']);
		//------------------------------------------------------
		// on vérifie l'EXTENSION
		if(!in_array($file_Extension, explode(',', $extensions_valides))) {
			$msgErreurPhoto .= 'L\'extension ne correspond pas (Extensions acceptées  : <b>'.$extensions_valides.'</b>)<br />';
			if(in_array($file_MimeType, explode(',', $mimes_valides))) {
			  $msgErreurPhoto .= '<b>Attention</b> : Ce fichier est peut-être corrompu !<br /> L\'extension ne correspond pas au type MIME !<br />';
			}
		}
		// on vérifie le TYPE MIME
		if(!in_array($file_MimeType, explode(',', $mimes_valides))) {
			$msgErreurPhoto 	.= 'Le type MIME ne correspond pas (Extensions acceptées  : <b>'.$extensions_valides.'</b>)<br />';
			if(in_array($file_Extension, explode(',', $extensions_valides))) {
			  $msgErreurPhoto 	.= '<b>Attention</b> : Ce fichier est peut-être corrompu !<br />';
			  $msgErreurPhoto 	.= 'L\'extension ne correspond pas au type MIME !<br />';
			}
		}
		// on vérifie les RESTRICTIONS sur les fichiers
		if (UPLOAD_ERR_OK<>0 && UPLOAD_ERR_FORM_SIZE==2) {
			$msgErreurPhoto 	.= 'Taille de fichier trop important ('.FILE_SIZEMAX_PHOTO.' octets)<br />';
		}
        if ($img_taille > $taille_max)
        {
            $msgErreurPhoto 	.= " Fichier trop gros !";
        }

	    //-----------------------------------------------------------
		if($msgErreurPhoto == ''){ // si il n'y a aucune erreur, on peut sauvegarder l'image dans le dossier

			if(file_exists($content_dir . $_FILES['file']['name'])){ // si le fichier existe déjà
		    	$test = unlink($content_dir . $_FILES['file']['name']); // on supprime le lien
		    }

			if(!move_uploaded_file($_FILES['file']['tmp_name'], $content_dir . $_FILES['file']['name']) ) // on copie le fichier dans un dossier
		    {
		        $msgErreurPhoto .= 'Impossible de copier le fichier';
		    }

		    if($msgErreurPhoto == ''){ // si toujours pas d'érreur a la sauvegarde, on renvoie l'url de l'image pour l'afficher 
		    	$aRes = array(
		    		"src"  => $content_dir . $_FILES['file']['name'],
		    		"error"=>false);
		    	echo json_encode($aRes);
		    }
	    }
	    else
	    {
	        $aRes = array(
	    		"src"  => false,
	    		"error"=>$msgErreurPhoto);
	    	echo json_encode($aRes);
	    }
    }*/
//}
//************************************************************************
// sauvegarde de l'image en BDD (Chemin de l'image)
/*function saveImgRecipe()
{
   // $img = $_POST['img'];
    $imgModel = new ImgRecipe();
    $content_dir= 'public/upload/';
    $img_blob   = '';
    $img_taille = 0;
    $img_type   = '';
    $img_nom    = $_SESSION['idUser'].'_'.$_SESSION['idRecette'];
    $img_src    = $content_dir . $img_nom;
    //$data = base64_decode($img);
    //$file = $content_dir . $_SESSION['idUser'] . '.png';

    //if (strpos($img, 'data:image/png;base64') === 0) {
/*        if(file_exists($content_dir . $img_nom)) {
            rename($content_dir . $_SESSION['idUser'], $content_dir . $img_nom);
        }*/
/*        $data = array(
            "img_type"=>'image/png',
            "img_nom"=>$img_nom,
            "img_blob"=>'',
            "img_taille"=>'',
            "img_src"=>$img_src);

        $imgModel->hydrate($data);
        $verifAdd = $imgModel->vérif();
        if($verifAdd == false)
        {
            $imgModel->add($imgModel);
        }
        else
        {
            $imgModel->update($img_nom, $img_taille, $img_type, $img_blob, $img_src, $verifAdd[0]['img_id']);
        }*/
   // }

//}*/

        //$img = str_replace('data:image/png;base64,', '', $img);
        /*$img = str_replace(' ', '+', $img);*/



/*        if (file_put_contents($file, $data)) {
            $aRes = array(
                "src" => $file,
                "error" => false);
            echo json_encode($aRes);
        } else {
            $aRes = array(
                "src" => false,
                "error" => 'Une erreur est survenue...');
            echo json_encode($aRes);
        }*/
    //}
/*	$img = new ImgRecipe();
	$content_dir= 'public/upload/';
    $ret        = false;
    $img_blob   = '';
    $img_taille = 0;
    $img_type   = '';
    $img_nom    = '';
    $img_src    = '';
    $taille_max = 16000000;
    $ret        = is_uploaded_file($_FILES['file']['tmp_name']);

    if (!$ret)
    {
        switch($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                $response="rien";
                break;
            case UPLOAD_ERR_NO_FILE:
                $response='Aucun fichier n\'a été téléchargé. ';
            case UPLOAD_ERR_INI_SIZE:
                $response='La taille du fichier téléchargé excède la valeur de  upload_max_filesize,.';
            case UPLOAD_ERR_FORM_SIZE:
                $response='La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE.';
            case UPLOAD_ERR_PARTIAL:
                $response='Le fichier n\'a été que partiellement téléchargé.';
            case UPLOAD_ERR_NO_TMP_DIR:
                $response='Un dossier temporaire est manquant. Introduit en PHP 5.0.3. ';
            case UPLOAD_ERR_CANT_WRITE:
                $response=' Échec de l\'écriture du fichier sur le disque. Introduit en PHP 5.1.0. ';
            case UPLOAD_ERR_EXTENSION:
                $response='Une extension PHP a arrêté l\'envoi de fichier. PHP ne propose aucun moyen de déterminer quelle extension est en cause';
            default:
                $response='erreur inconnue.';
        }
        $aRes = array(
            "src"  => false,
            "error"=> $response.' '.$_FILES['file']['size']);
        echo json_encode($aRes);
    }
    else
    {
        $img_taille = $_FILES['file']['size'];
    	$img_type   = $_FILES['file']['type'];
		$img_nom    = $_SESSION['idUser'].'_'.$_SESSION['idRecette'];
		$img_src    = $content_dir . $img_nom;
		if(file_exists($content_dir . $_FILES['file']['name'])){
		    	rename ($content_dir . $_FILES['file']['name'], $content_dir . $img_nom);

		   	$data = array(
		    	"img_type"=>$img_type,
		    	"img_nom"=>$img_nom,
		    	"img_blob"=>'',
		    	"img_taille"=>$img_taille,
		    	"img_src"=>$img_src);
	   
		    $img->hydrate($data);
		   	$verifAdd = $img->vérif();
		   	if($verifAdd == false)
		   	{
		   		$img->add($img);
		   	}
		   	else
		   	{
				$img->update($img_nom, $img_taille, $img_type, $img_blob, $img_src, $verifAdd[0]['img_id']);
		   	}
		}
    }*/

//*************************************************************************
// supprime image chargée (dossier temporaire et pas enregistrée en BDD)
/*function delImgLoad()
{*/
/*    $content_dir = 'public/upload/';
/*    $ret        = is_uploaded_file($_FILES['file']['tmp_name']);
    if (!$ret)
    {
        $res = responseAjax(false);
        echo json_encode($res);
    }else{*/
       /* if(file_exists($content_dir . $_SESSION['idUser'].'.png')){ // si le fichier existe déjà
            $test = unlink($content_dir . $_SESSION['idUser'].'.png'); // on supprime le lien
            $res = responseAjax(true);
            echo json_encode($res);
        }else{
            $aRes = array(
                "src"  => $content_dir . $_SESSION['idUser'].'.png',
                "error"=>false);
            $res = responseAjax($aRes);
            echo json_encode($res);
        }*/
 //   }
/*    $img = $_POST['img'];
    if (strpos($img, 'data:image/png;base64') === 0) {

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = 'public/upload/'.$_SESSION['idUser'].'.png';

        if (file_put_contents($file, $data)) {
            $aRes = array(
                "src"  => $file,
                "error"=>false);
            echo json_encode($aRes);
        } else {
            $aRes = array(
                "src"  => false,
                "error"=>'Une erreur est survenue...');
            echo json_encode($aRes);
        }*/
//----------------------------------------
/*   $content_dir = 'public/upload/';
    $ret        = is_uploaded_file($_FILES['file']['tmp_name']);
    if (!$ret)
    {
        $res = responseAjax(false);
        echo json_encode($res);
    }else{
        if(file_exists($content_dir . $_FILES['file']['name'])){ // si le fichier existe déjà
            $test = unlink($content_dir . $_FILES['file']['name']); // on supprime le lien
            $res = responseAjax(true);
            echo json_encode($res);
        }else{
            $aRes = array(
                "src"  => $content_dir . $_FILES['file']['name'],
                "error"=>false);
            $res = responseAjax($aRes);
            echo json_encode($res);
        }
    }*/
//}


