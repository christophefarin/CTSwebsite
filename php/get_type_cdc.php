<?php
/*
	This PHP script establishes a connection to a database using 'connect.php' and then fetches distinct values of 'type_cdc' from the 'catalogue_cdc' table.

	The retrieved unique 'type_cdc' values are used to create HTML <option> elements for a dropdown menu.

	- Initially, an empty string named $options is defined.
	- A foreach loop iterates over the distinct 'type_cdc' values fetched from the database, constructing <option> tags for each value.
	- These <option> tags are appended to the $options string in the format "<option value='value'>Display Text</option>".
	- Finally, a default option "<option value=''>Sélectionnez le type</option>" followed by the constructed options based on 'type_cdc' values is echoed out.

	Note: The script does not perform input validation or output escaping, which can lead to security vulnerabilities if used with untrusted data.

	Abbreviation: cdc => chemin de câbles / res => résultat
*/
require_once('connect.php');

$res = $db->Select("SELECT DISTINCT(`type_cdc`) FROM `catalogue_cdc`");

$options = '';
foreach ($res as $types) {
	$options .= "<option value=\"{$types['type_cdc']}\">{$types['type_cdc']}</option>";
}

echo '<option value="">Sélectionnez le type</option>';
echo $options;
?>