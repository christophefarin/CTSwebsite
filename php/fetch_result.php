<?php
// This script is designed to handle server-side processing for DataTables. For more information about the DataTables plugin, visit https://datatables.net/manual/server-side.
// To understand asynchronous HTTP requests using Ajax, refer to the documentation at https://api.jquery.com/jquery.ajax/.

// Display PHP errors (place this at the beginning of your PHP scripts)
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Start a session if not already started
if (session_status()==1) { //_DISABLED = 0, _NONE = 1, _ACTIVE = 2
    session_start();
}

// Include the connection to the database
require_once('connect.php');

// Define the columns to be fetched from the database table
$column = array("id", "type_cdc", "largeur", "hauteur", "charge_max", "poids");

// Retrieve POST data for query parameters: type_cdc, hauteur, result_diam, largeurmax, result_poids, result_section
// Format and set default values for query parameters
$typeCdcForequest = $_POST['type_cdc'];
if(!empty($_POST["hauteur"])) {
$hauteurForequest = $_POST['hauteur'];}
else {$hauteurForequest = "";}
if(!empty($_POST["result_diam"])) {
$largeurCibleForequest = number_format($_POST['result_diam'],2,'.','');}
else {$largeurCibleForequest = "";}
if(!empty($_POST["largeurmax"])) {
$largeurMaxForequest = ($_POST['largeurmax']);}
else {$largeurMaxForequest = "";}
if(!empty($_POST["result_poids"])) {
$chargeCibleForequest = number_format($_POST['result_poids'],2,'.','');}
else {$chargeCibleForequest = "";}
if(!empty($_POST["result_section"])) {
$volumeCibleForequest = number_format($_POST['result_section'],2,'.','');}
else {$volumeCibleForequest = "";}

// Construct the SQL query based on the received parameters for filtering data
$queryInit = "SELECT id, type_cdc, largeur, hauteur, charge_max, poids FROM catalogue_cdc WHERE type_cdc LIKE '$typeCdcForequest' AND largeur >= '$largeurCibleForequest' AND largeur <= '$largeurMaxForequest' AND hauteur='$hauteurForequest' AND charge_max>='$chargeCibleForequest' AND section_max>='$volumeCibleForequest'";

// Query to determine data pagination in the table based on the 'length' and 'start' parameters from DataTables
$queryPage = '';

if($_POST["length"] != -1)
{
 $queryPage = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

// Execute the SQL query with pagination and order by clause
$queryElse = $queryInit .=' ORDER BY id ASC ';
// Get total number of filtered rows
$numberFilterRow = $db->Count($queryElse);
// Fetch data matching the pagination criteria
$result=$db->Select($queryElse . $queryPage);

// Get the data corresponding to the pagination
$data = array();

foreach($result as $row)
{
 $sub_array = array();
 $sub_array[] = $row['id'];
 $sub_array[] = $row['type_cdc'];
 $sub_array[] = $row['largeur'];
 $sub_array[] = $row['hauteur'];
 $sub_array[] = $row['charge_max'];
 $sub_array[] = $row['poids'];
 $data[] = $sub_array;
}

// Prepare output array with necessary information like draw count, total records, filtered records, and data to be displayed
$output = array(
 'draw'   => intval($_POST['draw']),
 'recordsTotal' => $countAllData = $db->Count($queryInit),
 'recordsFiltered' => $numberFilterRow,
 'data'   => $data
);

// Return the output data as JSON for DataTables to consume
echo json_encode($output);

// Close the database connection
$db->Close();

?>
