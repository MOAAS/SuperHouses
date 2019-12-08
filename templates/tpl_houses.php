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

<?php function draw_house($username, $house, $pictures) {
  $avgRating = getHouseAvgRating($house->place_id);
  $comments = getHouseComments($house->place_id);
  $ownerProfilepic = getProfilePicture($house->ownerUsername);
  $numComments = count($comments);
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

    <?php if($username == $house->ownerUsername){ ?>
      <a href="edit_house.php?id=<?=$house->place_id?>"><button type="button">Edit Place</button></a>
    <?php } ?>
    
    <div id="place-body">
      <section id="place-info">
        <h2><?=toHTML($house->title)?></h2>        
        <p id="houseOwner">
          <img src="<?=$ownerProfilepic?>" alt="<?=toHTML($house->ownerUsername)?>"> 
          <?=toHTML($house->ownerDisplayname)?> 
          <?php if ($house->ownerUsername != $username) {?>
            <a href="../pages/profile.php#Conversation <?=toHTML($house->ownerUsername)?>">(Message)</a>
          <?php } ?>
        </p>
        <div id="placeRating">
          <?php if ($numComments == 0) { ?>            
            <span>No reviews</span>
          <?php } else { ?>
            <span id="avgRating"><?=$avgRating?> <i class="fas fa-star"></i></span>
            <span>(<?=$numComments==1?'1 review':$numComments . ' reviews'?>)</span>
          <?php } ?>
        </div>
        <p id="houseLocation"><i class="fa fa-map-marker-alt"></i> &nbsp;<?=toHTML($house->getLocationString())?></p>
        <p id="houseAddress">Address: <?=toHTML($house->address)?></p>
        <p id="houseAcommodations">
          <i class="fas fa-users"> <?=$house->maxPeople?> guests</i>
          <i class="fas fa-bed"> <?=toHTML('2')?> rooms / <?=toHTML('4')?> beds</i> 
          <i class="fas fa-shower"> <?=toHTML('3')?> bathrooms</i> 
        </p>
        <p id="houseDescription" class="allowNewlines"><?=toHTML($house->description)?></p>
      </section>
      <form action="../actions/action_addReservation" method="post" id="booking" class="genericForm">
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

      <section id="placeComments">
        <h2 class="<?=$numComments==0?'hidden':''?>">Comments</h2>
        <?php foreach($comments as $comment)  { ?>
          <article class="comment">
            <span class="hidden reservationID"><?=$comment['reservation']?></span>
            <img src="<?=getProfilePicture($comment['username'])?>" alt="<?=toHTML($comment['username'])?>"> 
            <h3 class="commentPoster"><?=toHTML($comment['username'])?></h3> 
            <p class="commentReservation"><?=toHTML($comment['date'])?></p>
            <div class="rating">

              <?php for ($i = 0; $i < $comment['rating']; $i++) { ?>
                <i class="fas fa-star"></i>
              <?php } ?>
              <?php for ($i = $comment['rating']; $i < 5; $i++) { ?>
                <i class="far fa-star"></i>
              <?php } ?>
              <?=$comment['rating']?>/5
            </div>
            <p class="commentContent allowNewLines"><?=toHTML($comment['comment'])?></p>
            <?php if ($comment['reply'] != null) { ?>
              <section class="comment reply">
                <img src="<?=$ownerProfilepic?>" alt="<?=toHTML($house->ownerUsername)?>"> 
                <h3 class="commentPoster"><?=toHTML($house->ownerUsername)?></h3>
                <p class="commentContent allowNewLines"><?=$comment['reply']?></p>
              </section>
            <?php } else if ($username == $house->ownerUsername) { ?>
              <form method="post" action="" class="genericForm hidden">
                <h3>Reply to guest</h3>
                <span class="closeForm clickable"><i class="fas fa-times"></i></span>
                <textarea name="content" placeholder="Type your reply..."></textarea>
                <button type="submit">Reply</button>
              </form>
            <?php } ?>
          </article>
        <?php } ?>    

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

