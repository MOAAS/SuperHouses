
"use strict"


let houseID = document.getElementById("houseID");
let ownerPic = document.querySelector('#houseOwner img').src;
let ownerName = document.querySelector('#houseOwnerName').textContent;

let photos = document.getElementById("photoCarousel").children;
let slideIndex = (photos.length > 1)?1:0;
showPhotos();

function advancePhotos(n) {
  slideIndex = (slideIndex + n) % photos.length;
  while (slideIndex < 0)
    slideIndex += photos.length;
  showPhotos();
}

function showPhotos() {
  for (let i = 0; i < photos.length; i++) {
    photos[i].style.transform = "translate(" + slideIndex * -45 + "em)";      
  }
}

document.getElementById("photoLeftButton").addEventListener("click", function(){advancePhotos(-1)}, false);
document.getElementById("photoRightButton").addEventListener("click", function(){advancePhotos(1)}, false);

// BOOKING 

let nightCount = document.getElementById("totalNights");
let totalPrice = document.querySelector("#bookingPrice .priceValue");
let pricePerNight = document.querySelector(".priceTag .priceValue");
let checkInDate = document.getElementById("checkInDate");
let checkOutDate = document.getElementById("checkOutDate");

let bookingForm = document.getElementById("booking");
let bookButton = bookingForm.querySelector('button[type="submit"]');
let unavailableDate = bookingForm.querySelector('#booking #unavailableDate');
let loadingIndicator = bookingForm.querySelector('#booking #loadingIndicator');

let futureReservations;
sendGetRequest('../actions/get_futureReservations.php', { placeID: houseID.textContent }, onGetReservationsLoad);

function onGetReservationsLoad() {
  futureReservations = JSON.parse(this.responseText)
}

function validateDates() {
  let checkIn = Date.parse(checkInDate.value);
  let checkOut = Date.parse(checkOutDate.value); 

  if (Number.isNaN(checkIn) || Number.isNaN(checkOut)) {
    unavailableDate.innerHTML = "";
    return;
  }

  for (let i = 0; i < futureReservations.length; i++) {
    let reservationStart = new Date(futureReservations[i]['dateStart']);
    let reservationEnd = new Date(futureReservations[i]['dateEnd']);
    

    if (checkIn < reservationEnd && checkOut > reservationStart) {
      unavailableDate.innerHTML = 
        "Unavailable date! <br> Clashes with " + 
        dateToString(reservationStart) + 
        ' to ' + 
        dateToString(reservationEnd);
      return;
    }
  }
  unavailableDate.innerHTML = "";
}

checkInDate.addEventListener('change', function(event) {
  validateDates();
  checkOutDate.min = checkInDate.value;
  updateBookingPrice();
});

checkOutDate.addEventListener('change', function() {
  validateDates();
  checkInDate.max = checkOutDate.value;
  updateBookingPrice();
});

bookingForm.addEventListener('submit', function(event){
  event.preventDefault();
  if (bookButton.textContent.includes('Confirm')) {
    bookButton.style.display = "none";
    loadingIndicator.style.display = "block";
    sendPostRequest('../actions/action_makeReservation.php', { 
      placeID: houseID.textContent, 
      checkIn: checkInDate.value,  
      checkOut: checkOutDate.value,  
    }, onReservationMade);
    return;
  }
  let checkIn = Date.parse(checkInDate.value);
  let checkOut = Date.parse(checkOutDate.value);
  
  if (unavailableDate.textContent != "")
    addButtonAnimation(bookButton, "red", 'Unavailable date', 'Book')
  else if (Number.isNaN(checkIn) || Number.isNaN(checkOut))
    addButtonAnimation(bookButton, "red", 'Pick the dates', 'Book')
  else if (checkIn == checkOut)
    addButtonAnimation(bookButton, "red", 'Minimum of 1 night', 'Book')
  else addButtonAnimation(bookButton, "green", '<i class="fas fa-check"></i> Confirm', 'Book')
});

function onReservationMade() {
  let response = JSON.parse(this.responseText)
  console.log(response);
  if(response == null) {
    window.location.href = "profile.php#Your reservations";
  }

  else {
    bookButton.style.display = "block";
    loadingIndicator.style.display = "none";
    setTimeout(() => addButtonAnimation(bookButton, "red", response, 'Book'), 20)
  }
}

function updateBookingPrice() {  
  let checkIn = Date.parse(checkInDate.value);
  let checkOut = Date.parse(checkOutDate.value);

  let numNights = 0;
  if (!Number.isNaN(checkIn) && !Number.isNaN(checkOut)) {
    numNights = (checkOut - checkIn) / (1000 * 3600 * 24)
  }

  if (numNights == 1)
    nightCount.textContent = numNights + ' night';
  else nightCount.textContent = numNights + ' nights';

  totalPrice.textContent = (parseFloat(pricePerNight.textContent) * numNights).toFixed(2);
}

// COMMENTING

let clickableComments = document.querySelectorAll('#placeComments .comment.clickable');
clickableComments.forEach(comment => {
  let form = comment.querySelector('form');
  comment.addEventListener('click', () => {    
    if (!comment.classList.contains('clickable')) 
      return;
    comment.classList.toggle('clickable');
    form.classList.toggle('hidden');
  }, false);
  comment.querySelector('.closeForm').addEventListener('click', (event) => {
    event.stopPropagation(); // p nao fazer outros event listeners
    comment.classList.toggle('clickable');
    form.classList.toggle('hidden');
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    
    let messageContent =  form.querySelector('textarea').value;
    let replyButton = form.querySelector('button');
    let reservationID = comment.id;    

    if (messageContent == "")
      return addButtonAnimation(replyButton, "red", "Reply can't be empty", "Reply")
    else if (replyButton.textContent == "Reply")
      return addButtonAnimation(replyButton, "green", "Confirm reply", "Reply");

    sendPostRequest('../actions/action_replyComment.php', {
      reservationID: reservationID,
      content: messageContent
    }, null);

    let reply = document.createElement('section');
    reply.classList.add('reply')
    reply.classList.add('comment')
    reply.innerHTML = 
    '<img src="' +ownerPic + '" alt="' + ownerName + '"> ' +
    '<h3 class="commentPoster">' + ownerName + '</h3>' +
    '<p class="commentContent allowNewlines">' + htmlEntities(messageContent) + '</p>'

    comment.append(reply);
    form.classList.toggle('hidden')
  })


});
