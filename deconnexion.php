<?php 

// Je fais appel à init car j'ai besoin de session_start(); 
require_once "inc/init.php";

if(isConnected()) {
// J'enlève le membre de la session.
unset($_SESSION['membre']);
}

// Je redirige vers la page souhaitée.
header("location:connexion.php");
exit;

