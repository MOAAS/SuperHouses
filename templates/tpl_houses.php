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