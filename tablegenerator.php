<?php
if (isset($_POST["submit"])) {
    $dataArray = $_POST["db"];
    $table = $_POST["name"];
    $create_table = "CREATE TABLE `$table` (
        `id` int(11) NOT NULL AUTO_INCREMENT,";
    foreach ($dataArray as $item) {
        $create_table .=  "`$item` varchar(255) DEFAULT NULL,\n";
    }
    $create_table .=   "`active` tinyint(4) NOT NULL DEFAULT '1',
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1";
    $content = $create_table;
    $name = $table;
    $backup_name = 0;
    $backup_name = $backup_name ? $backup_name : $name . ".sql";
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
    echo $content;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>database</title>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <style>
        input {
            margin: 10px;
            padding: 5px;
        }

        button[type="button"] {
            border: 1px solid black;
            background-color: green;
            user-select: none;
            margin: 5px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <center>
        <div class="container">
            <h1>SQL Databse Table Generator</h1>
            <form method="post">
                <input type="text" name="name" placeholder="Table Name">
                <div class="form-group">
                   
                </div>
                <button onclick="addmore()" type="button">Add More</button>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </center>
    <script>
        function addmore() {
            var myhtml = '<input type="text" class="input" name="db[]"><br>';
            $('.form-group').append(myhtml);
            $('.input').on('keydown', function(e) {
                if (e.which == 9) {
                    addmore()
                }
            });
        }
        addmore();
    </script>

</body>

</html>
