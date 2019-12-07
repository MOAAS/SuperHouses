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
  $userId = getUserID($_SESSION['username']);
  $avg_rating = getHouseRating($house->place_id);
  $num_ratings = getNumRatings($house->place_id);
  $user_rating = getUserRating($userId, $house->place_id);
  $owner = getUserInfo($house->ownerUsername);
  $ownerId = getUserID($owner->username);
  ?>
  <section id="house">
    <div id="photos">
      <ul id="photoCarousel">
      <?php foreach($pictures as $picture){?>
        <li>
        <img src=<?=$picture?> alt="<?=toHTML($house->title)?>">
        </li>
      <?php } ?>
      </ul>
      <button id="photoLeftButton">&#10094;</button>
      <button id="photoRightButton">&#10095;</button>
    </div>
    <?php 
    if($userId == $ownerId){ ?>
      <a href="edit_house.php?id=<?=$house->place_id?>"><button type="button">Edit Place</button> </a>
    <?php } ?>
    
    <div id="place-body">
      <section id="place-info">
        <p class="title"><?=toHTML($house->title)?></p>
        <i class="fa fa-map-marker-alt"></i>
        <p class="address"><?=toHTML($house->address)?>, <?=toHTML($house->city)?>, <?=toHTML($house->country)?></p>
        <p class="description"><?=toHTML($house->description)?></p>
        <p class="host">Hóspede: <?=toHTML($house->ownerDisplayname)?></p>
      </section>
      <section id="booking" class="genericForm">
        <i class="fab fa-bitcoin"></i>
        <p class="price"><?=toHTML($house->pricePerDay)?></p>
          <div class="rating">
            <form class="stars">
                <input type="radio" id="1star" name="stars" <?=($user_rating == 1)?'checked="checked"':''; ?>>
                <label for="1star"></label>
                <input type="radio" id="2stars" name="stars" <?=($user_rating == 2)?'checked="checked"':''; ?>>
                <label for="2stars"></label>
                <input type="radio" id="3stars" name="stars" <?=($user_rating == 3)?'checked="checked"':''; ?>>
                <label for="3stars"></label>
                <input type="radio" id="4stars" name="stars" <?=($user_rating == 4)?'checked="checked"':''; ?>>
                <label for="4stars"></label>
                <input type="radio" id="5stars" name="stars" <?=($user_rating == 5)?'checked="checked"':''; ?>/>
                <label for="5stars"></label>
            </form>
            <p class="stars"><?=toHTML($num_ratings)?> reviews</p>
        </div>
        <div id="checkInDateField">
          <label for="checkInDate">Check-in:</label>
          <input id="checkInDate" type="date" name="checkInDate">
        </div>
        <div id="checkOutDateField">
          <label for="checkOutDate">Check-out:</label>
          <input id="checkOutDate" type="date" name="checkOutDate">
        </div>
        <input type="submit" value="Book">
      </section>
    </div>
  </section>
<?php } ?>

<?php function draw_editHouse($house, $pictures) { 
  $countryOptions = getAllCountries();?>
  <section id="addHouse" class="genericForm profileTab">
    <h2>Edit your place</h2>    
    <form method="post" action="../actions/action_editHouse.php?id=<?=$house->place_id?>" enctype="multipart/form-data">
      <label for="title">Title</label>      
      <input id="title" type="text" name="title" placeholder="Name your place"  value="<?=toHTML($house->title)?>" required>

      <label for="description">Description</label>
      <textarea rows="6" id="description" name="description" placeholder="Describe your place"  required><?=toHTML($house->description)?></textarea>
      <div id="localization">
        <div>
        
          <label for="houseCountry">Country</label>
          <select id="<?=$id?>" name="country">
            <option value="">None</option>
            <?php foreach ($countryOptions as $country) {
              if($country == $house->country){ ?>
              <option selected value="<?=$country?>"><?=$country?></option>
              <?php }else{ ?>
              <option value="<?=$country?>"><?=$country?></option>
            <?php }}?>
          </select>

        </div>
        <div>
          <label for="houseCity">City</label>
          <input id="houseCity" type="text" name="city" placeholder="City" value="<?=toHTML($house->city)?>"required>
        </div>
        <div>
          <label for="address">Address</label>
          <input id="address" type="text" name="address" placeholder="Address" value="<?=toHTML($house->address)?>" required>
        </div>
      </div>
      
      <p>Recommended Capacity</p>
      <div id="details">
        <input id="min" type="number" name="min" placeholder="Minimum people" min="1" max="20" value="<?=toHTML($house->minPeople)?>" required>
        <input id="max" type="number" name="max" placeholder="Maximum people" min="1" max="20" value="<?=toHTML($house->maxPeople)?>" required>
        <input id="price" type="number" name="price" placeholder="Price $/day" min="1" max="10000" value="<?=toHTML($house->pricePerDay)?>" required>
      </div>
      
      <div id=addHouseImages>
        <input id="files" type="file" name="fileUpload[]" multiple>        
        <label for="files">Choose images</label>
        <ul id="result">
          <?php foreach($pictures as $picture){?>
          <li>
            <img src=<?=$picture?> alt="<?=toHTML($house->title)?>">
          </li>
          <?php } ?>
        </ul>
      </div>

      <input type="submit" value="Save">
    </form>
  </section>
<?php } ?>

