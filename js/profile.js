let messageHistory = document.querySelector('#messageHistory ul');
let conversations = document.querySelector('#conversations ul');
let currentConversation = null;

let sendMsgForm = document.querySelector('#messages #sendMessageInput form');
let sendMsgInput = sendMsgForm.querySelector('#sentMessage');

// Profile

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
        case '#Your places': document.getElementById('yourPlaces').style.display = ""; break;
        case '#Add Place': document.getElementById('addHouse').style.display = ""; break;
        case '#Reservations': document.getElementById('editProfile').style.display = ""; break;
        case '#Your reservations': document.getElementById('editProfile').style.display = ""; break;
        case '#Messages': document.getElementById('conversations').style.display = ""; break;
        default: 
            if (selected.startsWith("#Conversation_"))
                toConversation(findConversation(selected.split('_')[1])); 
            else console.log("lmao");
            break;
    }
}

let tabItems = document.querySelectorAll('#profile nav li');
tabItems.forEach(tabItem => {
    tabItem.addEventListener('click', event => selectTabItem(tabItem.textContent));        
});
selectTabItem(decodeURIComponent(window.location.hash.substr(1)));

// Conversations

function scrollConversationToBottom() {
    let scrollable = document.querySelector('#messageHistory');
    scrollable.scrollTop = scrollable.scrollHeight;
}

function appendMessage(content, wasSent, sendTime) {
    let message = document.createElement('li');
    message.classList.add('message');
    if (wasSent == true)
        message.classList.add('sentMessage');
    else message.classList.add('receivedMessage');

    message.innerHTML += "<p>" + htmlEntities(content) + "</p>"
    message.innerHTML += '<small class="messageDate">' + htmlEntities(sendTime)  + '</small>'        
    messageHistory.appendChild(message);
}

function updateConversation(conversation, content) {
    let date = new Date().getHours() + ":" + new Date().getMinutes();
    conversation.querySelector('p').innerHTML = htmlEntities(content);
    conversation.querySelector('.messageDate').innerHTML = htmlEntities(date);
    conversation.remove();
    conversations.insertBefore(conversation, conversations.firstChild);
    return date;
}

function onConversationLoad() {
    let messages = JSON.parse(this.responseText);

    for (let i = 0; i < messages.length; i++) {
        appendMessage(messages[i].content, messages[i].wasSent, messages[i].sendTime);
    }
    scrollConversationToBottom();
}

function findConversation(username) {
    let conversations = document.querySelectorAll("#conversations .conversation");
    for (let i = 0; i < conversations.length; i++) {
        if (conversations[i].querySelector('h3').textContent == username)
            return conversations[i];
    }
}

function toConversation(conversation) {    
    if (conversation == null) {
        console.log("Null conversation");
        backToConversations();
        return;
    }
    messageHistory.innerHTML = "";
    sendGetRequest('../actions/get_conversation.php',
    {
        otherUser: conversation.querySelector('h3').textContent
    }, onConversationLoad);

    let username = conversation.querySelector('h3').textContent;
    window.location.hash = "Conversation_" + username;

    currentConversation = conversation;
    conversation.classList.add('seenMessage');
    document.getElementById('conversations').style.display = "none";
    document.querySelector('#messages header h2').textContent = username;
    document.getElementById('messages').style.display = "";
}

function backToConversations() {
    document.getElementById('conversations').style.display = "";
    document.getElementById('messages').style.display = "none";
    window.location.hash = "Messages"
}

// Messages

sendMsgForm.addEventListener('submit', (event) => sendMessage(event));

function sendMessage(event) {
    event.preventDefault();
    let content = sendMsgInput.value
    if (content == "")
        return;
    sendPostRequest('../actions/action_sendMessage.php',
    {
        receiverUsername: document.querySelector('#messages header h2').textContent,
        content: content
    });
    let timeStamp = updateConversation(currentConversation, content);
    appendMessage(content, true, timeStamp);
    sendMsgInput.value = "";
    scrollConversationToBottom();
}

document.querySelectorAll('#conversations .conversation').forEach(conversation => {
    conversation.addEventListener('click', (event) => toConversation(conversation));
});

document.querySelector('#messages #messageBack').addEventListener('click', backToConversations);

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

const addHouseButton = document.getElementById('addHouseButton');
function selectAddPlace(){
    selectTabItem('Add Place')
}
addHouseButton.addEventListener('click',selectAddPlace, false);


