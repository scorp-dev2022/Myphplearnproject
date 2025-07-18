<?php
require_once '_navbar.php';
include '_values.php';
?>
<?php
if(isset($_POST['upload']) && $_POST['upload'] == "upload"){
    print_r($_FILES);
$name = $_FILES['uploadedfile']['name'];
$tmpname = $_FILES['uploadedfile']['tmp_name'];
$newpath='./img/';

$path_destination = $newpath.$name;

if(move_uploaded_file($tmpname,$path_destination)){
echo "dosya başarıyla taşındı";
}
else{
    echo "hata";
}
}
?>

 <div class="container my-5">
    
        <div class="row">

            <div class="col-3">
                <ul class="list-group">
                  <?php
                  foreach ($katagoriler as $katagori){
                   echo "<li class='list-group-item'>".$katagori[0]."</li>";
                  }
                  ?>
                 
                </ul>
            </div>
            <div class="col-9">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="uploadedfile">
            <input  type="submit" value="upload" name="upload">
            </form>
            </div>
        
        
        </div>
    
    </div>
    
<?php
require_once '_footer.php';
?>