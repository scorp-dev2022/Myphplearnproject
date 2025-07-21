<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    exit;
}
?>
<?php
include '../pdo.php';
?>

<?php

class Categorys
{
  private $name;
  private $conect;

  // ❗HATA: Yapıcı metodda $name her zaman istenmeyebilir — opsiyonel yapılabilir veya dışarıdan alınmayabilir
  public function __construct($name = null)
  {
    $this->name = $name;
    $this->conect = new Db(); // ✅ Db sınıfının connect() metodunun tanımlı olması gerekir
  }

  public function __destruct()
  {
    // ❕YAPILMAYAN AMA SAKINCASI YOK: Destructor boş tanımlanmış, istersen silebilirsin
  }

  public function getCategory()
  {
    $pdo = $this->conect->connect();
    $query = "SELECT * FROM categories";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // ❗HATA: $category değişkeni oluşturulmadan return ediliyor — ama bu teknik olarak sorun yaratmaz
    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $category;
  }

  public function setcategorys($name)
  {
    try {
      $this->name = $name; // ✅ Değer ataması doğru — ancak gerek yoksa sınıfa atamayabilirsin

      $pdo = $this->conect->connect();

      // ❗HATA: SQL ifadesi hatalıydı — VALUES(name=?) yerine VALUES(?) kullanılmalı
      $query = "INSERT INTO categories (name) VALUES (?)";
      $stmt = $pdo->prepare($query);

      // ❗HATA: bindParam kullanımı için '?' placeholder'ı varsa sıralı indeks (1) kullanılmalı
      // ❕Alternatif olarak: $stmt->execute([$name]); daha pratik olur

      $stmt->bindParam(1, $name); 
      $stmt->execute();

      // ❗HATA: $stmt her zaman true döner — burada if kontrolü anlamsız olabilir
      echo "Inserted value successfully";

    } catch (\Throwable $th) {
      // ❗HATA: Sadece throw yapılmış — kullanıcıya hata mesajı göstermek mantıklı olabilir
      echo "Hata oluştu: " . $th->getMessage();
    }
  }
}
?>