<?php 

  session_start();

  include_once "database.php";

  if(isset($_SESSION['current_user'])) {
    if(isset($_GET['user_id'])) {
      $db = new Database();
      $updated = $db->updateStatus("users", "Offline now", $_GET['user_id']);
      if($updated) {
        session_unset();
        session_destroy();
        header("location: ../login.php");
      } else {
        header("location: ../profile.php");
      }
    }
  } else {
    header("location: ../login.php");
  }

?>