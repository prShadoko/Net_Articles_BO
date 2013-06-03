<?php

require_once 'persistance/SQLRequest.php';

/**
 * Description of DBUtils
 *
 * @author
 */
class DBUtils
{

	private static function getConnection()
	{
		try
		{
			$connection = new PDO('mysql:host=localhost;dbname=net_articles', 'mod', 'mod');
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$connection->exec('SET CHARACTER SET utf8;');
			return $connection;
		} catch(Exception $e)
		{
			$connection = null;
			throw $e;
		}
	}

	public static function read(SQLRequest $requete)
	{
		try
		{
			$connection = self::getConnection();
			$prep = $connection->prepare($requete->getRequest());
			$prep->execute($requete->getParameters());
			$connection = null;
			return $prep;
		} catch(Exception $e)
		{
			$connection = null;
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
						$requete->addParameter('id', $id);
					}
				}
			}
			unset($requete);
			foreach($transaction->getRequetes() as $requete)
			{
				$prep = $connexion->prepare($requete->getRequest());
				$prep->execute($requete->getParameters());
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