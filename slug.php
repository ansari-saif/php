<?php 

 function slug($string)
{
    $slug = strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace("/[^a-zA-Z0-9\-]/", '-', addslashes($string))), "-"));
    return $slug;
}
 function getSlug($string, $array)
{
    $stringOriginal =slug($string);
    $string = $stringOriginal;
    $i = 1;
    while (1) {
        if (in_array($string, $array)) {
            $string = $stringOriginal . "-" . $i;
            $i++;
        } else {
            return $string;
            break;
        }
    }
}
?>
