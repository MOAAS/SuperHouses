
"use strict"

let slideIndex = 0;
showPhotos();

function advancePhotos(n) {
  let photos = document.getElementById("photoCarousel").children;
  slideIndex = (slideIndex + n) % photos.length;
  while (slideIndex < 0)
    slideIndex += photos.length;
  showPhotos();
}

function showPhotos() {
  let photos = document.getElementById("photoCarousel").children;
  for (let i = 0; i < photos.length; i++) {
    photos[i].style.display = "none";  
  }
  photos[slideIndex].style.display = "block";  
}

document.getElementById("photoLeftButton").addEventListener("click", function(){advancePhotos(-1)}, false);
document.getElementById("photoRightButton").addEventListener("click", function(){advancePhotos(1)}, false);