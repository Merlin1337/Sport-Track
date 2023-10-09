<?php

require("config.php");

if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['birthdate']) && !empty($_POST['weight']) && !empty($_POST['height']) && !empty($_POST['email']) && !empty($_POST['gender']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])) { // Check if all fields are filled
  if (recaptcha()) { // Check if reCaptcha has been solved
    $email = htmlspecialchars($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Check email format
      $weight = htmlspecialchars($_POST['weight']);
      $height = htmlspecialchars($_POST['height']);

      if (is_numeric($weight) && is_numeric($height)) {
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $gender = htmlspecialchars($_POST['gender']);

        if (in_array($_POST['gender'], array('male', 'female', 'other'))) { // Check if gender entered matches existing gender
          $birthdate = explode('/', htmlspecialchars($_POST['birthdate']));
          $birthdateSQL = $birthdate[2] . $birthdate[1] . $birthdate[0];

          $password = $_POST['password'];
          $passwordc = $_POST['confirm-password'];

          if (preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) { // Check if password meets security requirements
            if ($password == $passwordc) {
              $req = $bdd->prepare('SELECT * FROM users WHERE email = ?'); // Check if user doesn't exist yet in db
              $req->execute(array($email));
              if ($req->rowCount() == 0) {
                // Insert user in DB
                $req = $bdd->prepare("INSERT INTO users (last_name, first_name, gender, birthdate, weight, height, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $req->execute(array($lastname, $firstname, $gender, $birthdateSQL, $weight, $height, $email, password_hash($password, PASSWORD_DEFAULT)));
                
                // Log the user + redirect to dashboard

                $_SESSION['id'] = $user['id']; // Assign login data to user session
                $_SESSION['password'] = $user['password'];

                $autologin['id'] = $user['id'];
                $autologin['password'] = $user['password'];

                $autologin = openssl_encrypt(json_encode($autologin), 'AES-128-ECB', $cookie_key); // Encrypts login data

                setcookie('autologin', $autologin, time() + 7 * 24 * 60 * 60, '/', $_SERVER['HTTP_HOST'], false, true); // /!\ Penser à changer false en true (secure => localhost / domaine

                
                header("Location: ../dashboard/?success"); 
                exit;
              } else {
                header("Location: ../register?error=exist");
                exit;
              }
            }
          } else {
            header("Location: ../register?error=password");
            exit;
          }
        } else {
          header("Location: ../register?error=gender");
          exit;
        }
      } else {
        header("Location: ../register?error=invalid-value");
        exit;
      }
    } else {
      header("Location: ../register?error=email");
      exit;
    }
  } else {
    header("Location: ../register?error=captcha");
    exit;
  }
} else {
  header("Location: ../register?error=fields");
  exit;
}
