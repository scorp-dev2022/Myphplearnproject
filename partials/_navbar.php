<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>Blog App</title>
</head>

<body>

  <div class="container mb-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Blogapp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Anasayfa</a>
            </li>
          </ul>

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <?php
            session_start();
            if ($_SESSION['usernames'] ?? "" && $_SESSION['islogedin'] != "True") {
              echo '
              <li class="nav-item">
              <a class="nav-link" href="adduser.php">Kulanıcı Yönet</a>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="blogekleme.php">Yönet</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" id="logout">Çıkış</a>
            </li>';
            } else {
              echo '<li class="nav-item">
              <a class="nav-link" href="login.php">Giriş Yap</a>
            </li>';
            }
            ?>
          </ul>
          <form class="d-flex" action="index.php" method="GET">
            <input class="form-control me-2" type="text" name="mesaj" placeholder="Search" aria-label="Search">
            <input value="Ara" type="submit" class="btn btn-outline-light">
            <!-- <button class="btn btn-outline-light" type="submit">Ara</button> -->
          </form>
        </div>
      </div>
    </nav>
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../script/user_class.js"></script>
  <script type="text/javascript">

    $(document).ready(function () {

      const users = new Users();
      $("#logout").click(function (event) {
        users.logout();
      });
    });
  </script>