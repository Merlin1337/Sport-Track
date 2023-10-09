<?php


if (isset($_FILES['data'])) {
    $ext = pathinfo($_FILES['data']['name'], PATHINFO_EXTENSION);
    if(strtolower($ext) == 'json') {
        $tmpFile = $_FILES['data']['tmp_name'];
        $imgPath = '../userdata/';
        $imgName = "miaou" . "." . $ext;

        if (is_uploaded_file($tmpFile)) {
            if(move_uploaded_file($tmpFile, $imgPath . $imgName)) {
            header("Location: ../dashboard/?status=success"); exit;
        }
        } else {
            header("Location: ../dashboard/?status=error"); exit;
        }
    
    } else {
        header("Location: ../dashboard/?status=format"); exit;
    }

}

?>