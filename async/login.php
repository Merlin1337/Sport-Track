<?php

require("config.php");

if (check_login()) {
    header("Location: ../dashboard");
    exit();
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    if (recaptcha()) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $req = $bdd->prepare('SELECT * FROM users WHERE email = ?'); // Check if user exist in DB
    $req->execute(array($email));

    if ($req->rowCount() > 0) {
        $user = $req->fetch();

        if (password_verify($password, $user['password'])) {

            $_SESSION['id'] = $user['id']; // Assign login data to user session
            $_SESSION['password'] = $user['password'];

            if (isset($_POST['remember'])) {
                $autologin['id'] = $user['id'];
                $autologin['password'] = $user['password'];

                $autologin = openssl_encrypt(json_encode($autologin), 'AES-128-ECB', $cookie_key); // Encrypts login data

                setcookie('autologin', $autologin, time() + 7 * 24 * 60 * 60, '/', $_SERVER['HTTP_HOST'], false, true); // /!\ Penser à changer false en true (secure => localhost / domaine) + LOGOUT
            }

            header("Location: ../dashboard/?status=login-success"); 
            exit(); // Redirect login after success

        } else {
            header("Location: ../login.php?status=password");
            exit();
        }
    } else {
        header("Location: ../login.php?status=exist");
        exit();
    }
} else {
    header("Location: ../login.php?status=captcha");
    exit();
}
} else {
    header("Location: ../login.php?status=fields");
    exit();
}
