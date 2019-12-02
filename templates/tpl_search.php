<?php function draw_search($location, $startDate, $endDate, $maxPrice, $numAdults, $numChildren, $numBabies) { ?>
  <i id="searchButton" class="fas fa-search"></i>
  <div id="searchBackground">
    <section id="searchDialog" class="genericForm">
      <h3>Rent with us for the ultimate experience.</h3>
      <form method="get" action="../pages/search_houses.php">
        <div id="locationField">
            <label for="location">Where?</label>
            <input id="location" type="text" name="location" value="<?=toHTML($location)?>">  
        </div>

        <div id="startDateField">
            <label for="startDate">From:</label>
            <input id="startDate" type="date" name="startDate" value="<?=toHTML($startDate)?>">  
        </div>

        <div id="endDateField">
            <label for="endDate">To:</label>
            <input id="endDate" type="date" name="endDate" value="<?=toHTML($endDate)?>">  
        </div>

        <div id="maxPriceSlider">
            <label for="maxPrice">Maximum Price:</label>
            <input id="maxPrice" type="range" min="1" max="1000" name="maxPrice" value="<?=toHTML($maxPrice)?>">
            <div class="priceTag">
                <p class="priceValue">0</p>
                <p class="priceCurrency"> € / day</p>
            </div>
        </div>

        <input type="number" name="numAdults" class="hidden"/>
        <input type="number" name="numChildren" class="hidden"/>
        <input type="number" name="numBabies" class="hidden"/>

        <div id="countAdults" class="guestCounter">
            <label>Adults</label>
            <div class="counterManager">
                <div class="decreaseNum"><i class="fas fa-minus"></i></div>
                <p class="count"><?=toHTML($numAdults)?></p>
                <div class="increaseNum"><i class="fas fa-plus"></i></div>            
            </div>         
        </div>
        <div id="countChildren" class="guestCounter">
            <label>Children</label>
            <div class="counterManager">
                <div class="decreaseNum"><i class="fas fa-minus"></i></div>
                <p class="count"><?=toHTML($numChildren)?></p>
                <div class="increaseNum"><i class="fas fa-plus"></i></div>            
            </div>         
        </div>

        <div id="countBabies" class="guestCounter">
            <label>Babies</label>
            <div class="counterManager">
                <div class="decreaseNum"><i class="fas fa-minus"></i></div>
                <p class="count"><?=toHTML($numBabies)?></p>
                <div class="increaseNum"><i class="fas fa-plus"></i></div> 
            </div>         
        </div>      

        <input type="submit" value="Search">
      </form>
    </section>
  </div>
<?php } ?>