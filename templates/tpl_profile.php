<?php function draw_profile($username) { 
  $user = getUserInfo($username);
  $countryOptions = getAllCountries();
  $messages = getConversations($username);
  print_r($messages);
?>
  <section id="profile">
    <h2 id="userProfileName"><?=toHTML($user->username)?></h2>
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
    <?php draw_conversations($messages) ?>
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

<?php function draw_conversations($conversations) { ?>
  <section id="conversations" class="profileTab">
    <h2>Conversations</h2>
    <ul>
      <?php foreach ($conversations as $conversation) { ?>
        <li class="conversation <?=$conversation->wasSent?'sentMessage':'receivedMessage'?> <?=$conversation->seen?'seenMessage':''?>">
          <img src="../database/avatars/defaultAv.jpg" alt="Photo"/>
          <h3><?=$conversation->otherUser?></h3>
          <p><?=$conversation->content?></p>
          <small class="messageDate"> <?=$conversation->sendTime?></small>
        </li>
      <?php } ?>
    </ul>
  </section>
<?php } ?>

<?php function draw_messages($messages){?>
  <section id="messages" class="profileTab">
    <header>
      <i id="messageBack" class="fas fa-chevron-left"></i>
      <img src="../database/avatars/defaultAv.jpg" alt="Photo"/>
      <h2>John</h2>
    </header>
    <div id="messageHistory">
      <ul>
      <?php foreach ($messages as $message) { ?>
        <li class="message <?=$message->wasSent?'sentMessage':'receivedMessage'?>">
          <p><?=$message->content?></p>
          <small class="messageDate"><?=$message->endTime?></small>
        </li>
      <?php } ?>
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