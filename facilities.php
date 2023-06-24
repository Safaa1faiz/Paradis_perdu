<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP-FACILITIES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php require('inc/links.php'); ?>
    <style>
        .pop:hover{
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>
    </head>
  <body class="bg-light">

  <?php require('inc/header.php');?>

    <div class="my-5  px-4">
     <h2 class="fw-bold h-font text-center">Les facilités disponible</h2>
     <hr>
         <p class="text-center mt-3 mb-5 h-font">Plongez-vous dans l'atmosphère envoûtante de la médina de Chafchaoune, avec ses ruelles sinueuses, ses souks animés et ses bâtiments historiques. </p>
      </div>  
    <div class="container">
        <div class="row">
            <?php
             $res = selectAll('facilities');
             $path = FACILITIES_IMG_PATH;


             while ($row = mysqli_fetch_assoc($res)) {
               echo<<<data
                    <div class="col-lg-4 col-md-6 mt-3 mb-5 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                    <img src="$path$row[icon]" alt="wifi" width="40px">
                    <h5 class="m-0 ms-3">$row[name]</h5>
                    </div>
                    <p>$row[description]</p>
                </div>
               </div>      
               data;
             }
            
            ?>

        </div>
    </div>
  <?php require('inc/footer.php');?>    

 </body>
 </html>