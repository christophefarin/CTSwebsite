<?php
/*
    This PHP script performs the following tasks:

    Error Reporting Setup:
    - It sets up PHP error reporting to display all errors and warnings, aiding in debugging.
    
    Session Initialization:
    - Checks if a session is already active; if not, it starts a new session.
    
    Including Necessary Class:
    - Includes the "class_cart.php" file which contains the class responsible for managing the cart functionality.
    
    Creating Cart Object:
    - Initializes an object named $oPanier from the cart class to manage the shopping cart operations.
    
    Calculating Sums in Cart:
    - Calls the getSumsInCart method on the cart object to calculate sums within the cart.
    
    Output:
    - Encodes the calculation results in JSON format using json_encode and outputs the result.
*/

// Display PHP errors (place this at the beginning of your PHP scripts)
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Start a session if not already started
if (session_status()==1) { //_DISABLED = 0, _NONE = 1, _ACTIVE = 2
    session_start();
}
// Include the class which allows you to manage the cart
require_once "class_cart.php";

// Construct the cart object
$oPanier = new cart();

// Get the quantities in the cart
$calculs = $oPanier->getSumsInCart();

// Return the output data as JSON
echo json_encode($calculs);

?>
