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
              <p class="priceValue"><?=$house->price?></p> 
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

<?php function draw_house($house, $pictures) {?>
  <section id="house">
    <h2 class="title"><?=toHTML($house->title)?></h2>
    <div style="padding: 0 0 0 0; font-size: 48px; color: orange;"> <!-- W T F ?????????? -->
      <i class="far fa-star"></i>
      <span>5.0</span>
    </div>
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
    <p class="host">Hóspede: <?=toHTML($house->ownerDisplayname)?></p>
    <p class="description"><?=toHTML($house->description)?></p>
    <p><?=toHTML($house->address)?>, <?=toHTML($house->city)?>, <?=toHTML($house->country)?></p>
    <p class="price"><?=$house->price?></p>
  </section>
<?php } ?>


<?php function draw_addHouse($countryOptions){?>
  <section id="addhouse" class="genericForm">

    <header><h2>Add your place!</h2></header>
    
    <form method="post" action="../actions/action_addHouse.php" enctype="multipart/form-data">
      <label for="title">Title</label>      
      <input id="title" type="text" name="title" placeholder="Name your place" required>

      <label for="description">Description</label>
      <textarea rows="4" id="description" name="description" placeholder="Describe your place" required></textarea>
      <div id="localization">
        <div>
          <label for="country">Country</label>
          <select id="country" name="country">
            <option value="">None</option>
            <?php foreach ($countryOptions as $country) { ?>
              <option value="<?=$country?>"><?=$country?></option>
            <?php } ?>
          </select>
        </div>
        <div>
          <label for="city">City</label>
          <input id="city" type="text" name="city" placeholder="City" required>
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