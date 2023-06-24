<?php
session_name('user');
session_start();

include "connect.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM user_crud WHERE email = :email";
$stmt = $db->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['profile'] = $user['profile'];
    // print_r($_SESSION['user_id']);

    header("Location: users.php");
    exit;
  } else {
    $_SESSION['error'] = "Invalid username or password";
    // header("Location: users.php");
  }
} else {
  $_SESSION['error'] = "Invalid username or password";
  // header("Location: users.php");
}