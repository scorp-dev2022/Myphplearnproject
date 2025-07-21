<?php
include '../model/_film_class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $takefilm = new Film();

    if (isset($_POST['getmovie'])) {
        echo json_encode($takefilm->getmovies());
        exit;
    }

    if (isset($_POST['baslik'], $_POST['aciklama'], $_POST['url'], $_POST['durum'],$_POST['addmovie'])) {
        $title = $_POST['baslik'];
        $description = $_POST['aciklama'];
        $url = $_POST['url'];
        $isactive = (int) $_POST['durum'];
        $cevap = $takefilm->addmovies($title, $description, $url, $isactive, $_FILES);
        echo $cevap;
        exit;
    }

    if (isset($_POST['iddelete'])) {
        $id = $_POST['iddelete'];
        echo $takefilm->deletemovies($id);
        exit;
    }

    if (isset($_POST['baslik'], $_POST['aciklama'], $_POST['url'], $_POST['durum'],$_POST['id'],$_POST['updatemovie'])) {
        $title = $_POST['baslik'];
        $description = $_POST['aciklama'];
        $url = $_POST['url'];
        $isactive = (int) $_POST['durum'];
        $id = $_POST['id'];
        $cevap = $takefilm->updatemovies($id,$title, $description, $url, $isactive, $_FILES);
        echo $cevap;
        exit;
    }
    echo "error";
}
?>