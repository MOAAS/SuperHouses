
"use strict"

let slideIndex = 1;
let photos = document.getElementById("photoCarousel").children;
showPhotos();

function advancePhotos(n) {
  slideIndex = (slideIndex + n) % photos.length;
  while (slideIndex < 0)
    slideIndex += photos.length;
  showPhotos();
}

function showPhotos() {
  for (let i = 0; i < photos.length; i++) {
    photos[i].style.transform = "translate(" + slideIndex * -40 + "em)";      
  }
}

document.getElementById("photoLeftButton").addEventListener("click", function(){advancePhotos(-1)}, false);
document.getElementById("photoRightButton").addEventListener("click", function(){advancePhotos(1)}, false);