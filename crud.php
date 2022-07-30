<?php
class DB
{
    private $conn;
    public $table;
    public function __construct($table)
    {
        $this->connect();
        $this->table = $table;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    private function connect()
    {
        $this->host = "";
        $this->user = "root";
        $this->pass = "";
        $this->dbname = "test";

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . '', $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            echo "<br><h1>Please create database named test</h1>";
        }

        if (!$this->conn) {
            $this->error = 'Fatal Error :' . $e->getMessage();
        }

        return $this->conn;
    }

    public function disconnect()
    {
        if ($this->conn) {
            $this->conn = null;
        }
    }

    public function createTable($table)
    {
        $sql = "CREATE TABLE `$table` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) DEFAULT NULL,
                    `email` varchar(255) DEFAULT NULL,
                    `phone` varchar(255) DEFAULT NULL,
                    `message` varchar(255) DEFAULT NULL,
                    `status` tinyint(4) NOT NULL DEFAULT '1',
                    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1";
        $this->execute($sql);
    }
    public function get($id = NULL)
    {
        $table = $this->table;
        $sql = "SELECT * FROM $table" . ($id ? " WHERE id = $id" : "") . " ORDER BY id DESC";
        $result = $this->conn->prepare($sql);
        $query = $result->execute();
        if ($query == false) {
            echo 'Error SQL: ' . $query;
            die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $id ? $result->fetch() :  $result->fetchAll();
    }

    function save($data, $id = null)
    {
        $table = $this->table;

        foreach ($data as $key => $value) {
            $array[] = "`$key`='" . $value . "'";
        }
        $datatoupdate = implode(", ", $array);
        if ($id) {
            $sql = "UPDATE `$table` SET $datatoupdate WHERE id = $id";
        } else {
            $sql = "INSERT INTO  `$table` SET $datatoupdate";
        }
        return $this->execute($sql);
    }

    function delete($id)
    {
        $table = $this->table;

        $sql = "DELETE FROM $table WHERE id = $id";
        return $this->execute($sql);
    }

    /* 
    all = false = all data
    all = true  = single data
    */
    public function getData($query, $all = false)
    {
        $result = $this->conn->prepare($query);
        $query = $result->execute();
        if ($query == false) {
            echo 'Error SQL: ' . $query;
            die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $all ? $result->fetch() :  $result->fetchAll();
    }
    public function execute($query)
    {
        $response = $this->conn->exec($query);
        return $response;
    }
}

$table = "data2";
$data = new DB($table);
if (isset($_POST) && !empty($_POST)) {
    $data->save($_POST, $_POST["id"] ?? null);
}
$isEdit = false;
if (isset($_GET['action']) && !empty($_GET['action'])) {
    switch ($_GET["action"]) {
        case 'edit':
            $edit = $data->get($_GET["id"]);
            $isEdit = true;
            break;
        case 'delete':
            $data->delete($_GET["id"]);
            break;
        default:
            # code...
            break;
    }
}
try {
    $dataVal = $data->get();
} catch (\Throwable $e) {
    // print_r($e->getMessage());
    $data->createTable($table);
    $dataVal = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>data</title>
</head>

<body>
    <form method="post">
        <input type="text" value="<?= $isEdit ? $edit['name'] : null ?>" name="name" placeholder="name"><br>
        <input type="text" value="<?= $isEdit ? $edit['email'] : null ?>" name="email" placeholder="email"><br>
        <input type="text" value="<?= $isEdit ? $edit['phone'] : null ?>" name="phone" placeholder="phone"><br>
        <input type="text" value="<?= $isEdit ? $edit['message'] : null ?>" name="message" placeholder="message"><br>
        <?php if ($isEdit) : ?>
            <input type="hidden" value="<?= $edit['id'] ?>" name="id">
        <?php endif; ?>
        <button type="submit">save</button>
    </form>
    <br>
    <table border="1">
        <tr>
            <th>name</th>
            <th>email</th>
            <th>phone</th>
            <th>message</th>
            <th>Action</th>
        </tr>
        <?php foreach ($dataVal as $k => $v) { ?>
            <tr>
                <td><?= $v['name'] ?></td>
                <td><?= $v['email'] ?></td>
                <td><?= $v['phone'] ?></td>
                <td><?= $v['message'] ?></td>
                <td>
                    <a href="?id=<?= $v['id'] ?>&action=edit">E</a>&nbsp;
                    <a href="?id=<?= $v['id'] ?>&action=delete">D</a>&nbsp;
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
