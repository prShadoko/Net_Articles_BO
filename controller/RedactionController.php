<?php
require_once 'model/Redaction.php';
require_once 'model/Article.php';
require_once 'model/Author.php';
require_once 'FormValidator.php';
require_once 'CRUDController.php';

class RedactionController extends CRUDController {
	
	private $_redaction;
	private $_articleList;
	private $_authorList;
	private $_part;
	private $_rows;
	private $_article;
	
	protected function create() {
		$params = BootStrap::getRequest()->getParameters();
		if(!isset($params['id']) ) {
			header('location: '.BootStrap::getRequest()->getURL(null, 'read'));
		}
		
		$this->setView('redactionCreate');
		
		$this->_rows = Author::identityList();
		$this->_authorList = Redaction::authorList($params['id']);
		$this->_article = new Article();
		$this->_article->read($params['id']);
	}

	protected function delete() {
		
	}

	protected function read() {
		
		
		$params = BootStrap::getRequest()->getParameters();
		
		if(isset($params['update']) && isset($params['id'])) {
			header('location: '.BootStrap::getRequest()->getURL(null, 'create', Array('id'=>$params['id'])));
		}
		
		
		
		$this->setView('redactionRead');
		
		$this->_articleList = Article::titleList();
		
		$this->_article = 0;
		if(isset($params['id'])) {
			$this->_article = $params['id'];
		}
		else {
			$this->_article = $this->_articleList[0]['id'];
		}
		$this->_rows = Redaction::readableList($this->_article);
	}

	protected function update() {
		
		$params = BootStrap::getRequest()->getParameters();
		
		if(!isset($params['id'])) {
			header('location: '. BootStrap::getRequest()->getURL(null, 'read'));
			exit;
		}
		
		if(isset($params['create']) || !isset($params['authors'])) {
			header('location: '. BootStrap::getRequest()->getURL(null, 'create', Array('id'=>$params['id'])));
			exit;
		}
		
		$this->_article = new Article();
		$this->_article->read($params['id']);
				
		if(isset($params['validate'])) {
			$parts = $params['parts'];
			$totalPart = 0;
			foreach($parts as $part) {
				$totalPart += $part;
			}
			foreach($parts as $k => $part) {
				$parts[$k] = $part / $totalPart * 100;
			}
			
			$validator = $this->validate($params);
			if($validator->isValid()) {
				
				$authors = $params['authors'];
				foreach ($authors as $k => $v) {
					if($parts[$k] == 0) {
						unset($parts[$k]);
						unset($authors[$k]);
					}
				}
				
				
				Redaction::updateDB($this->_article->getId(), $authors, $parts);
				
				header('location: '.BootStrap::getRequest()->getURL(null,'read', Array('id'=>$params['id'])));
			}
		}
		
		$this->setView('redactionUpdate');
		
		//$this->_article = $params['id'];
		
		$this->_rows = Redaction::significantFieldList($this->_article->getId(), $params['authors']);//Author::significantFieldList($params['authors']);
		
		$this->_authorList = Author::identityList($params['authors']);
		
	}
	
	public function validate($rs) {
		$validator = new FormValidator();
		$validator->addValidator('parts', 'number', 'Les parts doivent être des nombres.');
		$validator->addValidator('parts', 'sum', 'La somme des parts doit être égales à 100.', 100);
		
		if($validator->validate($rs)) {
			$this->setUserMessages($validator->getConfirmMessage());
			$this->isAnErrorMessage(false);
		}
		else {
			$this->setUserMessages($validator->getErrors());
			$this->isAnErrorMessage(true);
		}
		
		return $validator;
	}
	
	public function getRows() {
		return $this->_rows;
	}
	
	public function getArticleList() {
		return $this->_articleList;
	}
	
	public function getAuthorList() {
		return $this->_authorList;
	}
	
	public function getArticle() {
		return $this->_article;
	}
	
	
	public function getPart() {
		return $this->_part;
	}
}

?>
