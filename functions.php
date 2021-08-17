<?php
function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
} 

//file upload 
  $dir = "images/";
  $filesArray = [
    "image1",
    "image2",
    "image3",
    "image4",
    "image5",
    "image6",
  ];
  foreach ($filesArray as $item) {
    if (isset($_FILES[$item]['name']) && ($_FILES[$item]['name'] != null)) {
      ($_POST[$item] =  time() . "-" . $_FILES[$item]['name']);
      move_uploaded_file($_FILES[$item]['tmp_name'], ($dir . $_POST[$item]));
    }
  }
?>

//file upload update
  $dir = "images/";
  $filesArrayUpdate = [
    "image1",
    "image2",
    "image3",
    "image4",
    "image5",
    "image6",
  ];
  $filesArray = array();
  foreach ($filesArrayUpdate as $itemArr) {
    isset($_FILES[$itemArr]['name']) ? array_push($filesArray, $itemArr) : null;
  }
  foreach ($filesArray as $item) {
    if (isset($_FILES[$item]['name']) && ($_FILES[$item]['name'] != null)) {
      ($_POST[$item] =  time() . "-" . $_FILES[$item]['name']);
      move_uploaded_file($_FILES[$item]['tmp_name'], ($dir . $_POST[$item]));
    }
  }



//active
function active($link) {
  echo  (basename($_SERVER['PHP_SELF']) == $link) ? 'active' : null;
}
