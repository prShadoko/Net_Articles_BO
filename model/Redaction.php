<?php
require_once 'persistence/DBUTils.php';
require_once 'CRUDTable.php';

class Redaction {
	
	public function affectValue($rs) {
		
	}

	public function read($id) {
		
	}
	public static function delete($ids) {
		
	}

	public static function getRowCount() {
		$req = new SQLRequest();
		$req->setRequest(
			'Select count(*) 
			from redige;'
			);
		
		$rs = DBUtils::read($req)->fetchAll(PDO::FETCH_NUM);
		return $rs[0][0];
	}

	public static function readableList($article) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select r.id_article as "id", au.identite_auteur as "Auteur", r.part as "Part"
			from redige r
			join article ar on ar.id_article = r.id_article
			join auteur au on au.id_auteur = r.id_auteur
			where r.id_article = '.$article.' 
			order by r.id_article ASC;'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function authorList($article){
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_auteur as "id"
			from redige
			where id_article = '.$article.';'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function significantFieldList($article, $authors) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select r.id_auteur as "id", au.identite_auteur as "author", r.part as "part"
			from redige r
			join auteur au on au.id_auteur = r.id_auteur
			where r.id_article = '. $article .'
			and r.id_auteur IN ('.self::idsToString($authors).');'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function part($article, $authors) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_auteur as author, part
			from redige
			where r.id_article = '. $article .'
			and r.id_auteur IN ('.self::idsToString($authors).');'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function updateDB($article, $authors, $parts){
		$transaction = new Transaction();
		//debug($article);debug($authors);debug($parts);exit;
		$sql = 'delete from redige where id_article = :idArticle';
		$request = new SQLRequest();
		$request->setRequest($sql);
		$request->addParameter('idArticle', $article);
		$transaction->addRequest($request);
		
		foreach($authors as $k => $a){
			$sql = 'insert into redige(id_article, id_auteur, part) values(:idArticle, :idAuthor, :part)';
			
			$request = new SQLRequest();
			$request->setRequest($sql);
			$request->addParameter('idArticle', $article);
			$request->addParameter('idAuthor', $a);
			$request->addParameter('part', $parts[$k]);
			
			$transaction->addRequest($request);
		}
		
		DBUtils::transaction($transaction);
	}
	
	/*public static function partOfAuthor($ids) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select r.id_auteur as "id", au.identite_auteur as "Auteur", r.part as "Part"
			from redige r
			join article ar on ar.id_article = r.id_article
			join auteur au on au.id_auteur = r.id_auteur
			where r.id_article IN ('. self::idsToString($ids) .')
			UNION
;'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}*/

	public static function fieldlist($fields, $start = null, $length = null) {
		$fieldList = '';
		
		
		foreach ($fields as $name => $field){
			$fieldList .= $field.' as "'.$name.'", ';
		}
		
		$fieldList = substr($fieldList, 0, strlen($fieldList)-2);
		
		$req = 'Select '.$fieldList.'
			from redige r
			join article ar on ar.id_article = r.id_article
			join auteur au on au.id_auteur = r.id_auteur
			order by r.id_article ASC';
		
			if(	isset($start) && isset($length) ) {
				$req .= ' limit '.$start.', '.$length;
			}
		
		$request = new SQLRequest();
		$request->setRequest($req.';');
		
		return DBUtils::read($request)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function idsToString($ids) {
		$idList = "";
		foreach($ids as $id){
			$idList .= $id.', ';
		}
		
		return substr($idList, 0, strlen($idList)-2);
	}
}

?>
