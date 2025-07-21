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
                            <option>Film ekleme</option>
                            <option>film güncelleme</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <input type="text" class="form-control" id="idvalue" placeholder="" style="display: none;">
                    <div class="col-12 col-md-6 mb-2">
                        <label for="title">Başlık</label>
                        <input type="text" class="form-control" id="title" placeholder="Başlık">
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <label for="description">Açıklama</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-6 mb-2">
                        <label for="resimurlad">Resim URL</label>
                        <input type="file" name="images[]" class="form-control" id="resimurlad" multiple>
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <label for="urlimg">Url</label>
                        <input type="text" class="form-control" id="urlimg" placeholder="Url">
                    </div>
                </div>


                <br>
                <div class="row mb-5">

                    <div class="col-6 col-md-6 mb-2">
                        <div class="form-group">
                            <label>Yayındamı</label><br>
                            <div class="d-flex mx-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="activerad">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Pasif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="pasifrad"
                                        checked="">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <button class="btn btn-success" id="submit">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Onayla
                        </button>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="container">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">BAŞLIK</th>
                                    <th scope="col">AÇIKLAMA</th>
                                    <th scope="col">RESİMYOLU</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">DURUM</th>
                                    <th scope="col">EYLEM</th>
                                </tr>
                            </thead>
                            <tbody id="loadmovietable">

                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        </div>

    </div>



    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="../script/film_class.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            const film = new Film();
            film.loadTableMovies();
            function loadValues() {
                if ($("#ProccesSlc").val() == "Film ekleme") {
                    film.title = $("#title").val();
                    film.description = CKEDITOR.instances.description.getData();
                    film.imageUrl = $("#resimurlad")[0].files;
                    film.url = $("#urlimg").val();
                    film.isActive = $("#activerad").is(":checked");
                    film.addfilm();
                }
                else if ($("#ProccesSlc").val() == "film güncelleme") {
                    film.title = $("#title").val();
                    film.description = CKEDITOR.instances.description.getData();
                    film.imageUrl = $("#resimurlad")[0].files;
                    film.url = $("#urlimg").val();
                    film.isActive = $("#activerad").is(":checked");
                    film.updatefilm();
                }

            }


            film.eventHandler(function (response) {
                if (response == "success") {
                    film.loadTableMovies();
                    alert("Başarıyla silindi!!!");
                }
                else {
                    alert(response);
                }
            }, "btndelete", "delete");

            film.eventHandler(function (response) {
                console.log(response);
                $("#title").val(response[0]);
                CKEDITOR.instances.description.setData(response[1]);
                $("#urlimg").val(response[3]);
            }, "btnselect", "select");

            $("#submit").on("click", function (e) {
                e.preventDefault();
                const process = $("#ProccesSlc").val();
                if (process === "Film ekleme") {
                    loadValues();
                    film.loadTableMovies();
                }
                else if (process === "film güncelleme") {
                    loadValues();
                    film.loadTableMovies();
                } else {
                    alert("Lütfen bir işlem seçin!");
                }
            });
        });
    </script>

    <?php
    require_once './partials/_footer.php';
    ?>
    <?php
    require_once './plugins/_ckeditor.php';
    ?>