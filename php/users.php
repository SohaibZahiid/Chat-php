<?php 

  include_once "database.php";


  $db = new Database();

  $result = $db->read("users");

  echo json_encode($result);


?>