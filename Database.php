<?php
class Database {
    private $host = "MySQL-8.0";
    private $dbname = "gl-test";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Помилка підключення до БД: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if ($params) {
            $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
