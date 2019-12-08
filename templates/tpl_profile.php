<?php function draw_profile($username) { 
  $user = getUserInfo($username);
  $countryOptions = getAllCountries();
  $messages = getConversations($username);
  $houseList = getHousesFromOwner($username);
  $comingReservations = getComingReservations($username);
  $goingReservations = getGoingReservations($username);
?>
  <section id="profile">
    <h2 id="userProfileName"><?=toHTML($user->username)?></h2>
    <nav>
      <ul>
        <li>Profile</li>
        <li>Your places</li>
        <li>Add place</li>
        <li>Future guests</li>
        <li>Your reservations</li>
        <li>Messages</li>
      </ul>
    </nav>
    <?php draw_profileedit($user, $countryOptions) ?>
    <?php draw_yourListing($houseList) ?>
    <?php draw_addHouse($countryOptions) ?>
    <?php draw_comingReservations($comingReservations) ?>
    <?php draw_goingReservations($goingReservations) ?>
    <?php draw_conversations($messages) ?>
    <?php draw_messages() ?>
      
  </section>

<?php } ?>

<?php function draw_profileedit($user, $countryOptions) {?>
  <section id="editProfile" class="genericForm profileTab">
    <h2>Edit Profile</h2>
    <section id="editInfo">
      <h3>Personal Information</h3>

      <form method="post" action="../actions/action_editProfile.php" enctype="multipart/form-data">
        
        <div id="ppic">
          <input id="profilePic" type="file" name="imageUpload" accept=".png, .jpg, .jpeg" />
          <label for="profilePic"></label>
          <ul id="preview">
            <li><img src= "<?=$user->profilePic?>" alt="Profile Pic"></li>
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
  <section id="yourPlaces" class="profileTab <?=count($houseList)==0?'noContent':''?>">
    <h2>Your Places</h2>
    <?php
      if(count($houseList)>0)
        draw_houselist($houseList);
      else { ?>
        <p>Looks like you dont have any place yet!</p>
        <button id="addHouseButton" type="button">Add a Place</button>
      <?php } ?>
  </section>
<?php } ?>

<?php function draw_comingReservations($comingReservations) { ?>
  <section id="comingReservations" class="profileTab reservationList <?=count($comingReservations)==0?'noContent':''?>">
    <h2>Future Guests</h2>
    <?php if (count($comingReservations) == 0) { ?>
      <p>You haven't received any reservations yet!</p>
      <button id="checkPlacesButton" type="button">Check your places</a></button>      
    <?php } else { ?>
    <table>
        <thead>
          <tr>
            <th colspan="2">Place</th>
            <th>Date</th>
            <th>Guest</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($comingReservations as $reservation) { 
            $place = $reservation->getPlace();
          ?>
          <tr class="reservation">
            <td><a href="../pages/house.php?id=<?=$place->place_id?>"><img src="../database/houseImages/<?=$place->place_id?>/0"></a></td>
            <td class="reservationInfo">
              <span class="hidden reservationID"><?=$reservation->getID()?></span>
              <h3 class="houseTitle"><a href="house.php?id=<?=$place->place_id?>"><?=toHTML($place->title)?></a></h3>
              <p><i class="fas fa-map-marker-alt"></i> <?=toHTML($place->getLocationString())?></p>
            </td>            
            <td class="reservationDate <?=$reservation->isApproaching()?'reservationApproaching':''?>">
              <p><?=$reservation->getStartString()?></p>
              <p><i class="fas fa-long-arrow-alt-down"></i></p>
              <p><?=$reservation->getEndString()?><p>
            </td>
            <td class="reservationGuest"><h3><?=$reservation->getGuest()?></h3></td>
            <td>
              <p class="totalPrice"><span class="priceValue"><?=$reservation->getTotalPrice()?></span> €</p>
              <p class="numNights"><span class="priceValue"><?=$place->pricePerDay?></span> € x <?=$reservation->getNights()?> <?=$reservation->getNights()==1?'night':'nights'?></p>
            </td>
            <td>
              <?php if ($reservation->isApproaching()) { ?>
                <button class="cancelReservation" type="button" disabled>Too late to cancel</button>              
              <?php } else { ?>
                <button class="cancelReservation" type="button">Cancel Reservation</button>
              <?php } ?>
            </td>
          </tr>    
        <?php } ?> 
      </tbody>
    </table>
    <?php } ?> 
  </section>
<?php } ?>

