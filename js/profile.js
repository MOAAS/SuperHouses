function hideAllTabs() {
    document.querySelectorAll('#profile .profileTab').forEach(tab => {
        tab.style.display = "none";
    });
}

function selectTabItem(tabItemName) {
    if (tabItemName == "")
        tabItemName = "Profile";
    document.querySelectorAll('#profile nav li').forEach(tabItem => {
        if (tabItem.textContent == tabItemName)
            tabItem.classList.add('selectedTab')
        else tabItem.classList.remove('selectedTab')
    });
    window.location.hash = tabItemName;
    updateTabs();
}

function updateTabs() {
    let selected = decodeURIComponent(window.location.hash);
    hideAllTabs();
    switch (selected) {
        case '#Profile': document.getElementById('editProfile').style.display = ""; break;
        case '#Your places': document.getElementById('editProfile').style.display = ""; break;
        case '#Add Place': document.getElementById('addHouse').style.display = ""; break;
        case '#Reservations': document.getElementById('editProfile').style.display = ""; break;
        case '#Your reservations': document.getElementById('editProfile').style.display = ""; break;
        case '#Messages': document.getElementById('conversations').style.display = ""; break;
        default: console.log("Lmao"); break;
    }
}

let tabItems = document.querySelectorAll('#profile nav li');
tabItems.forEach(tabItem => {
    tabItem.addEventListener('click', event => selectTabItem(tabItem.textContent));        
});
selectTabItem(decodeURIComponent(window.location.hash.substr(1)));

function toMessage() {
    document.getElementById('conversations').style.display = "none";
    document.getElementById('messages').style.display = "";
}

function backToConversations() {
    document.getElementById('conversations').style.display = "";
    document.getElementById('messages').style.display = "none";
}

document.querySelectorAll('#profile #conversations .conversation').forEach(conversation => {
    conversation.addEventListener('click', toMessage);
});

document.querySelector('#profile #messages #messageBack').addEventListener('click', backToConversations);

// coisas do doni

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