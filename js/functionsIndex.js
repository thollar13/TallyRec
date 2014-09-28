// JScript File

// Wait for Cordova to load
//

document.addEventListener("deviceready", onDeviceReady, false);

$(document).bind("mobileinit", function () {
    if (navigator.userAgent.indexOf("Android") != -1) {
        $.mobile.defaultPageTransition = 'none';
        $.mobile.defaultDialogTransition = 'none';
    }
});

// Cordova is loaded and it is now safe to make calls Cordova methods
//
function onDeviceReady() {
    document.addEventListener("offline", onOffline, false);
    checkConnection();
}

function onOffline() {
    $.mobile.changePage($('#nonetwork'), {
        transition: "pop"
    });
}

function checkConnection() {
    var connectionState = navigator.network.connection.type;
    if (connectionState == Connection.NONE || connectionState == Connection.UNKNOWN) {
        $.mobile.changePage($('#nonetwork'), {
            transition: "pop"
        });
    }
}

/* Push Notification Variable */
var pushNotification;

$(document).delegate("#login", "pagebeforecreate", function () {

    checkCredentials();

    // AutoLogin
    function checkCredentials() {

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        var storage = window.localStorage;
        var username = storage.getItem("MyUsername");
        var password = storage.getItem("MyPassword");

            $.get("http://tallyrecapp.dev/php/1.3.0/SIManual.php", { "username": username, "password": password }, processResult);

            function processResult(data, textStatus) {
                if (data == "Success") {
                // Success
                    storage.setItem("LoggedIn", "Indeed");

                    //hide Page Loading Animation
                    $.mobile.hidePageLoadingMsg();

                    window.location.href = "console.html";
                }
                else {
                // Error loging in
                    //hide Page Loading Animation
                    $.mobile.hidePageLoadingMsg();

                    //return false;
                    window.location.href = "signin.html";
                }
            }
        }


});

$(document).ready(function () {

    if (navigator.userAgent.indexOf("Android") != -1) {
        $.mobile.defaultPageTransition = 'none';
        $.mobile.defaultDialogTransition = 'none';
    }

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    var connecting = "Connecting";

    $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
    setInterval(function () {

        if (connecting == "Connecting...") {
            connecting = "Connecting";
        }
        else {
            connecting = connecting + ".";
        }

        $('#connecting').html(connecting);

    }, 400); // the "60000" here refers to the time to refresh the div.  it is in milliseconds. 

});            //END OnReady

