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

// Include the class which allows you to manage the basket
require_once "class_cart.php";

// Construct the cart object
$oPanier = new cart();

// Reset cart display
$reseTabcart=intval($_POST['draw']);

// Fetches the number of unique products in the cart
$nbIdProducts = $oPanier->getNbIdProductsInCart();

// Retrieves the list of products in the cart 
$contenuPanier = $oPanier->getList();

// Constructs an array containing product details for display in DataTables
if(!empty($nbIdProducts))
{
foreach($contenuPanier as $row)
{
 $sub_array = array();
 $sub_array[] = $row['id'];
 $sub_array[] = $row['produit'];
 $sub_array[] = $row['diametre'];
 $sub_array[] = $row['poids'];
 $sub_array[] = $row['section'];
 $sub_array[] = $row['nombre'];
 $data[] = $sub_array;
}
}
else {$data = array();}

// Return the data and parameters to DataTables
$output = array(
 'draw'   => $reseTabcart,
 'recordsTotal' => $nbIdProducts,
 'recordsFiltered' => $nbIdProducts,
 'data'   => $data
);

// Return the output data as JSON for DataTables to consume
echo json_encode($output);
?>
