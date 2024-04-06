<?php
/*
	This PHP script queries a database table for "largeur" values based on user input, specifically the "hauteur" value sent through a POST request. It connects to the database using the 'connect.php' file.

	If the "hauteur" value is not empty in the POST request:
	1. It retrieves "largeur" values from the 'catalogue_cdc' table that match the provided 'type_cdc' and 'hauteur'.
	2. Finds the maximum "largeur" value within the retrieved set.
	3. Displays an HTML <option> element with the maximum "largeur" value as both its value and text content.
	4. Generates individual <option> elements for each "largeur" value fetched from the database result set.

	Note: Input validation and sanitization are not included in this code snippet, making it vulnerable to security risks like SQL injection.

	Abbreviation: cdc => chemin de câbles / res => résultat
*/
require_once('connect.php');
if (!empty($_POST["hauteur"])) {
	$typeCdc = $_POST["type_cdc"];
	$hauteur = $_POST["hauteur"];

	$res = $db->Select("SELECT `largeur` FROM `catalogue_cdc` WHERE `type_cdc` = ? AND `hauteur` = ?", array($typeCdc, $hauteur));
	$resLargeurs = array_column($res, "largeur");

	$maxLargeur = max($resLargeurs);

	echo '<option value="' . $maxLargeur . '">' . $maxLargeur . '</option>';

	foreach ($res as $largeurs) {
		echo '<option value="' . $largeurs["largeur"] . '">' . $largeurs["largeur"] . '</option>';
	}
}?>
