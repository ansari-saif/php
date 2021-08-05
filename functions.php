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
  $filesArray = ["cv"];
  $dir = "images/";
  foreach ($filesArray as $item) {
    if (isset($_FILES[$item]['name']) && ($_FILES[$item]['name'] != null)) {
      ($dataArray[$item] =  time() . "-" . $_FILES[$item]['name']);
      move_uploaded_file($_FILES[$item]['tmp_name'], ($dir . $dataArray[$item]));
    }
  }
?>
