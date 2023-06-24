<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP-HOME</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <?php require('inc/links.php'); ?>
    
<style>
       .availability-form {
        margin-top: -50px;
        z-index: 2;
        position: relative;
     }
     @media screen and (max-width: 575px) {
        .availability-form {
        margin-top: 25px;
        padding: 0 35px;
     } }
         </style>
</head>
  <body class="bg-light">

  <?php require('inc/header.php');?>
<!--Carousel-->
     <div class="container-fluid px-lg-4 mt-4">
     <div class="swiper swiper-container">
     <div class="swiper-wrapper">
      <?php
      $res = selectAll('carousel');
    while ($row = mysqli_fetch_assoc($res)) {
      $path = CAROUSEL_IMG_PATH;
      echo <<<data
      <div class="swiper-slide">
        <img src="$path$row[image]" class="w-100 d-block" />
      </div>
      data;
      }
    ?>
  </div>
 </div>
</div>


<!--Check avalailability form-->
      <div class="container availability-form">
    <div class="row">
        <div class="col-lg-12 bg-white shadow p-4 rounded h-font">
            <h6 class="mb-4">Vérifier la disponibilité des réservations:</h6>
            <form>
                <div class="row align-items-end">
                <div class="col-lg-3 mb-3">
                    <label class="form-label" style="font-weight: 500;">Check-in</label>
                    <input type="date" class="form-control shadow-none">
                </div>
                   <div class="col-lg-3 mb-3">
                    <label class="form-label" style="font-weight: 500;">Check-out</label>
                    <input type="date" class="form-control shadow-none">
                   </div>
                   <div class="col-lg-3 mb-3">
                    <label class="form-label" style="font-weight: 500;">Adultes</label>
                    <select class="form-select shadow-none">
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" style="font-weight: 500;">Enfants</label>
                    <select class="form-select shadow-none">
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-lg-1 mb-lg-3 mt-2">
                    <button type="submit" class="btn btn-success" style>Submit</button>
                </div>
                </div>
                </div>
            </form>
        </div>
    </div>
      </div>

<!--Our Rooms-->
   <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Chambres & Suites</h2>
   <div class="container">
    <div class="row">
<?php
// get features of room
$room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?  ORDER BY `id` DESC LIMIT 3", [1, 0], 'ii');

