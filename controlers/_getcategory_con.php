
<?php
include '../model/_category_class.php';

if($_SERVER['REQUEST_METHOD'] ==='POST'){
    $category=[];
    $categoryobj = new Categorys();

if(isset($_POST['getcategory'])){
echo json_encode($category = $categoryobj->getCategory());
}

if(isset($_POST['addcategory'])){
  $name = $_POST['addcategory'];
   echo json_encode($categoryobj->setcategorys($name));
}

}


?>