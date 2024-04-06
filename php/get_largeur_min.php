<?php
/*
	This PHP script retrieves data from a database table based on user input, specifically the "hauteur" value sent through a POST request.
	It requires a connection to the database through the 'connect.php' file.

	If the "hauteur" value is not empty in the POST request, a SQL query is executed to fetch the "largeur" values from the 'catalogue_cdc' table
	that match the provided 'type_cdc' and 'hauteur'.

	The script then generates HTML <option> elements based on the retrieved data:
	- The minimum "largeur" value is displayed as an option with the corresponding value.
	- Following that, each unique "largeur" value fetched is displayed as an individual option.

	Note: This code snippet lacks proper input validation and sanitization, which can lead to security vulnerabilities like SQL injection.

	Abbreviation: cdc => chemin de câbles / res => résultat
*/
require_once('connect.php');
if (!empty($_POST["hauteur"])) {
	$typeCdc = $_POST["type_cdc"];
	$hauteur = $_POST["hauteur"];

	$res = $db->Select("SELECT `largeur` FROM `catalogue_cdc` WHERE `type_cdc` = ? AND `hauteur` = ?", array($typeCdc, $hauteur));
	$resLargeurs = array_column($res, "largeur");

	echo '<option value="' . min($resLargeurs) . '">' . min($resLargeurs) . '</option>';

	foreach ($res as $largeurs) {
		echo '<option value="' . $largeurs["largeur"] . '">' . $largeurs["largeur"] . '</option>';
	}
}?>
