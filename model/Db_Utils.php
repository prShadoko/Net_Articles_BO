<?php

/**
 * Description of Db_Utils
 *
 * @author 
 */
class Db_Utils {

    private static function getConnexion() {
        $connexion = new PDO("mysql:host=localhost;dbname=net_articles", "root", "");
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connexion;
    }

    public static function lecture($requete) {

        $prep = self::getConnexion()->prepare($requete);
        // echo $requete; exit;
        $prep->execute();

        return $prep;
    }

    public static function ecriture($requete) {
        try {
            $prep = self::getConnexion()->prepare($requete);
            $prep->execute();
        } catch (Exception $e) {
            throw new MonException($e);
        }
    }

    public static function transaction_V1($requete, $id_parametre) {
        try {
            $connexion = self::getConnexion();
            $connexion->beginTransaction();
            $prep = $connexion->prepare("Select inc_parametre(:param) as id");
            $parametres = Array(":param" => $id_parametre);
            $prep->execute($parametres);
            $res = $prep->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                $id = $res['id'];
                $prep = $connexion->prepare($requete);
                $parametres = Array(":id" => $id);
                $prep->execute($parametres);
            }
            $connexion->commit();
        } catch (MonException $me) {
            $connexion->rollBack();
            throw $me;
        } catch (Exception $e) {
            $connexion->rollBack();
            throw new MonException($e);
        }
    }

    public static function Transaction($requetes, $id_parametre = null) {

        try {
            $connexion = self::getConnexion();
            if (!is_null($id_parametre)) {
                //Appel a la proczedure stockée
                $connexion->beginTransaction();
                $prep = $connexion->prepare("Select inc_parametre(:param) as id");
                $parametres = Array(":param" => $id_parametre);
                $prep->execute($parametres);
                $res = $prep->fetch(PDO::FETCH_ASSOC);
                if ($res) {
                    $id = $res['id'];
                    foreach ($requetes as &$requete) {
                        $requete = str_replace(":id", $id, $requete);
                    }
                    unset($requete);
                }
            }

            //Exécuter toutes les requetes
            foreach ($requetes as $requete) {
                $prep = $connexion->prepare($requete);
                $prep->execute();
            }
        } catch (MonException $me) {
            $connexion->rollBack();
            throw $me;
        } catch (Exception $e) {
            $connexion->rollBack();
            throw new MonExcption($e);
        }
    }

}

?>
