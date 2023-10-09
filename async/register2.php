<?php

require("config.php"); // Link db to file

if(count(array_filter($_POST))==count($_POST)) { // Check if all fields are filled
    $email = htmlspecialchars($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Check email format
        // add "check if exist"
        // password_hash()
        $last_name = htmlspecialchars($_POST['lastname']);
        $first_name = htmlspecialchars($_POST['firstname']);

        $req = $bdd->prepare("INSERT INTO users (last_name, first_name, gender, birth_date, weight, height, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $req->execute(array(htmlspecialchars($_POST['']), ));
      } else {
        header("Location: ../register?error=email"); exit;
      }
} else {
    header("Location: ../register?error=fields"); exit;
}





?>