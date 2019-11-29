let slideIndex = 1;
showPhotos(slideIndex);

function advancePhotos(n) {
    showPhotos(slideIndex += n);
}

function showPhotos(n) {
  let i;
  let photos = document.getElementById("photoCarousel").children;
  console.log(photos.length);
  if (n > photos.length) {slideIndex = 1}
  if (n < 1) {slideIndex = photos.length}
  for (i = 0; i < photos.length; i++) {
    photos[i].style.display = "none";  
  }
  photos[slideIndex-1].style.display = "block";  
}

document.getElementById("photoLeftButton").addEventListener("click", function(){advancePhotos(-1)}, false);
document.getElementById("photoRightButton").addEventListener("click", function(){advancePhotos(1)}, false);