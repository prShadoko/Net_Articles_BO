<?php
require_once 'persistance/DBUtils.php';

class Article {

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

	public function affectValue($rs) {
		$this->setId($rs['id']);
		$this->setSummary($rs['summary']);
		$this->setIdDomain($rs['idDomain']);
		$this->setTitle($rs['title']);
		$this->setPrice($rs['price']);
		$this->setPublicationDate($rs['publicationDate']);
		$this->setFile($rs['file']);
	}
	
	public function updateDB() {
		
		$req = new SQLRequest();
		$req->setRequest(
			'UPDATE article
			SET id_domaine=:idDomain, resume=:summary, titre=:title, prix=:price, date_article=:publicationDate, fichier=:file
			WHERE id_article=:id;'
			);
		$req->addParameter('id', $this->_id);
		$req->addParameter('idDomain', $this->_idDomain);
		$req->addParameter('summary', $this->_summary);
		$req->addParameter('title', $this->_title);
		$req->addParameter('price', $this->_price);
		$req->addParameter('publicationDate', $this->_publicationDate);
		$req->addParameter('file', $this->_file);
		
		$transaction = new Transaction();
		$transaction->addRequest($req);
		
		DBUtils::Transaction($transaction);
	}
	
	public static function readableArticleList($start, $length) {
		
		$req = new SQLRequest();
		$req->setRequest(
			'Select a.id_article as id, d.lib_domaine as domaine, a.titre, a.resume, a.prix, a.date_article as "date article", a.fichier 
			from article a
			join domaine d on d.id_domaine = a.id_domaine
			limit '.$start.', '.$length.';'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function getArticleCount() {
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
}

?>
