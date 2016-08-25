<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 11/04/16
 * Time: 6:09 PM
 */
class panel {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/include/db_connect.php';
        require_once dirname(__FILE__) . '/include/PassHash.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function getAllClassRooms() {
        $stmt = $this->conn->prepare("SELECT * FROM classrooms");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM students");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    public function getUser($admin_name) {

        $stmt = $this->conn->prepare("SELECT admin_id from admins WHERE admin_name = ?");
        $stmt->bind_param("s", $admin_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        if ($num_rows > 0) {
            $stmt->bind_result($admin_id);
            $stmt->fetch();
            return $admin_id;
        } else {
            $user_name = 'Admin';
            $password_hash = PassHash::hash('Admin');
            $stmt = $this->conn->prepare("INSERT INTO admins(user_name, password) values(?, ?)");
            $stmt->bind_param("ss", $user_name, $password_hash);
            $result = $stmt->execute();
            $user_id = $stmt->insert_id;
            $stmt->close();
            return $user_id;
        }
    }

    public function loginUser() {
        $name = 'Admin';
        $matricula = '1234';

        $stmt = $this->conn->prepare("SELECT user_id from users WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        if ($num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            return $user_id;
        } else {
            $stmt = $this->conn->prepare("INSERT INTO users(name, matricula) values(?, ?)");
            $stmt->bind_param("ss", $name, $matricula);
            $result = $stmt->execute();
            $user_id = $stmt->insert_id;
            $stmt->close();
            return $user_id;
        }
    }
}
?>