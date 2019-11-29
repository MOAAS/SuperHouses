"use strict"

let priceTags = document.querySelectorAll('.priceTag .priceValue');
priceTags.forEach(element => {
    element.textContent = parseFloat(element.textContent).toFixed(2);
});

// coisas do search

let searchButton = document.getElementById('searchButton');
let searchBackground = document.getElementById('searchBackground');

searchButton.addEventListener('click', () => {
    searchBackground.style.display = "block";
});

window.addEventListener('click', event => {
    if (event.target == searchBackground)
        searchBackground.style.display = "none";
});

let sliderPriceTag = document.querySelector('#maxPriceSlider .priceTag .priceValue');
let maxPriceSlider = document.getElementById('maxPrice')
maxPriceSlider.addEventListener('input', () => {
    sliderPriceTag.textContent = parseFloat(maxPriceSlider.value).toFixed(2);
});
sliderPriceTag.textContent = parseFloat(maxPriceSlider.value).toFixed(2);


let guestCounters = document.querySelectorAll(".guestCounter");
guestCounters.forEach(element => {
    let counter = element.querySelector('.count');
    let increaseBtn = element.querySelector('.increaseNum');
    let decreaseBtn = element.querySelector('.decreaseNum');
    increaseBtn.addEventListener('click', () => {
        if (counter.textContent == "10")
            return;
        counter.textContent++;
        updateGuestCounterButtons(increaseBtn, decreaseBtn, counter);
    });
    decreaseBtn.addEventListener('click', () => {
        if (counter.textContent == "0")
            return;
        counter.textContent--;
        updateGuestCounterButtons(increaseBtn, decreaseBtn, counter);
    });
    updateGuestCounterButtons(increaseBtn, decreaseBtn, counter);
});

function updateGuestCounterButtons(increaseBtn, decreaseBtn, counter) {
    if (counter.textContent == "0") {
        decreaseBtn.style.opacity = "0.5";
        decreaseBtn.style.cursor = "auto";
    }
    else {
        decreaseBtn.style.opacity = "1";
        decreaseBtn.style.cursor = "pointer";
    }
    if (counter.textContent == "10") {
        increaseBtn.style.opacity = "0.5";
        increaseBtn.style.cursor = "auto";
    }
    else {
        increaseBtn.style.opacity = "1";
        increaseBtn.style.cursor = "pointer";
    }
}

let searchForm = document.querySelector('#searchDialog form');
searchForm.addEventListener('submit', () => {
    event.preventDefault();
    let startDate = document.querySelector('#searchDialog input[name="startDate"]').value;
    let endDate = document.querySelector('#searchDialog input[name="endDate"]').value;
    if (startDate > endDate)
        return;
    document.querySelector('#searchDialog input[name="numAdults"]').value = document.querySelector('#countAdults .count').textContent;
    document.querySelector('#searchDialog input[name="numChildren"]').value = document.querySelector('#countChildren .count').textContent;
    document.querySelector('#searchDialog input[name="numBabies"]').value = document.querySelector('#countBabies .count').textContent;
    searchForm.submit();
});
