<?php function draw_profileedit($username) { ?>
  <section id="editProfile" class="genericForm">
    <header><h2><?=$username?>'s Profile</h2></header>
    <h3>Edit Username</h3>
    <form id="editUsernameForm" method="post" action="../actions/action_editUsername.php">
      <label for="currPassword">Current Password</label>
      <input id="currPassword" type="password" name="currPassword" required>  

      <label for="newUsername">New Username</label>
      <input id="newUsername" type="text" name="newUsername" required>

      <input type="submit" value="Save">
    </form>

    <h3>Edit Password</h3>
    <form id="editPasswordForm" method="post" action="../actions/action_editPassword.php">
      <label for="currPassword">Current Password</label>
      <input id="currPassword" type="password" name="currPassword" required>  

      <label for="newPassword">New Password</label>
      <input id="newPassword" type="password" name="newPassword" required>

      <label for="confirmPassword">Confirm Password</label>
      <input id="confirmPassword" type="password" name="confirmPassword" required>

      <input type="submit" value="Save">
    </form>
  </section>
<?php } ?>
