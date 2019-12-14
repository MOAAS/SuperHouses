"use strict"

let priceTags = document.querySelectorAll('.priceValue');
priceTags.forEach(priceTag => { priceTag.textContent = parseFloat(priceTag.textContent).toFixed(2) });


function addButtonAnimation(button, newColor, newText, finalText) {
    button.style.backgroundColor = newColor;
    button.innerHTML = newText;
    setTimeout(() => {
        button.style.transition = "background-color 2.7s linear";
        button.style.backgroundColor = "";
    }, 250);
    setTimeout(() => {
        button.innerHTML = finalText;
        button.style.transition = "";
    }, 3000);
}

function dateToString(date) {
    let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return date.getDate() + " " + months[date.getMonth()].substr(0, 3) + " " + date.getFullYear();
}

function timeToString(date) {
    let hours = date.getHours();
    let minutes = date.getMinutes();
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    return hours + ":" + minutes;
}

function setInvalidInput(input, placeholder) {
    input.classList.add('invalidInput');
    input.style.border = "2px solid red";
    input.placeholder = placeholder;
}

function clearInvalidInput(input) {
    input.classList.remove('invalidInput');
    input.style.border = "";
    input.placeholder = "";
}

let addHouseForm = document.querySelector('#manageHouse form');
if (addHouseForm != null) {
    addHouseForm.addEventListener('submit', event => {
        event.preventDefault();
        let validForm = true;
        let addHouseFormButton = addHouseForm.querySelector('button[type="submit"]');
        let buttonText = addHouseFormButton.textContent;
    
        let checkStringInput = (input) => {
            if (input.value == "") {
                validForm = false;
                setInvalidInput(input, "Must not be empty!");
            }
            else clearInvalidInput(input)
        }
        
        let checkIntegerInput = (input) => {
            if (!Number.isInteger(parseInt(input.value)) || input.value <= 0) {
                setInvalidInput(input, "Must be a positive integer!");
                validForm = false;
            }
            else clearInvalidInput(input)
        }
        
        let checkPriceInput = (input) => {
            if (isNaN(input.value) || input.value <= 0 || input.value > 1000) {
                setInvalidInput(input, "Must be a positive number (Max. 1000 €)!");
                validForm = false;
            }
            else clearInvalidInput(input)
        }

        let checkFileInput = (input) => {
            if (input.files.length == 0 && input.classList.contains('requiresFiles')) {
                validForm = false;
                setInvalidInput(input, "Must not be empty!");
            }
            else clearInvalidInput(input)
        }
        
        checkStringInput(addHouseForm.querySelector('input[name="title"]'));
        checkStringInput(addHouseForm.querySelector('textarea[name="description"]'));
        checkStringInput(addHouseForm.querySelector('input[name="city"]'));
        checkStringInput(addHouseForm.querySelector('input[name="address"]'));
        checkStringInput(addHouseForm.querySelector('select[name="country"]'));
        checkIntegerInput(addHouseForm.querySelector('input[name="numRooms"]'));
        checkIntegerInput(addHouseForm.querySelector('input[name="numBeds"]'));
        checkIntegerInput(addHouseForm.querySelector('input[name="numBathrooms"]'));
        checkIntegerInput(addHouseForm.querySelector('input[name="capacity"]'));
        checkPriceInput(addHouseForm.querySelector('input[name="price"]'));
        checkFileInput(addHouseForm.querySelector('input[name="fileUpload[]"]'));
        
        if (validForm)
            addHouseForm.submit();
        else addButtonAnimation(addHouseFormButton, "red", "Invalid input", buttonText);
    });
}

function previewImages(event,outputId){
    let files = event.target.files; //FileList object
    let output = document.getElementById(outputId);
    output.innerHTML = ""; //recomeça

    for (let i = 0; i < files.length; i++) {
        let file = files[i];

        //Only pics
        if (!file.type.match('image'))
            continue;

        let picReader = new FileReader();

        picReader.addEventListener("load", function (event) {
           let picFile = event.target;
           let li = document.createElement("li");
           li.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                "title='" + picFile.name + "'/>";
            output.appendChild(li);
        });

        //Read the image
        picReader.readAsDataURL(file);
    }
}

const currentTheme = localStorage.getItem('theme');
if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);
}
function changeTheme(theme){
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}

let profilebutton = document.getElementById('profilebutton');
let dropdownbackground = document.querySelector(".dropdown-content");

profilebutton.addEventListener('click', () => {
    if (dropdownbackground.style.display == "block") 
        dropdownbackground.style.display = "none";
    else dropdownbackground.style.display = "block";
});

window.addEventListener('click', event => {
    if (event.target == dropdownbackground)
        dropdownbackground.style.display = "none";
});


