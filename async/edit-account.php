<?php

require("config.php");

if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['birthdate']) && !empty($_POST['weight']) && !empty($_POST['height']) && !empty($_POST['gender'])) { // Check if all fields are filled
      $weight = htmlspecialchars($_POST['weight']);
      $height = htmlspecialchars($_POST['height']);

      if (is_numeric($weight) && is_numeric($height)) {
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $gender = htmlspecialchars($_POST['gender']);

        if (in_array($_POST['gender'], array('male', 'female', 'other'))) { // Check if gender entered matches existing gender
          $birthdate = explode('/', htmlspecialchars($_POST['birthdate']));
          $birthdateSQL = $birthdate[2] . $birthdate[1] . $birthdate[0];

                
                $req = $bdd->prepare("UPDATE users SET last_name = ?, first_name = ?, gender = ?, birthdate = ?, weight = ?, height = ? WHERE id = ?");
                $req->execute(array($lastname, $firstname, $gender, $birthdateSQL, $weight, $height, $user['id']));
                

                    header("Location: ../dashboard/account.php?status=success"); 
                    exit();
        } else {
          header("Location: ../dashboard/account.php?status=gender");
          exit();
        }
      } else {
        header("Location: ../dashboard/account.php?status=invalid-value");
        exit();
      }
} else {
  header("Location: ../dashboard/account.php?status=fields");
  exit();
}
