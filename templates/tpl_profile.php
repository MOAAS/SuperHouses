<?php function draw_profileedit($user, $countryOptions) { ?>
  <section id="editProfile" class="genericForm">
    <header><h2><?=$user->username?>'s Profile</h2></header>
    <div id="editInfo">
      <h3>Personal Information</h3>
      <form id="editSelfForm" method="post" action="../actions/action_editProfile.php">
        <label for="displayname">Display Name</label>
        <input id="displayname" type="text" name="displayname" value="<?=$user->displayname?>">  

        <label for="country">Country</label>
        <select id="country" name="country">
          <option value=""></option>
          <?php foreach ($countryOptions as $country) { ?>
            <option value="<?=$country?>" <?=$country==$user->country?'selected':''?>><?=$country?></option>
          <?php } ?>
          
        </select>

        <label for="city">City</label>
        <input id="city" type="text" name="city" value="<?=$user->city?>">  

        <input type="submit" value="Save">
      </form>
    </div>

    <div id="editCredentials">
      <h3>Edit Username</h3>
      <form id="editUsernameForm" method="post" action="../actions/action_editUsername.php">
        <label for="currPassword1">Current Password</label>
        <input id="currPassword1" type="password" name="currPassword" required>  

        <label for="newUsername">New Username</label>
        <input id="newUsername" type="text" name="newUsername" required>

        <input type="submit" value="Save">
      </form>

      <h3>Edit Password</h3>
      <form id="editPasswordForm" method="post" action="../actions/action_editPassword.php">
        <label for="currPassword2">Current Password</label>
        <input id="currPassword2" type="password" name="currPassword" required>  

        <label for="newPassword">New Password</label>
        <input id="newPassword" type="password" name="newPassword" required>

        <label for="confirmPassword">Confirm Password</label>
        <input id="confirmPassword" type="password" name="confirmPassword" required>

        <input type="submit" value="Save">
      </form>
    </div>
  </section>
<?php } ?>
