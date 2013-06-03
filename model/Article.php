<?php
require_once 'persistance/DBUtils.php';

class Article {

	private $_idArticle;
	private $_summary;
	private $_idDomain;
	private $_title;
	private $_price;
	private $_publicationDate;
	private $_file;


	public function read($idArticle) {

		$req = new SQLRequest();
		$req->setRequest('Select * from article where id_article = :id_article;');
		$req->addParameter('id_article', $idArticle);
		
		$rs = DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);

		$this->affecterValeur($rs[0]);
	}

	private function affectValue($rs) {
		$this->setIdArticle($rs['id_article']);
		$this->setResume($rs['resume']);
		$this->setIdDomaine($rs['id_domaine']);
		$this->setTitle($rs['titre']);
		$this->setPrice($rs['prix']);
		$this->setPublicationDate($rs['date_article']);
		$this->setFile($rs['fichier']);
	}

	public static function readableArticleList() {
		
		$req = new SQLRequest();
		$req->setRequest('Select id_article as id, id_domaine, titre, resume, prix, date_article, fichier from article;');
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getIdArticle() {
		return $this->id_article;
	}

	public function setIdArticle($idArticle) {
		$this->_idArticle = $idArticle;
	}

	public function getSummary() {
		return $this->_summary;
	}

	public function setSummary($summary) {
		$this->_summary = $summary;
	}

	public function getIdDomaine() {
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

	public function setPrix($price) {
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
