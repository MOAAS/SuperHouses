<?php function draw_search() { ?>
  <i id="searchButton" class="fas fa-search"></i>
  <div id="searchBackground">
    <div id="searchDialog">
      <h3>Rent with us for the ultimate experience.</h3>
      <form method="get" action="../pages/search_houses.php">
        <div id="locationField">
            <label for="location">Where?</label>
            <input id="location" type="text" name="location" required>  
        </div>

        <div id="startDateField">
            <label for="startDate">From:</label>
            <input id="startDate" type="date" name="startDate" required>  
        </div>

        <div id="endDateField">
            <label for="endDate">To:</label>
            <input id="endDate" type="date" name="endDate" required>  
        </div>

        <div id="maxPriceSlider">
            <label for="maxPrice">Maximum Price:</label>
            <input id="maxPrice" type="range" min="1" max="9999" value="500" name="maxPrice">
            <p class="priceTag">0</p>
        </div>


        <input type="number" name="numAdults" class="hidden"/>
        <input type="number" name="numChildren" class="hidden"/>
        <input type="number" name="numBabies" class="hidden"/>

        <div id="countAdults" class="guestCounter">
            <label>Adults</label>
            <div class="counterManager">
                <div class="decreaseNum"><i class="fas fa-minus"></i></div>
                <p class="count">0</p>
                <div class="increaseNum"><i class="fas fa-plus"></i></div>            
            </div>         
        </div>

        <div id="countChildren" class="guestCounter">
            <label>Children</label>
            <div class="counterManager">
                <div class="decreaseNum"><i class="fas fa-minus"></i></div>
                <p class="count">0</p>
                <div class="increaseNum"><i class="fas fa-plus"></i></div>            
            </div>         
        </div>

        <div id="countBabies" class="guestCounter">
            <label>Babies</label>
            <div class="counterManager">
                <div class="decreaseNum"><i class="fas fa-minus"></i></div>
                <p class="count">0</p>
                <div class="increaseNum"><i class="fas fa-plus"></i></div> 
            </div>         
        </div>      

        <input type="submit" value="Search">
      </form>
    </div>
  </div>
<?php } ?>