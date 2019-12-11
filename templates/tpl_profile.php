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
      <!-- just for the hamburguer menu in responsive layout -->
      <input type="checkbox" id="hamburger" class="hidden"> 
      <label class="hamburger hidden" for="hamburger"></label>

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
    <?php draw_goingReservations($username, $goingReservations) ?>
    <?php draw_conversations($messages) ?>
    <?php draw_messages() ?>
      
  </section>

<?php } ?>

<?php function draw_profileedit($user, $countryOptions) {?>
  <section id="editProfile" class="genericForm profileTab reducedWidth">
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
        draw_houselist($houseList,true);
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
      <button id="checkPlacesButton" type="button">Check your places</button>      
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
            <td class="reservationImg"><a href="../pages/house.php?id=<?=$place->place_id?>"><img src="../database/houseImages/<?=$place->place_id?>/0" alt="<?=toHTML($place->title)?>"></a></td>
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
            <td class="reservationPrice">
              <p class="totalPrice"><span class="priceValue"><?=$reservation->getTotalPrice()?></span> €</p>
              <p class="numNights"><span class="priceValue"><?=$reservation->getPricePerDay()?></span> € x <?=$reservation->getNights()?> <?=$reservation->getNights()==1?'night':'nights'?></p>
            </td>
            <td class="reservationAction">
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

<?php function draw_goingReservations($username, $goingReservations) { ?>
  <section id="goingReservations" class="profileTab reservationList <?=count($goingReservations)==0?'noContent':''?>">
    <h2>Your Reservations</h2>
    <?php if (count($goingReservations) == 0) { ?>
      <p>You haven't booked any reservations yet!</p>
      <button id="searchPlacesButton" type="button">Search for houses</button>
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
          $reservation->isApproaching();
        ?>
        <tr class="reservation">
          <td class="reservationImg"><a href="../pages/house.php?id=<?=$place->place_id?>"><img src="../database/houseImages/<?=$place->place_id?>/0" alt="<?=toHTML($place->title)?>"></a></td>
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
          <td class="reservationPrice">
            <p class="totalPrice"><span class="priceValue"><?=$reservation->getTotalPrice()?></span> €</p>
            <p class="numNights"><span class="priceValue"><?=$reservation->getPricePerDay()?></span> € x <?=$reservation->getNights()?> <?=$reservation->getNights()==1?'night':'nights'?></p>
          </td>
          <td class="reservationAction">
            <?php if (isReviewed($reservation->getID())) { ?>
              <button type="button" disabled>Reservation reviewed</button>    
            <?php } else if ($reservation->isCancellable()) { ?>
              <button class="cancelReservation" type="button">Cancel Reservation</button>
            <?php } else if ($reservation->hasEnded() && $place->ownerUsername == $reservation->getGuest()) { ?>
              <button type="button" disabled>This is your house!</button>       
            <?php } else if ($reservation->hasEnded()) { ?>
              <button class="reviewReservation" type="button">Review reservation</button>
            <?php } else { ?>
              <button type="button" disabled>Too late to cancel</button>
            <?php } ?>
          </td>
          <td colspan="5" class="hidden reviewForm">
            <form method="post" class="genericForm">
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
    </table>
    <?php } ?> 
  </section>
<?php } ?>


<?php function draw_addHouse($countryOptions){?>
  <section id="manageHouse" class="profileTab genericForm reducedWidth">
    <h2>Add your place</h2>    
    <form method="post" action="../actions/action_addHouse.php" enctype="multipart/form-data">

      <div id="mainInfo">
        <label for="title">Title</label>      
        <input id="title" type="text" name="title" placeholder="Name your place">

        <label for="description">Description</label>
        <textarea id="description" rows="6"  name="description" placeholder="Describe your place"></textarea>
      </div>

      <section id="location">
        <h3>Location</h3>
        <label for="houseCountry">Country</label>
        <?php draw_countrySelect("houseCountry", $countryOptions); ?>

        <label for="houseCity">City</label>
        <input id="houseCity" type="text" name="city" placeholder="City">

        <label for="address">Address</label>
        <input id="address" type="text" name="address" placeholder="Address">
      </section>

      <section id="accomodations">
        <h3>Accomodations</h3>
        <label for="numRooms">Bedrooms</label>
        <input id="numRooms" type="number" name="numRooms" placeholder="Number of bedrooms">
        
        <label for="numBeds">Beds</label>
        <input id="numBeds" type="number" name="numBeds" placeholder="Number of beds">

        <label for="numBathrooms">Bathrooms</label>
        <input id="numBathrooms" type="number" name="numBathrooms" placeholder="Number of bathrooms">
      </section>

      <section id="details">
        <h3>Details</h3>
        <label for="capacity">Capacity</label>
        <input id="capacity" type="number" name="capacity" placeholder="Guest capacity">

        <label for="price">Price (Max. 1000€)</label>
        <input id="price" type="number" step="0.01" name="price" placeholder="€ / night">
      </section>

      <div id="manageHouseImages">
        <input id="files" type="file" name="fileUpload[]" multiple class="requiresFiles">        
        <label for="files" class="clickable">Choose images</label>
        <ul id="result"></ul>
      </div>

      <button type="submit">Add house</button>
    </form>
  </section>
<?php } ?>

<?php function draw_conversations($conversations) { ?>
  <section id="conversations" class="profileTab <?=count($conversations)==0?'noContent':'reducedWidth'?>">
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
  <section id="messages" class="profileTab reducedWidth">
    <header>
      <i id="messageBack" class="fas fa-chevron-left"></i>
      <img src="../database/profileImages/defaultPic/default.png" alt="Photo"/>
      <h2>Placeholder</h2>
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
