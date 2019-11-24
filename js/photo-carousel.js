var slideIndex = 1;
showPhotos(slideIndex);

function advancePhotos(n) {
    showPhotos(slideIndex += n);
}

function showPhotos(n) {
  var i;
  let photos = document.getElementsByClassName("photoCarousel")[0].children;
  if (n > photos.length) {slideIndex = 1}
  if (n < 1) {slideIndex = photos.length}
  for (i = 0; i < photos.length; i++) {
    photos[i].style.display = "none";  
  }
  photos[slideIndex-1].style.display = "block";  
}