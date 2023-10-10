<?php

session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=sporttrack;charset=utf8', 'lou', 'Linux4018!');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// Google Recaptcha
function recaptcha() {
    $secret = '6LckjHUoAAAAAFjAE1gcDtYh1ac48-6iXKbh2Aax';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $api_url = 'https://www.google.com/recaptcha/api/siteverify?' 
        .'secret='.$secret
        .'&response='.$response
        .'&remoteip='.$remoteip;
    
    $decode = json_decode(file_get_contents($api_url), true);
        
    if ($decode['success'] == true) {
        return true;
    } else {
        return false;
    }
}

// Clé pour la génération du cookie de reconnexion
$cookie_key = 'Vj9n8VNY@]jL-93Fs%s4Qsrr_45]J5@)!';

// Reconnexion auto avec cookie
if (!isset($_SESSION['id']) AND !isset($_SESSION['password']) AND !empty($_COOKIE['autologin'])) {
    $autologin = json_decode(openssl_decrypt($_COOKIE['autologin'], 'AES-128-ECB', $cookie_key), true);

    if (!empty($autologin['id']) AND !empty($autologin['password'])) {
        $req = $bdd->prepare('SELECT * FROM users WHERE id = ? AND password = ?');
        $req->execute(array($autologin['id'], $autologin['password']));

        if ($req->rowCount() == 1) {
            $r = $req->fetch();

            $_SESSION['id'] = $r['id'];
            $_SESSION['password'] = $r['password'];
        }
    }
}

// Vérification de la connexion
if (!empty($_SESSION['id']) AND !empty($_SESSION['password'])) {
	$req = $bdd->prepare('SELECT * FROM users WHERE id = ? AND password = ?');
	$req->execute(array($_SESSION['id'], $_SESSION['password']));
	
	if ($req->rowCount() == 1) {
        $user = $req->fetch();
    }
}


// Check user login
function check_login() {
    if (!empty($_SESSION['id']) AND !empty($_SESSION['password'])) {
        return true;
    } else {
		
        return false;
    }
}

?>