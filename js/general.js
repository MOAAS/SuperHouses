"use strict"

let priceTags = document.querySelectorAll('.priceTag .priceValue');
priceTags.forEach(priceTag => priceTag.textContent = parseFloat(priceTag.textContent).toFixed(2));
