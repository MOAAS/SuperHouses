<?php function draw_profile($username) { 
  $user = getUserInfo($username);
  $countryOptions = getAllCountries();
  $messages = getLatestMessages($username);
?>
  <section id="profile">
    <h2><?=toHTML($user->username)?></h2>
    <nav>
      <ul>
        <li>Profile</li>
        <li>Your places</li>
        <li>Add Place</li>
        <li>Reservations</li>
        <li>Your reservations</li>
        <li>Messages</li>
      </ul>
    </nav>
    <?php draw_profileedit($user, $countryOptions) ?>
    <?php draw_addHouse($countryOptions) ?>
    <?php draw_messages($messages) ?>
      
  </section>

<?php } ?>

<?php function draw_profileedit($user, $countryOptions) { ?>
  <section id="editProfile" class="genericForm profileTab">
    <h2>Edit Profile</h2>
    <section id="editInfo">
      <h3>Personal Information</h3>
      <form method="post" action="../actions/action_editProfile.php">
        <label for="displayname">Display Name</label>
        <input id="displayname" type="text" name="displayname" value="<?=toHTML($user->displayname)?>">  

        <label for="userCountry">Country</label>
        <?php draw_countrySelect("userCountry", $countryOptions); ?>

        <label for="userCity">City</label>
        <input id="userCity" type="text" name="city" value="<?=toHTML($user->city)?>">  

        <input type="submit" value="Save">
      </form>
    </section>

    <section id="editCredentials">
      <h3>Edit Username</h3>
      <form method="post" action="../actions/action_editUsername.php">
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
    </section>
  </section>
<?php } ?>

<?php function draw_countrySelect($id, $countryOptions) { ?>
  <select id="<?=$id?>" name="country">
    <option value="">None</option>
    <?php foreach ($countryOptions as $country) { ?>
      <option value="<?=$country?>"><?=$country?></option>
    <?php } ?>
  </select>
<?php } ?>

<?php function draw_addHouse($countryOptions){?>
  <section id="addHouse" class="genericForm profileTab">
    <h2>Add your place</h2>    
    <form method="post" action="../actions/action_addHouse.php" enctype="multipart/form-data">
      <label for="title">Title</label>      
      <input id="title" type="text" name="title" placeholder="Name your place" required>

      <label for="description">Description</label>
      <textarea rows="6" id="description" name="description" placeholder="Describe your place" required></textarea>
      <div id="localization">
        <div>
          <label for="houseCountry">Country</label>
          <?php draw_countrySelect("houseCountry", $countryOptions); ?>
        </div>
        <div>
          <label for="houseCity">City</label>
          <input id="houseCity" type="text" name="city" placeholder="City" required>
        </div>
        <div>
          <label for="address">Address</label>
          <input id="address" type="text" name="address" placeholder="Address" required>
        </div>
      </div>
      
      <div id="details">
        <div>
          <label for="min">Min</label>
          <input id="min" type="number" name="min" placeholder="min" min="1" max="20" required>
        </div>
        <div>
          <label for="max">Max</label>
          <input id="max" type="number" name="max" placeholder="max" min="1" max="20" required>
        </div>
        <div>
          <label for="price">Price</label>
          <input id="price" type="number" name="price" placeholder="50" required>
        </div>
      </div>
      
      <div>
        <input id="files" type="file" name="fileUpload[]" multiple required>        
        <label for="files">Choose images</label>
        <ul id="result"></ul>
      </div>

      <input type="submit" value="Save">
    </form>
  </section>

<?php } ?>

<?php function draw_messages($messages){?>
  <section id="messages" class="profileTab">
    <h2>Your Messages</h2>
    <div id="conversations">
      <ul>
        <li class="conversation">
          <h3>John</h3>
          <p>Message from John</p>
          <span>May 28th</span>
        </li>
        <li class="conversation">
          <h3>Not John</h3>
          <p>Message from John 2</p>
          <span>May 27th</span>
        </li>
        <li class="conversation">
          <h3>John but another John</h3>
          <p>Message from John 3</p>
          <span>May 26th</span>
        </li>
      </ul>
    </div>
    <div id="conversationUser">
      <h3>John</h3>
    </div>
    <div id="messageHistory">
      <ul>
        <li class="message receivedMessage">
          <p>Message from John</p>
          <small class="messageDate">May 27th</small>
        </li>
        <li class="message receivedMessage">
          <p>Another message from John</p>
          <small class="messageDate">May 28th</small>
        </li>
        <li class="message sentMessage">
          <p>Message that you sent to John</p>
          <small class="messageDate">May 28th</small>
        </li>
      </ul>
    </div>
    <div id="sendMessageInput">
      <form method="post" action="../actions/action_sendMessage.php">
        <input id="sentMessage" type="text" name="content" placeholder="Type your message...">
        <button type="submit"><i class="fas fa-paper-plane"></i></button>      
      </form>
    </div>
  </section>

<?php } ?>