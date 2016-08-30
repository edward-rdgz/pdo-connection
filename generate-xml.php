<?php

require_once('functions.php');

$fun = new functions(); // INSTANCIA DE LA CLASE
$sql = "SELECT * FROM multas";
$labelname = "transitnet";
$filename = "multas";
$fun->generateXML($sql, $labelname, $filename); // ESPECIFICACION DEL ARCHIVO XML

/*function gallery() {
	$gal = simplexml_load_file("url...");
	foreach($parent->children() as $child) {
		echo $child->getName();
	}
}*/

$fun->email();
?>