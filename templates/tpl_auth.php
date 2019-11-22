<?php function draw_login() { ?>
  <section id="login">
    
    <header><h2>Welcome Back!</h2></header>

    <form method="post" action="../actions/action_login.php">
      <label for="username">Username</label>
      <input id="username" type="text" name="username" placeholder="Type your username" required>  

      <label for="password">Password</label>
      <input id="password" type="password" name="password" placeholder="Type your password" required>

      <input type="submit" value="Login">
    </form>

    <footer>
      <p>Need an account? <a href="signup.php">Sign up!</a></p>
    </footer>

  </section>
<?php } ?>

<?php function draw_signup() { ?>
  <section id="signup">

    <header><h2>Create New Account</h2></header>

    <form method="post" action="../actions/action_signup.php">
      <label for="fullName">Full Name</label>      
      <input id="fullName" type="text" name="fullName" placeholder="Type your name" required>

      <label for="username">Username</label>
      <input id="username" type="text" name="username" placeholder="Pick a username" required>

      <label for="password">Password</label>
      <input id="password" type="password" name="password" placeholder="Pick a password" required>

      <input type="submit" value="Signup">
    </form>

    <footer>
      <p>Already have an account? <a href="login.php">Sign in!</a></p>
    </footer>

  </section>
<?php } ?>