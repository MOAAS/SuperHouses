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
        button.textContent = finalText;
        button.style.transition = "";
    }, 3000);
}

function dateToString(date) {
    let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return date.getDate() + " " + months[date.getMonth()].substr(0, 3) + " " + date.getFullYear();
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
