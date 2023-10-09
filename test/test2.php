<?php

require("../async/config.php");

$age = $_POST['age'];
$bouffe = $_POST['bouffe'];

$req = $bdd->prepare("INSERT INTO test (age, miaou) VALUES (?, ?)");
$req->execute(array($age, $bouffe));

echo("ça a marché youhou");

header("Location: test.php"); exit;

?>