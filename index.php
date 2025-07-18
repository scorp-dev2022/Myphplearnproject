<?php
include '_values.php';
?>

<?php
$yenifilmler = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['mesaj'])) {
  $deger = strtolower(trim($_GET['mesaj'])); // Küçük harfe çevir ve boşlukları temizle

  foreach ($filmler as $film) {
    if (strpos(strtolower($film["Baslik"]), $deger) !== false) {
      $yenifilmler[] = $film;
    }
  }

  // Eğer eşleşen yoksa, bilgi ver
  if (empty($yenifilmler)) {
    echo "Aradığınız kriterlere uygun film bulunamadı.";
  } else {
    $filmler = $yenifilmler;
  }
}
?>




 <!-- navbar tanımlaması -->
   <?php
   require_once "_navbar.php";
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

              
                      <?php 
                    
                      shuffle($filmler); // rasgele sıralama yapar
                      foreach($filmler as $film){
                       
                        $FilmOzet = substr(ucfirst($film["Ozet"]),0,70)."...";
                        if($film["VizyondaMi"] == 1){
                          $film["VizyondaMi"] = "Vizyonda";
                           echo "<div class='card mb-3'>
                                 <div class='row'>
                                     <div class='col-3'><img class='img-fluid' src='img/{$film['resim']}.jpeg' alt=''>
                                 </div>
                             <div class='col-9'>
                            <div class='card-body'>                        
                                <h5 class='card-title'>{$film["Baslik"]}</h5>
                                <p class='card-text'>
                                     {$FilmOzet}
                                </p>
                                <div>
                                    <span class='badge bg-primary'>{$film["Yorum"]}</span>
                                    <span class='badge bg-primary'>{$film["Begeni"]}</span>
                                    <span class='badge bg-warning'>{$film["VizyondaMi"]}</span>
                                </div>
                            </div>
                        
                        </div>
                                 </div>
                              </div>"; 
                        }
                            
                      }
                      ?>
              

            </div>
        
        
        </div>
    
    </div>

<!-- footer tanımlaması -->
   <?php
   require_once "_footer.php";
   ?>

