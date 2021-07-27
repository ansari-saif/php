<?php
function insert($conn,  $data, $table)
{
    foreach ($data as $key => $value) {
        $array[] = "`$key`='" . mysqli_real_escape_string($conn, $value) . "'";
    }
    $datatoupdate = implode(", ", $array);
    $s = "INSERT INTO  `$table` SET $datatoupdate";
    $result =  mysqli_query($conn, $s) || die("update Query failed ------------> " . mysqli_error($conn));
    return $result ? true : false;
}
