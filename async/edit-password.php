<?php

require("config.php");

if (!empty($_POST['email'])) {
  if ($_POST['email'] != $user['email']) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 
    
      $req = $bdd->prepare("UPDATE users SET email = ? WHERE id = ?");
      $req->execute(array($email, $user['id']));
      header("Location: ../dashboard/account.php?=success-email"); exit();
      
    } else {
      header("Location: ../dashboard/account.php?status=format");
      exit(); 
    }
  } 
} else {
  header("Location: ../dashboard/account.php?error=email-field");
   exit();
}
if (!empty($_POST['password']) && !empty($_POST['confirm-password']) && !empty($_POST['current-password'])) { // Check if all fields are filled
      
      if (password_verify($_POST['current-password'], $user['password'])) {
        $password = $_POST['password'];
        $passwordc = $_POST['confirm-password'];

          if ($password == $passwordc) {
             if (preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) { // Check if password meets security requirements

                $req = $bdd->prepare("UPDATE users SET password = ? WHERE id = ?");
                $req->execute(array(password_hash($password, PASSWORD_DEFAULT), $user['id']));

                header("Location: ../logout.php?status=success-pwd"); exit();
             } else {
                  header("Location: ../dashboard/account.php?status=security");
                  exit();
             }
          } else {
              header("Location: ../dashboard/account.php?status=pwd-match");
               exit();     
          }

      } else {
          header("Location: ../dashboard/account.php?status=incorrect");
          exit();
      }
} else { 
    header("Location: ../dashboard/account.php?status=fields");
    exit();
}

header("Location: ../dashboard/account.php?");
exit();