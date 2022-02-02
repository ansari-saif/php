<?php

$DBhost = "localhost";
$DBuser = "root";
$DBpassword = "";
$DBname = "test_api";

$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
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
function update($conn,  $data, $table, $id)
{
    foreach ($data as $key => $value) {
        $array[] = "`$key`='" . mysqli_real_escape_string($conn, $value) . "'";
    }
    $datatoupdate = implode(", ", $array);
    $s = "UPDATE  `$table` SET $datatoupdate WHERE id = $id";
    $result =  mysqli_query($conn, $s) || die("update Query failed ------------> " . mysqli_error($conn));
    return $result ? true : false;
}
function getData($conn, $table, $id = NULL)
{
    $sql = "SELECT * FROM $table" . ($id ? " WHERE id = $id" : "");
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $data = array_map("mapData", $data);
    return $id ? $data[0] : $data;
}
function mapData($arr)
{
    $arr['comments'] = json_decode($arr['comments']);
    return $arr;
}
header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
// header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);
$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case 'POST':
        $insArr = [
            "name" => $data['name'],
            "detail" => $data['detail']
        ];
        $msg = insert($conn, $insArr, "employee") ? $data : ['something wrong'];
        return  print_r(json_encode($msg));
        break;
    case 'GET':
        $result =  getData($conn, "employee", isset($_GET["id"]) ? $_GET["id"] : 0);
        return  print_r(json_encode($result));
        break;
    case 'PATCH':
        $upArr = ['comments' => (json_encode($data['comments']))];
        $result =  update($conn, $upArr, "employee", isset($_GET["id"]) ? $_GET["id"] : 0);
        return  print_r(json_encode($result));
        break;
    default:
        # code...
        break;
}
