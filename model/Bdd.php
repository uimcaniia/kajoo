<?php
namespace Model;

use PDO;

class Bdd
{

    const SER = "localhost";

    const BAS = "kajoo";

    const PSW = "T0t0r0";

    const USER = "root";

    /*
     * const SER = "localhost";
     * const BAS = "coan3607_kajoo";
     * const PSW = "Ez8BgfPF-8-d";
     * const USER = "coan3607";
     */
    protected static $bdd = null;

    // ***********************************************************************************************************************
    static protected function getConnexion()
    {
        try {
            self::$bdd = new PDO('mysql:host=' . self::SER . ';dbname=' . self::BAS . ';charset=utf8', '' . self::USER . '', '' . self::PSW . '', array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
            return self::$bdd;
        } catch (Exception $e) {
            die('erreur : ' . $e->getMessage());
            return false;
        }
    }

    // **************************************************************************************************************
    // Exécute une requête
    public function countEntrie($request)
    {
        $bdd = self::getConnexion();
        $rep = $bdd->query($request);
        $res = $rep->fetch();
        $rep->closeCursor(); // Termine le traitement de la requête
        return $res;
    }

    // **************************************************************************************************************
    // Exécute une requête
    public function selectSearchBar($request)
    {
        $bdd = self::getConnexion();
        $rep = $bdd->query($request);
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        $rep->closeCursor(); // Termine le traitement de la requête
        return $res;
    }

    // **************************************************************************************************************
    // Exécute une requête non préparée (sans parma) et renvoie le resultat (SELECT)
    public function addRequestSelect($request)
    {
        $bdd = self::getConnexion();

        $rep = $bdd->query($request);
        $res = $rep->fetchALL(PDO::FETCH_ASSOC); // array qui contient champ par champ les valeurs
        if (! empty($res)) // on vérifie si un résultat est retournée
        {
            return $res;
        } else {
            return false;
            $res = array();
        }
        $rep->closeCursor(); // Termine le traitement de la requête
    }

    // **********************************************************************************************
    // Exécute une requête type (SELECT) préparée et renvoie le resultat ou false si rien
    // $aParam => array contenant les paramètre de $request sous la forme : array(':id', $value);
    public function reqPrepaExecSEl($request, $aParam)
    {
        $res = array();
        $bdd = self::getConnexion();
        $req = $bdd->prepare($request);
        for ($i = 0; $i < count($aParam); $i ++) {
            if (isset($aParam[$i][2])) {
                $req->bindValue($aParam[$i][0], $aParam[$i][1], $aParam[$i][2]);
            } else {
                $req->bindValue($aParam[$i][0], $aParam[$i][1]);
            }
        }
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        if (! empty($res)) // on vérifie si un résultat est retournée
        {
            return $res;
        } else {
            return false;
            $res = array();
        }
        $req->closeCursor(); // Termine le traitement de la requête
    }

    // **********************************************************************************************
    // Exécute une requête (INSERT) préparée et renvoie le resultat ou false si rien
    // $aParam => array contenant les paramètre de $request sous la forme : array(':id', $value);
    public function reqPrepaExec($request, $aParam)
    {
        $bdd = self::getConnexion();
        $req = $bdd->prepare($request);
        for ($i = 0; $i < count($aParam); $i ++) {
            $req->bindValue($aParam[$i][0], $aParam[$i][1]);
        }
        $req->execute();
        $req->closeCursor(); // Termine le traitement de la requête
    }

    // **********************************************************************************************
    // Exécute une requête (INSERT) préparée et renvoie le resultat ou false si rien
    // $aParam => array contenant les paramètre de $request sous la forme : array(':id', $value);
    public function reqPrepaExecNoParam($request)
    {
        $bdd = self::getConnexion();
        $req = $bdd->prepare($request);
        $req->execute();
        $req->closeCursor(); // Termine le traitement de la requête
    }
}


