<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP-ABOUT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <?php require('inc/links.php'); ?>
    <style>
        .box {
            border-top-color: var(--teal) !important;
        }
    </style>
    </head>
  <body class="bg-light">

  <?php require('inc/header.php');?>

    <div class="my-5 px-4">
     <h2 class="fw-bold h-font text-center">A propos de nous</h2>
     <hr>
         <p class="text-center mt-3 h-font">Bienvenue à Chafchaoune !</p>
      </div> 

    <div class="container">
     <div class="row justify-content-between align-items-center">
        <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2 ">
                <h4 class="mb-3 fw-bold h-font">Découvrez la beauté de notre charmant hotel niché au cœur des montagnes du Maroc. </h4>
                    <p class="h-font">
                    Chafchaoune est réputé pour ses paysages pittoresques, sa culture vibrante et son hospitalité chaleureuse. Explorez notre site pour en savoir plus sur les attractions locales, les activités passionnantes et les hébergements confortables qui vous attendent.
                   </p>
                   </div>
                   <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
               <img src="images/about/chaoune1.jpg" alt="" class="w-100">
              </div>
             </div>
          </div>  
    <div class="container mt-5">
     <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-3">
                  <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/hotel.svg" alt="" width="70px">
                    <h5 class="mt-3">100+ ROOMS</h5>
                     </div>
                      </div>
            <div class="col-lg-3 col-md-6 mb-4 px-3">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/customers.svg" alt="" width="70px">
                    <h5 class="mt-3">150+ CUSTOMER</h5>
                </div>
                </div>
            <div class="col-lg-3 col-md-6 mb-4 px-3">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/rating.svg" alt="" width="70px">
                    <h5 class="mt-3">120+ REVIEWS</h5>
                </div>
                   </div>
            <div class="col-lg-3 col-md-6 mb-4 px-3">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/staff.svg" alt="" width="70px">
                    <h5 class="mt-3">50+ STAFFS</h5>
                   </div>
                   </div>
       </div>
    </div>
    <h3 class="my-5 fw-bold h-font text-center">MANAGMENT TEAM</h3>
    <div class="container px-4">
       <div class="swiper mySwiper">
         <div class="swiper-wrapper  mb-5">
          <?php
           $about_r = selectAll('team_details');
           $path=ABOUT_IMG_PATH;
           while ($row = mysqli_fetch_assoc($about_r)) {
           echo <<<data
           <div class="swiper-slide bg-white text-center overflow-hidden rounded">
           <img src="$path$row[picture]" alt="" class="w-100">
           <h5 class="mt-2">$row[name]</h5>
           </div>
           data;
          }
        ?>            
    </div>
    <div class="swiper-pagination"></div>
  </div>
</div>
  <?php require('inc/footer.php');?>    
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidePerView: 4,
      spaceBetween: 40,  
      pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
      },

        breakpoints: {
        320: {
        slidesPerView: 1,
        },
        640: {
        slidesPerView: 1,
        },
        768: {
        slidesPerView: 3,
        },
        1024: {
        slidesPerView: 3,
        },
      }
    });
  </script>
 </body>
 </html>