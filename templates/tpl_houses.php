<?php function draw_houselist($houseList) {?>
<section id="houses">
    <ul>
    <?php foreach($houseList as $house){?>
      <li>
        <figure>
          <img src="https://freshome.com/wp-content/uploads/2018/09/contemporary-exterior.jpg" alt="House">
          <figcaption><h3><?=$house['title']?></h3></figcaption>
        </figure>
        <div class="houseInfo">
          <div class="priceTag">
            <p class="priceValue"><?=$house['price']?></p> 
            <p class="priceCurrency"> € / day</p>
          </div>
          <p class="houseLocation"><i class="fas fa-map-marker-alt"></i> <?=$house['city']?>, <?=$house['countryName']?></p>
          <p class="guestLimit"><i class="fas fa-users"></i> <?=$house['minPeople']?> - <?=$house['maxPeople']?> people</p>
        </div>
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