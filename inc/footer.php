<!--Footer-->
    <div class="container-fluid bg-white mt-5">
        <div class="row">
            <div class="col-lg-4 p-4">
              <h3 class="h-font fs-bold fs-3 mb-2"><?php echo $settings_r['site_title']?></h3>
              <p><?php echo $settings_r['site_about']?></p>
            </div>
            <div class="col-lg-4 p-4">
             <h5 class="mb-3">Links</h5>
             <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Acceuil</a><br>
             <a href="roooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
             <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Services</a><br>
       
             <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact</a><br>
             <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">A propos de nous</a>
            </div>
            <div class="col-lg-4 p-4">
            <h5 class="mb-3">Suivez nous</h5>
            <?php 
             if($contact_r['tw']!=''){
              echo <<<data
                <a href="$contact_r[tw]" class="d-inline-block mb-2 text-dark text-decoration-none">
                <i class="bi bi-twitter" target="_blank" ></i> Twitter    
                </a><br>
              data;
             }
            ?>  
                    <a href="<?php echo $contact_r['fb']?>"class="d-inline-block mb-2 text-dark text-decoration-none " >
                    <i class="bi bi-facebook" target="_blank"></i> Facebook    
                    </a><br>
                    <a href="<?php echo $contact_r['insta']?>"class="d-inline-block text-dark text-decoration-none">
                    <i class="bi bi-instagram" target="_blank"></i> Instagram    
                    </a>
            </div>
        </div>
    </div>
  <h6 class="text-center bg-dark text-white p-3 m-0">Designed and Developed by SAFAA FAIZ</h6> 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
<script>





</script>
 