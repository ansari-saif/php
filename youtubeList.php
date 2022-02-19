<?php
$dir = "images/";
$filesArray = ["image1", "image2", "image3"];

foreach ($filesArray as $item) {
    if (isset($_FILES[$item]['name']) && ($_FILES[$item]['name'] != null)) {
        ($dataArray[$item] =  time() . "-" . $_FILES[$item]['name']);
        move_uploaded_file($_FILES[$item]['tmp_name'], ($dir . $dataArray[$item]));
    }
}
/* foreach ($_FILES as $key => $item) {
    if (isset($_FILES[$key]['name']) && ($_FILES[$key]['name'] != null)) {
        ($dataArray[$key] =  time() . "-" . $_FILES[$key]['name']);
        move_uploaded_file($_FILES[$key]['tmp_name'], ($dir . $dataArray[$key]));
    }
}
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/" method="post" enctype="multipart/form-data">
        <input type="file" name="image1">
        <input type="file" name="image2">
        <input type="file" name="image3">
        <button type="submit">add</button>
    </form>
</body>

</html>
