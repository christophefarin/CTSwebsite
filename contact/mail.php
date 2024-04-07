<?php
//fichier mail.php

//on inclus le script autoloader du CAPTCHA
require_once 'autoload.php';

//affichage des erreurs PHP ( A mettre au début de tes scripts PHP )
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//démarrage une session si pas déjà démarrée
if (session_status()==1) { //_DISABLED = 0, _NONE = 1, _ACTIVE = 2
    session_start();
}
//Modifier l'entête de la requète HTTP pour préciser le type de données que le client va reçevoir
header('Content-Type: application/json; charset=utf-8');

//CAPTCHA
//vérification si le champ "grecaptcharesponse" contient une valeur
if(isset($_POST['grecaptcharesponse']) && !empty($_POST['grecaptcharesponse'])){
    $recaptcha = new \ReCaptcha\ReCaptcha("6Lxxxxxxxxxxxxxxxxxxx");

    $resp = $recaptcha->setExpectedHostname('localhost')
    ->verify($_POST['grecaptcharesponse']);

    if ($resp->isSuccess()) {
        //captacha validé
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        if ($name === '') {
            print json_encode(array('message' => 'Nom ne doit pas être vide', 'code' => 0));
            exit();
        }
        if ($email === '') {
            print json_encode(array('message' => 'E-mail ne doit pas être vide', 'code' => 0));
            exit();
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                print json_encode(array('message' => 'Format de l\'e-mail invalide', 'code' => 0));
                exit();
            }
        }
        if ($message === '') {
            print json_encode(array('message' => 'Message ne doit pas être vide', 'code' => 0));
            exit();
        }

        $to = "your@email.com";  //recipient email address
        $subject = "Contact From website";  //Subject of the email
        //Message content to send in an email
        $message = 'Name: '.$name."\n".'Email: '.$email."\n".'Message: '.$message;
        //Email headers
        $headers = "From:".$email."\r\n";
        $headers .= "Reply-To:".$email."\r\n";
        //Send email 
        mail($to, $subject, $message, $headers) or die("Error!");
        print json_encode(array('message' => 'E-mail envoyé!', 'code' => 1));
        exit();
    } else {
        //captacha invalide
        $errors = $resp->getErrorCodes();
        print json_encode(array('message' => 'Captcha invalide', 'code' => 0));
        exit();
    }
} else {
    //Robot verification failed
    print json_encode(array('message' => 'Test Captcha a échoué, veuillez réessayer', 'code' => 0));
    exit();
    } 
;
?>
