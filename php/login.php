<?php

session_start();

include_once "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

if (!empty($email) && !empty($password)) {
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $db = new Database();
    if ($db->login($email, $password)) {

      $result = $db->userByEmail("users", $email);

      $updated = $db->updateStatus("users", "Active now", $result["id"]);

      $_SESSION["current_user"] = $result["id"];

      echo json_encode(["message" => "success", "data" => $result]);

    } else {
      echo json_encode(["message" => "Email or password is incorrect"]);
    }
  } else {
    echo json_encode(["message" => "{$email} is not a valid email!"]);
  }
} else {
  echo json_encode(["message" => "All fields are required!"]);
}
