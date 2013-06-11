<?php
require_once 'persistence/DBUtils.php';
require_once 'CRUDTable.php';

class Article implements CRUDTable {

	private $_id;
	private $_summary;
	private $_idDomain;
	private $_title;
	private $_price;
	private $_publicationDate;
	private $_file;


	public function read($idArticle) {

		$req = new SQLRequest();
		$req->setRequest(
				'Select id_article as id, id_domaine as idDomain, titre as title, resume as summary, prix as price, date_article as publicationDate, fichier as file
				from article where id_article = :id_article;');
		$req->addParameter('id_article', $idArticle);
		
		$rs = DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);

		$this->affectValue($rs[0]);
	}

	public function affectValue($rs){
		$this->setId(isset($rs['id'])?$rs['id']:null);
		$this->setSummary($rs['summary']);
		$this->setIdDomain($rs['idDomain']);
		$this->setTitle($rs['title']);
		$this->setPrice($rs['price']);
		$this->setPublicationDate($rs['publicationDate']);
		$this->setFile($rs['file']);
	}
	
	public function updateDB() {
		
		$idParameter = null;
		$req = new SQLRequest();
		
		if(is_null($this->getId())) {
			$req->setRequest(
				'insert into article (id_article, id_domaine, resume, titre, prix, date_article, fichier)
				VALUES(:id, :idDomain, :summary, :title, :price, :publicationDate, :file);'
				);
			$tableId = 'article';
			$req->setTableId($tableId);
		}
		else {
			$req->setRequest(
				'UPDATE article
				SET id_domaine=:idDomain, resume=:summary, titre=:title, prix=:price, date_article=:publicationDate, fichier=:file
				WHERE id_article=:id;'
				);
			$req->addParameter('id', $this->_id);
		}
		
		$req->addParameter('idDomain', $this->_idDomain);
		$req->addParameter('summary', $this->_summary);
		$req->addParameter('title', $this->_title);
		$req->addParameter('price', $this->_price);
		$req->addParameter('publicationDate', $this->_publicationDate);
		$req->addParameter('file', $this->_file);
		
		$transaction = new Transaction();
		$transaction->addRequest($req);
		
		DBUtils::transaction($transaction);
	}
	
	public static function readableList($start, $length) {
		
		$req = new SQLRequest();
		$req->setRequest(
			'Select a.id_article as id, d.lib_domaine as domaine, a.titre, a.resume, a.prix, a.date_article as "date article", a.fichier 
			from article a
			join domaine d on d.id_domaine = a.id_domaine
			limit '.$start.', '.$length.';'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function significantFieldList($ids) {

		$req = new SQLRequest();
		$req->setRequest(
			'Select id_article as id, titre, date_article as "Date de publication"
			from article
			where id_article IN ('. self::idsToString($ids) .');'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function titleList() {

		$req = new SQLRequest();
		$req->setRequest(
			'Select id_article as id, titre as title
			from article;'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function delete($ids) {
		
		$req = new SQLRequest();
		$req->setRequest(
			'delete from article
			where id_article IN ('.  self::idsToString($ids) .');'
			);
		
		$transaction = new Transaction();
		$transaction->addRequest($req);
		
		DBUtils::transaction($transaction);
	}
	
	public static function idsToString($ids) {
		$idList = "";
		foreach($ids as $id){
			$idList .= $id.', ';
		}
		
		return substr($idList, 0, strlen($idList)-2);
	}
	
	public static function getRowCount() {
		$req = new SQLRequest();
		$req->setRequest(
			'Select count(*) 
			from article;'
			);
		
		$rs = DBUtils::read($req)->fetchAll(PDO::FETCH_NUM);
		return $rs[0][0];
	}


	public function getId() {
		return $this->_id;
	}

	public function setId($idArticle) {
		$this->_id = $idArticle;
	}

	public function getSummary() {
		return $this->_summary;
	}

	public function setSummary($summary) {
		$this->_summary = $summary;
	}

	public function getIdDomain() {
		return $this->_idDomain;
	}

	public function setIdDomain($idDomain) {
		$this->_idDomain = $idDomain;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function setTitle($title) {
		$this->_title = $title;
	}

	public function getPrice() {
		return $this->_price;
	}

	public function setPrice($price) {
		$this->_price = $price;
	}

	public function getPublicationDate() {
		return $this->_publicationDate;
	}

	public function setPublicationDate($publicationDate) {
		$this->_publicationDate = $publicationDate;
	}

	public function getFile() {
		return $this->_file;
	}

	public function setFile($file) {
		$this->_file = $file;
	}

	public static function fieldlist($fields, $start = null, $length = null) {
		$fieldList = '';
		
		foreach ($fields as $name => $field){
			$fieldList .= $field.' as "'.$name.'", ';
		}
		
		$fieldList = substr($fieldList, 0, strlen($fieldList)-2);
		
		$req = 'Select '.$fieldList.'
			from article
			order by id_article ASC';
		
			if(	isset($start) && isset($length) ) {
				$req .= ' limit '.$start.', '.$length;
			}
		
		$request = new SQLRequest();
		$request->setRequest($req.';');
		
		return DBUtils::read($request)->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>
