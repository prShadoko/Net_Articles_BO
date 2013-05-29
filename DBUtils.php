<?php

require_once 'Utils/Requete.php';

/**
 * Description of DBUtils
 *
 * @author
 */
class DBUtils
{

	private static function getConnexion()
	{
		try
		{
			$connexion = new PDO('mysql:host=localhost;dbname=net_articles', 'mod', 'mod');
			$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$connexion->exec('SET CHARACTER SET utf8;');
			return $connexion;
		} catch(Exception $e)
		{
			$connexion = null;
			throw $e;
		}
	}

	public static function Lecture(Requete $requete)
	{
		try
		{
			$connexion = self::getConnexion();
			$prep = $connexion->prepare($requete->getRequete());
			$prep->execute($requete->getParametres());
			$connexion = null;
			return $prep;
		} catch(Exception $e)
		{
			$connexion = null;
			throw $e;
		}
	}

	/**
	 *
	 * @param <array(Requete)> $requetes
	 * @param <String> $id_parametre
	 * @return type
	 * @throws MonException
	 */
	static public function Transaction(Transaction $transaction, $id_parametre = null)
	{
		try
		{
			$id = null;
			$connexion = self::getConnexion();
			$connexion->beginTransaction();
			if(!is_null($id_parametre))
			{
				$prep = $connexion->prepare('SELECT inc_parametre(:param) AS `id`');
				$parametres = array('param' => $id_parametre);
				$prep->execute($parametres);
				$res = $prep->fetch(PDO::FETCH_ASSOC);
				if($res !== false)
				{
					$id = $res['id'];
					$requetes = $transaction->getRequetes();
					foreach($requetes as &$requete)
					{
						$requete->ajouterParametre('id', $id);
					}
				}
			}
			unset($requete);
			foreach($transaction->getRequetes() as $requete)
			{
				$prep = $connexion->prepare($requete->getRequete());
				$prep->execute($requete->getParametres());
			}
			$connexion->commit();
			$connexion = null;
			return $id; //Might be uninitialized
		} catch(MonException $me)
		{
			$connexion->rollback();
			$connexion = null;
		} catch(Exception $e)
		{
			$connexion->rollback();
			$connexion = null;
			throw new MonException($e);
		}
	}
}

?>