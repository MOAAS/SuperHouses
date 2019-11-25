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