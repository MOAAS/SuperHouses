<?php function draw_houselist($houseList) {?>
<section id="houses">
    <ul>
    <?php foreach($houseList as $house)
    
    {?>
      <li>
        <a href="house.php?id=<?=$house->place_id?>">
          <figure>
            <img src="../database/houseImages/<?=$house->place_id?>/0" alt="House image">
            <figcaption><h3><?=toHTML($house->title)?></h3></figcaption>
          </figure>
          <div class="houseInfo">
            <div class="priceTag">
              <p class="priceValue"><?=$house->pricePerDay?></p> 
              <p class="priceCurrency"> € / day</p>
            </div>
            <p class="houseLocation"><i class="fas fa-map-marker-alt"></i> <?=toHTML($house->getLocationString())?></p>
            <p class="guestLimit"><i class="fas fa-users"></i> <?=toHTML($house->minPeople)?> - <?=toHTML($house->maxPeople)?> people</p>
          </div>
        </a>
      </li>
    <?php } ?>
    </ul>
</section>
<?php } ?>

<?php function draw_house($house, $pictures) {
  $ratings = getHouseRatings($house->place_id);
  $owner = getUserInfo($house->ownerUsername);
?>
  <section id="house">
    <span id="houseID" class="hidden"><?=$house->place_id?></span>
    <div id="photos">
      <ul id="photoCarousel">
      <?php foreach($pictures as $picture){?>
        <li><img src=<?=$picture?> alt="<?=toHTML($house->title)?>"></li>
      <?php } ?>
      </ul>
      <button id="photoLeftButton">&#10094;</button>
      <button id="photoRightButton">&#10095;</button>
    </div>
    <div id="place-body">
      <section id="place-info">
        <h2><?=toHTML($house->title)?></h2>        
        <p id="houseOwner">
          <img src="<?=getProfilePicture($house->ownerUsername)?>" alt="<?=toHTML($house->ownerUsername)?>"> 
          <?=toHTML($house->ownerDisplayname)?> 
          <a href="../pages/profile.php#Conversation <?=toHTML($house->ownerUsername)?>">(Message him)</a>
        </p>
        <p id="houseLocation"><i class="fa fa-map-marker-alt"></i> &nbsp;<?=toHTML($house->getLocationString())?></p>
        <p id="houseAddress">Address: <?=toHTML($house->address)?></p>
        <p id="houseCommodities">
          <i class="fas fa-users"> <?=$house->maxPeople?> people</i>
          <i class="fas fa-bed"> <?=toHTML('2')?> rooms / <?=toHTML('4')?> beds</i> 
          <i class="fas fa-shower"> <?=toHTML('3')?> bathrooms</i> 
        </p>
        <p id="houseDescription"><?=toHTML($house->description)?></p>
      </section>
      <form action="../actions/action_addReservation" method="post" id="booking" class="genericForm">
        <!--
          <div class="rating">
            <form class="stars">
                <input type="radio" id="1star" name="stars" <?//=($user_rating == 1)?'checked="checked"':''; ?>>
                <label for="1star"></label>
                <input type="radio" id="2stars" name="stars" <?//=($user_rating == 2)?'checked="checked"':''; ?>>
                <label for="2stars"></label>
                <input type="radio" id="3stars" name="stars" <?//=($user_rating == 3)?'checked="checked"':''; ?>>
                <label for="3stars"></label>
                <input type="radio" id="4stars" name="stars" <?//=($user_rating == 4)?'checked="checked"':''; ?>>
                <label for="4stars"></label>
                <input type="radio" id="5stars" name="stars" <?//=($user_rating == 5)?'checked="checked"':''; ?>/>
                <label for="5stars"></label>
            </form>
            <p class="stars"><?//=toHTML($num_ratings)?> reviews</p>
        </div>
      -->
        <label for="checkInDate">Check-in:</label>
        <input id="checkInDate" type="date" name="checkInDate" min="<?=date("Y-m-d")?>">       

        <label for="checkOutDate">Check-out:</label>
        <input id="checkOutDate" type="date" name="checkOutDate" min="<?=date("Y-m-d")?>">

        <p id="unavailableDate"></p>

        <p class="priceTag"><span class="priceValue"><?=toHTML($house->pricePerDay)?></span> <i class="fas fa-euro-sign"></i> x <span id="totalNights">0 nights</span></p>
        <p id="bookingPrice" class="priceTag">Total: <span class="priceValue">0</span> <i class="fas fa-euro-sign"></i></p>
        <button type="submit">Book</button>
        <span id="loadingIndicator" class="hidden"><i class="fas fa-spinner"></i></span>
      </form>
    </div>
  </section>
<?php } ?>