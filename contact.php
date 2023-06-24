<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP-Contact</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php require('inc/links.php'); ?>

    </head>
  <body class="bg-light">

  <?php require('inc/header.php');?>
    <div class="my-5 px-4">
     <h2 class="fw-bold h-font text-center">CONTACT</h2>
     <hr>
     <p class="text-center mt-3 fw-bold h-font">Vous avez des envies ou des questions ?</p>
    </div>  
    <div class="container">
        <div class="row">
    <div class="col-lg-6 col-md-6 mb-5 px-4">
        <div class="bg-white rounded mb-4 shadow p-4">
        <iframe class="w-100 rounded" height="320px" src="<?php echo $contact_r['iframe'] ?>" loading="lazy"></iframe>
                    <h5>Adress</h5>
                   <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2"><i class="bi bi-geo-alt-fill"></i><?php echo $contact_r['address'] ?>
                     
                    </a>  
                    <h5 class="mt-4">Email</h5>
                    <a href="mailto:<?php echo $contact_r['email'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i><?php echo $contact_r['email'] ?>
                    </a>
                   <h5>Call us</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>"class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>    
                    </a>
                    <br>
                    <?php
                     if ($contact_r['pn2'] != '') {
                      echo <<<data
                     <a href="tel:+$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-phone-fill"></i>+$contact_r[pn2]</a>
                     data;
                     }
                    ?>
                     <h5 class="mt-4">Follow us</h5>
                    <?php
                      if ($contact_r['tw'] != '') {
                      echo <<<data
                      <a href="{$contact_r['tw']}" class="d-inline-block text-dark fs-5 me-2">
                      <i class="bi bi-twitter" target="_blank"></i>
                      </a>
                      data;
                     }
                    ?>
                    <a href="<?php echo $contact_r['fb']?>"class="d-inline-block mb-3 text-dark fs-5 me-2" target="_blank">
                     <i class="bi bi-facebook"></i>    
                    </a>
                    <a href="<?php echo $contact_r['insta']?>"class="d-inline-block text-dark fs-5 " target="_blank">
                     <i class="bi bi-instagram"></i>     
                    </a>
                </div>
            </div>
       <div class="col-lg-6 col-md-6  px-4">
                <div class="bg-white rounded shadow p-4 ">
              <form method="POST">
                <h5>Contacter nous maintenant!</h5>
                <div class="mt-3">
                    <label class="form-label" style="font-weight: 500;">Nom et prénom</label>
                    <input type="text" name="name" class="form-control shadow-none" required>
                </div>
                <div class="mt-3">
                    <label class="form-label" style="font-weight: 500;">Email</label>
                    <input type="email" class="form-control shadow-none"  name="email" required>
                </div>
                <div class="mt-3">
                    <label class="form-label" style="font-weight: 500;">Sujet</label>
                    <input type="text" class="form-control shadow-none"  name="subject" required>
                </div>
                <div class="mt-3">
                    <label class="form-label" style="font-weight: 500;">Message</label>
                   <textarea  name="message" required class="form-control shadow-none" row="5" style="resize: none;"></textarea>
                </div>
                <button type="submit" name="send" class="btn btn-success mt-3">Envoyer</button>
              </form>
            </div>
        </div>
    </div>
 </div>
   
 <?php
if(isset($_POST['send']))
{
  $frm_data = filteration($_POST);

  $q = "INSERT INTO `user_queries`(`name`,`email`,`subject`,`message`) VALUES (?,?,?,?)";
  $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];

  $res = insert($q, $values, 'ssss');
  if($res == 1){
    alert('success', 'Mail sent!');
  }
  else{
    alert('error', 'Server Down! Try again later');
  }
}
?>


  <?php require('inc/footer.php');?>    

 </body>
 </html>