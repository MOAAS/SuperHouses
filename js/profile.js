function hideAllTabs() {
    document.querySelectorAll('#profile .profileTab').forEach(element => {
        element.style.display = "none";
    });
}

function updateTabs() {
    let selected = document.querySelector('.selectedTab').textContent;
    hideAllTabs();
    switch (selected) {
        case 'Profile': document.getElementById('editProfile').style.display = ""; break;
        case 'Your places': document.getElementById('editProfile').style.display = ""; break;
        case 'Add Place': document.getElementById('addHouse').style.display = ""; break;
        case 'Reservations': document.getElementById('editProfile').style.display = ""; break;
        case 'Your reservations': document.getElementById('editProfile').style.display = ""; break;
        case 'Messages': document.getElementById('editProfile').style.display = ""; break;
        default: console.log("Lmao"); break;
    }
}

let tabItems = document.querySelectorAll('#profile nav li');
tabItems.forEach(tabItem => {
    tabItem.addEventListener('click', event => {
        tabItems.forEach(tabItem => tabItem.classList.remove('selectedTab'));
        tabItem.classList.add('selectedTab');
        updateTabs();
    });
});
updateTabs();

let filesInput = document.getElementById("files");

filesInput.addEventListener("change", function (event) {

    let files = event.target.files; //FileList object
    let output = document.getElementById("result");
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

});