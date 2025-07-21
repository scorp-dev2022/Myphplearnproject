<?php
include 'class.php';
?>

<!-- navbar tanımlaması -->
<?php
require_once "./partials/_navbar.php";
?>

<div class="container my-5">

  <div class="row">

    <div class="col-3">
      <ul class="list-group" id="loadcategory">
      </ul>
    </div>
    <div class="col-9" id="loadmovie">
      <button id="a" class="btn btn-primary">tıkla</button>
    </div>


  </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="../script/category_class.js"></script>
<script src="../script/film_class.js"></script>
<script src="../script/user_class.js"></script>
<script type="text/javascript">

  $(document).ready(function () {
    const films = new Film();
    const users = new Users();
    const category = new Category();
    category.getcategory();
    films.loadMovies();
  });
</script>


<!-- footer tanımlaması -->
<?php
require_once "./partials/_footer.php";
?>