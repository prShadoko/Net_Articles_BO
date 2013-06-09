<?php

interface CRUDTable {
	
	public function read($id);

	public function affectValue($rs);
	
	public function updateDB();

	public static function readableList($start, $length);
	
	public static function significantFieldList($ids);
	
	public static function delete($ids);
	
	/*public static function idsToString($ids) {
		$idList = "";
		foreach($ids as $id){
			$idList .= $id.', ';
		}
		
		return substr($idList, 0, strlen($idList)-2);
	}*/
	
	public static function getArticleCount();
	
}

?>
