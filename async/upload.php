<?php

require("config.php");

if (isset($_FILES['data'])) {
    $ext = pathinfo($_FILES['data']['name'], PATHINFO_EXTENSION);
    if(strtolower($ext) == 'json') {

        $req = $bdd->prepare("INSERT INTO data (id_user) VALUES (?)");
        $req->execute(array($user['id']));

        $req = $bdd->prepare('SELECT * FROM data WHERE id_user = ? ORDER BY uploaded_datetime DESC LIMIT 1');
        $req->execute(array($user['id']));
    
        $data = $req->fetch();
        $data_id = $data['id'];


        $tmpFile = $_FILES['data']['tmp_name'];
        $imgPath = '../userdata/';
        $imgName = "data_".$data_id . ".json";

        if (is_uploaded_file($tmpFile)) {
            if(move_uploaded_file($tmpFile, $imgPath . $imgName)) {
            header("Location: ../dashboard/?status=success"); exit();
        }
        } else {
            header("Location: ../dashboard/?status=error"); exit();
        }
    
    } else {
        header("Location: ../dashboard/?status=format"); exit();
    }

}

?>