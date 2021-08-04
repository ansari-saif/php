<?php
$config = [
    "host" => "localhost",
    "dbUser" => "root",
    "dbPass" => "",
    "db" => "saif",
    "data" => [
        "name",
        "email",
        "phone",
        "message"
    ],
    "table" => "contact",
];
$host = $config['host'];
$db = $config['db'];
$dbUser = $config['dbUser'];
$dbPass = $config['dbPass'];
$conn = mysqli_connect($host, $dbUser, $dbPass, $db) or die("connection field --------->" . mysqli_connect_error());
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

$insertArray =  $config['data'];
$table = $config['table'];
$create_table = "CREATE TABLE `$table` (
    `id` int(11) NOT NULL AUTO_INCREMENT,";
    foreach ($insertArray as $item) {
        $create_table .=  "`$item` varchar(255) DEFAULT NULL,";
    }
    $create_table .=   "`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
   ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1";
!mysqli_query($conn, "DESCRIBE `$table`") ? (mysqli_query($conn, $create_table) || die("query failed -- " . mysqli_error($conn))) : null;


if (isset($_POST['name'])) {

    $result = insert($conn, $_POST, $table);

    if ($result) {
        echo "<div class='alert alert-success'> <i class='fa fa-check' ></i> Rates Add Successfully</div>";
    } else {
        echo "<div class='alert alert-danger'> <i class='fa fa-ban' ></i> Unable To Add</div>";
    }
}
$count = count($insertArray);
?>



<!DOCTYPE html>
<html>

<body>

    <h2>Contact Form</h2>

    <form action="" method="post">

    <?php foreach ($insertArray as $key => $item) : 
        if(($count-2)>=$key){
        ?>
    	<label for="<?=$item?>"><?=$item?></label><br>
        <input type="<?=($item=='email'?'email':'text')?>" id="<?=$item?>" name="<?=$item?>" requierd><br>
    <?php } endforeach; ?>
        
        

        <label><?= $insertArray[($count-1)] ?></label><br>
        <textarea type="text" name="<?= $insertArray[($count-1)] ?>" id="" cols="30" rows="10"></textarea>
        <input type="submit">
    </form>



</body>

</html>