while ($room_data = mysqli_fetch_assoc($room_res)) {
    $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
    $features_data = "";
    while ($fea_row = mysqli_fetch_assoc($fea_q)) {
        $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>" . $fea_row['name'] . "</span>";
    }

    // get facilities of room
    $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
    $facilities_data = "";
    while ($fac_row = mysqli_fetch_assoc($fac_q)) {
        $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>" . $fac_row['name'] . "</span>";
    }

    // get thumbnail of image
    $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
    $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id` = '$room_data[id]' AND `thumb` = '1'");

    if (mysqli_num_rows($thumb_q) > 0) {
        $thumb_res = mysqli_fetch_assoc($thumb_q);
        $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
    }
     
    $book_btn = "";

    if (!$settings_r['shutdown']){
      $login=0;
      if(isset($SESSION['login']) && $_SESSION['login']==true){
        $login=1;
      }
      $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white btn-success shadow-none'>Book Now</button>";
    }

    // print room card 
    echo <<<data
    <div class="col-lg-4 col-md-6 my-3">
        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
            <img src="$room_thumb" class="card-img-top" alt="...">
            <div class="card-body">
                <h5>{$room_data['name']}</h5>
                <h6 class="mb-4">{$room_data['price']}DH per night </h6>
                <div class="features mb-4">
                    <h6 class="mb-1">Features</h6>
                    $features_data
                </div>
                <div class="facilities mb-4">
                    <h6 class="mb-1">Facilities</h6>
                    $facilities_data
                </div>
                <div class="guests mb-4">
                    <h6 class="mb-1">Guests</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                        {$room_data['adult']} Adultes
                    </span>
                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                        {$room_data['children']} Children
                    </span>
                </div> 
                <div class="rating mb-4">
                    <h6 class="mb-1">Rating</h6>
                    <span class="badge rounded-pill bg-light">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </span>
                </div>
                <div class="d-flex justify-content-evenly mb-2">
                    $book_btn
                    <a href="room_details.php?id={$room_data['id']}" class="btn btn-sm btn-outline-dark shadow-none">More details</a>
                </div>
            </div>
        </div>
    </div>
data;
}
?>
        <div class="col-lg-12 text-center mt-5">
          <a href="roooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
        </div>
    </div>
   </div>

<!--Our FACILITIES-->
   <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Nos services</h2>
   <div class="container">
    <div class="row justify-content-evenly px-lg-8 px-md-8 px-5">
                  <?php
             $res = mysqli_query($con, "SELECT * FROM `facilities`  ORDER BY `id` DESC LIMIT 5");
             $path = FACILITIES_IMG_PATH;


             while ($row = mysqli_fetch_assoc($res)) {
               echo<<<data
                    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                    <img src="$path$row[icon]" alt="wifi" width="40px">
                    <h5 class="m-0 ms-3">$row[name]</h5>
                    </div>    
               data;
             }
            
            ?>
     <div class="col-lg-12 text-center mt-5">
          <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
     </div>
    </div>
   </div>
    <!--Testimonials-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">AVIS DES CLIENTS</h2>
    <div class="container mt-5">
       <div class="swiper swiper-testimonials">
       <div class="swiper-wrapper mb-5">

         <div class="swiper-slide bg-white p-4">
            <div class="profile d-flex align-items-center mb-3">
          <img src="images/about/rating.svg" width="30px">
         <h6 class="m-0 ms-2">Avis de Jeanne</h6>
         </div>
         <p>
           J'ai adoré mon séjour à l'hôtel paradis perdu à Chefchaoune. L'emplacement était parfait, juste à quelques pas de la médina. Les chambres étaient spacieuses, propres et décorées avec goût. Le personnel était extrêmement accueillant et serviable, prêt à répondre à toutes nos demandes. Le petit-déjeuner proposé était délicieux, avec une variété d'options locales. Je recommande vivement cet hôtel pour un séjour confortable à Chefchaoune.
         </p>
         <div class="rating">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
        </div>
      </div>

       <div class="swiper-slide bg-white p-4">
            <div class="profile d-flex align-items-center mb-3">
          <img src="images/about/rating.svg" width="30px">
         <h6 class="m-0 ms-2">Avis de Marc :</h6>
         </div>
         <p>
          Nous avons passé un merveilleux séjour à l'hôtel paradis perdu. L'atmosphère était très relaxante et paisible, idéale pour se ressourcer. La décoration de l'hôtel était magnifique, avec des touches marocaines traditionnelles. Les chambres étaient confortables et bien équipées, offrant une vue imprenable sur la ville. Le personnel était sympathique et attentionné, et ils ont rendu notre séjour encore plus agréable. Je recommande vivement cet hôtel pour une expérience authentique à Chefchaoune
         </p>
         <div class="rating">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
        </div>
      </div>

       <div class="swiper-slide bg-white p-4">
            <div class="profile d-flex align-items-center mb-3">
          <img src="images/about/rating.svg" width="30px">
         <h6 class="m-0 ms-2">Avis de Khadija :</h6>
         </div>
         <p>
          Nous avons passé un merveilleux séjour à l'hôtel paradis perdu. L'atmosphère était très relaxante et paisible, idéale pour se ressourcer. La décoration de l'hôtel était magnifique, avec des touches marocaines traditionnelles. Les chambres étaient confortables et bien équipées, offrant une vue imprenable sur la ville. Le personnel était sympathique et attentionné, et ils ont rendu notre séjour encore plus agréable. Je recommande vivement cet hôtel pour une expérience authentique à Chefchaoune
         </p>
         <div class="rating">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
        </div>
      </div>


       <div class="swiper-slide bg-white p-4">
            <div class="profile d-flex align-items-center mb-3">
          <img src="images/about/rating.svg" width="30px">
         <h6 class="m-0 ms-2">Avis de Sophie :</h6>
         </div>
         <p>
            Notre séjour à l'hôtel paradis perdu a été fantastique. L'emplacement était idéal, à proximité de nombreux restaurants et attractions. Les chambres étaient propres, bien entretenues et offraient tout le confort nécessaire. Le personnel était incroyablement amical et serviable, fournissant d'excellentes recommandations pour les endroits à visiter et les activités à faire à Chefchaoune. Nous avons également apprécié le petit-déjeuner copieux et délicieux chaque matin. Je recommande vivement cet hôtel pour un séjour mémorable à Chefchaoune.
         </p>
         <div class="rating">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
        </div>
      </div>
    </div>
     <div class="swiper-pagination"></div>
      </div>
      <div class="col-lg-12 text-center mt-5">
          <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know more>>></a>
     </div>
    </div>

<!--Reach us-->

      <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
      <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
              <iframe class="w-100 rounded" height="320px" src="<?php
              echo $contact_r['iframe']?>" loading='lazy'></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call us</h5>
                    <a href="tel: +<?php
                     echo $contact_r['pn1']?>"class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i>+<?php
                    echo $contact_r['pn1']?>     
                    </a>
                    <br>
                    <?php 
                    if($contact_r['pn2'] != '') {
                    echo <<<data
                    <a href="tel:{$contact_r['pn2']}" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-phone-fill"></i>
                    +{$contact_r['pn2']}
                    </a>
                    data;
                   }
                    ?>
                    
                </div>
                 <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow us</h5>
                   <?php
                 if ($contact_r['tw'] != '') {
                 echo <<<data
                 <a href="{$contact_r['tw']}" class="d-inline-block mb-3">
                 <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-twitter"></i> Twitter</span>
                  </a>
                  <br>
                 data;
                }

                ?>  
                    <a href="<?php echo $contact_r['fb']?>" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-facebook"></i> Facebook</span>     
                    </a>
                     <br>
                    <a href="<?php echo $contact_r['insta']?>"class="d-inline-block">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-instagram"></i> Instagram</span>     
                    </a>
                </div>
           </div>
       </div>
   </div>
<?php require('inc/footer.php');?>    
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
       loop: true,
       autoplay: {
        delay: 2500,
        disableOnInteraction: false,
       }
    });
  </script>
  <script>
    var swiper = new Swiper(".swiper-testimonials", {
      effect: "coverflow",
      grabCursor: true,
      loop: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView: "3",
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
        slidesPerView: 1,
        },
        640: {
        slidesPerView: 1,
        },
        768: {
        slidesPerView: 2,
        },
        1024: {
        slidesPerView: 3,
        },
      }
    });
  </script>
</body>
</html>