<?php
$dir = "foldername/";
$filesArray = ["image1", "image2", "image3", "cir1", "cir2", "cir3", "cir4", "cir5"];
foreach ($filesArray as $item) {
    if (isset($_FILES[$item]['name']) && ($_FILES[$item]['name'] != null)) {
        ($dataArray[$item] =  time() . "-" . $_FILES[$item]['name']);
        move_uploaded_file($_FILES[$item]['tmp_name'], ($dir . $dataArray[$item]));
    }
}







// with ext validation

$dir = "foldername/";
$filesArray = ["image1", "image2", "image3", "cir1", "cir2", "cir3", "cir4", "cir5"];
foreach ($filesArray as $item) {
    if (isset($_FILES[$item]['name']) && ($_FILES[$item]['name'] != null)) {
        if (in_array($ext, array('jpeg', 'png', 'jpg', 'JPG', 'PNG'))) {
            ($dataArray[$item] =  time() . "-" . $_FILES[$item]['name']);
            move_uploaded_file($_FILES[$item]['tmp_name'], ($dir . $dataArray[$item]));
        } else {
            $msg = "<div class=\"alert alert-danger\" role=\"alert\">Only jpeg', 'png', 'jpg', 'JPG', are allowed </div>";
        }
    }
}
