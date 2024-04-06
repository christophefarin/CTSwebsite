<?php
// This script is designed to handle server-side processing for DataTables. For more information about the DataTables plugin, visit https://datatables.net/manual/server-side.
// To understand asynchronous HTTP requests using Ajax, refer to the documentation at https://api.jquery.com/jquery.ajax/.

// Display PHP errors (place this at the beginning of your PHP scripts)
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Start a session if not already started
if (session_status() == 1) { // _DISABLED = 0, _NONE = 1, _ACTIVE = 2
    session_start();
}

// Include the connection to the database
require_once('connect.php');

// Define the columns to be fetched from the database table
$column = array("id", "type_cable", "diam_ext", "poids", "section_utile"); // Removed "nombre"

// Construct the initial SQL query
$queryInit = "SELECT * FROM catalogue_cables";

// Query to determine data pagination in the table based on the 'length' and 'start' parameters from DataTables
$queryPage = '';

if ($_POST["length"] != -1) {
    $queryPage = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

// Handle queries when a value is entered in the search field
if (isset($_POST["search"]["value"])) {
    $querySearch = $queryInit .=' WHERE type_cable LIKE "%'.$_POST["search"]["value"].'%" OR diam_ext LIKE "%'.$_POST["search"]["value"].'%" OR poids LIKE "%'.$_POST["search"]["value"].'%" OR section_utile LIKE "%'.$_POST["search"]["value"].'%"';
    $numberFilterRow = $db->Count($querySearch);
    $result = $db->Select($querySearch . $queryPage);
}

// Handle queries when sorting is activated on a column
if (isset($_POST["order"])) {
    $queryOrder = $queryInit .=' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    $numberFilterRow = $db->Count($queryOrder);
    $result = $db->Select($queryOrder . $queryPage);
} else {
    // Default queries in case of no search or sort
    $queryElse = $queryInit .='ORDER BY id DESC ';
    $numberFilterRow = $db->Count($queryElse);
    $result = $db->Select($queryElse . $queryPage);
}

// Get the data corresponding to the pagination
$data = array();

foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $row['id'];
    $sub_array[] = $row['type_cable'];
    $sub_array[] = $row['diam_ext'];
    $sub_array[] = $row['poids'];
    $sub_array[] = $row['section_utile'];
    $data[] = $sub_array;
}

// Return the data and parameters to DataTables
$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $countAllData = $db->Count($queryInit),
    'recordsFiltered' => $numberFilterRow,
    'data' => $data
);

// Return the output data as JSON for DataTables to consume
echo json_encode($output);

// Close the database connection
$db->Close();
?>