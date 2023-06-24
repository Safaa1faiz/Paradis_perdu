
<!--Navbar-->
    <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="images/logo.png" alt="paradisperdu" width="50" height="40">
    </a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link me-2" href="index.php">Acceuil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="roooms.php">Chambres & Suites</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facilities.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="about.php">A propos de nous</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
    <div class="d-flex">
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModel">Connexion	</button>
        <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModel">Registration	</button>
    </div>
    </div>
  </div>
</nav>
  <!-- Modal -->
       <div class="modal fade" id="loginModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
        <form action="login.php" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center">
         <i class="bi bi-person-circle fs-3 me-2"></i> Connexion
        </h5>
        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" name="email" class="form-control shadow-none"  required>
     </div>
     <div class="mb-4">
        <label class="form-label" >Mot de passe</label>
        <input type="password" name="password" class="form-control shadow-none"required minlenght="6">
     </div>
     <div class="d-flex align-items-center justify-content-between mb-2">
        <button type="submit" class="btn btn-dark shadow-none" name="login">Connexion</button>
        <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
     </div>
      </div>
      </form>
    </div>
    </div>
    </div>
    <!-- Modal registration: -->
       <div class="modal fade" id="registerModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
         <div class="modal-content">
        <form id="register-form" action="register.php" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-person-lines-fill fs-3 me-2"></i>  Registration
        </h5>
        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
            Note: Your details must match with your ID (Identity card, passport, driving license, etc...)
            that will be required during check-in.
        </span>
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">Nom & prénom</label>
                <input name="full_name" type="text" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 p-0 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control shadow-none" required>
            </div>
              <div class="col-md-6 p-0 mb-3">
              <label class="form-label">Photo</label>
              <input type="file" name="profile" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
            </div>
            <div class="col-md-12 p-0 mb-3">
              <label class="form-label">Addresse</label>
              <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
             </div>
            <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="pass" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 p-0 mb-3">
              <label class="form-label">Confirm mot de passe</label>
              <input type="password" name="cpass" class="form-control shadow-none" required>
            </div>
            </div>
        </div>
        <div class="text-center my-1">
                   <button type="submit" class="btn btn-dark shadow-none">REGISTERER</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>