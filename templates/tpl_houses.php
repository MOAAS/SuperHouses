<?php function draw_houselist($houseList) {?>
<section id="houses">
    <ul>
    <?php foreach($houseList as $house){?>
      <li>
        <a href="house.php?id=<?=$house->place_id?>">
          <figure>
            <img src="https://freshome.com/wp-content/uploads/2018/09/contemporary-exterior.jpg" alt="House">
            <figcaption><h3><?=$house->title?></h3></figcaption>
          </figure>
          <div class="houseInfo">
            <div class="priceTag">
              <p class="priceValue"><?=$house->price?></p> 
              <p class="priceCurrency"> € / day</p>
            </div>
            <p class="houseLocation"><i class="fas fa-map-marker-alt"></i> <?=$house->city?>, <?=$house->country?></p>
            <p class="guestLimit"><i class="fas fa-users"></i> <?=$house->minPeople?> - <?=$house->maxPeople?> people</p>
          </div>
        </a>
      </li>
    <?php } ?>
    </ul>
</section>
<?php } ?>

<?php function draw_house($house, $pictures) {?>
  <section id="house">
	<p class="title"><?=$house->title?></p>
	<div style="padding: 0 0 0 0; font-size: 48px; color: orange;">
		<i class="far fa-star"></i>
		<span>5.0</span>
	</div>
	<div id="photos">
		<ul id="photoCarousel">
		<?php foreach($pictures as $picture){?>
		  <li>
			<img src=<?=$picture?>>
		  </li>
		<?php } ?>
		</ul>
		<button id="photoLeftButton">&#10094;</button>
		<button id="photoRightButton">&#10095;</button>
	</div>
	<p class="host">Hóspede: <?=$house->ownerDisplayname?></p>
	<p class="description"><?=$house->description?></p>
    <p><?=$house->address?>, <?=$house->city?>, <?=$house->country?></p>
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
      <input id="description" type="text" name="description" placeholder="Descrive your place" required>

      <label for="country">Country</label>
        <select id="country" name="country">
          <option value=""></option>
          <?php foreach ($countryOptions as $country) { ?>
            <option value="<?=$country?>"><?=$country?></option>
          <?php } ?>
        </select>

      <label for="city">City</label>
      <input id="city" type="text" name="city" placeholder="City" required>

      <label for="address">Address</label>
      <input id="address" type="text" name="address" placeholder="Address" required>

      <label for="min">Min</label>
      <input id="min" type="number" name="min" placeholder="0" required>
      <label for="max">Man</label>
      <input id="max" type="number" name="max" placeholder="2" required>
      <label for="price">Price</label>
      <input id="price" type="numbher" name="price" placeholder="50" required>
      
      <label for="file">Upload Images</label>
      <input type="file" name="fileUpload[]" multiple >

      <input type="submit" value="Save">
    </form>
  </section>

<?php } ?>