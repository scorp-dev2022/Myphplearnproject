<?php

$katagoriler = [
["Macera"],
["Dram"],
["Komedi"],
["Korku"],
["Gerilim"]
];

$filmler = [

  "ilk film"=> [
    "resim" => 1,
    "Baslik" => "Paper Lives",
    "Ozet" => "kağıt toplayarak geçinen ve sağlığı giderek kötüleşen Mehmet terk edilmiş bir çocuk bulur. Birden hayatına giren küçük Ali, onu kendi çocukluğuyla yüzleştirecektir. (18 yaş ve üzeri için uygundur)",
    "Tarih" => "12.10.2002",
    "Yorum" => 100,
    "Begeni" => 150,
    "VizyondaMi" => 1
  ],

  "ikinci film" =>[
    "resim" => 2,
    "Baslik" => "Walking Dead",
    "Ozet" => "zombi kıyametinin ardından hayatta kalanlar, birlikte verdikleri ölüm kalım mücadelesinde insanlığa karşı duydukları umuda tutunur.",
    "Tarih" => "12.10.2015",
    "Yorum" => 350,
    "Begeni" => 500,
    "VizyondaMi" => 1
  ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Blog App</title>
</head>
<body>
    
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
                      foreach($filmler as $film){
                       
                        $FilmOzet = substr(ucfirst($film["Ozet"]),0,70)."...";
                        if($film["VizyondaMi"] == 1){
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



</body>
</html>