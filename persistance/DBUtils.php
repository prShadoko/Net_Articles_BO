<?php

require_once 'persistance/Transaction.php';
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
	 * @param <array(Requete)> $requests
	 * @param <String> $idParameter
	 * @return type
	 * @throws MonException
	 */
	static public function transaction(Transaction $transaction, $idParameter = null)
	{
		try
		{
			$id = null;
			
			$connection = self::getConnection();
			$connection->beginTransaction();
				
			if(!is_null($idParameter))
			{
				$prep = $connection->prepare('SELECT inc_parametre(:param) AS `id`');
				$parameters = array('param' => $idParameter);
				$prep->execute($parameters);
				$res = $prep->fetch(PDO::FETCH_ASSOC);
				
				if($res !== false)
				{
					$id = $res['id'];
					$requests = $transaction->getRequest();
					foreach($requests as &$request)
					{
						$request->addParameter('id', $id);
					}
				}
			}
			unset($request);
			foreach($transaction->getRequest() as $request)
			{
				$prep = $connection->prepare($request->getRequest());
				$prep->execute($request->getParameters());
			}
			$connection->commit();
			$connection = null;
			return $id; //Might be uninitialized
		} catch(Exception $e)
		{
			$connection->rollback();
			$connection = null;
			throw $e;
		}
	}
}

?>