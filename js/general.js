"use strict"

let priceTags = document.querySelectorAll('.priceValue');
priceTags.forEach(priceTag => {priceTag.textContent = parseFloat(priceTag.textContent).toFixed(2)});


const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
const currentTheme = localStorage.getItem('theme');
if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);
    if (currentTheme === 'dark') {
        toggleSwitch.checked = true;
    }
}

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

function switchTheme(e) {
    if (e.target.checked) {
            document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                    }
                        else {        document.documentElement.setAttribute('data-theme', 'light');
                            localStorage.setItem('theme', 'light');
                                }    
                                    }

                                        toggleSwitch.addEventListener('change', switchTheme, false);
