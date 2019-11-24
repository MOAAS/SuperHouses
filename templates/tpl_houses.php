<?php function draw_houselist($houseList) {?>
<section id="houses">
    <ul>
    <?php foreach($houseList as $house){?>
      <li>
        <figure>
          <img src="https://freshome.com/wp-content/uploads/2018/09/contemporary-exterior.jpg" alt="House">
          <figcaption><h3><?=$house['title']?></h3></figcaption>
        </figure>
        <p><?=$house['address']?>, <?=$house['city']?>, <?=$house['countryName']?></p>
        <p class="price"><?=$house['price']?></p>
      </li>
    <?php } ?>
    </ul>
</section>
<?php } ?>

<?php function draw_house($house, $pictures) {?>
  <section id="house">
    <ul class="photoCarousel">
    <?php foreach($pictures as $picture){?>
      <li>
        <img src=<?=$picture?>>
      </li>
    <?php } ?>
    </ul>
    <button onclick="advancePhotos(-1)">&#10094;</button>
    <button onclick="advancePhotos(1)">&#10095;</button>
    <p><?=$house->address?>, <?=$house->city?>, <?=$house->country?></p>
    <p class="price"><?=$house->price?></p>
  </section>
<?php } ?>