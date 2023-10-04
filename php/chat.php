<?php
session_start();

include_once "database.php";

if (isset($_SESSION['current_user'])) {

  $message = $_POST['message'];

  $currentUser = $_SESSION['current_user'];
  $otherUser = $_GET['user_id'];



  $db = new Database();
  $inserted = $db->insert("chats", array("incoming" => $otherUser, 
  "outgoing" => $currentUser, "msg" => $message));
  if ($inserted) {
    echo json_encode(["message" => "success"]);
  } else {
    echo json_encode(["message" => "Something went wrong]"]);
  }
}

