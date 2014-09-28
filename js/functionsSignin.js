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

$(document).ready(function () {

    if (navigator.userAgent.indexOf("Android") != -1) {
        $.mobile.defaultPageTransition = 'none';
        $.mobile.defaultDialogTransition = 'none';
    }

    var storage = window.localStorage;

    /* Start of Index.html */

    //Prevents page reload when enter hit on inputs.
    $('input').keypress(function (e) {
        if (e.which == 13) {
            return false;
        }
    });

    //Login SECTION
    $('#Username').keypress(function (e) {
        if (e.which == 13) {
            $('#loginBtn').click();
            return false;
        }
    });

    $('#Password').keypress(function (e) {
        if (e.which == 13) {
            $('#loginBtn').click();
            return false;
        }
    });

    //Create User SECTION1
    $('#username1').keypress(function (e) {
        if (e.which == 13) {
            $('#CreateUser1').click();
            return false;
        }
    });

    $('#password1').keypress(function (e) {
        if (e.which == 13) {
            $('#CreateUser1').click();
            return false;
        }
    });

    $('#email1').keypress(function (e) {
        if (e.which == 13) {
            $('#CreateUser1').click();
            return false;
        }
    });

    //Create User SECTION2
    $('#fname').keypress(function (e) {
        if (e.which == 13) {
            $('#CreateUser2').click();
            return false;
        }
    });

    $('#lname').keypress(function (e) {
        if (e.which == 13) {
            $('#CreateUser2').click();
            return false;
        }
    });

    $('#phone').keypress(function (e) {
        if (e.which == 13) {
            $('#CreateUser2').click();
            return false;
        }
    });

    //Forgot Account SECTION
    $('#forgotemail').keypress(function (e) {
        if (e.which == 13) {
            $('#forgotBtn').click();
            return false;
        }
    });

    var attempt = 1;
    //Authenticate User
    $('#loginBtn').click(function () {

        // Validate Fields
        var username = document.forms["SignInForm"]["Username"].value;
        var password = document.forms["SignInForm"]["Password"].value;

        if (username == null || username == "") {
            document.forms["SignInForm"]["Username"].placeholder = "Username - Required";
            return false;
        }
        if (password == null || password == "") {
            document.forms["SignInForm"]["Password"].placeholder = "Password - Required";
            return false;
        }

        //Show Loading
        $.mobile.showPageLoadingMsg();

        $.get("http://tallyrecapp.dev/php/1.3.0/SIManual.php", { "username": username, "password": password }, processResult);
        var success;

        function processResult(data, textStatus) {
            data = data.trim();
            if (data == "E-L") {
                // Error loging in
                $('#SignInError').html('The Username or Password was incorrect.<br /> Login attempt #' + attempt + '.');

                attempt = attempt + 1;
                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
            else if (data == "Success") {
                // Success
                storage.setItem("LoggedIn", "Indeed");
                storage.setItem("MyUsername", username);
                storage.setItem("MyPassword", password);

                    $.ajax({
                        type: "GET",
                        url: "http://tallyrecapp.dev/php/1.3.0/UserInfo/getUserInfo.php",
                        data: { "username": username },
                        dataType: 'json',
                        success: function (data) {
                            storage.setItem("MyUserID", data.userid);
                            storage.setItem("MyFname", data.fname);
                            storage.setItem("MyLname", data.lname);
                            storage.setItem("MyAvatar", data.avatar);
                            storage.setItem("MyEmail", data.email);
                            storage.setItem("MyPhone", data.phone);

                            
                            //Hide Loading
                            $.mobile.hidePageLoadingMsg();

                            window.location.href = "console.html";
                        }
                    });

            }
            else {
                // Error loging in
                $('#SignInError').text('There was a problem Signing in, please try again.');

                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
        }

    });


    /* Start of Create User */


    //Checks Email and Username, Copies data from logincreateuser1 to logincreateuser2
    $('#CreateUser1').click(function () {

        // Validate Fields
        var x = document.forms["CheckUserForm"]["username1"].value;
        var y = document.forms["CheckUserForm"]["password1"].value;
        var z = document.forms["CheckUserForm"]["email1"].value;

        if (x == null || x == "") {
            document.forms["CheckUserForm"]["username1"].placeholder = "Username - Required";
            return false;
        }
        if (y == null || y == "") {
            document.forms["CheckUserForm"]["password1"].placeholder = "Password - Required";
            return false;
        }
        if (z == null || z == "") {
            document.forms["CheckUserForm"]["email1"].placeholder = "E-Mail - Required";
            return false;
        }
        //Email Validation
        var atpos = z.indexOf("@");
        var dotpos = z.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= z.length) {
            alert("Not a valid e-mail address");
            return false;
        }

        //Show Loading
        $.mobile.showPageLoadingMsg();

        //Check Username and Email
        var username = $('#username1').val();
        var email = $('#email1').val();
        $.get("http://tallyrecapp.dev/php/1.3.0/CACheck.php", { "username": username, "email": email }, processResult);

        function processResult(data, textStatus) {
            if (data == "E-U") {
                //Display Username Error
                $('#CreateUserError1').text('Username already in use.');
                $.mobile.hidePageLoadingMsg();
            }
            else if (data == "E-E") {
                //Display Email Error
                $('#CreateUserError1').text('Email already in use.');
                $.mobile.hidePageLoadingMsg();
            }
            else {
                //Redirect
                $('#username2').val($('#username1').val());
                $('#password2').val($('#password1').val());
                $('#email2').val($('#email1').val());

                $.mobile.changePage($('#logincreateuser2'), {
                    transition: "slide"
                });

                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
        } //End processResult()



    });

    // Create User
    $('#CreateUser2').click(function () {

        // Validate Fields
        var x = document.forms["CreateUserForm"]["fname"].value;
        var y = document.forms["CreateUserForm"]["lname"].value;

        if (x == null || x == "") {
            document.forms["CreateUserForm"]["fname"].placeholder = "First Name - Required";
            return false;
        }
        if (y == null || y == "") {
            document.forms["CreateUserForm"]["lname"].placeholder = "Last Name - Required";
            return false;
        }

        //Show Loading
        $.mobile.showPageLoadingMsg();

        var username = $('#username2').val();
        var password = $('#password2').val();
        var email = $('#email2').val();
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var phone = $('#phone').val();

        //Check Username and Email
        $.get("http://tallyrecapp.dev/php/1.3.0/CACreate.php", { "username": username, "password": password, "email": email, "fname": fname, "lname": lname, "phone": phone }, processResult);

        function processResult(data, textStatus) {
            if (data == "E-C") {
                $('#CreateUserError2').text('There was a problem creating the account, please try again.');
            }
            else {

                storage.setItem("MyUsername", username);
                storage.setItem("MyPassword", password);
                storage.setItem("MyFname", fname);
                storage.setItem("MyLname", lname);
                storage.setItem("MyAvatar", "Unknown");
                storage.setItem("LoggedIn", "Indeed");

                $.ajax({
                        type: "GET",
                        url: "http://tallyrecapp.dev/php/1.3.0/UserInfo/getUserInfo.php",
                        data: { "username": username },
                        dataType: 'json',
                        success: function (data) {
                            storage.setItem("MyUserID", data.userid);
                            storage.setItem("MyFname", data.fname);
                            storage.setItem("MyLname", data.lname);
                            storage.setItem("MyAvatar", data.avatar);
                            storage.setItem("MyEmail", data.email);
                            storage.setItem("MyPhone", data.phone);

                            
                            //Hide Loading
                            $.mobile.hidePageLoadingMsg();

                            window.location.href = "console.html";
                        }
                    });
            }
        }
    });

    /* Start of Forgot */
    $('#forgotBtn').click(function () {

        var x = document.forms["forgotform"]["forgotemail"].value;

        if (x == null || x == "") {
            document.forms["forgotform"]["forgotemail"].placeholder = "E-Mail - Required";
            return false;
        }

        //Email Validation
        var atpos = x.indexOf("@");
        var dotpos = x.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
            alert("Not a valid e-mail address");
            return false;
        }

        //Show Loading
        $.mobile.showPageLoadingMsg();

        var keylist = "abcdefghijklmnopqrstuvwxyz123456789"
        var temp = ''
        for (i = 0; i < 8; i++)
            temp += keylist.charAt(Math.floor(Math.random() * keylist.length));

        var email = $('#forgotemail').val();

        //Reset Password
        $.get("http://tallyrecapp.dev/php/1.3.0/SIForgot.php", { "email": email, "password": temp }, processResult);

        function processResult(data, textStatus) {
            $('#forgotError').text('Check your email inbox for login information.');

            //Hide Loading
            $.mobile.hidePageLoadingMsg();
        }
    });

});         //END OnReady

