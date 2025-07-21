<?php
require_once '../pdo.php';

class User
{
    private $id;
    private $name;
    private $surname;
    private $username;
    private $password;
    private $isactive;
    private $conect;

    public function __construct($id = null, $name = null, $surname = null, $username = null, $password = null, $isactive = true)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->password = $password;
        $this->isactive = $isactive;
        $this->conect = new Db();
    }

    public function getuser()
    {
        $pdo = $this->conect->connect();
        $query = "SELECT * FROM USER";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function login($username, $password)
    {
        $pdo = $this->conect->connect();
        $query = "SELECT * FROM USER WHERE USERNAME = :username";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_set_cookie_params([
                'httponly' => true,
                'secure' => true,
                'samesite' => 'Strict'
            ]);
            session_start();
            $_SESSION['usernames'] = $user['username'];
            $_SESSION['islogedin'] = "true";
            return "success";
        } else {
            return "error";
        }
    }

    public function updateuser($username, $password, $id)
    {
        $pdo = $this->conect->connect();

        $query = "UPDATE USER SET USERNAME = :username, PASSWORD = :password WHERE id = :id;";
        $stmt = $pdo->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "success";
        } else {
            return "error";
        }
    }

    public function adduser($username, $password)
    {
        $pdo = $this->conect->connect();

        $query = "INSERT INTO USER (USERNAME, PASSWORD) VALUES (:username, :password)";
        $stmt = $pdo->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "success";
        } else {
            return "error";
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        return "logedout";
    }

    public function getusers()
    {
        $pdo = new Db();
        $pdo = $this->conect->connect();
        $query = "SELECT * FROM user";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function deleteuser($id)
    {
        $pdo = new Db();
        $pdo = $this->conect->connect();
        $stmtDelete = $pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmtDelete->bindParam(':id', $id);
        return $stmtDelete->execute() ? "success" : "error";
    }
}


?>