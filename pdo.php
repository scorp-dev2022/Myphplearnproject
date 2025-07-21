<?php



class Db
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "blogapp";
    public function connect()
    {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $t) {
            echo "Bağlantı hatası:" . $t->getMessage();
        }

    }

   
}



// $select = "select * from product where id=? and title=?";

// $iddegeri = 2;
// $title = "Esaretin bedeli";
// $stmt = $baglan->prepare($select);
// $stmt->execute([$iddegeri,$title]);
// print_r($stmt->fetchAll());
//  while($row = $stmt->fetch()){
//      echo $row["title"]."<br>";
//  }


// insert 

// $a = new Db();
// $pdo = $a->connect();
// $data = ["iphone 15", 25000, "iphone ile güzel bir hayata merhaba diyin"];
// $query = "insert into product (title,price,description) values (?,?,?)";

// $stmt = $pdo->prepare($query);
// $stmt->execute($data);








?>