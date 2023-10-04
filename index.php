<?php include_once "./header.php" ?>
  <body>
    <div class="wrapper">
      <section class="signup">
        <header>
          <h2>Realtime Chat App</h2>
        </header>
        <form action="#" enctype="multipart/form-data">
          <div class="error-text">This is an error message</div>
          <div class="name-details">
            <div class="field">
              <label for="firstname">First Name</label>
              <input type="text" name="firstname" placeholder="First Name" />
            </div>
            <div class="field">
              <label for="lastname">Last Name</label>
              <input type="text" name="lastname" placeholder="Last Name" />
            </div>
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Email" />
          </div>
          <div class="field">
            <label for="password">Password</label>
            <input type="text" name="password" placeholder="Password" />
          </div>
          <div class="field file">
            <label for="image">Select Image</label>
            <input type="file" name="image"/>
          </div>
          <div class="field button">
            <input type="submit" class="continue" value="Continue to Chat" />
          </div>
        </form>
        <div class="already">Already signed up? <a href="login.php">Login now</a></div>
      </section>
    </div>
    <script src="./js/signup.js"></script>
  </body>
</html>
