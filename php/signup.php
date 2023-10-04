<?php

include_once "database.php";


$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
  // validate email
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $db = new Database();
    // check if email already exists
    if ($db->checkEmail($email)) {
      echo json_encode(["message" => "{$email} already exists!"]);
    } else {
      // check file uploaded
      if (isset($_FILES['image'])) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        // get image extension
        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);

        $extensions = ['png', 'jpg', 'jpeg']; // valid extensions

        if (in_array($img_ext, $extensions)) { // image extension matches with array
          $time = time();
          $new_img_name = $time . $img_name;

          if (move_uploaded_file($tmp_name, "../images/" . $new_img_name)) {
            $status = "Active now";

            // insert user to db
            $inserted = $db->insert("users", [
              "fname" => $fname, "lname" => $lname,
              "email" => $email, "password" => $password, "img" => $new_img_name,
              "status" => $status
            ]);

            if ($inserted) {
              $result = $db->userByEmail("users", $email);
              $_SESSION["current_user"] = $result["id"];
              echo json_encode(["message" => "success"]);
            } else {
              echo json_encode(["message" => "error"]);
            }
          }
        } else {
          echo json_encode(["message" => "Please select an valid image - jpeg, jpg, png!"]);
        }
      } else {
        echo json_encode(["message" => "Please select an image!"]);
      }
    }
  } else {
    echo json_encode(["message" => "{$email} is not a valid email!"]);
  }
} else {
  echo json_encode(["message" => "All fields are required!"]);
}
