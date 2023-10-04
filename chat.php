<?php
include_once "./header.php";
include_once "./php/database.php";

session_start();

if(!isset($_SESSION['current_user'])) {
  header("location: login.php");
}
?>

<body>
  <div class="wrapper wrapper-chat">
    <section class="chat">
      <header class="header">
        <?php
        $db = new Database();
        $profile = $db->userById("users", $_GET['user_id']);
        ?>

        <a href="profile.php" class="back-arrow"><i class="fa-solid fa-arrow-left"></i></a>
        <img src="./images/<?php echo $profile['img'] ?>" alt="user profile" class="image" />
        <div class="content">
          <h4><?php echo $profile['fname'] . " " . $profile['lname'] ?></h4>
          <p class="sm-text"><?php echo $profile['status'] ?></p>
        </div>
      </header>
      <div class="chat-box">
        <!-- <div class="message outgoing">
          <div class="details">
            <p>Lorem ipsum dolor sit amet.</p>
          </div>
        </div> -->
      </div>
      <form action="#" class="typing-area">
        <input type="text" class="message" name="message" placeholder="Type a message here...">
        <input type="text" class="incoming" name="incoming" value="<?php echo $_GET['user_id'] ?>" hidden>
        <button><i class="fa-solid fa-paper-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="./js/chat.js"></script>
</body>

</html>