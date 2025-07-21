<?php
require_once './partials/_navbar.php';
?>
<?php
if (!isset($_SESSION['islogedin'])) {
    header("Location: index.php");
    exit;
}
?>


<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4 mb-5">
                        <label for="largeSelect">İşlem Seçimi</label>
                        <select class="form-select form-control-lg" id="ProccesSlc">
                            <option>Eylem Seçiniz</option>
                            <option>Kulanıcı ekleme</option>
                            <option>Kulanıcı Güncelleme</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <input type="text" class="form-control" id="idvalue" placeholder="" style="display: none;">
                    <div class="col-12 col-md-6 mb-2">
                        <label for="username">Kulanıcı Adı</label>
                        <input type="text" class="form-control" id="username" placeholder="Kulanıcı Adı">
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <label for="password">Şifre</label>
                        <input type="text" class="form-control" id="password" placeholder="Şifre">
                    </div>
                </div>
                <br>

                <br>
                <div class="row mb-5 text-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-success" id="submit">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Onayla
                        </button>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-12">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">KULANICI ADI</th>
                        <th scope="col">EYLEM</th>
                    </tr>
                </thead>
                <tbody id="loadusertable">

                </tbody>
            </table>
        </div>

    </div>



    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="script/user_class.js"></script>


    <script type="text/javascript">
        const users = new Users();
        function loadValue() {
            const process = $("#ProccesSlc").val();
            if (process === "Kulanıcı ekleme") {

                const username = $("#username").val();
                const password = $("#password").val();
                users.adduser(username, password);

            } else if (process === "Kulanıcı Güncelleme") {

                users.setUsername = $("#username").val();
                users.setPassword = $("#password").val();
                users.updateuser();

            } else {
                alert("Lütfen bir işlem seçin!");
            }
        }

        $(document).ready(function () {
            $("#password").val("123");
              $("#username").val("Ahmetyavuz");
            users.loadTableUsers();

            users.eventHandler(function (response) {
                alert(response);
            }, "btndelete", "delete");

            users.eventHandler(function (response) {
                $("#username").val(response[0]);
            }, "btnselect", "select");


            $("#submit").on("click", function (e) {
                e.preventDefault();
                loadValue();
            });
        });
    </script>

    <?php
    require_once './partials/_footer.php';
    ?>