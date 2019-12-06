"use strict"

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function sendPostRequest(action, data, onload) {
    let request = new XMLHttpRequest();
    request.open('POST', action, true);
    request.onload = onload;
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax(data));      
}

function sendGetRequest(action, data, onload) {
    let request = new XMLHttpRequest();
    request.open("GET", action + '?' + encodeForAjax(data), true);
    request.onload = onload;
    request.send()
}