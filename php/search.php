<?php

include_once "database.php";

$searchTerm = $_GET['search'];

$db = new Database();

$result = $db->search("users", $searchTerm);

if($result) {
  echo json_encode(["message" => "success", "data" => $result]);
} else {
  echo json_encode(["message" => "User not found"]);
}




