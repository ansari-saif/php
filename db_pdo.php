<?php
class DB
{
    private $conn;

    public function __construct()
    {
        $this->connect();
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
    public function get($table, $id = NULL)
    {
        $sql = "SELECT * FROM $table" . ($id ? " WHERE id = $id" : "");
        $result = $this->conn->prepare($sql);
        $query = $result->execute();
        if ($query == false) {
            echo 'Error SQL: ' . $query;
            die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $id ? $result->fetch() :  $result->fetchAll();
    }

    function save($data, $table, $id = null)
    {
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

    function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = $id";
        return $this->execute($sql);
    }

    public function getData($query, $all = false)
    {
        $result = $this->conn->prepare($query);
        $query = $result->execute();
        if ($query == false) {
            echo 'Error SQL: ' . $query;
            die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $reponse = $result->fetch();
        return $all ? $result->fetch() :  $result->fetchAll();
    }
    public function execute($query)
    {
        $response = $this->conn->exec($query);
        return $response;
    }
}
?>


<?php
//with table
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
        $this->dbname = "tarautility";

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . '', $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
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
