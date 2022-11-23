<?php

/**
 * Fonction DEV qui permet un affichage clair des données (array, string, number...)
 */
function debug($value){
    echo '<pre>';
        print_r($value);
    echo '</pre>';
}

function isConnected(): bool 
{
    return isset($_SESSION['membre']) ? TRUE : FALSE;
}

function isAdmin(): bool 
{
    return isConnected()&&$_SESSION['membre']['status'] === 'admin' ? TRUE : FALSE;
}

