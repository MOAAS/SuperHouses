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