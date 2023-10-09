<?php

require ("config.php");

if (count(array_filter($_POST)) == count($_POST)) { // Check if all fields are filled
  $email = htmlspecialchars($_POST['email']);
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Check email format
    $weight = htmlspecialchars($_POST['weight']);
    $height = htmlspecialchars($_POST['weight']);
    if (is_numeric($weight) && is_numeric($height)) {
      $lastname = htmlspecialchars($_POST['lastname']);
      $firstname = htmlspecialchars($_POST['firstname']);
      $gender = htmlspecialchars($_POST['gender']);
      if (in_array($_POST['gender']), array('male', 'female', 'other')) {
        $birthdate = htmlspecialchars($_POST['birthdate']);
      }
  } else {
    header("Location: ../register?error=invalid_value"); exit;
  }

} else {
  header("Location: ../register?error=email"); exit;

}

} else {
  header("Location: ../register?error=fields"); exit;
}

?>