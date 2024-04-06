<?php
/*
	This PHP script loads data related to specific "hauteur" values from a database table based on user input. It requires a connection to the database established in the 'connect.php' file.

	If the POST variable 'type_cdc' is not empty:
	It queries the database to fetch distinct 'hauteur' values from the 'catalogue_cdc' table that correspond to the provided 'type_cdc'.
	For each retrieved 'hauteur' value, it generates an HTML dropdown option displaying the 'hauteur' value.
	The generated dropdown options allow users to select different 'hauteur' values based on the 'type_cdc' submitted via the POST request.
	Note: This code snippet should be used within an HTML form and may benefit from input validation and sanitization for security and robustness.

	Abbreviation: cdc => chemin de câbles / res => résultat
*/
require_once('connect.php');
if(!empty($_POST["type_cdc"])) {
	$typeCdc = $_POST["type_cdc"];
	$res = $db->Select("SELECT DISTINCT(`hauteur`) FROM `catalogue_cdc` WHERE `type_cdc` = ? ", array($typeCdc));
	?>

	<option value="">Sélectionnez la hauteur</option>

	<?php
	foreach ($res as $hauteurs) {
		?>
		<option value="<?php echo $hauteurs["hauteur"]; ?>"><?php echo $hauteurs["hauteur"]; ?></option>
		<?php
	}
}?>