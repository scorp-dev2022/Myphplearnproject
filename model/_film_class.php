<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    exit;
}
?>
<?php
require_once '../pdo.php';
require_once 'debug.php';
?>

<?php
class Film
{

    private $id;
    private $title;
    private $descrition;
    private $imgurl;
    private $url;
    private $isactive;
    private $conect;

    public function __construct($id = null, $title = null, $descrition = null, $imgurl = null, $url = null, $isactive = true)
    {
        $this->id = $id;
        $this->title = $title;
        $this->descrition = $descrition;
        $this->imgurl = $imgurl;
        $this->url = $url;
        $this->isactive = $isactive;
        $this->conect = new Db();
    }
  
    public function getmovies()
    {
        $pdo = new Db();
        $pdo = $this->conect->connect();
        $query = "SELECT * FROM BLOGS";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $films;

    }

    public function addmovies($baslik, $aciklama, $url, $durum, $files)
    {
        $pdo = new Db();
        $pdo = $this->conect->connect();

        $uploadedPaths = [];

        if (!empty($files['images']['name'][0])) {
            foreach ($files['images']['name'] as $key => $name) {
                $tmp_name = $files['images']['tmp_name'][$key];
                $newpath = '../img/' . basename($name);

                if (move_uploaded_file($tmp_name, $newpath)) {
                    $uploadedPaths[] = $newpath;
                }
            }
        }

        $resimurlad = implode(',', $uploadedPaths);

        if (empty($url)) {
            return "error";
        }

        $stmtCheck = $pdo->prepare("SELECT url FROM blogs WHERE url = :url");
        $stmtCheck->bindParam(':url', $url);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            return "kayit var";
        }

        $stmtInsert = $pdo->prepare("INSERT INTO blogs (title, description, imageUrl, url, isActive)
                                            VALUES (:title, :description, :imageUrl, :url, :isActive)");
        $stmtInsert->bindParam(':title', $baslik);
        $stmtInsert->bindParam(':description', $aciklama);
        $stmtInsert->bindParam(':imageUrl', $resimurlad);
        $stmtInsert->bindParam(':url', $url);
        $stmtInsert->bindParam(':isActive', $durum);

        return $stmtInsert->execute() ? "success" : "error";
    }

    public function updatemovies($id, $baslik, $aciklama, $url, $durum, $files)
    {
        try {
            $pdo = $this->conect->connect();
            debugLog("Veritabanı bağlantısı", $pdo);
            debugLog("POST Verisi", [
                "id" => $id,
                "baslik" => $baslik,
                "aciklama" => $aciklama,
                "url" => $url,
                "durum" => $durum
            ]);
            debugLog("FILES Verisi", $files);

            $selectquery = "SELECT imageUrl FROM blogs WHERE id = :id";
            $stmt = $pdo->prepare($selectquery);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $urls = $stmt->fetch(PDO::FETCH_ASSOC);
                debugLog("Mevcut Görsel URL", $urls);

                if (isset($urls['imageUrl'])) {
                    $imgpath = $urls['imageUrl'];
                    if (file_exists($imgpath)) {
                        @unlink($imgpath);
                        debugLog("Eski görsel silindi", $imgpath);
                    }

                    $uploadedPaths = [];
                    if (!empty($files['images']['name'][0])) {
                        foreach ($files['images']['name'] as $key => $name) {
                            $tmp_name = $files['images']['tmp_name'][$key];
                            $newpath = '../img/' . basename($name);

                            if (move_uploaded_file($tmp_name, $newpath)) {
                                $uploadedPaths[] = $newpath;
                            }
                        }
                    }

                    debugLog("Yüklenen Yeni Görseller", $uploadedPaths);
                    $resimurlad = implode(',', $uploadedPaths);

                    if (empty($url)) {
                        debugLog("URL Boş", $url);
                        return "error";
                    }

                    $stmtCheck = $pdo->prepare("SELECT url FROM blogs WHERE url = :url AND id != :id");
                    $stmtCheck->bindParam(':url', $url);
                    $stmtCheck->bindParam(':id', $id);
                    $stmtCheck->execute();

                    if ($stmtCheck->rowCount() > 0) {
                        debugLog("URL zaten kayıtlı", $url);
                        return "kayit var";
                    }

                    $stmtInsert = $pdo->prepare("UPDATE blogs SET title = :title, description = :description, imageUrl = :imageUrl, url = :url, isActive = :isActive WHERE id = :id");
                    $stmtInsert->bindParam(':title', $baslik);
                    $stmtInsert->bindParam(':description', $aciklama);
                    $stmtInsert->bindParam(':imageUrl', $resimurlad);
                    $stmtInsert->bindParam(':url', $url);
                    $stmtInsert->bindParam(':isActive', $durum);
                    $stmtInsert->bindParam(':id', $id);

                    $success = $stmtInsert->execute();
                    if (!$success) {
                        debugLog("SQL Hatası", $stmtInsert->errorInfo());
                    }

                    return $success ? "success" : "error";
                } else {
                    debugLog("Görsel alanı eksik", $urls);
                    return "error";
                }
            } else {
                debugLog("İlgili kayıt bulunamadı", $id);
                return "error";
            }
        } catch (\Throwable $th) {
            debugLog("Exception", $th->getMessage());
            return $th->getMessage();
        }
    }
    public function deletemovies($id)
    {
        $pdo = new Db();
        $pdo = $this->conect->connect();
        $stmtDelete = $pdo->prepare("DELETE FROM BLOGS WHERE id = :id");
        $stmtDelete->bindParam(':id', $id);
        return $stmtDelete->execute() ? "success" : "error";
    }

}
?>