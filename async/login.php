<?php

require("config.php");


$req = $bdd->prepare("INSERT INTO users (email) VALUES (?, ?)");
$req->execute(array($id));


?>