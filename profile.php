<?php 

session_start();

if(!isset($_SESSION['current_user'])) {
  header("location: login.php");
}

include_once "./header.php";
include_once "./php/database.php"

?>
  <body>
    <div class="wrapper">
      <section class="profile">
        <header>
          <?php 
            $db = new Database();
            $profile = $db->userById("users", $_SESSION['current_user']);
          ?>
          <div class="content">
            <img src="./images/<?php echo $profile['img']  ?>" alt="user image" class="image"/>
            <div class="details">
              <h4><?php echo $profile['fname'] . " " . $profile['lname'] ?></h4>
              <p class="sm-text"><?php echo $profile['status']  ?></p>
            </div>
          </div>
          <a href="php/logout.php?user_id=<?php echo $profile['id'] ?>">Logout</a>
        </header>
        <div class="search">
          <input type="text" name="search" placeholder="Select an user to start chat" />
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div class="users-list">
          <!-- <a href="#" class="user">
            <div class="content">
              <img src="/profile.jpg" alt="user image" class="image"/>
              <div class="details">
                <h4>Coding Nepal</h4>
                <p class="sm-text">Hello Andrew</p>
              </div>
            </div>
            <div class="status">
              <i class="fa-solid fa-circle"></i>
            </div>
          </a> -->
        </div>
      </section>
    </div>
    <script src="./js/users.js"></script>
  </body>
</html>
