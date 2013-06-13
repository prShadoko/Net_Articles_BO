<?php
require_once 'model/Right.php';
require_once 'Controller.php';

class RightController extends Controller {
	
	private $_rows;
	private $_page;
	private $_pageCount;
	
	private static $length = 6;

	public function run($action) {
		
		if($action == 'update') {
			Right::update();
		}
		
		$this->initPagination();
		if($this->_pageCount == 0) {
			$this->setRows(Array(Array()));
		}
		else {
			$this->setRows(Right::readableList(($this->getPage() - 1) * self::$length, self::$length));
		}
		
	}
	
	public function initPagination() {

		$this->setPage(BootStrap::getRequest()->getPage());
		$this->setPageCount(ceil(Right::getRowCount() / self::$length));

		if ($this->_page > $this->_pageCount) {
			$this->_page = $this->_pageCount;
		}
	}
	
	public function getPage() {
		return $this->_page;
	}
	
	public function setPage($page) {
		$this->_page = $page;
	}
	
	public function getPageCount() {
		return $this->_pageCount;
	}
	
	public function setPageCount($pageCount) {
		$this->_pageCount = $pageCount;
	}
	
	public function setRows($rows) {
		$this->_rows = $rows;
	}
	
	public function getRows() {
		return $this->_rows;
	}
}

?>
