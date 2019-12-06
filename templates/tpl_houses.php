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
            <p class="houseLocation"><i class="fas fa-map-marker-alt"></i> <?=toHTML($house->city)?>, <?=toHTML($house->country)?></p>
            <p class="guestLimit"><i class="fas fa-users"></i> <?=toHTML($house->minPeople)?> - <?=toHTML($house->maxPeople)?> people</p>
          </div>
        </a>
      </li>
    <?php } ?>
    </ul>
</section>
<?php } ?>

<?php function draw_house($house, $pictures) {
  $avg_rating = getHouseRating($house->place_id);
  $num_ratings = getNumRatings($house->place_id);
  $user_rating = getUserRating(getUserID($_SESSION['username']), $house->place_id);
  ?>
  <section id="house">
    <h2 class="title"><?=toHTML($house->title)?></h2>
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
    </div>
    <div id="place-body">
      <div id="place-info">
        <p class="host">Hóspede: <?=toHTML($house->ownerDisplayname)?></p>
        <p class="description"><?=toHTML($house->description)?></p>
        <p><?=toHTML($house->address)?>, <?=toHTML($house->city)?>, <?=toHTML($house->country)?></p>
      </div>
      <div id="booking">
        <p class="price"><?=$house->price?></p>
      </div>
    </div>
  </section>
<?php } ?>