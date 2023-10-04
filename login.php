<?php 

include_once "./header.php";
session_start();

if(isset($_SESSION['current_user'])) {
  header("location: profile.php");
}

?>
  <body>
    <div class="wrapper">
      <section class="signup login">
        <header class="heading">
          <h2>Realtime Chat App</h2>
        </header>
        <form action="#">
          <div class="error-text">This is an error message</div>
          <div class="field">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Email" />
          </div>
          <div class="field">
            <label for="password">Password</label>
            <input type="text" name="password" placeholder="Password" />
          </div>
          <div class="field button">
            <input type="submit" value="Continue to Chat" class="continue" />
          </div>
        </form>
        <div class="already">Not yet signed up? <a href="signup.php">Signup now</a></div>
      </section>
    </div>

    <script src="./js/login.js"></script>
  </body>
</html>
