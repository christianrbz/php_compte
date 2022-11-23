<?php 

// DECLARATION DE LA SESSION 
// C'est obligatoire de le déclarer au tout début de notre site 
session_start();

try {
    
    $type_bdd = "mysql";
    $host = "localhost";
    $dbname = "php_compte";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC // Ici je définis que le mode de récupération des données par défaut sera sous forme associative
    ];

    $bdd = new PDO("$type_bdd:host=$host;dbname=$dbname", $username, $password, $options);

} catch (Exception $e) {
    die("ERREUR CONNEXION BDD : " . $e->getMessage());	
}

define( "RACINE_SITE", str_replace( "\\", "/", str_replace( "inc", "", __DIR__ ) ) );


define("URL", "http://$_SERVER[HTTP_HOST]".str_replace($_SERVER['DOCUMENT_ROOT'], "", RACINE_SITE));


// Appel de mes fonctions 
require_once "functions.php";

// Décalration des variables "globales"
$errorMessage = "";
$successMessage = "";
