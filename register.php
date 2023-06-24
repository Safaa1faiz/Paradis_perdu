<?php

session_start();

// Define the variables
$full_name = $_POST['full_name'];
$address = $_POST['address'];
$email = $_POST['email'];
$password = $_POST['pass'];
$profile = isset($_FILES['profile']) ? $_FILES['profile'] : null;
$target_dir = "profil/";
$target_file = $target_dir . basename($_FILES["profile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a valid file
if (isset($_FILES["profile"])) {
  if ($_FILES["profile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  } else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Sorry, only JPG, PNG, and JPEG files are allowed.";
    $uploadOk = 0;
  }
}

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
    $timestamp = time();
    $random_number = rand(1, 10000);
    $profile_name = "profile_user" . $timestamp . $random_number . "." . $imageFileType;
    $profile_path = $target_dir . $profile_name;

    // Rename the uploaded picture
    if (!rename($target_file, $profile_path)) {
      echo "Sorry, there was an error uploading your file.";
      exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validate the user's input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email address.";
      exit();
    }

    if (strlen($password) < 8) {
      echo "Password must be at least 8 characters long.";
      exit();
    }


    // Connect to the database
    $dsn = 'mysql:host=localhost;dbname=hbwebsite';
    $username = 'root';
    $password = '';

    try {
      $pdo = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      exit();
    }

    // Insert the user into the database
    $sql = "INSERT INTO user_crud (full_name, address, email, password, profile) VALUES (:full_name, :address, :email, :password, :profile)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':profile', $profile_name);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
      // Redirect the user to the homepage
      header("Location: index.php");
    } else {
      $message = 'Something went wrong. Please try again.';
      $_SESSION['message'] = $message;
      header("Location: signUp.php");
    }

    // Close the database connection
    $pdo = null;
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

// Redirect the user to the homepage
// header("Location: index.php"); 

?>