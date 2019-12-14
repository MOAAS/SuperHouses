"use strict"

function updateNotificationNum() {
    let notificationNum = document.getElementById('notificationNum');
    if (notificationNum == null)
        return;
    if (notificationNum.textContent == "0")
        notificationNum.style.display = "none";
    else notificationNum.style.display = "block";
}

function toggleNotificationList() {
    let notificationList = document.getElementById('notificationList');
    if (notificationList.style.display == "block") {
        notificationList.style.display = "none";
        let seenNotifs = document.querySelectorAll('#notificationList li.notifSeen')
        seenNotifs.forEach(notif => {
            let notifID = notif.querySelector('.notifId').textContent;  
            sendPostRequest('../actions/action_set_notif_seen.php', {notif_id: notifID}, null);
            notif.remove();
        });
    }
    else notificationList.style.display = "block";

    let notificationNum = document.getElementById('notificationNum').textContent;
    if (notificationNum == 0)
        notificationList.innerHTML =  '<li><p class="notifContent">No notifications</p></li>'
}

updateNotificationNum();
document.querySelectorAll('#notificationBell, #notificationNum').forEach(element => {
    element.addEventListener('click', toggleNotificationList);
});

let notifications = document.querySelectorAll('#notificationList li');
notifications.forEach(notification => {
    let markAsSeen = notification.querySelector('.notifMarkAsSeen');
    if (markAsSeen == null)
        return;
    markAsSeen.addEventListener('click', () => {
        notification.classList.toggle('notifUnseen');
        notification.classList.toggle('notifSeen');
        if (notification.classList.contains('notifUnseen'))
            notificationNum.textContent++;
        else notificationNum.textContent--;
        updateNotificationNum();

    });
});

