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
function update($conn,  $data, $table,$id)
{
    foreach ($data as $key => $value) {
        $array[] = "`$key`='" . mysqli_real_escape_string($conn, $value) . "'";
    }
    $datatoupdate = implode(", ", $array);
    $s = "UPDATE  `$table` SET $datatoupdate WHERE id = $id";
    $result =  mysqli_query($conn, $s) || die("update Query failed ------------> " . mysqli_error($conn));
    return $result ? true : false;
}
function getData($conn,$table, $id = NULL) {
    $sql = "SELECT * FROM $table".($id ? " WHERE id = $id": "");
     $result = mysqli_query($conn,$sql);
     $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
     return $id ? $data[0] : $data;
}
