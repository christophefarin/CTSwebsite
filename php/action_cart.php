<?php

/**
* This PHP script manages a virtual cart using session variables.
* Source: https://codes-sources.commentcamarche.net/source/102874-php-panier-caddi-virtuel-en-session
*/

// Display PHP errors
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Start a session if not already started
if (session_status() == 1) { //_DISABLED = 0, _NONE = 1, _ACTIVE = 2
    session_start();
}

// Include the class that handles the cart functionality
require_once "class_cart.php";

// Determine the action based on the POST request
if ($_POST['action'] == 'add') {
    $produit = $_POST['type_cable'];
    $diametre = $_POST['diam_ext'];
    $poids = $_POST['poids'];
    $section = $_POST['section_utile'];
    $nombre = 1;
}

if ($_POST['action'] == 'edit') {
    $nombre = $_POST['nombre'];
}

$id = $_POST['id'];
$action = $_POST['action'];

// Initialize the cart object
$oPanier = new cart();

// Perform actions based on the specified action
switch ($action) {
    case "add":
        // Add a product to the cart
        $oPanier->addProduct($id, $produit, $diametre, $poids, $section, $nombre);
        break;

    case "edit":
        // Update the quantity of a product in the cart
        $oPanier->updateQteProduct($id, $nombre);
        break;

    case "delete":
        // Remove a product from the cart
        $oPanier->removeProduct($id);
        break;
}

// Return JSON encoded response
echo json_encode($_POST);

?>