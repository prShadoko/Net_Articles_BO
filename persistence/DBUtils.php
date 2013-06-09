<?php

require_once 'persistence/Transaction.php';
require_once 'persistence/SQLRequest.php';

class DBUtils
{

	/**
	 * Get the connection to the DB.
	 * @return PDO The connection.
	 * @throws Exception Throw an exception if there are any problem with the DB.
	 */
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

	/**
	 * Prepare a reading SQL request.
	 * @param SQLRequest $request The request to prepare.
	 * @return PDOStatement The preparation.
	 * @throws Exception Throw an exception if there are problem with the request.
	 */
	public static function read(SQLRequest $request)
	{
		try
		{
			$connection = self::getConnection();
			$prep = $connection->prepare($request->getRequest());
			$prep->execute($request->getParameters());
			$connection = null;
			return $prep;
		} catch(Exception $e)
		{
			$connection = null;
			throw $e;
		}
	}

	/**
	 * Execute a transaction with the DB. A transaction execute some writing request.
	 * If a request fail, the transaction do a rollback.
	 * @param Transaction $transaction
	 * @param type $idParameter
	 * @return type
	 * @throws Exception
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
					$requests = $transaction->getRequests();
					foreach($requests as &$request)
					{
						$request->addParameter('id', $id);
					}
				}
			}
			unset($request);
			foreach($transaction->getRequests() as $request)
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