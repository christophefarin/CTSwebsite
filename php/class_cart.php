<?php
/**
*  This class represents a cart that stores products in a session.
*  Source: https://codes-sources.commentcamarche.net/source/102874-php-panier-caddi-virtuel-en-session
*/
class cart{
  
  /**
  * Constructor for the class
  * Initializes the shopping cart if not already created
  */
  function __construct(){
    // Start sessions if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Initialize the cart if not already created
    if(!isset($_SESSION['panier'])){
    $this->initCart();
    }
  }
  
  /**
  * Initializes an empty cart in the session
  */
  public function initCart(){
    $_SESSION['panier'] = array(); 
  }
  
  /**
  * Get the list of products in the cart
  * Returns NULL if the cart is empty
  */
  public function getList(){
    return !empty($_SESSION['panier']) ? $_SESSION['panier'] : NULL;
  }
  
  /**
  * Add a product to the cart with quantity
  * Calculates sum values per product based on quantity
  */
  public function addProduct($idProduit,$libelleProduit,$diametreExterieurProduit,$poidsProduit,$sectionUtileProduit,$qte=1){
    if($qte > 0 ){
      $_SESSION['panier'][$idProduit] = array('id'=>$idProduit
                                                ,'produit'=>$libelleProduit
                                                ,'diametre'=>$diametreExterieurProduit
                                                ,'poids'=>$poidsProduit
                                                ,'section'=>$sectionUtileProduit
                                                ,'nombre'=>$qte
                                                ); 
      $this->updateSumOfProduct($idProduit);
    }else{
      return "ERREUR : Vous ne pouvez pas ajouter un produit sans quantité..."; 
    }
  }
  
  private function updateSumOfProduct($idProduit){
    if(isset($_SESSION['panier'][$idProduit])){
      $_SESSION['panier'][$idProduit]['diametre_Sum'] = $_SESSION['panier'][$idProduit]['nombre'] * $_SESSION['panier'][$idProduit]['diametre'];
      $_SESSION['panier'][$idProduit]['poids_Sum'] = $_SESSION['panier'][$idProduit]['nombre'] * $_SESSION['panier'][$idProduit]['poids'];
      $_SESSION['panier'][$idProduit]['section_Sum'] = $_SESSION['panier'][$idProduit]['nombre'] * $_SESSION['panier'][$idProduit]['section'];
    }
  }
  
  /**
  * Updates the quantity of a product in the cart
  */
  public function updateQteProduct($idProduit,$qte=0){
    if(isset($_SESSION['panier'][$idProduit])){
      if ($qte==0){$this->removeProduct($idProduit);}
      else{
      $_SESSION['panier'][$idProduit]['nombre'] = $qte;
      $this->updateSumOfProduct($idProduit);}
    }else{
      return "ERREUR : produit non présent dans le panier"; 
    }
  }
  
  /**
  * Removes a product from the cart
  */
  public function removeProduct($idProduit){
    if(isset($_SESSION['panier'][$idProduit])){
      unset($_SESSION['panier'][$idProduit]);
    }
  }
  
  /**
  * Get the total number of products in the cart
  */
  public function getNbProductsInCart(){
    $nb = 0;
    $panier = !empty( $_SESSION['panier'] ) ? $_SESSION['panier'] : NULL;
    if(!empty($panier)){
      foreach($panier as $P){ 
        $nb += $P['nombre'];
      }
    }
    return $nb;
  }

  /**
  * Get the number of unique products in the cart
  */
  public function getNbIdProductsInCart(){
    $nbyId = 0;
    $panier = !empty( $_SESSION['panier'] ) ? $_SESSION['panier'] : NULL;
    if(!empty($panier)){
        $nbyId = count($panier);
    }
    return $nbyId;
  }
  
  /**
  * Get total sums (diameters, weights, sections) and maximum diameter of products in the cart
  */
  public function getSumsInCart(){
    $totalDiametre = 0;
    $totalPoids = 0;
    $totalSection = 0;
    $maxDiametre = 0;
    // Retrieve the cart items from the session or set it to NULL if empty
    $panier = !empty( $_SESSION['panier'] ) ? $_SESSION['panier'] : NULL;
    // Calculate sums only if the cart is not empty
    if(!empty($panier)){
      foreach($panier as $P){ 
        $totalDiametre += $P['diametre_Sum'];
        $totalPoids += $P['poids_Sum'];
        $totalSection += $P['section_Sum'];
        $maxDiametre = max($maxDiametre,$P['diametre']);
      }
    }
    // Format the calculated sums to two decimal places
    $totalDiametreRoud = number_format($totalDiametre,2,'.','');
    $totalPoidsRoud = number_format($totalPoids,2,'.','');
    $totalSectionRoud = number_format($totalSection,2,'.','');
    $maxDiametreRoud = number_format($maxDiametre,2,'.','');

    // Return the formatted sums as an array
    return [$totalDiametreRoud, $totalPoidsRoud, $totalSectionRoud, $maxDiametreRoud];
    /** 
    * Example usage to destructure the array returned by this function:
    * [$a, $b, $c, $d] = destructingFunction();
    * echo $a; //output: $maxdiam
    * echo $b; //output: $totaldiam
    * echo $c; //output: $totalpoids
    * echo $d; //output: $totalsection
    */
  }
  
}