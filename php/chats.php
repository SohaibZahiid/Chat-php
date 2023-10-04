<?php
session_start();

include_once "database.php";

if (isset($_SESSION['current_user'])) {

  $currentUser = $_SESSION['current_user'];
  $incoming = $_GET['user_id'];

  $db = new Database();

  $result = $db->readWhere("chats", $currentUser, $incoming);

  if($result) {
    echo json_encode(["message" => "success", "data" => $result, "outgoing" => $currentUser]);
  } else {
    echo json_encode(["message" => "Messages not found"]);
  }

}
