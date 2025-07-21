<!DOCTYPE html>
<html lang="tr">

<head>
    
    <title>BlogApp Login</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form>
        <h3>Giriş Yapın</h3>

        <label for="username">Kulanıcı Adı</label>
        <input type="text" placeholder="Kulanıcı Adı" id="username">

        <label for="password">Şifre</label>
        <input type="password" placeholder="Şifre" id="password">

        <button id="submit">Giriş Yap</button>

    </form>

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="../script/user_class.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            const usr = new Users();
            $("#submit").on("click", function (e) {
                e.preventDefault();
                usr.setUsername = $("#username").val();
                usr.setPassword = $("#password").val();
                usr.login();
            });
        });
    </script>
</body>

</html>