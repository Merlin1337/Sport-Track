<?php

require("config.php");

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $req = $bdd->prepare('SELECT * FROM users WHERE email = ?'); // verif si l'user existe
    $req->execute(array($email));
    if ($req->rowCount() == 1) {
        $user = $req->fetch();
        if (password_verify($password, $user['password'])) {

                $_SESSION['id'] = $user['id']; // attribue les infos de connexions à la session de l'user
                $_SESSION['password'] = $user['password'];

                $autologin['id'] = $user['id'];
                $autologin['password'] = $user['password'];

                $autologin = openssl_encrypt(json_encode($autologin), 'AES-128-ECB', $cookie_key); // Chiffre ses données de connexion

                setcookie('autologin', $autologin, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST'], true, true);

                header("Location: /dashboard"); die; // Redirect login after success

        } else {
            header("Location: ../login?error=password");
            exit;
        }
    } else {
        header("../login.php?error=exist");
        exit;
    }
} else {
    header("Location: ../login.php?error=fields");
    exit;
}

?>