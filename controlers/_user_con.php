<?php
require_once '../model/_user_class.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = new User();

    if (isset($_POST['getuser'])) {
        echo json_encode($user->getusers());
        exit;
    }

    // Login işlemi
    if (isset($_POST['username']) && isset($_POST['password'])) {
        echo $user->login($_POST['username'], $_POST['password']);
        exit;
    }

    // Kayıt işlemi
    if (isset($_POST['usernameadd']) && isset($_POST['passwordadd'])) {
        echo $user->adduser($_POST['usernameadd'], $_POST['passwordadd']);
        exit;
    }
    //güncelleme işlemi 
    if (isset($_POST['usernameupdate']) && isset($_POST['passwordupdate'])) {
        echo $user->updateuser($_POST['usernameupdate'], $_POST['passwordupdate'],$_POST['id']);
        exit;
    }

    if (isset($_POST['iddelete'])) {
        $id = $_POST['iddelete'];
        echo $user->deleteuser($id);
        exit;
    }

    if (isset($_POST['logout'])) {

        echo $user->logout();
        exit;
    }
}
?>