<?php function draw_profile($user, $ppic, $countryOptions,$houseList) { ?>
  <section id="profile">
    <header><h2><?=toHTML($user->username)?></h2></header>
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
    <?php draw_profileedit($user, $ppic, $countryOptions) ?>
    <?php draw_yourListing($houseList) ?>
    <?php draw_addHouse($countryOptions) ?>
      
  </section>

<?php } ?>

<?php function draw_profileedit($user, $ppic, $countryOptions) {?>
  <section id="editProfile" class="genericForm profileTab">
    <header><h2>Edit Profile</h2></header>
    <section id="editInfo">
      <h3>Personal Information</h3>

      <form method="post" action="../actions/action_editProfile.php" enctype="multipart/form-data">
        
        <div id="ppic">
          <input id="profilePic" type="file" name="imageUpload" accept=".png, .jpg, .jpeg" />
          <label for="profilePic"></label>
          <ul id="preview">
            <li><img src= "<?=$ppic?>" alt="Profile Pic"></li>
          </ul>
        </div>

        <label for="displayname">Display Name</label>
        <input id="displayname" type="text" name="displayname" value="<?=toHTML($user->displayname)?>">  

        <label for="userCountry">Country</label>
        <?php draw_countrySelect("userCountry", $countryOptions); ?>

        <label for="userCity">City</label>
        <input id="userCity" type="text" name="city" value="<?=toHTML($user->city)?>">  

        <input type="submit" value="Save">
      </form>

      <h3>Preferences</h3>
      <div class="theme-switch-wrapper">
        <p>Theme</p>
          <label class="theme-switch" for="checkbox">
          <input type="checkbox" id="checkbox" />
          <div class="slider round"></div>
          </label>
      </div>
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


<?php function draw_yourListing($houseList){?>
  <section id="yourPlaces" class="genericForm profileTab">
    <?php
      if(count($houseList)>0)
        draw_houselist($houseList);
      else{ ?>
      <div id="noPlaces">
       <p>Looks like you dont have any place yet!</p>
       <button id="addHouseButton" type="button">Add a Place</button>
      </div> 
      <?php } ?>
  </section>
<?php } ?>

<?php function draw_addHouse($countryOptions){?>
  <section id="addHouse" class="genericForm profileTab">

    <header><h2>Add your place!</h2></header>
    
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
      
      <p>Recomended Capacity</p>
      <div id="details">
        <div>
          <label for="min">Minimum</label>
          <input id="min" type="number" name="min" placeholder="Minimum" min="1" max="20" required>
        </div>
        <div>
          <label for="max">Maximum</label>
          <input id="max" type="number" name="max" placeholder="Maximum" min="1" max="20" required>
        </div>
        <div>
          <label for="price">Price</label>
          <input id="price" type="number" name="price" placeholder="Price $/day" min="1" max="10000"  required>
        </div>
      </div>
      
      <div id=addHouseImages>
        <input id="files" type="file" name="fileUpload[]" multiple required>        
        <label for="files">Choose images</label>
        <ul id="result"></ul>
      </div>

      <input type="submit" value="Save">
    </form>
  </section>

<?php } ?>

