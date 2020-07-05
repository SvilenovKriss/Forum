<?php
  include 'src/jwt/jwt.service.php';
  require 'vendor/autoload.php';

  function signUp($email, $username, $password, $db) {
    $query_email = "SELECT * FROM user WHERE email='$email'";
    $stmt = $db->query($query_email);
    if($stmt) {
      return "Email already exists";
    }

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO app.user (email, username, password, createdAt)
      VALUES ('$email', '$username', '$hashPassword', NOW())";
    $response = $db->query($query);
    if (!$response) {
      die('mysqli error: '.mysqli_error($db));
    }

    $msg = array("msg" => "Successfully registered!");
    return json_encode($msg);
  }

  function signIn($email, $password, $db) {
    $query = "SELECT * FROM app.user WHERE email= '$email'";
    $stmt = $db->query($query);
    if(!$stmt) {
      die('mysqli error: ' .mysqli_error($db));
    }

    $userData = $stmt->fetchAll()[0];
    $hashPassowrd = password_verify($password, $userData['password']);
    if(!$hashPassowrd) {
      die ("$hashPassowrd AND $userData[password]");
    }

    $token = jwtTokenEncode($email, $userData['id']);
    $insertQuery = "UPDATE user SET token='$token' WHERE email='$email'";
    $updateDb = $db->query($insertQuery);
    if(!$updateDb) {
      die('mysqli error: ' .mysqli_error($db));
    }
    $tokenObj = array("token" => $token);
    return json_encode($tokenObj);
  }
?>