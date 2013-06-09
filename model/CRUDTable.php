<?php

interface CRUDTable {
	
	/**
	 * Must read an entry from the DB and put datas into attributes.
	 * @param number $id The identifiant of the entry in the table.
	 */
	public function read($id);

	/**
	 * Must put data from a result set into attributes.
	 * @param Array $rs Data from a result set.
	 */
	public function affectValue($rs);
	
	/**
	 * Must update the DB with the datas from the object.
	 */
	public function updateDB();

	/**
	 * Must be return a list of readable entries from DB.
	 * @param number $start The number of the entry to start.
	 * @param number $length The number of the entry to return.
	 */
	public static function readableList($start, $length);
	
	/**
	 * Must be return a list of significants fields from DB.
	 * @param Array $ids Identifiants of entries.
	 */
	public static function significantFieldList($ids);
	
	/**
	 * Must delete entries to DB.
	 * @param type $ids Identifiants of entries.
	 */
	public static function delete($ids);
	
	/**
	 * Must get the count of articles from the DB.
	 */
	public static function getArticleCount();
	
}

?>
