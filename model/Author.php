<?php
require_once 'persistence/DBUTils.php';
require_once 'CRUDTable.php';
require_once 'Article.php';
require_once 'Redaction.php';

class Author implements CRUDTable {
	
	private $_id;
	private $_identity;
	private $_address;
	private $_login;
	private $_pwd;
	
	public function read($id) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_auteur as "id", identite_auteur as "identity", adresse_auteur as "address", login_auteur as "login", pwd_auteur as "pwd" 
			from auteur 
			where id_auteur = :id;'
			);
		
		$req->addParameter('id', $id);
		
		$rs = DBUtils::read($req)->fetchAll(PDO::F);

		$this->affectValue($rs[0]);
	}
	
	public function affectValue($rs) {
		$this->setId(isset($rs['id'])?$rs['id']:null);
		$this->setIdentity($rs['identity']);
		$this->setAddress($rs['address']);
		$this->setLogin($rs['login']);
		$this->setPwd($rs['pwd']);
	}
	
	public function updateDB() {
		$idParameter = null;
		$req = new SQLRequest();
		
		if(is_null($this->getId())) {
			$req->setRequest(
				'insert into auteur (id_auteur, identite_auteur, adresse_auteur, login_auteur, pwd_auteur)
				VALUES(:id, :identity, :address, :login, :pwd);'
				);
			$tableId = 'auteur';
			$req->setTableId($tableId);
		}
		else {
			$req->setRequest(
				'UPDATE auteur
				SET identite_auteur=:identity, adresse_auteur=:address, login_auteur=:login, pwd_auteur=:pwd
				WHERE id_auteur=:id;'
				);
			$req->addParameter('id', $this->_id);
		}
		
		$req->addParameter('identity', $this->getIdentity());
		$req->addParameter('address', $this->getAddress());
		$req->addParameter('login', $this->getLogin());
		$req->addParameter('pwd', $this->getPwd());
		
		$transaction = new Transaction();
		$transaction->addRequest($req);
		
		DBUtils::transaction($transaction, $idParameter);
	}

	public static function delete($ids) {
            //Suppression
            
            //Suppression des parts de rédaction des auteurs
            foreach($ids as $k=>$id){
             Redaction::deleteAuteur($id);
            }
            
            //Suppression des droits associés aux auteurs
            $req = new SQLRequest();
                 $req->setRequest(
			'delete from droits
			where id_auteur IN ('.  self::idsToString($ids) .');'
			);
                 
                 $transaction = new Transaction();
		$transaction->addRequest($req);
                
                //Suppression des auteurs
		$req->setRequest(
			'delete from auteur
			where id_auteur IN ('.  self::idsToString($ids) .');'
			);
		
		$transaction->addRequest($req);
		
		DBUtils::transaction($transaction);

	}

	public static function getRowCount() {
		$req = new SQLRequest();
		$req->setRequest(
			'Select count(*) 
			from auteur;'
			);
		
		$rs = DBUtils::read($req)->fetchAll(PDO::FETCH_NUM);
		return $rs[0][0];
	}

	public static function readableList($start, $length) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_auteur as "id", identite_auteur as "Identité", adresse_auteur as "Adresse", login_auteur as "Login" 
			from auteur
			limit '.$start.', '.$length.';'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function significantFieldList($ids) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_auteur as id, identite_auteur as "Identité", adresse_auteur as "Adresse"
			from auteur
			where id_auteur IN ('. self::idsToString($ids) .');'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function identityList($ids = null) {
		
		$req = 'Select id_auteur as id, identite_auteur as "identity"
			from auteur';
		if(isset($ids)){
			$req .= ' where id_auteur IN ('. self::idsToString($ids) .')';
		}
		
		$request = new SQLRequest();
		$request->setRequest($req);
		return DBUtils::read($request)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function idsToString($ids) {
		$idList = "";
		foreach($ids as $id){
			$idList .= $id.', ';
		}
		
		return substr($idList, 0, strlen($idList)-2);
	}
	
	public function getId() {
		return $this->_id;
	}

	public function setId($id) {
		$this->_id = $id;
	}

	public function getIdentity() {
		return $this->_identity;
	}

	public function setIdentity($identity) {
		$this->_identity = $identity;
	}

	public function getAddress() {
		return $this->_address;
	}

	public function setAddress($address) {
		$this->_address = $address;
	}

	public function getLogin() {
		return $this->_login;
	}

	public function setLogin($login) {
		$this->_login = $login;
	}

	public function getPwd() {
		return $this->_pwd;
	}

	public function setPwd($pwd) {
		$this->_pwd = $pwd;
	}

	public static function fieldlist($fields, $start = null, $length = null) {
		
	}


}

?>
