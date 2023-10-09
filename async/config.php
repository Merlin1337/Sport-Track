<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=sporttrack;charset=utf8', 'root', '');
} catch(Exception $e) {
    exit();
    die('Erreur : '.$e->getMessage());
}

?>