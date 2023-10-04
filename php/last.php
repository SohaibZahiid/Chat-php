<?php 

  include_once "database.php";


  $db = new Database();

  $result = $db->lastMessage();

  if($result) {
    echo json_encode(["message" => "success", "data" => $result]);
  } else {
    echo json_encode(["message" => "No message available"]);
  }



?>