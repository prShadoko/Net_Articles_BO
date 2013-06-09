<?php
/**
 * Dump and display a variable.
 * @param mixed $var The variable to dump.
 */
function debug($var) {
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}
?>
