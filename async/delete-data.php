<?php

require("config.php");

$id = $_GET['id'];

$req = $bdd->prepare('SELECT * FROM data WHERE id = ?'); // Get the data in DB from ID
$req->execute(array($id));

$data = $req->fetch();

if ($data['id_user'] == $user['id']) { // Check if the data belong to the user
    $req = $bdd->prepare('DELETE FROM data WHERE id = ?'); // Delete the data
    $req->execute(array($id));

    unlink("../userdata/data_".$id.".json"); // Delete file

    // Redirect after success
    header("Location: ../dashboard/account.php?delete=success");
    exit();
} else {
    header("Location: /");
    exit();
}