<?php function draw_goingReservations($goingReservations) { ?>
  <section id="goingReservations" class="profileTab reservationList <?=count($goingReservations)==0?'noContent':''?>">
    <h2>Your Reservations</h2>
    <?php if (count($goingReservations) == 0) { ?>
      <p>You haven't booked any reservations yet!</p>
      <button type="button"><a href="../pages/search_houses.php">Search for houses</a></button>      
    <?php } else { ?>
    <table>
      <thead>
        <tr>
        <th colspan="2">Place</th>
        <th>Date</th>
        <th>Price</th>
        <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($goingReservations as $reservation) { 
          $place = $reservation->getPlace();
        ?>
        <tr class="reservation">
          <td><a href="../pages/house.php?id=<?=$place->place_id?>"><img src="../database/houseImages/<?=$place->place_id?>/0"></a></td>
          <td class="reservationInfo">
            <span class="hidden reservationID"><?=$reservation->getID()?></span>
            <h3 class="houseTitle"><a href="house.php?id=<?=$place->place_id?>"><?=toHTML($place->title)?></a></h3>
            <p><i class="fas fa-map-marker-alt"></i> <?=toHTML($place->getLocationString())?></p>
          </td>            
          <td class="reservationDate <?=$reservation->isApproaching()?'reservationApproaching':''?>">
            <p><?=$reservation->getStartString()?></p>
            <p><i class="fas fa-long-arrow-alt-down"></i></p>
            <p><?=$reservation->getEndString()?><p>
          </td>
          <td>
            <p class="totalPrice"><span class="priceValue"><?=$reservation->getTotalPrice()?></span> €</p>
            <p class="numNights"><span class="priceValue"><?=$place->pricePerDay?></span> € x <?=$reservation->getNights()?> <?=$reservation->getNights()==1?'night':'nights'?></p>
          </td>
          <td>
            <?php if (isReviewed($reservation->getID())) { ?>
              <button type="button" disabled>Reservation reviewed</button>              
            <?php } else if ($reservation->recentlyEnded()) { ?>
              <button class="reviewReservation" type="button">Review reservation</button>
            <?php } else if ($reservation->isApproaching()) { ?>
              <button type="button" disabled>Too late to cancel</button>              
            <?php } else { ?>
              <button class="cancelReservation" type="button">Cancel Reservation</button>
            <?php } ?>
          </td>
          <td colspan="5" class="hidden reviewForm">
            <form method="post" action="" class="genericForm">
              <h3>Review this reservation!</h3>
              <div class="rating">
                <input type="radio" id="1star<?=$reservation->getID()?>" name="stars" class="hidden">
                <label for="1star<?=$reservation->getID()?>" class="clickable"><i class="fas fa-star"></i></label>
                <input type="radio" id="2stars<?=$reservation->getID()?>" name="stars" class="hidden">
                <label for="2stars<?=$reservation->getID()?>" class="clickable"><i class="fas fa-star"></i></label>
                <input type="radio" id="3stars<?=$reservation->getID()?>" name="stars" class="hidden">
                <label for="3stars<?=$reservation->getID()?>" class="clickable"><i class="fas fa-star"></i></label>
                <input type="radio" id="4stars<?=$reservation->getID()?>" name="stars" class="hidden">
                <label for="4stars<?=$reservation->getID()?>" class="clickable"><i class="fas fa-star"></i></label>
                <input type="radio" id="5stars<?=$reservation->getID()?>" name="stars" class="hidden">
                <label for="5stars<?=$reservation->getID()?>" class="clickable"><i class="fas fa-star"></i></label>
              </div>
              <span class="closeForm clickable"><i class="fas fa-times"></i></span>
              <textarea name="content" placeholder="Type your comment..."></textarea>
              <button type="submit">Review</button>
            </form>
          </td>
        </tr>   
      <?php } ?> 
      </tbody>
    <?php } ?> 
   </table>
  </section>
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
      
      <p>Recommended Capacity</p>
      <div id="details">
        <input id="min" type="number" name="min" placeholder="Minimum people" min="1" max="20" required>
        <input id="max" type="number" name="max" placeholder="Maximum people" min="1" max="20" required>
        <input id="price" type="number" name="price" placeholder="Price $/day" min="1" max="10000"  required>
      </div>
      
      <div id=addHouseImages>
        <input id="files" type="file" name="fileUpload[]" multiple>        
        <label for="files">Choose images</label>
        <ul id="result"></ul>
      </div>

      <input type="submit" value="Save">
    </form>
  </section>

<?php } ?>

<?php function draw_conversations($conversations) { ?>
  <section id="conversations" class="profileTab <?=count($conversations)==0?'noContent':''?>">
    <h2>Conversations</h2>
    <?php if (count($conversations) == 0) { ?>
      <p>You have no active conversations!</p>
    <?php } else { ?>
      <ul>
        <?php foreach ($conversations as $conversation) { ?>
          <li class="
            conversation 
            <?=$conversation->wasSent?'sentMessage':'receivedMessage'?> 
            <?=$conversation->seen?'seenMessage':''?>"
          >
            <img src="<?=getUserInfo($conversation->otherUser)->profilePic?>" alt="Photo"/>
            <h3><?=$conversation->otherUser?></h3>
            <p><?=toHTML($conversation->content)?></p>
            <small class="messageDate"> <?=$conversation->sendTime?></small>
          </li>
        <?php } ?>
      </ul>
    <?php } ?>
 </section>
<?php } ?>

<?php function draw_messages(){?>
  <section id="messages" class="profileTab">
    <header>
      <i id="messageBack" class="fas fa-chevron-left"></i>
      <img src="../database/profileImages/defaultPic/default.png" alt="Photo"/>
      <h2></h2>
    </header>
    <div id="messageHistory">
      <ul>
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
