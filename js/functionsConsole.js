// JScript File

// Wait for Cordova to load
//

//Check Network Status
document.addEventListener("deviceready", onDeviceReady, false);


$(document).bind("mobileinit", function () {
    if (navigator.userAgent.indexOf("Android") != -1) {
        $.mobile.defaultPageTransition = 'none';
        $.mobile.defaultDialogTransition = 'none';
    }
    else {
        $.mobile.defaultPageTransition = 'pop';
        $.mobile.defaultDialogTransition = 'pop';
    }
});

// Cordova is loaded and it is now safe to make calls Cordova methods
//
function onDeviceReady() {
    document.addEventListener("offline", onOffline, false);
    checkConnection();
}

function onOffline() {
    $.mobile.changePage($('#nonetwork'));
}

function checkConnection() {
    var connectionState = navigator.network.connection.type;
    if (connectionState == Connection.NONE || connectionState == Connection.UNKNOWN) {
        $.mobile.changePage($('#nonetwork'));
    }
}

/* Console Main Page */
$(document).delegate("#console", "pagebeforeshow", function () {

    var storage = window.localStorage;
    var username = storage.getItem("MyUsername");

    //getUserInfo();
    function getUserInfo() {
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
            }
        });
    }

    var userid = storage.getItem("MyUserID");
    var FName = storage.getItem("MyFname");
    var LName = storage.getItem("MyLname");
    var Avatar = storage.getItem("MyAvatar");

    pendingTeamReqs();
    getMyTeams();
    getMyLeagues();

    function getMyTeams() {
        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/Profile/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#MyTeamsDiv').html(data.myTeams).trigger('create');
                $('#FollowDiv').html(data.followingTeams).trigger('create');
                //$('#PastTeamsDiv').html(data.archivedTeams).trigger('create');
            }
        });
    }

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#consolePanelMyTeamsDiv').html(data.myTeams).trigger('create');
                $('#consolePanelFollowingTeamsDiv').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        //$('#myNameConsole').html("Hey, " + FName + "! Did you know...");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
            //$('#myImage').attr("src", "images/portraits/Male.png");
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
            //$('#myImage').attr("src", "images/portraits/Female.png");
        }
        else {
            var src = "images/portraits/Unknown.png";
            //$('#myImage').attr("src", "images/portraits/Unknown.png");
        }

        var text = "<ul data-role='listview'><li><a href='#console' data-ajax='false'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#consolePanelMyName').html(text).trigger('create');

    }

    getTallyRecMessage();

    function getTallyRecMessage() {
        $.get("http://tallyrecapp.dev/php/1.3.0/Profile/didYouKnow.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('#TallyRecMessage').html(data);
        }
    }

    getMyMessages();

    function getMyMessages() {
        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyMessages.php",
            data: { "userid": userid },
            dataType: 'json',
            success: function (data) {
                //$('#myMessageContactsDiv').html(data.messagetbl).trigger('create');
                $('.consolePanelMessages').html(data.newmessagecount).trigger('create');
            }
        });
    }

    // Get number of pending requests
    function getMyLeagues() {
        $.get("http://tallyrecapp.dev/php/1.3.0/League/getLeagues.php", { "username": username }, processResult2);

        function processResult2(data, textStatus) {
            $('#MyLeaguesDiv').html(data).trigger('create');
        }
    }

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }
});

/* Settings Page */
$(document).delegate("#settings", "pagebeforeshow", function () {

    var storage = window.localStorage;

    var username = storage.getItem("MyUsername");
    var userid = storage.getItem("MyUserID");
    var email = storage.getItem("MyEmail");
    var password = storage.getItem("MyPassword");
    var phone = storage.getItem("MyPhone");
    var fname = storage.getItem("MyFname");
    var lname = storage.getItem("MyLname");
    var avatar = storage.getItem("MyAvatar");

    setSettings();

    // Sets the fields on user settings
    function setSettings() {
        $('#SettingsUsername').html(username);
        $('#SettingsFname').val(fname);
        $('#SettingsLname').val(lname);
        $('#SettingsEmail').val(email);
        $('#SettingsPassword').val(password);
        $('#SettingsPhone').val(phone).trigger('create');

        if (avatar == "Male") {
            $("#Male").attr('checked', true).checkboxradio('refresh');
            $("#Female").attr('checked', false).checkboxradio('refresh');
            $("#Unknown").attr('checked', false).checkboxradio('refresh');
        }
        else if (avatar == "Female") {
            $("#Female").attr('checked', true).checkboxradio('refresh');
            $("#Unknown").attr('checked', false).checkboxradio('refresh');
            $("#Male").attr('checked', false).checkboxradio('refresh');
        }
        else {
            avatar = "Unknown";
            $("#Unknown").attr('checked', true).checkboxradio('refresh');
            $("#Male").attr('checked', false).checkboxradio('refresh');
            $("#Female").attr('checked', false).checkboxradio('refresh');
        }
    }

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#settingsPanelMyTeamsDiv').html(data.myTeams).trigger('create');
                $('#settingsPanelFollowingDiv').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        var FName = storage.getItem("MyFname");
        var LName = storage.getItem("MyLname");
        var Avatar = storage.getItem("MyAvatar");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
        }
        else {
            var src = "images/portraits/Unknown.png";
        }

        var text = "<ul data-role='listview'><li><a href='#console'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#settingsPanelMyName').html(text).trigger('create');
    }

    pendingTeamReqs()

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }
});


/* Settings Page */
$(document).delegate("#PendingRequests", "pagebeforeshow", function () {

    var storage = window.localStorage;

    var userid = storage.getItem("MyUserID");
    var username = storage.getItem("MyUsername");

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#notifyPanelMyTeams').html(data.myTeams).trigger('create');
                $('#notifyPanelFollowing').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        var FName = storage.getItem("MyFname");
        var LName = storage.getItem("MyLname");
        var Avatar = storage.getItem("MyAvatar");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
        }
        else {
            var src = "images/portraits/Unknown.png";
        }

        var text = "<ul data-role='listview'><li><a href='#console'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#pendingreqPanelMyName').html(text).trigger('create');
    }

    getMyNotes();

    // Get pending teams
    function getMyNotes() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getMyNotifications.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('#mynotifications').html(data).trigger('create');
        }
    }

    pendingTeamReqs()

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }

});

$(document).delegate("#createteam", "pagebeforeshow", function () {

    var storage = window.localStorage;

    var userid = storage.getItem("MyUserID");
    var username = storage.getItem("MyUsername");

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#createTeamPanelMyTeamsDiv').html(data.myTeams).trigger('create');
                $('#createTeamPanelFollowingDiv').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        var FName = storage.getItem("MyFname");
        var LName = storage.getItem("MyLname");
        var Avatar = storage.getItem("MyAvatar");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
        }
        else {
            var src = "images/portraits/Unknown.png";
        }

        var text = "<ul data-role='listview'><li><a href='#console'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#createteamPanelMyName').html(text).trigger('create');
    }

    pendingTeamReqs()

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }
});

$(document).delegate("#pastteams", "pagebeforeshow", function () {

    var storage = window.localStorage;

    var userid = storage.getItem("MyUserID");
    var username = storage.getItem("MyUsername");

    getMyTeams();

    function getMyTeams() {
        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/GetTeams/getPastTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#PastTeamsDiv').html(data.myPastTeams).trigger('create');
            }
        });
    }

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#pastTeamsPanelMyTeamsDiv').html(data.myTeams).trigger('create');
                $('#pastTeamsPanelFollowingDiv').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        var FName = storage.getItem("MyFname");
        var LName = storage.getItem("MyLname");
        var Avatar = storage.getItem("MyAvatar");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
        }
        else {
            var src = "images/portraits/Unknown.png";
        }

        var text = "<ul data-role='listview'><li><a href='#console'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#pastteamPanelMyName').html(text).trigger('create');
    }

    pendingTeamReqs()

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }

});

/* Settings Page */
$(document).delegate("#createleague", "pagebeforecreate", function () {

    var year = new Date().getFullYear() - 1;
    var count = 0;

    getYears();

    // Get pending teams
    function getYears() {

        var ddl = "<select name='leagueYearSelection' id='leagueYear' data-mini='true'>";

        while (count < 4) {

            if (count == 1) {
                ddl = ddl + "<option value='" + year + "' selected='selected'>" + year + "</option>";
            }
            else {
                ddl = ddl + "<option value='" + year + "'>" + year + "</option>";
            }

            count++;
            year++;
        }

        ddl = ddl + "</select>";

        $('#leaguecreateyearDDL').html(ddl).trigger('create');
    }
});

/* My Message Contacts Page */
$(document).delegate("#myMessages", "pagebeforeshow", function () {
    var storage = window.localStorage;

    var userid = storage.getItem("MyUserID");
    var username = storage.getItem("MyUsername");

    getMyMessages();

    function getMyMessages() {
        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyMessages.php",
            data: { "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#myMessageContactsDiv').html(data.messagetbl).trigger('create');
            }
        });
    }

    getMyTeamMates();

    function getMyTeamMates() {
        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyTeamMates.php",
            data: { "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#messageSuggestionsDiv').html(data.myContacts).trigger('create');
            }
        });
    }

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#myMessagesPanelMyTeamsDiv').html(data.myTeams).trigger('create');
                $('#myMessagesPanelFollowingTeamsDiv').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        var FName = storage.getItem("MyFname");
        var LName = storage.getItem("MyLname");
        var Avatar = storage.getItem("MyAvatar");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
        }
        else {
            var src = "images/portraits/Unknown.png";
        }

        var text = "<ul data-role='listview'><li><a href='#console'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#messagesPanelMyName').html(text).trigger('create');
    }

    pendingTeamReqs()

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }
});

/* My Message Contacts Page */
$(document).delegate("#composeMessage", "pagebeforecreate", function () {

});

$(document).delegate("#search", "pagebeforeshow", function () {

    var storage = window.localStorage;

    var userid = storage.getItem("MyUserID");
    var username = storage.getItem("MyUsername");

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#searchMyTeamsDiv').html(data.myTeams).trigger('create');
                $('#searchFollowTeamsDiv').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        var FName = storage.getItem("MyFname");
        var LName = storage.getItem("MyLname");
        var Avatar = storage.getItem("MyAvatar");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
        }
        else {
            var src = "images/portraits/Unknown.png";
        }

        var text = "<ul data-role='listview'><li><a href='#console'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#searchMyNameDiv').html(text).trigger('create');
    }

    pendingTeamReqs()

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }
});

$(document).delegate("#teamMain", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");
    var userid = storage.getItem("MyUserID");
    var username = storage.getItem("MyUsername");
    var playertype = storage.getItem("SelectedRosterPlayerType");
    var teamManager = storage.getItem("GotoTeamManageID");

    // Startup Scripts
    setTeamSportImg();
    setNextGame();
    setTeamNote();

    setTeamName();
    setTeamManageMode();

    // Universal Function
    // Set Team Name On All Pages
    function setTeamName() {
        $('.SelectedTeamName').text(TeamName);
    }

    // Universal Function
    // Determine Management Mode And Set Display
    function setTeamManageMode() {
        var TeamManageID = storage.getItem("GotoTeamManageID");

        // Follower
        if (TeamManageID == "2" || TeamManageID == "") {
            // Hide Manage Functions
            $("#chatnotallowed").css("display", "block");
            $("#chatallowed").css("display", "none");
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#chatNoteSettings").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
        }

        // Player
        else if (TeamManageID == "0") {
            // Hide Manage Functions
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#teamNoteDiv").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }

        // Manager
        else {
            // Show Manager Functions
            $("#TeamHiddenSettings").css("display", "block");
            $("#newRosterBtn").css("display", "block");
            $("#newRosterBtnDiv").css("display", "block");
            $("#newGameBtn").css("display", "block");
            $("#newGameBtnDiv").css("display", "block");
            $("#chatNoteSettings").css("display", "block");
            $("#FollowNoteSettings").css("display", "block");
            $("#teamManagerOption").css("display", "block");

            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
            }

            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
    }

    /* Team Main Page */

    //Set Sport Image
    function setTeamSportImg() {

        var sport = storage.getItem("GotoTeamSport");
        var sportimg = "<img src='images/sport/" + sport + ".png' class='SportImgLarge' />";
        $('#sportImageDiv').html(sportimg).trigger('create');
    }

    // Get the Latest Team Notification
    function setTeamNote() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getTeamNote.php", { "teamid": TeamID, "teammanager": teamManager }, processResult);

        function processResult(data, textStatus) {
            $('#teamnote').html(data).trigger('create');
        }
    }

    // Get the Next and Previous Game
    function setNextGame() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getNextGame.php", { "teamid": TeamID, "teamname": TeamName }, processResult);

        function processResult(data, textStatus) {
            $('#TeamMainInfo').html(data);
            $('#TeamMainInfo').trigger('create');

            $.get("http://tallyrecapp.dev/php/1.3.0/getPreviousGame.php", { "teamid": TeamID }, processResult1);

            function processResult1(data, textStatus) {
                if (data == "NoGames") {
                } else {
                    $('#previousGame').html(data);
                    $('#previousGame').trigger('create');
                }
            }
        }
    }

    // Panel
    getMyTeamsPanel();

    function getMyTeamsPanel() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/Panel/getMyTeams.php",
            data: { "username": username, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#teamMainPanelMyTeamsDiv').html(data.myTeams).trigger('create');
                $('#teamMainPanelFollowingDiv').html(data.followingTeams).trigger('create');
            }
        });
    }

    getMyNamePanel();

    function getMyNamePanel() {

        var FName = storage.getItem("MyFname");
        var LName = storage.getItem("MyLname");
        var Avatar = storage.getItem("MyAvatar");

        if (Avatar == "Male") {
            var src = "images/portraits/Male.png";
        }
        else if (Avatar == "Female") {
            var src = "images/portraits/Female.png";
        }
        else {
            var src = "images/portraits/Unknown.png";
        }

        var text = "<ul data-role='listview'><li><a href='#console'><img src='" + src + "' class='ui-li-icon'/>" + FName + " " + LName + "</a></li></ul>"

        $('#teamPanelMyName').html(text).trigger('create');
    }

    pendingTeamReqs()

    // Get number of pending requests
    function pendingTeamReqs() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            $('.consolePanelNotifications').html(data).trigger('create');
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Team Schedule */
$(document).delegate("#teamSchedule", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");
    var TeamManageID = storage.getItem("GotoTeamManageID");
    var TeamLeagueID = storage.getItem("GotoTeamLeagueID");
    var playertype = storage.getItem("SelectedRosterPlayerType");

    setTeamSchedule();
    setTeamName();
    setTeamManageMode();
    getTodayDate();

    // Universal Function
    // Set Team Name On All Pages
    function setTeamName() {

        $('.SelectedTeamName').text(TeamName);
    }

    // Universal Function
    // Determine Management Mode And Set Display
    function setTeamManageMode() {

        // Follower
        if (TeamManageID == "2" || TeamManageID == "") {
            // Hide Manage Functions
            $("#chatnotallowed").css("display", "block");
            $("#chatallowed").css("display", "none");
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#chatNoteSettings").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
        }

        // Player
        else if (TeamManageID == "0") {
            // Hide Manage Functions
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#teamNoteDiv").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }

        // Manager
        else {
            // Show Manager Functions
            $("#TeamHiddenSettings").css("display", "block");
            $("#newRosterBtn").css("display", "block");
            $("#newRosterBtnDiv").css("display", "block");
            $("#newGameBtn").css("display", "block");
            $("#newGameBtnDiv").css("display", "block");
            $("#chatNoteSettings").css("display", "block");
            $("#FollowNoteSettings").css("display", "block");
            $("#teamManagerOption").css("display", "block");

            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
            }

            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
    }

    // Get Team Schedule
    function setTeamSchedule() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getSchedule.php", { "teamid": TeamID, "teamleagueid": TeamLeagueID, "manage": TeamManageID }, processResult);

        function processResult(data, textStatus) {
            $('#SelectedTeamScheduleDiv').html(data).trigger('create');

            // Get Team Record
            setTeamScheduleRecord();
        }
    }

    // Get Team Schedule Record
    function setTeamScheduleRecord() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getScheduleRecord.php", { "teamid": TeamID }, processResult);

        function processResult(data, textStatus) {
            $('#teamWLTdiv').html(data).trigger('create');
        }
    }

    function getTodayDate() {
        $('#quickTeamGameDate').val(new Date().toJSON().slice(0, 10));
    }

    orientationcheck();
    function orientationcheck(e) {
        var display = window.orientation;
        if (display == -90 || display == 90) {
            if ($.mobile.activePage.attr("id") == "teamSchedule") {
                $('#quickAddMoveDiv').css("display", "none");
                $('#quickAddDiv').css("display", "block");
            }
        }
        else {
            if ($.mobile.activePage.attr("id") == "teamSchedule") {
                $('#quickAddDiv').css("display", "none");
                $('#quickAddMoveDiv').css("display", "block");
            }
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Team Roster */
$(document).delegate("#teamRoster", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");
    var playertype = storage.getItem("SelectedRosterPlayerType");

    setTeamRoster();
    setTeamName();
    setTeamManageMode();

    // Universal Function
    // Set Team Name On All Pages
    function setTeamName() {
        $('.SelectedTeamName').text(TeamName);
    }

    // Universal Function
    // Determine Management Mode And Set Display
    function setTeamManageMode() {
        var TeamManageID = storage.getItem("GotoTeamManageID");

        // Follower
        if (TeamManageID == "2" || TeamManageID == "") {
            // Hide Manage Functions
            $("#chatnotallowed").css("display", "block");
            $("#chatallowed").css("display", "none");
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#chatNoteSettings").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
        }

        // Player
        else if (TeamManageID == "0") {
            // Hide Manage Functions
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#teamNoteDiv").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }

        // Manager
        else {
            // Show Manager Functions
            $("#TeamHiddenSettings").css("display", "block");
            $("#newRosterBtn").css("display", "block");
            $("#newRosterBtnDiv").css("display", "block");
            $("#newGameBtn").css("display", "block");
            $("#newGameBtnDiv").css("display", "block");
            $("#chatNoteSettings").css("display", "block");
            $("#FollowNoteSettings").css("display", "block");
            $("#teamManagerOption").css("display", "block");

            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
            }

            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
    }
    // Get Team Roster
    function setTeamRoster() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getRoster.php", { "teamid": TeamID }, processResult);

        function processResult(data, textStatus) {
            $('#TeamRosterDiv').html(data).trigger('create');

            //Get Roster Count
            $.get("http://tallyrecapp.dev/php/1.3.0/getRosterCount.php", { "teamid": TeamID }, processResult);

            function processResult(data, textStatus) {
                $('#teamRosterCount').html(data).trigger('create');
            }

        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Add Person to Team*/
$(document).delegate("#AddPersonToRoster", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var TeamID = storage.getItem("GotoTeamID")
    var playertype = storage.getItem("SelectedRosterPlayerType");

    getTeamFollowers();

    function getTeamFollowers() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getTeamFollowers.php", { "teamid": TeamID }, processResult);

        function processResult(data, textStatus) {
            $('#teamFollowersDiv').html(data).trigger('create');
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Team Chat */
$(document).delegate("#teamChat", "pagebeforeshow", function (e) {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");
    var TeamManageID = storage.getItem("GotoTeamManageID");
    var playertype = storage.getItem("SelectedRosterPlayerType");

    setTeamName();
    setTeamManageMode();

    /* Universal Functions */

    // Set Team Name On All Pages
    function setTeamName() {

        $('.SelectedTeamName').text(TeamName);
    }

    // Determine Management Mode And Set Display
    function setTeamManageMode() {
        var TeamManageID = storage.getItem("GotoTeamManageID");

        // Follower
        if (TeamManageID == "2" || TeamManageID == "") {
            // Hide Manage Functions
            $("#chatnotallowed").css("display", "block");
            $("#chatallowed").css("display", "none");
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#chatNoteSettings").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
        }

        // Player
        else if (TeamManageID == "0") {
            // Hide Manage Functions
            $("#newRosterBtn").css("display", "none");
            $("#newRosterBtnDiv").css("display", "none");
            $("#newGameBtn").css("display", "none");
            $("#newGameBtnDiv").css("display", "none");
            $("#teamNoteDiv").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }

        // Manager
        else {
            // Show Manager Functions
            $("#TeamHiddenSettings").css("display", "block");
            $("#newRosterBtn").css("display", "block");
            $("#newRosterBtnDiv").css("display", "block");
            $("#newGameBtn").css("display", "block");
            $("#newGameBtnDiv").css("display", "block");
            $("#chatNoteSettings").css("display", "block");
            $("#FollowNoteSettings").css("display", "block");
            $("#teamManagerOption").css("display", "block");

            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
            }

            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
    }

    setTeamChat();

    // Get the Team Chat
    function setTeamChat() {
        $.get("http://tallyrecapp.dev/php/1.3.0/getChat.php", { "teamid": TeamID, "userid": UserID, "TeamManageID": TeamManageID }, processResult);

        function processResult(data, textStatus) {
            if (data == "NoMessages") {
            }
            else {
                $('#chatMessages').html(data).trigger('create');
            }
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Team Settings */
$(document).delegate("#teamSettings", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    var TeamManageID = storage.getItem("GotoTeamManageID");
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var playertype = storage.getItem("SelectedRosterPlayerType");
    var teamarchived = storage.getItem("GotoTeamArchived");

    getTeamSettings();

    // Get Settings Data
    function getTeamSettings() {

        var GoToTeam = storage.getItem("GotoTeam");
        var GoToTeamSport = storage.getItem("GotoTeamSport");
        var GoToTeamState = storage.getItem("GotoTeamState");
        var GoToTeamCity = storage.getItem("GotoTeamCity");
        var GoToTeamPark = storage.getItem("GotoTeamPark");
        var GoToTeamLeague = storage.getItem("GotoTeamLeague");
        var GoToTeamNote = storage.getItem("GotoTeamNote");
        var GoToTeamChat = storage.getItem("GotoTeamChat");
        var GoToTeamFollowers = storage.getItem("GotoTeamFollowers");

        $('#settingsName').val(GoToTeam);
        $('#settingsState').val(GoToTeamState);
        $('#settingsCity').val(GoToTeamCity);
        $('#settingsPark').val(GoToTeamPark);
        $('#settingsLeague').val(GoToTeamLeague);

        $('#settingsSport').val(GoToTeamSport);
        $('#settingsSport').selectmenu('refresh');

        //Chat settings
        if (GoToTeamFollowers == "1") {
            $("#followerNoteYes").attr("checked", true).trigger('create');
            $("#followerNoteNo").attr("checked", false).trigger('create');
        }
        else {
            $("#followerNoteYes").attr("checked", false).trigger('create');
            $("#followerNoteNo").attr("checked", true).trigger('create');
        }

        //team Note settings
        if (GoToTeamNote == "1") {
            $("#teamNoteYes").attr("checked", true).trigger('create');
            $("#teamNoteNo").attr("checked", false).trigger('create');
        }
        else {
            $("#teamNoteYes").attr("checked", false).trigger('create');
            $("#teamNoteNo").attr("checked", true).trigger('create');
        }

        //Chat settings
        if (GoToTeamChat == "1") {
            $("#chatNoteYes").attr("checked", true).trigger('create');
            $("#chatNoteNo").attr("checked", false).trigger('create');
        }
        else {
            $("#chatNoteYes").attr("checked", false).trigger('create');
            $("#chatNoteNo").attr("checked", true).trigger('create');
        }

    }

    setTeamManageMode();
    setTeamName();

    // Set Team Name On All Pages
    function setTeamName() {
        $('.SelectedTeamName').text(TeamName);
    }

    // Determine Management Mode And Set Display
    function setTeamManageMode() {

        // Follower
        if (TeamManageID == "2" || TeamManageID == "") {
            $("#TeamHiddenSettings").css("display", "none");
            $("#callplayerBtn").css("display", "none");
            $("#saveRosterBtn").css("display", "none");
            $("#saveTeamSettings").css("display", "none");
            $("#deleteplayer").css("display", "none");
            $("#followdeleteBtn").html("<a id='deleteteamBtn' data-role='button' data-mini='true'>Un-Follow</a>").trigger('create');
            $("#chatNoteSettings").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
        }
        // Player
        else if (TeamManageID == "0") {
            $("#TeamHiddenSettings").css("display", "none");
            $("#saveRosterBtn").css("display", "none");
            $("#saveTeamSettings").css("display", "none");
            $("#deleteplayer").css("display", "none");
            $("#FollowNoteSettings").css("display", "none");
            $("#teamManagerOption").css("display", "none");
            $("#dummyphonenumber").css("display", "none");
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
            $("#followdeleteBtn").html("<a id='deleteteamBtn' data-role='button' data-mini='true'>Take Me Off</a>").trigger('create');
        }
        // Manager
        else {
            // Show Manager Functions
            $("#TeamHiddenSettings").css("display", "block");
            $("#newRosterBtn").css("display", "block");
            $("#newRosterBtnDiv").css("display", "block");
            $("#newGameBtn").css("display", "block");
            $("#newGameBtnDiv").css("display", "block");
            $("#chatNoteSettings").css("display", "block");
            $("#FollowNoteSettings").css("display", "block");
            $("#teamManagerOption").css("display", "block");

            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
            }

            $("#followdeleteBtn").html("<a id='deleteteamBtn' data-role='button' data-mini='true'>Delete Team</a>").trigger('create');
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
    }

    if (teamarchived == "yes") {
        $("#unarchiveteamBtn").css("display", "block");
        $("#archiveteamBtn").css("display", "none");
    }
    else {
        $("#unarchiveteamBtn").css("display", "none");
        $("#archiveteamBtn").css("display", "block");
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Team Roster */
$(document).delegate("#teamEditRoster", "pagebeforeshow", function () {


    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    var TeamManageID = storage.getItem("GotoTeamManageID");
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var selectedrosterID = storage.getItem("SelectedRosterID");
    var playertype = storage.getItem("SelectedRosterPlayerType");

    setTeamManageMode();
    setTeamName();

    // Set Selected Person
    function SetPersonInfo() {
        $('#selectedName').val(selectedrosterName);
        $('#selectedNumber').val(selectedrosterNumber);
        $('#callplayerBtn').attr("href", "tel:" + selectedrosterPhone);
    }

    // Set Team Name On All Pages
    function setTeamName() {
        $('.SelectedTeamName').text(TeamName);
    }

    // Determine Management Mode And Set Display
    function setTeamManageMode() {

        // Follower
        if (TeamManageID == "2" || TeamManageID == "") {
            $("#TeamHiddenSettings").css("display", "none");
            $("#callplayerBtn").css("display", "none");
            $("#saveRosterBtn").css("display", "none");
            $("#saveTeamSettings").css("display", "none");
            $("#deleteplayer").css("display", "none");
            $("#deleteteamBtn").html("Un-Follow");
        }
        // Player
        else if (TeamManageID == "0") {
            $("#TeamHiddenSettings").css("display", "none");
            $("#saveRosterBtn").css("display", "none");
            $("#saveTeamSettings").css("display", "none");
            $("#deleteplayer").css("display", "none");
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
        // Manager
        else {
            // Show Manager Functions
            $("#TeamHiddenSettings").css("display", "block");
            $("#newRosterBtn").css("display", "block");
            $("#newRosterBtnDiv").css("display", "block");
            $("#newGameBtn").css("display", "block");
            $("#newGameBtnDiv").css("display", "block");
            $("#chatNoteSettings").css("display", "block");
            $("#FollowNoteSettings").css("display", "block");
            $("#teamManagerOption").css("display", "block");

            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
            }

            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Team Schedule */
$(document).delegate("#teamEditSchedule", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    var TeamManageID = storage.getItem("GotoTeamManageID");
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");
    var playertype = storage.getItem("SelectedRosterPlayerType");

    setTeamManageMode();
    setTeamName();

    // Set Team Name On All Pages
    function setTeamName() {
        $('.SelectedTeamName').text(TeamName);
    }

    // Determine Management Mode And Set Display
    function setTeamManageMode() {

        // Follower
        if (TeamManageID == "2" || TeamManageID == "") {
            $("#TeamHiddenSettings").css("display", "none");
            $("#callplayerBtn").css("display", "none");
            $("#saveRosterBtn").css("display", "none");
            $("#saveTeamSettings").css("display", "none");
            $("#deleteplayer").css("display", "none");
            $("#deleteteamBtn").html("Un-Follow");
        }
        // Player
        else if (TeamManageID == "0") {
            $("#TeamHiddenSettings").css("display", "none");
            $("#saveRosterBtn").css("display", "none");
            $("#saveTeamSettings").css("display", "none");
            $("#deleteplayer").css("display", "none");
            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
        // Manager
        else {
            // Show Manager Functions
            $("#TeamHiddenSettings").css("display", "block");
            $("#newRosterBtn").css("display", "block");
            $("#newRosterBtnDiv").css("display", "block");
            $("#newGameBtn").css("display", "block");
            $("#newGameBtnDiv").css("display", "block");
            $("#chatNoteSettings").css("display", "block");
            $("#FollowNoteSettings").css("display", "block");
            $("#teamManagerOption").css("display", "block");

            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
            }

            $("#chatnotallowed").css("display", "none");
            $("#chatallowed").css("display", "block");
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

/* Team Statistics */
$(document).delegate("#teamStatistics", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");
    var TeamManageID = storage.getItem("GotoTeamManageID");
    var playertype = storage.getItem("SelectedRosterPlayerType");

    // Set Team Name On All Pages
    setTeamName();

    function setTeamName() {

        $('.SelectedTeamName').text(TeamName);
    }

    // Get Overall, Home, and Away Records
    getStatsRecords();

    function getStatsRecords() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/TeamStats/getStatsRecords.php",
            data: { "teamid": TeamID },
            dataType: 'json',
            success: function (data) {
                $('#teamWLT').html(data.overallRecord).trigger('create');
                $('#teamHomeWLT').html(data.homeRecord).trigger('create');
                $('#teamAwayWLT').html(data.awayRecord).trigger('create');
            }
        });
    }

    // Get Overall, Home, and Away PF/PA
    getStatsPoints();

    function getStatsPoints() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/TeamStats/getStatsPoints.php",
            data: { "teamid": TeamID },
            dataType: 'json',
            success: function (data) {
                $('#teamOverallPF').html(data.overallPF).trigger('create');
                $('#teamOverallPA').html(data.overallPA).trigger('create');
                $('#teamHomePF').html(data.homePF).trigger('create');
                $('#teamHomePA').html(data.homePA).trigger('create');
                $('#teamAwayPF').html(data.awayPF).trigger('create');
                $('#teamAwayPA').html(data.awayPA).trigger('create');
                $('#teamOverallPFAVG').html(data.overallAvgPF).trigger('create');
                $('#teamOverallPAAVG').html(data.overallAvgPA).trigger('create');
                $('#teamHomePFAVG').html(data.homeAvgPF).trigger('create');
                $('#teamHomePAAVG').html(data.homeAvgPA).trigger('create');
                $('#teamAwayPFAVG').html(data.awayAvgPF).trigger('create');
                $('#teamAwayPAAVG').html(data.awayAvgPA).trigger('create');
            }
        });
    }

    // Get Overall, Home, and Away Win/Loss/Tie Streaks
    getStatsStreak();

    function getStatsStreak() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/TeamStats/getStatsStreak.php",
            data: { "teamid": TeamID },
            dataType: 'json',
            success: function (data) {
                $('#teamOverallStreak').html(data.overallStreak).trigger('create');
                $('#teamHomeStreak').html(data.homeStreak).trigger('create');
                $('#teamAwayStreak').html(data.awayStreak).trigger('create');
            }
        });
    }

    setStatsFollowers();

    // Get Stats of # Followers
    function setStatsFollowers() {
        $.get("http://tallyrecapp.dev/php/1.3.0/TeamStats/getStatsTeamFollowers.php", { "teamid": TeamID }, processResult);

        function processResult(data, textStatus) {
            $('#teamOverallFollowers').html(data).trigger('create');
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

$(document).ready(function () {

    if (navigator.userAgent.indexOf("Android") != -1) {
        $.mobile.defaultPageTransition = 'none';
        $.mobile.defaultDialogTransition = 'none';
    }
    else {
        $.mobile.defaultPageTransition = 'pop';
        $.mobile.defaultDialogTransition = 'pop';
    }

    var storage = window.localStorage;
    var username = storage.getItem("MyUsername");
    var userid = storage.getItem("MyUserID");
    var email = storage.getItem("MyEmail");
    var password = storage.getItem("MyPassword");
    var phone = storage.getItem("MyPhone");
    var fname = storage.getItem("MyFname");
    var lname = storage.getItem("MyLname");

    // Check to see if user is logged in
    var LoggedIn = storage.getItem("LoggedIn");
    if (LoggedIn == "Indeed") {
    }
    else {
        location.href = 'index.html';
    }

    // Scripts to configure pages

    /* Set Accept or Deny for Prospect Requests */
    $('#clearMyNotes').click(function () {

        //Show loading
        $.mobile.showPageLoadingMsg();

        $.get("http://tallyrecapp.dev/php/1.3.0/clearMyNotes.php", { "userid": userid }, processResult);

        function processResult(data, textStatus) {
            if (data == "Success") {

                $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult1);

                function processResult1(data, textStatus) {
                    $('.consolePanelNotifications').html(data).trigger('create');

                    $.mobile.changePage('#console');
                    //hide Page Loading Animation
                    $.mobile.hidePageLoadingMsg();
                }

                $.get("http://tallyrecapp.dev/php/1.3.0/getMyNotifications.php", { "userid": userid }, processResult2);

                function processResult2(data, textStatus) {
                    $('#mynotifications').html(data).trigger('create');

                    //Hide page loader
                    $.mobile.hidePageLoadingMsg();
                }

            }
        }
    });

    $('#PendingRequests').on('click', '.clearOneNote', function () {

        //Show loading
        $.mobile.showPageLoadingMsg();

        var noteid = $(this).data('note');

        $.get("http://tallyrecapp.dev/php/1.3.0/clearOneNote.php", { "noteid": noteid }, processResult);

        function processResult(data, textStatus) {
            if (data == "Success") {

                $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult1);

                function processResult1(data, textStatus) {
                    $('.consolePanelNotifications').html(data).trigger('create');
                }

                $.get("http://tallyrecapp.dev/php/1.3.0/getMyNotifications.php", { "userid": userid }, processResult2);

                function processResult2(data, textStatus) {
                    $('#mynotifications').html(data).trigger('create');

                    //Hide page loader
                    $.mobile.hidePageLoadingMsg();
                }
            }
        }
    });

    /* Search Page */

    $('#consolePanelSearchBtn').click(function () {
        var searchterm = $('#consolePanelSearchField').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#consolePanelSearchField').val()

                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    $('#messagesPanelSearchBtn').click(function () {
        var searchterm = $('#messagesPanelSearchField').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#messagesPanelSearchField').val()
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    $('#searchPanelBtn').click(function () {
        var searchterm = $('#searchPanelInput').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#searchPanelInput').val()
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    $('#notifyPanelSearchBtn').click(function () {
        var searchterm = $('#notifyPanelSearchInput').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#notifyPanelSearchInput').val()
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    $('#settingsPanelSearchBtn').click(function () {
        var searchterm = $('#settingsPanelSearchInput').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#settingsPanelSearchInput').val()
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    $('#teamMainPanelSearchBtn').click(function () {
        var searchterm = $('#teamMainPanelSearchInput').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#teamMainPanelSearchInput').val()
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    $('#createTeamPanelSearchBtn').click(function () {
        var searchterm = $('#createTeamPanelSearchInput').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#createTeamPanelSearchInput').val()
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    $('#pastTeamsPanelSearchBtn').click(function () {
        var searchterm = $('#pastTeamsPanelSearchInput').val();
        if (searchterm == "" || searchterm == null) {
            $.mobile.changePage("#search");
        }
        else {
            //Show loading
            $.mobile.showPageLoadingMsg();

            $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchterm }, processResult);
            function processResult(data, textStatus) {
                $.mobile.changePage("#search");

                $('#searchresults').html(data).trigger('create');
                $('#initialTeamSearch').val(searchterm);
                $('#pastTeamsPanelSearchInput').val()
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    // Initial Search
    $('#search').on('click', '#teamSearchBtn', function () {

        // Validate Fields
        var x = document.forms["SearchTeamForm"]["initialTeamSearch"].value;

        if (x == null || x == "") {
            document.forms["SearchTeamForm"]["initialTeamSearch"].placeholder = "Search Terms - Required";
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        var searchinfo = $('#initialTeamSearch').val();

        $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchinfo }, processResult);

        function processResult(data, textStatus) {
            $('#searchresults').html(data).trigger('create');

            //Hide Loading
            $.mobile.hidePageLoadingMsg();
        }
    });

    $('#search').on('input', '#initialTeamSearch', function () {

        // Validate Fields
        var x = document.forms["SearchTeamForm"]["initialTeamSearch"].value;

        if (x == null || x == "") {
            document.forms["SearchTeamForm"]["initialTeamSearch"].placeholder = "Search Terms - Required";
            $('#searchresults').html("").trigger('create');
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        var searchinfo = $('#initialTeamSearch').val();

        $.get("http://tallyrecapp.dev/php/1.3.0/searchTeams.php", { "searchinfo": searchinfo }, processResult);

        function processResult(data, textStatus) {
            $('#searchresults').html(data).trigger('create');

            //Hide Loading
            $.mobile.hidePageLoadingMsg();
        }
    });

    // Follow Team
    $('#search').on('click', '.FollowTeam', function () {

        //Show loading
        $.mobile.showPageLoadingMsg();

        var teamid = $(this).data('teamid');
        var teamname = $(this).data('teamname');

        $.get("http://tallyrecapp.dev/php/1.3.0/setFollowteam.php", { "teamid": teamid, "userid": userid, "username": username }, processResult);
        function processResult(data, textStatus) {
            if (data == "Success") {

                // Refresh data
                $.get("http://tallyrecapp.dev/php/1.3.0/GetTeams/getFollowTeams.php", { "username": username }, processResult1);
                function processResult1(data, textStatus) {
                    $('#FollowDiv').html(data).trigger('create');

                    //Send FollowingPushNote to coach
                    $.get("http://tallyrecapp.dev/php/1.3.0/PushNotify/prodPushNewFollower.php", { "username": username, "teamid": teamid, "teamname": teamname }, processResult2);
                    function processResult2(data, textStatus) {

                        // Redirect to Console
                        $.mobile.changePage($('#console'));

                        //Hide Loading
                        $.mobile.hidePageLoadingMsg();

                    }
                }
            }
            else {
                // Do Nothing
                return false;
            }
        }

    });

    /* Start of Console Page */

    $(document).on('click', '.createteamlink', function () {

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        var teamid = $(this).data('teamid');
        var teamleagueid = $(this).data('leagueid');
        if (teamleagueid == "" || teamleagueid == null) {
            teamleagueid = "0";
        }
        var teamname = $(this).data('teamname');
        var managerid = $(this).data('manager');
        var teamstate = $(this).data('state');
        var teamcity = $(this).data('city');
        var teampark = $(this).data('park');
        var teamsport = $(this).data('sport');
        var teamleague = $(this).data('league');
        var teamnote = $(this).data('teamnote');
        var chat = $(this).data('chat');
        var followers = $(this).data('followers');
        var archived = $(this).data('archived');

        storage.setItem("GotoTeamID", teamid);
        storage.setItem("GotoTeamLeagueID", teamleagueid);
        storage.setItem("GotoTeam", teamname);
        storage.setItem("GotoTeamManageID", managerid);
        storage.setItem("GotoTeamState", teamstate);
        storage.setItem("GotoTeamCity", teamcity);
        storage.setItem("GotoTeamPark", teampark);
        storage.setItem("GotoTeamSport", teamsport);
        storage.setItem("GotoTeamLeague", teamleague);
        storage.setItem("GotoTeamNote", teamnote);
        storage.setItem("GotoTeamChat", chat);
        storage.setItem("GotoTeamFollowers", followers);
        storage.setItem("GotoTeamArchived", archived);

        $.mobile.changePage('#teamMain', {
            allowSamePageTransition: true,
            transition: "none"
        });

        $('#teamMain').bind('pageshow', function (e) {
            $(this).addClass('ui-page-active');
        });


        //hide Page Loading Animation
        $.mobile.hidePageLoadingMsg();

    });

    $('#console').on('click', '.createleaguelink', function () {

        var leagueid = $(this).data('leagueid');
        var leaguename = $(this).data('leaguename');
        var managerid = $(this).data('manager');
        var leaguestate = $(this).data('state');
        var leaguecity = $(this).data('city');
        var leaguepark = $(this).data('park');
        var leaguesport = $(this).data('sport');
        var leagueseason = $(this).data('season');
        var leagueyear = $(this).data('year');
        var leaguedivision = $(this).data('division');
        var leaguenote = $(this).data('leaguenote');
        var leaguechat = $(this).data('leaguechat');
        var leaguefollowers = $(this).data('leaguefollowers');

        storage.setItem("GotoLeagueID", leagueid);
        storage.setItem("GotoLeague", leaguename);
        storage.setItem("GotoLeagueManageID", managerid);
        storage.setItem("GotoLeagueState", leaguestate);
        storage.setItem("GotoLeagueCity", leaguecity);
        storage.setItem("GotoLeaguePark", leaguepark);
        storage.setItem("GotoLeagueSport", leaguesport);
        storage.setItem("GotoLeagueSeason", leagueseason);
        storage.setItem("GotoLeagueYear", leagueyear);
        storage.setItem("GotoLeagueDivision", leaguedivision);
        storage.setItem("GotoLeagueNote", leaguenote);
        storage.setItem("GotoLeagueChat", leaguechat);
        storage.setItem("GotoLeagueFollowers", leaguefollowers);

        $.mobile.changePage('#leagueMain');
    });

    /* Create New Team */
    $('#createNewTeamBtn').click(function () {
        // Validate Fields
        var x = document.forms["CreateTeamForm"]["newTeamName"].value;
        var y = document.forms["CreateTeamForm"]["newTeamState"].value;
        var z = document.forms["CreateTeamForm"]["newTeamCity"].value;

        if (x == null || x == "") {
            document.forms["CreateTeamForm"]["newTeamName"].placeholder = "Team Name - Required";
            return false;
        }
        if (y == null || y == "") {
            document.forms["CreateTeamForm"]["newTeamState"].placeholder = "State - Required";
            return false;
        }
        if (z == null || z == "") {
            document.forms["CreateTeamForm"]["newTeamCity"].placeholder = "City - Required";
            return false;
        }

        //Show Loading
        $.mobile.showPageLoadingMsg();

        var userid = storage.getItem("MyUserID");
        var teamname = $('#newTeamName').val();
        var sport = $('#newTeamSport').val();
        var state = $('#newTeamState').val();
        var city = $('#newTeamCity').val();
        var park = $('#newTeamPark').val();
        if (park == null || park == "") {
            park = "-"
        }
        var league = $('#newTeamLeague').val();
        if (league == null || league == "") {
            league = "-"
        }

        $.get("http://tallyrecapp.dev/php/1.3.0/createTeam.php", { "userid": userid, "teamname": teamname, "sport": sport, "state": state, "city": city, "park": park, "league": league }, processResult);

        function processResult(data, textStatus) {
            data = data.trim();
            if (data == "Success") {

                $.ajax({
                    type: "GET",
                    url: "http://tallyrecapp.dev/php/1.3.0/Profile/getMyTeams.php",
                    data: { "username": username, "userid": userid },
                    dataType: 'json',
                    success: function (data) {
                        $('#MyTeamsDiv').html(data.myTeams).trigger('create');
                        $('#FollowDiv').html(data.followingTeams).trigger('create');
                    }
                });

                $.mobile.changePage('#console');

                //Hide Loading
                $.mobile.hidePageLoadingMsg();

            }
        }
    });

    /* Personal Settings */

    // Logout
    $('#logoutBtn').click(function () {
        storage.clear();

        var deviceType = (navigator.userAgent.match(/iPad/i)) == "iPad" ? "iPad" : (navigator.userAgent.match(/iPhone/i)) == "iPhone" ? "iPhone" : (navigator.userAgent.match(/Android/i)) == "Android" ? "Android" : (navigator.userAgent.match(/BlackBerry/i)) == "BlackBerry" ? "BlackBerry" : "null";

        if (deviceType == "iPhone" || deviceType == "iPad") {
            window.plugins.iAdPlugin.showAd(false);
        }

        location.href = "signin.html";
    });

    // Save Changes
    $('#saveSettings').click(function () {

        // Validate Fields
        var w = document.forms["usersettingsform"]["SettingsFname"].value;
        var x = document.forms["usersettingsform"]["SettingsLname"].value;
        var y = document.forms["usersettingsform"]["SettingsEmail"].value;
        var z = document.forms["usersettingsform"]["SettingsPassword"].value;

        if (w == null || w == "") {
            document.forms["usersettingsform"]["SettingsFname"].placeholder = "First Name - Required";
            return false;
        }
        if (x == null || x == "") {
            document.forms["usersettingsform"]["SettingsLname"].placeholder = "Last Name - Required";
            return false;
        }
        if (y == null || y == "") {
            document.forms["usersettingsform"]["SettingsEmail"].placeholder = "E-Mail - Required";
            return false;
        }
        if (z == null || z == "") {
            document.forms["usersettingsform"]["SettingsPassword"].placeholder = "Password - Required";
            return false;
        }

        //Email Validation
        var atpos = y.indexOf("@");
        var dotpos = y.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= y.length) {
            alert("Not a valid e-mail address");
            return false;
        }

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        fname = $('#SettingsFname').val();
        lname = $('#SettingsLname').val();
        email = $('#SettingsEmail').val();
        password = $('#SettingsPassword').val();
        phone = $('#SettingsPhone').val();
        if (phone == null || phone == "") {
            phone = "-";
        }

        var avatarChoice = $("input:radio[name=avatar]:checked").val();
        var photo = "images/portraits/" + avatarChoice + ".png";


        //Check Email for duplicates
        if (email == storage.getItem("MyEmail")) {

            $.get("http://tallyrecapp.dev/php/1.3.0/updateMySettings.php", { "userid": userid, "fname": fname, "lname": lname, "email": email, "password": password, "phone": phone, "photo": photo }, processResult);

            function processResult(data, textStatus) {

                storage.setItem("MyAvatar", avatarChoice);
                storage.setItem("MyFname", fname);
                storage.setItem("MyLname", lname);
                storage.setItem("MyPassword", password);
                storage.setItem("MyEmail", email);
                storage.setItem("MyPhone", phone);

                $.mobile.changePage('#console');

                //hide Page Loading Animation
                $.mobile.hidePageLoadingMsg();
            }

        }
        else {
            $.get("http://tallyrecapp.dev/php/1.3.0/checkEmail.php", { "email": email }, processResult1);

            function processResult1(data, textStatus) {
                if (data == "E-E") {
                    //Duplicate emails
                    emailerror = "yes";
                    $('#teamsettingserror').text('Email already in use.');
                    return false;
                }
                else {

                    $.get("http://tallyrecapp.dev/php/1.3.0/updateMySettings.php", { "userid": userid, "fname": fname, "lname": lname, "email": email, "password": password, "phone": phone, "photo": photo }, processResult3);

                    function processResult3(data, textStatus) {

                        //Returned with no duplicates
                        storage.setItem("MyAvatar", avatarChoice);
                        storage.setItem("MyFname", fname);
                        storage.setItem("MyLname", lname);
                        storage.setItem("MyPassword", password);
                        storage.setItem("MyEmail", email);
                        storage.setItem("MyPhone", phone);

                        $.mobile.changePage('#console');

                        //hide Page Loading Animation
                        $.mobile.hidePageLoadingMsg();
                    }
                }
            }
        }

    });

    // Upload Photo
    $('#PhotoUploadBtn').click(function (e) {
        document.forms["ChangePic"].submit();
        location.href = 'console.html';
        e.preventDefault();
    });

    // Auto update Chat Every Minute
    $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
    setInterval(function () {

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");
        var TeamManageID = storage.getItem("GotoTeamManageID");

        if ($.mobile.activePage.attr("id") == "teamChat") {
            $.get("http://tallyrecapp.dev/php/1.3.0/getChat.php", { "teamid": TeamID, "userid": UserID, "TeamManageID": TeamManageID }, processResult);

            function processResult(data, textStatus) {
                if (data == "NoMessages") {
                }
                else {
                    $('#chatMessages').html(data).trigger('create');

                }
            }
        }

        if ($.mobile.activePage.attr("id") == "teamMain") {
            var ManageMode = storage.getItem("GotoTeamManageID");

            if (ManageMode == "1") {
            }
            else {
                var teamManager = storage.getItem("GotoTeamManageID");
                $.get("http://tallyrecapp.dev/php/1.3.0/getTeamNote.php", { "teamid": TeamID, "teammanager": teamManager }, processResult1);

                function processResult1(data, textStatus) {
                    $('#teamnote').html(data).trigger('create');
                }
            }
        }

    }, 30000); // the "30000" here refers to the time to refresh the div.  it is in milliseconds. 

    /*
    *
    *
    * Manage Functions
    * 
    */

    var storage = window.localStorage;

    // Check to see if user is logged in
    var LoggedIn = storage.getItem("LoggedIn");
    if (LoggedIn == "Indeed") {
    }
    else {
        location.href = 'index.html';
    }

    var TeamManageID = storage.getItem("GotoTeamManageID");
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");

    /* Team Settings */

    // Update Team Settings
    $('#saveTeamSettings').click(function () {

        // Validate Fields
        var w = document.forms["editteamsettingsform"]["settingsName"].value;
        var x = document.forms["editteamsettingsform"]["settingsState"].value;
        var y = document.forms["editteamsettingsform"]["settingsCity"].value;

        if (w == null || w == "") {
            document.forms["editteamsettingsform"]["settingsName"].placeholder = "Team Name - Required";
            return false;
        }
        if (x == null || x == "") {
            document.forms["editteamsettingsform"]["settingsState"].placeholder = "Team State - Required";
            return false;
        }
        if (y == null || y == "") {
            document.forms["editteamsettingsform"]["settingsCity"].placeholder = "Team City - Required";
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var settingsName = $('#settingsName').val();
        storage.setItem("GotoTeam", settingsName);

        var settingsSport = $('#settingsSport').val();
        storage.setItem("GotoTeamSport", settingsSport);

        var settingsState = $('#settingsState').val();
        storage.setItem("GotoTeamState", settingsState);

        var settingsCity = $('#settingsCity').val();
        storage.setItem("GotoTeamCity", settingsCity);

        var settingsPark = $('#settingsPark').val();
        if (settingsPark == null || settingsPark == "") {
            settingsPark = "-";
        }
        storage.setItem("GotoTeamPark", settingsPark);

        var settingsLeague = $('#settingsLeague').val();
        if (settingsLeague == null || settingsLeague == "") {
            settingsLeague = "-";
        }
        storage.setItem("GotoTeamLeague", settingsLeague);

        $.get("http://tallyrecapp.dev/php/1.3.0/updateTeamSettings.php", { "teamid": TeamID, "teamname": settingsName, "sport": settingsSport, "state": settingsState, "city": settingsCity, "park": settingsPark, "league": settingsLeague }, processResult);

        function processResult(data, textStatus) {

            var image = "<img src='images/sport/" + settingsSport + ".png' class='SportImgLarge'>";
            $('#sportImageDiv').html(image).trigger('create');

            $('.SelectedTeamName').text(settingsName);

            $.mobile.changePage('#teamMain');

            //Hide Loading
            $.mobile.hidePageLoadingMsg();
        }
    });

    //Saves TeamNote Notification settings
    $('input:radio[name=followerNote]').click(function () {

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var teamfollowers = $('input:radio[name=followerNote]:checked').val();
        storage.setItem("GotoTeamFollowers", teamfollowers);

        var teamnote = $('input:radio[name=teamNote]:checked').val();
        storage.setItem("GotoTeamNote", teamnote);

        var teamchat = $('input:radio[name=chatNote]:checked').val();
        storage.setItem("GotoTeamChat", teamchat);

        $.get("http://tallyrecapp.dev/php/1.3.0/updateNotificationSettings.php", { "teamfollowers": teamfollowers, "teamnote": teamnote, "teamchat": teamchat, "userid": UserID, "teamid": TeamID }, processResult);

        function processResult(data, textStatus) {
            //Do Nothing
        }
    });

    //Saves TeamNote Notification settings
    $('input:radio[name=teamNote]').click(function () {

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var teamfollowers = $('input:radio[name=followerNote]:checked').val();
        storage.setItem("GotoTeamFollowers", teamfollowers);

        var teamnote = $('input:radio[name=teamNote]:checked').val();
        storage.setItem("GotoTeamNote", teamnote);

        var teamchat = $('input:radio[name=chatNote]:checked').val();
        storage.setItem("GotoTeamChat", teamchat);

        $.get("http://tallyrecapp.dev/php/1.3.0/updateNotificationSettings.php", { "teamfollowers": teamfollowers, "teamnote": teamnote, "teamchat": teamchat, "userid": UserID, "teamid": TeamID }, processResult);

        function processResult(data, textStatus) {
            //Do Nothing
        }
    });

    //Saves Chat Notification settings
    $('input:radio[name=chatNote]').click(function () {

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var teamfollowers = $('input:radio[name=followerNote]:checked').val();
        storage.setItem("GotoTeamFollowers", teamfollowers);

        var teamnote = $('input:radio[name=teamNote]:checked').val();
        storage.setItem("GotoTeamNote", teamnote);

        var teamchat = $('input:radio[name=chatNote]:checked').val();
        storage.setItem("GotoTeamChat", teamchat);

        $.get("http://tallyrecapp.dev/php/1.3.0/updateNotificationSettings.php", { "teamfollowers": teamfollowers, "teamnote": teamnote, "teamchat": teamchat, "userid": UserID, "teamid": TeamID }, processResult);

        function processResult(data, textStatus) {
            //Do Nothing
        }
    });

    // Un-Archive Team
    $('#unarchiveteamBtn').click(function () {

        var ask = confirm("Un-Archive Team?")

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        //Show loading
        $.mobile.showPageLoadingMsg();

        if (ask == true) {
            $.get("http://tallyrecapp.dev/php/1.3.0/updateTeamUnArchive.php", { "teamid": TeamID, "userid": UserID }, processResult);

            function processResult(data, textStatus) {
                location.href = 'console.html';

                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
        }
        else {
            //Hide Loading
            $.mobile.hidePageLoadingMsg();
            return false;
        }
    });

    // Archive Team
    $('#archiveteamBtn').click(function () {

        var ask = confirm("Archive Team?")

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        //Show loading
        $.mobile.showPageLoadingMsg();

        if (ask == true) {
            $.get("http://tallyrecapp.dev/php/1.3.0/updateTeamArchive.php", { "teamid": TeamID, "userid": UserID }, processResult);

            function processResult(data, textStatus) {
                location.href = 'console.html';

                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
        }
        else {
            //Hide Loading
            $.mobile.hidePageLoadingMsg();
            return false;
        }
    });

    // Delete Team
    $('#teamSettings').on('click', '#deleteteamBtn', function () {

        var ask = confirm("Delete Team?")

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        //Show loading
        $.mobile.showPageLoadingMsg();

        if (ask == true) {
            $.get("http://tallyrecapp.dev/php/1.3.0/updateTeamDelete.php", { "teamid": TeamID, "userid": UserID }, processResult);

            function processResult(data, textStatus) {
                location.href = 'console.html';
                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
        }
        else {
            //Hide Loading
            $.mobile.hidePageLoadingMsg();
            return false;
        }
    });

    /* Edit Game */

    $('#teamEditSchedule').on('change', '#eventType', function () {

        var sel = $('#eventType').val();

        if (sel == "game") {
            $('#opptext').html("Opponent:");
            $('#scoreDiv').css("display", "block");
            $('#homeawayDiv').css("display", "block");
            $('#opponentDiv').css("display", "block");
        }
        else if (sel == "practice") {
            $('#scoreDiv').css("display", "none");
            $('#homeawayDiv').css("display", "none");
            $('#opponentDiv').css("display", "none");
        }
        else if (sel == "other") {
            $('#opptext').html("Event Name:");
            $('#scoreDiv').css("display", "none");
            $('#homeawayDiv').css("display", "none");
            $('#opponentDiv').css("display", "block");
        }

    });


    // Save Game
    $('#saveGameBtn').click(function () {

        var sel = $('#eventType').val();

        if (sel == "other") {
            var eventtype = "2";
        }
        else if (sel == "practice") {
            $('#GameOpponent').val('Practice');
            var eventtype = "1";
        }
        else {
            var eventtype = "0";
        }

        // Validate Fields
        var w = document.forms["editscheduleform"]["GameOpponent"].value;
        var x = document.forms["editscheduleform"]["GameCity"].value;
        var y = document.forms["editscheduleform"]["GameState"].value;

        if (w == null || w == "") {
            document.forms["editscheduleform"]["GameOpponent"].placeholder = "Required";
            return false;
        }
        if (x == null || x == "") {
            document.forms["editscheduleform"]["GameCity"].placeholder = "City - Required";
            return false;
        }
        if (y == null || y == "") {
            document.forms["editscheduleform"]["GameState"].placeholder = "State - Required";
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        var storage = window.localStorage;

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");
        var TeamManageID = storage.getItem("GotoTeamManageID");
        var TeamLeagueID = storage.getItem("GotoTeamLeagueID");

        var gameid = storage.getItem("SelectedGameID");
        if (gameid == "") {
            gameid = "0";
        }
        var teamid = storage.getItem("GotoTeamID");
        var GameOpponent = $('#GameOpponent').val();
        var GameDate = $('#GameDate').val();
        if (GameDate == null || GameDate == "") {
            GameDate = "-";
        }
        var GameTime = $('#GameTime').val();
        if (GameTime == null || GameTime == "") {
            GameTime = "-";
        }
        var GamePark = $('#GamePark').val();
        if (GamePark == null || GamePark == "") {
            GamePark = "-";
        }
        var GameHomeAway = $("#GameHomeAway").val();
        var GameCity = $('#GameCity').val();
        var GameState = $('#GameState').val();
        var GameHomeScore = $('#GameHomeScore').val();
        if (GameHomeScore == null || GameHomeScore == "") {
            GameHomeScore = "-";
        }
        var GameAwayScore = $('#GameAwayScore').val();
        if (GameAwayScore == null || GameAwayScore == "") {
            GameAwayScore = "-";
        }

        //Update the game
        $.get("http://tallyrecapp.dev/php/1.3.0/updateGame.php", { "gameid": gameid, "GameOpponent": GameOpponent, "GameDate": GameDate, "GameTime": GameTime, "GamePark": GamePark, "GameHomeAway": GameHomeAway, "GameCity": GameCity, "GameState": GameState, "GameHomeScore": GameHomeScore, "GameAwayScore": GameAwayScore, "teamid": teamid, "eventtype": eventtype }, processResult);

        function processResult(data, textStatus) {

            //Get refreshed Schedule
            $.get("http://tallyrecapp.dev/php/1.3.0/getSchedule.php", { "teamid": TeamID, "teamleagueid": TeamLeagueID, "manage": TeamManageID }, processResult1);

            function processResult1(data, textStatus) {
                $('#SelectedTeamScheduleDiv').html(data).trigger('create');

                // Get Team Record
                $.get("http://tallyrecapp.dev/php/1.3.0/getScheduleRecord.php", { "teamid": TeamID }, processResult2);

                function processResult2(data, textStatus) {
                    $('#teamWLTdiv').html(data).trigger('create');

                    //Update next game
                    $.get("http://tallyrecapp.dev/php/1.3.0/getNextGame.php", { "teamid": TeamID, "teamname": TeamName }, processResult3);

                    function processResult3(data, textStatus) {
                        $('#TeamMainInfo').html(data);
                        $('#TeamMainInfo').trigger('create');

                        //update previous game
                        $.get("http://tallyrecapp.dev/php/1.3.0/getPreviousGame.php", { "teamid": TeamID }, processResult4);

                        function processResult4(data, textStatus) {
                            if (data == "NoGames") {
                            }
                            else {
                                $('#previousGame').html(data);
                                $('#previousGame').trigger('create');
                            }

                            $.mobile.changePage('#teamSchedule');

                            //Hide Loading
                            $.mobile.hidePageLoadingMsg();

                        }
                    }
                }
            }
        }
    }); //END Save Game

    //Quick Add Game
    $('#quickTeamGameBtn').click(function () {

        // Validate Fields
        var w = document.forms["quickTeamGameForm"]["quickTeamGameOpponent"].value;

        if (w == null || w == "") {
            document.forms["quickTeamGameForm"]["quickTeamGameOpponent"].placeholder = "*Opponent - Required";
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        var storage = window.localStorage;

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");
        var TeamManageID = storage.getItem("GotoTeamManageID");
        var TeamLeagueID = storage.getItem("GotoTeamLeagueID");

        var eventtype = "0";
        var gameid = "0";
        var GameOpponent = $('#quickTeamGameOpponent').val();

        var GameDate = $('#quickTeamGameDate').val();
        if (GameDate == null || GameDate == "") {
            GameDate = "-";
        }

        var GameTime = $('#quickTeamGameTime').val();
        if (GameTime == null || GameTime == "") {
            GameTime = "-";
        }

        var GamePark = storage.getItem("GotoTeamPark");
        if (GamePark == null || GamePark == "") {
            GamePark = "-";
        }
        var GameHomeAway = $("#quickTeamGameHomeAway").val();

        var GameCity = storage.getItem("GotoTeamCity");
        if (GameCity == null || GameCity == "") {
            GameCity = "-";
        }
        var GameState = storage.getItem("GotoTeamState");
        if (GameState == null || GameState == "") {
            GameState = "-";
        }

        var GameHomeScore = "-";
        var GameAwayScore = "-";

        //Update the game
        $.get("http://tallyrecapp.dev/php/1.3.0/updateGame.php", { "gameid": gameid, "GameOpponent": GameOpponent, "GameDate": GameDate, "GameTime": GameTime, "GamePark": GamePark, "GameHomeAway": GameHomeAway, "GameCity": GameCity, "GameState": GameState, "GameHomeScore": GameHomeScore, "GameAwayScore": GameAwayScore, "teamid": TeamID, "eventtype": eventtype }, processResult);

        function processResult(data, textStatus) {

            //Get refreshed Schedule
            $.get("http://tallyrecapp.dev/php/1.3.0/getSchedule.php", { "teamid": TeamID, "teamleagueid": TeamLeagueID, "manage": TeamManageID }, processResult1);

            function processResult1(data, textStatus) {
                $('#SelectedTeamScheduleDiv').html(data).trigger('create');

                // Get Team Record
                $.get("http://tallyrecapp.dev/php/1.3.0/getScheduleRecord.php", { "teamid": TeamID }, processResult2);

                function processResult2(data, textStatus) {
                    $('#teamWLTdiv').html(data).trigger('create');

                    //Update next game
                    $.get("http://tallyrecapp.dev/php/1.3.0/getNextGame.php", { "teamid": TeamID, "teamname": TeamName }, processResult3);

                    function processResult3(data, textStatus) {
                        $('#TeamMainInfo').html(data);
                        $('#TeamMainInfo').trigger('create');

                        //update previous game
                        $.get("http://tallyrecapp.dev/php/1.3.0/getPreviousGame.php", { "teamid": TeamID }, processResult4);

                        function processResult4(data, textStatus) {
                            if (data == "NoGames") {
                            }
                            else {
                                $('#previousGame').html(data);
                                $('#previousGame').trigger('create');
                            }

                            // Clear Value
                            $('#quickTeamGameOpponent').val("");

                            //Hide Loading
                            $.mobile.hidePageLoadingMsg();
                        }
                    }
                }
            }
        }
    });

    // Delete Game 
    $('#deleteGameBtn').click(function () {
        var ask = confirm("Delete Event?")

        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");
        var gameid = storage.getItem("SelectedGameID");
        var TeamManageID = storage.getItem("GotoTeamManageID");
        var TeamLeagueID = storage.getItem("GotoTeamLeagueID");

        if (ask == true) {
            $.get("http://tallyrecapp.dev/php/1.3.0/deleteGame.php", { "gameid": gameid }, processResult);

            function processResult(data, textStatus) {

                $.get("http://tallyrecapp.dev/php/1.3.0/getSchedule.php", { "teamid": TeamID, "teamleagueid": TeamLeagueID, "manage": TeamManageID }, processResult1);

                function processResult1(data, textStatus) {
                    $('#SelectedTeamScheduleDiv').html(data).trigger('create');

                    // Get Team Record
                    $.get("http://tallyrecapp.dev/php/1.3.0/getScheduleRecord.php", { "teamid": TeamID }, processResult2);

                    function processResult2(data, textStatus) {
                        $('#teamWLTdiv').html(data).trigger('create');

                        //Update next game
                        $.get("http://tallyrecapp.dev/php/1.3.0/getNextGame.php", { "teamid": TeamID, "teamname": TeamName }, processResult3);

                        function processResult3(data, textStatus) {
                            $('#TeamMainInfo').html(data);
                            $('#TeamMainInfo').trigger('create');

                            //update previous game
                            $.get("http://tallyrecapp.dev/php/1.3.0/getPreviousGame.php", { "teamid": TeamID }, processResult4);

                            function processResult4(data, textStatus) {
                                if (data == "NoGames") {
                                }
                                else {
                                    $('#previousGame').html(data);
                                    $('#previousGame').trigger('create');
                                }

                                $.mobile.changePage('#teamSchedule');

                                //Hide Loading
                                $.mobile.hidePageLoadingMsg();
                            }
                        }
                    }
                }
            }

        }
        else {
            return false;
        }
    }); //END Delete Game

    /* Edit Roster */

    // Save Roster 
    $('#saveRosterBtn').click(function () {

        // Validate Fields
        var w = document.forms["editdummyform"]["selectedName"].value;

        if (w == null || w == "") {
            document.forms["editdummyform"]["selectedName"].placeholder = "Name - Required";
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var rosterid = storage.getItem("SelectedRosterID");
        var rostername = $('#selectedName').val();
        var rosternumber = $('#selectedNumber').val();
        if (rosternumber == null || rosternumber == "") {
            rosternumber = "-";
        }

        //Get Phone Number
        var rosterPhoneNumber = $('#selectedPhoneNumber').val();
        if (rosterPhoneNumber == 'u') {
            rosterPhoneNumber = 'NotDummy';
        }
        else {
            if (rosterPhoneNumber == null || rosterPhoneNumber == "") {
                rosterPhoneNumber = "-";
            }
        }

        var managercode = $('input:radio[name=teamManager]:checked').val();

        $.get("http://tallyrecapp.dev/php/1.3.0/updateRoster.php", { "rosterid": rosterid, 'rostername': rostername, 'rosternumber': rosternumber, 'managercode': managercode, 'rosterPhoneNumber': rosterPhoneNumber }, processResult);

        function processResult(data, textStatus) {

            $.get("http://tallyrecapp.dev/php/1.3.0/getRoster.php", { "teamid": TeamID }, processResult1);

            function processResult1(data, textStatus) {
                $('#TeamRosterDiv').html(data).trigger('create');

                //Get Roster Count
                $.get("http://tallyrecapp.dev/php/1.3.0/getRosterCount.php", { "teamid": TeamID }, processResult2);

                function processResult2(data, textStatus) {
                    $('#teamRosterCount').html(data).trigger('create');

                    $.mobile.changePage('#teamRoster');

                    //Hide Loading
                    $.mobile.hidePageLoadingMsg();
                }
            }
            //location.reload(true);
        }
    });

    // Add Player To Roster
    $('#AddDummyPlayer').click(function () {
        // Validate Fields
        var w = document.forms["createdummyform"]["DummyFname"].value;
        var x = document.forms["createdummyform"]["DummyLname"].value;

        if (w == null || w == "") {
            document.forms["createdummyform"]["DummyFname"].placeholder = "Name - Required";
            return false;
        }
        if (x == null || x == "") {
            document.forms["createdummyform"]["DummyLname"].placeholder = "Name - Required";
            return false;
        }
        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var rosterFname = $('#DummyFname').val();
        var rosterLname = $('#DummyLname').val();
        var rosternumber = $('#DummyRosterNumber').val();
        if (rosternumber == null || rosternumber == "") {
            rosternumber = "-";
        }
        var DummyPhone = $('#DummyPhone').val();
        if (DummyPhone == null || DummyPhone == "") {
            DummyPhone = "-";
        }

        $.get("http://tallyrecapp.dev/php/1.3.0/createDummyRoster.php", { 'teamid': TeamID, 'rosterFname': rosterFname, 'rosterLname': rosterLname, 'rosternumber': rosternumber, 'DummyPhone': DummyPhone }, processResult);

        function processResult(data, textStatus) {

            $.get("http://tallyrecapp.dev/php/1.3.0/getRoster.php", { "teamid": TeamID }, processResult1);

            function processResult1(data, textStatus) {
                $('#TeamRosterDiv').html(data).trigger('create');

                $.get("http://tallyrecapp.dev/php/1.3.0/getRosterCount.php", { "teamid": TeamID }, processResult2);

                function processResult2(data, textStatus) {
                    $('#teamRosterCount').html(data).trigger('create');
                    $.mobile.changePage('#teamRoster');

                    //Hide Loading
                    $.mobile.hidePageLoadingMsg();
                }
            }
        }
    });

    // Person Search
    $('#personSearchBtn').click(function () {

        // Validate Fields
        var w = document.forms["peoplesearchform"]["initialPersonSearch"].value;

        if (w == null || w == "") {
            document.forms["peoplesearchform"]["initialPersonSearch"].placeholder = "Search Terms - Required";
            return false;
        }

        var searchinfo = $('#initialPersonSearch').val();

        $.get("http://tallyrecapp.dev/php/1.3.0/searchPersons.php", { "searchinfo": searchinfo }, processResult);

        function processResult(data, textStatus) {
            $('#searchresults').html(data).trigger('create');
        }


    });

    // Add to Team
    $('#AddPersonToRoster').on('click', '.AddtoTeam', function () {

        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var selectedRosterID = $(this).data('rosterid');
        var selectedteamname = storage.getItem("GotoTeam");
        var selectedteamid = storage.getItem("GotoTeamID");

        $.get("http://tallyrecapp.dev/php/1.3.0/addToRoster.php", { "teamid": selectedteamid, "rosterid": selectedRosterID, "teamname": selectedteamname }, processResult);
        function processResult(data, textStatus) {

            if (data == "Success") {
                // Redirect Schedule and reload data
                $.get("http://tallyrecapp.dev/php/1.3.0/getRoster.php", { "teamid": TeamID }, processResult2);

                function processResult2(data, textStatus) {
                    $('#TeamRosterDiv').html(data).trigger('create');

                    $.get("http://tallyrecapp.dev/php/1.3.0/getRosterCount.php", { "teamid": TeamID }, processResult3);

                    function processResult3(data, textStatus) {
                        $('#teamRosterCount').html(data).trigger('create');

                        $.get("http://tallyrecapp.dev/php/1.3.0/getTeamFollowers.php", { "teamid": TeamID }, processResult4);

                        function processResult4(data, textStatus) {
                            $('#teamFollowersDiv').html(data).trigger('create');

                            $.mobile.changePage('#teamRoster');

                            //Hide Loading
                            $.mobile.hidePageLoadingMsg();
                        }
                    }
                }
            }
            else {
                // Send Push Notification
                var message = "You have been added to " + selectedteamname + "!";
                var token = data;

                $.get("http://tallyrecapp.dev/php/1.3.0/PushNotify/prodPushAddedToTeam.php", { "message": message, "rosterid": selectedRosterID }, processResult1);
                function processResult1(data, textStatus) {

                    // Redirect Schedule and reload data
                    $.get("http://tallyrecapp.dev/php/1.3.0/getRoster.php", { "teamid": TeamID }, processResult2);

                    function processResult2(data, textStatus) {
                        $('#TeamRosterDiv').html(data).trigger('create');

                        $.get("http://tallyrecapp.dev/php/1.3.0/getRosterCount.php", { "teamid": TeamID }, processResult3);

                        function processResult3(data, textStatus) {
                            $('#teamRosterCount').html(data).trigger('create');

                            $.get("http://tallyrecapp.dev/php/1.3.0/getTeamFollowers.php", { "teamid": TeamID }, processResult4);

                            function processResult4(data, textStatus) {
                                $('#teamFollowersDiv').html(data).trigger('create');

                                $.mobile.changePage('#teamRoster');

                                //Hide Loading
                                $.mobile.hidePageLoadingMsg();
                            }
                        }
                    }
                }
            }
        }

    });

    // Delete Player
    $('#teamEditRoster').on('click', '#deleteplayer', function () {

        var ask = confirm("Delete player from roster?")

        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        if (ask == true) {
            var rosterid = storage.getItem("SelectedRosterID");

            $.get("http://tallyrecapp.dev/php/1.3.0/deletePlayer.php", { "rosterid": rosterid, "userid": UserID }, processResult);
            function processResult(data, textStatus) {
                if (data == "DeleteSelf") {
                    alert("You can't delete yourself from your team.");
                    return false;
                    //Hide Loading
                    $.mobile.hidePageLoadingMsg();
                }
                else {
                    // Redirect to Console
                    $.get("http://tallyrecapp.dev/php/1.3.0/getRoster.php", { "teamid": TeamID }, processResult1);

                    function processResult1(data, textStatus) {
                        $('#TeamRosterDiv').html(data).trigger('create');

                        $.get("http://tallyrecapp.dev/php/1.3.0/getRosterCount.php", { "teamid": TeamID }, processResult2);

                        function processResult2(data, textStatus) {
                            $('#teamRosterCount').html(data).trigger('create');
                            $.mobile.changePage('#teamRoster');

                            //Hide Loading
                            $.mobile.hidePageLoadingMsg();
                        }
                    }
                }
            }
            //Hide Loading
            $.mobile.hidePageLoadingMsg();
        }
        else {
            //Hide Loading
            $.mobile.hidePageLoadingMsg();
            return false;
        }
    });

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;


    // Check to see if user is logged in
    var LoggedIn = storage.getItem("LoggedIn");
    if (LoggedIn == "Indeed") {
    }
    else {
        location.href = 'index.html';
    }

    // Get Variable from Storage
    var TeamName = storage.getItem("GotoTeam");
    var TeamID = storage.getItem("GotoTeamID");
    var UserID = storage.getItem("MyUserID");

    /* Team Main Page */
    $('.teamSettingsBtn').click(function () {
        $.mobile.changePage('#teamSettings');
    });

    /* Team Chat Page */
    $('#sendChatBtn').click(function () {

        // Validate Fields
        var w = document.forms["sendchatform"]["ChatMessageInput"].value;

        if (w == null || w == "") {
            document.forms["sendchatform"]["ChatMessageInput"].placeholder = "Message - Required";
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        $('#ChatMessageInput').blur();

        // Get Variable from Storage
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");
        var TeamName = storage.getItem("GotoTeam");
        var TeamManageID = storage.getItem("GotoTeamManageID");

        var message = $('#ChatMessageInput').val();
        var noteMessage = "New Chat Message from, " + TeamName;

        if ($('#teamNoteCheck').attr('checked')) {
            teamnote = "1";
        }
        else {
            teamnote = "0";
        }

        $.get("http://tallyrecapp.dev/php/1.3.0/sendChat.php", { "teamid": TeamID, "userid": UserID, "message": message, "teamnote": teamnote }, processResult);

        function processResult(data, textStatus) {

            $.get("http://tallyrecapp.dev/php/1.3.0/getChat.php", { "teamid": TeamID, "userid": UserID, "TeamManageID": TeamManageID }, processResult1);

            function processResult1(data, textStatus) {
                if (data == "NoMessages") {
                }
                else {

                    $('#ChatMessageInput').val('');
                    $('#chatMessages').html(data).trigger('create');
                }

                $.get("http://tallyrecapp.dev/php/1.3.0/PushNotify/prodPushChatNote.php", { "teamid": TeamID, "teamname": TeamName, "message": noteMessage, "myuserid": UserID }, processResult2);

                function processResult2(data, textStatus) {
                    //Hide Loading
                    $.mobile.hidePageLoadingMsg();
                }
            }
        }
    });

    var teamNoteCount = "0";

    $('#teamMain').on('click', '#NewTeamNoteBtn', function () {
        if (teamNoteCount == "0") {
            $('#NewTeamNote').css("display", "block");
            teamNoteCount = "1";
        }
        else {
            $('#NewTeamNote').css("display", "none");
            teamNoteCount = "0";
        }
    });

    $('#teamMain').on('click', '#TeamNoteSendBtn', function () {
        // Validate Fields
        var w = document.forms["TeamNoteForm"]["TeamNoteMessage"].value;

        if (w == null || w == "") {
            document.forms["TeamNoteForm"]["TeamNoteMessage"].placeholder = "Message - Required";
            return false;
        }

        //Page Loading Animation
        $('#TeamNoteMessage').blur();

        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var TeamName = storage.getItem("GotoTeam");
        var TeamID = storage.getItem("GotoTeamID");
        var UserID = storage.getItem("MyUserID");

        var message = $('#TeamNoteMessage').val();
        var teamnote = "1";

        $('#noteCloseBtn').click();

        $.get("http://tallyrecapp.dev/php/1.3.0/sendChat.php", { "teamid": TeamID, "userid": UserID, "message": message, "teamnote": teamnote }, processResult);

        function processResult(data, textStatus) {

            $.get("http://tallyrecapp.dev/php/1.3.0/PushNotify/prodPushTeamNote.php", { "teamid": TeamID, "teamname": TeamName, "message": message, "myuserid": UserID }, processResult2);

            function processResult2(data, textStatus) {

                //Refresh Data
                var teamManager = storage.getItem("GotoTeamManageID");

                $.get("http://tallyrecapp.dev/php/1.3.0/getTeamNote.php", { "teamid": TeamID, "teammanager": teamManager }, processResult);

                function processResult(data, textStatus) {
                    $('#teamnote').html(data).trigger('create');

                    //hide Page Loading Animation
                    $.mobile.hidePageLoadingMsg();
                }

            }

        }

    });

    /* Schedule Page Functions */


    // Edit Game Btn Listener
    $('#teamSchedule').on('click', '.EditGameBtn', function (e) {

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        var gameid = $(this).data('gameid');
        var opponent = $(this).data('opponent');
        var date = $(this).data('date');
        var time = $(this).data('time');
        var park = $(this).data('park');
        var homeaway = $(this).data('homeaway');
        var city = $(this).data('city');
        var state = $(this).data('state');
        var homescore = $(this).data('homescore');
        var awayscore = $(this).data('awayscore');
        var eventtype = $(this).data('eventtype');

        var TeamName = storage.getItem('GotoTeam');


        storage.setItem("SelectedGameID", gameid);

        $('#GameOpponent').val(opponent);
        $('#GameDate').val(date);

        // Gets Game Time
        GameTime = time;
        if (GameTime == "") {
            var currentTime = new Date();
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            if (hours > 11) {
                if (hours > 11) {
                    hours = hours - 12;
                }
                var time = (hours + ":" + minutes + " " + "PM");
            } else {
                var time = (hours + ":" + minutes + " " + "AM");
            }
            $('#GameTime').val(time);
        }
        else {
            $('#GameTime').val(GameTime);
        }

        // Gets Game Park
        GamePark = park;
        if (GamePark == "") {
            GamePark = storage.getItem("GotoTeamPark");
        }
        if (GamePark == "-") {
            GamePark = " ";
        }
        $('#GamePark').val(GamePark);

        // Gets Home or Away
        GameHomeAway = homeaway;
        if (GameHomeAway == "0") {
            var string = "<select id='GameHomeAway' data-mini='true' style='font-size: 8pt;'data-type='horizontal'><option value='1'>Home</option><option value='0' selected='selected'>Away</option></select>";
            $("#GameHomeAwayDD").html(string).trigger('create');
            //$("#GameHomeAway>option:eq(1)").attr('selected', true);
        }

        if (GameHomeAway == "1") {
            var string = "<select id='GameHomeAway' data-mini='true' style='font-size: 8pt;'data-type='horizontal'><option value='1' selected='selected'>Home</option><option value='0'>Away</option></select>";
            $("#GameHomeAwayDD").html(string).trigger('create');
            //$("#GameHomeAway>option:eq(0)").attr('selected', true);
        }


        GameCity = city;
        if (GameCity == "") {
            GameCity = storage.getItem("GotoTeamCity");
        }
        $('#GameCity').val(GameCity);


        GameState = state;
        if (GameState == "") {
            GameState = storage.getItem("GotoTeamState");
        }
        $('#GameState').val(GameState);

        // Set Home Score
        GameHomeScore = homescore;
        if (GameHomeScore == "-") {
            $('#GameHomeScore').val("");
        }
        else {
            $('#GameHomeScore').val(GameHomeScore);
        }

        // Set Away Score
        GameAwayScore = awayscore;
        if (GameAwayScore == "-") {
            $('#GameAwayScore').val("");
        }
        else {
            $('#GameAwayScore').val(GameAwayScore);
        }

        // Determine if Home Away, set Homescore or Awayscore HTML to name
        if (GameHomeAway == "0") {
            $('#AwayScoreTeam').html(TeamName + ':');
            $('#HomeScoreTeam').html(opponent + ':');
        }
        else {
            $('#HomeScoreTeam').html(TeamName + ':');
            $('#AwayScoreTeam').html(opponent + ':');


        }

        if (eventtype == "2") {
            //Other
            $('#opptext').html("Event Name:");
            $('#scoreDiv').css("display", "none");
            $('#homeawayDiv').css("display", "none");
            $('#opponentDiv').css("display", "block");
            var contents = "<select id='eventType' data-mini='true' style='font-size: 8pt;'data-type='horizontal'><option value='game'>Game</option><option value='practice'>Practice</option><option value='other' selected='selected'>Other</option></select>";
            $('#eventTypeDiv').html(contents).trigger('create');
        }
        else if (eventtype == "1") {
            //Practice
            $('#scoreDiv').css("display", "none");
            $('#homeawayDiv').css("display", "none");
            $('#opponentDiv').css("display", "none");
            var contents = "<select id='eventType' data-mini='true' style='font-size: 8pt;'data-type='horizontal'><option value='game'>Game</option><option value='practice' selected='selected'>Practice</option><option value='other'>Other</option></select>";
            $('#eventTypeDiv').html(contents).trigger('create');
        }
        else {
            //Game
            $('#opptext').html("Opponent:");
            $('#scoreDiv').css("display", "block");
            $('#homeawayDiv').css("display", "block");
            $('#opponentDiv').css("display", "block");
            var contents = "<select id='eventType' data-mini='true' style='font-size: 8pt;'data-type='horizontal'><option value='game' selected='selected'>Game</option><option value='practice'>Practice</option><option value='other'>Other</option></select>";
            $('#eventTypeDiv').html(contents).trigger('create');
        }

        //Determine if new game or edit game
        $('#deleteGameBtn').css("display", "block")

        //hide Page Loading Animation
        $.mobile.hidePageLoadingMsg();

        $.mobile.changePage('#teamEditSchedule');

    });

    // New Game Btn Listener
    $('#teamSchedule').on('click', '#newGameBtn', function () {

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        var storage = window.localStorage;

        storage.setItem("SelectedGameID", "");

        $('#GameOpponent').val("");
        $('#GameDate').val(new Date().toJSON().slice(0, 10));
        $('#GameTime').val('12:00 PM');

        GamePark = storage.getItem("GotoTeamPark");
        if (GamePark == "-") {
            GamePark = " ";
        }
        $('#GamePark').val(GamePark);

        var string = "<select id='GameHomeAway' data-mini='true' style='font-size: 8pt;'data-type='horizontal'><option value='1' selected='selected'>Home</option><option value='0'>Away</option></select>";
        $("#GameHomeAwayDD").html(string).trigger('create');

        GameCity = storage.getItem("GotoTeamCity");
        $('#GameCity').val(GameCity);

        GameState = storage.getItem("GotoTeamState");
        $('#GameState').val(GameState);

        $('#GameHomeScore').val("");
        $('#GameAwayScore').val("");
        $('#AwayScoreTeam').html('Away Team:');
        $('#HomeScoreTeam').html('Home Team:');


        //Determine if new game or edit game
        $('#deleteGameBtn').css("display", "none");

        $.mobile.changePage('#teamEditSchedule');

        //hide Page Loading Animation
        $.mobile.hidePageLoadingMsg();

    });

    /* Roster Page Functions */

    // New Roster Btn Listener
    $('#teamRoster').on('click', '#newRosterBtn', function () {

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        storage.setItem("SelectedRosterID", "");
        storage.setItem("SelectedRosterPlayerType", "");

        $.mobile.changePage('#AddPersonToRoster');

        //hide Page Loading Animation
        $.mobile.hidePageLoadingMsg();

    });

    // New Roster Btn Listener
    $('#teamRoster').on('click', '.RosterSelect', function () {
        //$('.RosterSelect').live('click', function () {

        var rosterid = $(this).data('rosterid');
        var rostername = $(this).data('rostername');
        var rosternumber = $(this).data('rosternumber');
        var rosterphone = $(this).data('rosterphone');
        //var rosteruserid = $(this).data('rosteruserid');
        var managercode = $(this).data('managercode');
        var playertype = $(this).data('playertype');
        storage.setItem("SelectedRosterPlayerType", playertype);

        $('#selectedName').val(rostername);

        if (rosternumber == "-") {
            $('#selectedNumber').val('');
        }
        else {
            $('#selectedNumber').val(rosternumber);
        }

        var manageMode = storage.getItem("GotoTeamManageID");

        if (manageMode == "1") {
            if (playertype == "u") {
                $('#dummyphonenumber').css('display', 'none');
                $('#selectedPhoneNumber').val('u');
            }
            else {
                $('#dummyphonenumber').css('display', 'block');
                $('#selectedPhoneNumber').val(rosterphone);
            }
        }

        //Set manager Code
        if (managercode == '1') {
            var optionSelected = "<div data-role='fieldcontain'><fieldset data-role='controlgroup' data-type='horizontal' data-mini='true'><legend></legend><input type='radio' name='teamManager' id='teamManagerYes' value='1' checked><label for='teamManagerYes'>Yes</label><input type='radio' name='teamManager' id='teamManagerNo' value='0'><label for='teamManagerNo'>No</label></fieldset></div>";
            $("#teamManagerSelectedOption").html(optionSelected).trigger('create');
        }
        else {
            var optionSelected = "<div data-role='fieldcontain'><fieldset data-role='controlgroup' data-type='horizontal' data-mini='true'><legend></legend><input type='radio' name='teamManager' id='teamManagerYes' value='1'><label for='teamManagerYes'>Yes</label><input type='radio' name='teamManager' id='teamManagerNo' value='0' checked><label for='teamManagerNo'>No</label></fieldset></div>";
            $("#teamManagerSelectedOption").html(optionSelected).trigger('create');
        }

        //Follower Restrictions
        if (manageMode == "2") {
        }
        else {
            if (rosterphone == "" || rosterphone == "-") {
                $('#callplayerBtn').css("display", "none");
            }
            else {
                $('#callplayerBtn').css("display", "block");
                $('#callplayerBtn').attr('href', 'tel:' + rosterphone);
            }
        }
        storage.setItem("SelectedRosterID", rosterid);

        $.mobile.changePage('#teamEditRoster');
    });

    /* Enter or Go key pressed */
    /* Enter or Go key pressed */


    //Prevents page reload when enter hit on inputs.
    $('input').keypress(function (e) { if (e.which == 13) { return false; } });

    //Chat SECTION
    $('#ChatMessageInput').keypress(function (e) { if (e.which == 13) { $('#sendChatBtn').click(); return false; } });

    $('#teamMain').on('click', '#TeamNoteMessage', function (e) { if (e.which == 13) { $('#TeamNoteSendBtn').click(); return false; } });


    //Search People SECTION
    $('#initialPersonSearch').keypress(function (e) { if (e.which == 13) { $('#personSearchBtn').click(); return false; } });

    //Create Dummy Player SECTION
    $('#DummyFname').keypress(function (e) { if (e.which == 13) { $('#AddDummyPlayer').click(); return false; } });

    $('#DummyLname').keypress(function (e) { if (e.which == 13) { $('#AddDummyPlayer').click(); return false; } });

    $('#DummyRosterNumber').keypress(function (e) { if (e.which == 13) { $('#AddDummyPlayer').click(); return false; } });

    $('#DummyPhone').keypress(function (e) { if (e.which == 13) { $('#AddDummyPlayer').click(); return false; } });

    //Edit Roster SECTION
    $('#selectedName').keypress(function (e) { var manageCode = storage.getItem("GotoTeamManageID"); if (manageCode == "1") { if (e.which == 13) { $('#saveRosterBtn').click(); return false; } } else { } });

    $('#selectedNumber').keypress(function (e) { var manageCode = storage.getItem("GotoTeamManageID"); if (manageCode == "1") { if (e.which == 13) { $('#saveRosterBtn').click(); return false; } } else { } });

    $('#selectedPhoneNumber').keypress(function (e) { var manageCode = storage.getItem("GotoTeamManageID"); if (manageCode == "1") { if (e.which == 13) { $('#saveRosterBtn').click(); return false; } } else { } });

    //Game EDIT and New Game
    $('#GameOpponent').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    $('#GameDate').focus(function (e) { e.preventDefault(); });

    $('#GameDate').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    $('#GameTime').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    $('#GamePark').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    $('#GameCity').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    $('#GameState').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    $('#GameHomeScore').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    $('#GameAwayScore').keypress(function (e) { if (e.which == 13) { $('#saveGameBtn').click(); return false; } });

    //Quick Save
    $('#quickTeamGameOpponent').keypress(function (e) { if (e.which == 13) { $('#quickTeamGameOpponent').blur(); $('#quickTeamGameBtn').click(); return false; } });

    //Team Settings SECTION
    $('#settingsName').keypress(function (e) { if (e.which == 13) { $('#saveTeamSettings').click(); return false; } });

    $('#settingsState').keypress(function (e) { if (e.which == 13) { $('#saveTeamSettings').click(); return false; } });

    $('#settingsCity').keypress(function (e) { if (e.which == 13) { $('#saveTeamSettings').click(); return false; } });

    $('#settingsPark').keypress(function (e) { if (e.which == 13) { $('#saveTeamSettings').click(); return false; } });

    $('#settingsLeague').keypress(function (e) { if (e.which == 13) { $('#saveTeamSettings').click(); return false; } });

    //Prevents page reload when enter hit on inputs.
    $('input').keypress(function (e) { if (e.which == 13) { return false; } });

    //Search Teams
    $('#initialTeamSearch').keypress(function (e) { if (e.which == 13) { $('#teamSearchBtn').click(); $('#initialTeamSearch').blur(); return false; } });

    //My Settings SECTION
    $('#SettingsFname').keypress(function (e) { if (e.which == 13) { $('#saveSettings').click(); return false; } });

    $('#SettingsLname').keypress(function (e) { if (e.which == 13) { $('#saveSettings').click(); return false; } });

    $('#SettingsEmail').keypress(function (e) { if (e.which == 13) { $('#saveSettings').click(); return false; } });

    $('#SettingsEmail').keypress(function (e) { if (e.which == 13) { $('#saveSettings').click(); return false; } });

    $('#SettingsPassword').keypress(function (e) { if (e.which == 13) { $('#saveSettings').click(); return false; } });

    $('#SettingsPhone').keypress(function (e) { if (e.which == 13) { $('#saveSettings').click(); return false; } });

    //Create a Team SECTION
    $('#newTeamName').keypress(function (e) { if (e.which == 13) { $('#createNewTeamBtn').click(); return false; } });

    $('#newTeamState').keypress(function (e) { if (e.which == 13) { $('#createNewTeamBtn').click(); return false; } });

    $('#newTeamCity').keypress(function (e) { if (e.which == 13) { $('#createNewTeamBtn').click(); return false; } });

    $('#newTeamPark').keypress(function (e) { if (e.which == 13) { $('#createNewTeamBtn').click(); return false; } });

    $('#newTeamLeague').keypress(function (e) { if (e.which == 13) { $('#createNewTeamBtn').click(); return false; } });


    /*
    *   Panel Search Btn
    */

    $('#consolePanelSearchField').keypress(function (e) { if (e.which == 13) { $('#consolePanelSearchBtn').click(); return false; } });

    $('#myMessages').on('keypress', '#messagesPanelSearchField', function (e) { if (e.which == 13) { $('#messagesPanelSearchBtn').click(); return false; } });

    $('#search').on('keypress', '#searchPanelInput', function (e) { if (e.which == 13) { $('#searchPanelBtn').click(); return false; } });

    $('#PendingRequests').on('keypress', '#notifyPanelSearchInput', function (e) { if (e.which == 13) { $('#notifyPanelSearchBtn').click(); return false; } });

    $('#settings').on('keypress', '#settingsPanelSearchInput', function (e) { if (e.which == 13) { $('#settingsPanelSearchBtn').click(); return false; } });

    $('#teamMain').on('keypress', '#teamMainPanelSearchInput', function (e) { if (e.which == 13) { $('#teamMainPanelSearchBtn').click(); return false; } });

    $('#createteam').on('keypress', '#createTeamPanelSearchInput', function (e) { if (e.which == 13) { $('#createTeamPanelSearchBtn').click(); return false; } });

    $('#pastteams').on('keypress', '#pastTeamsPanelSearchInput', function (e) { if (e.which == 13) { $('#pastTeamsPanelSearchBtn').click(); return false; } });

    /*
    *
    *
    * Auto Update
    *
    */

    // Auto update Every Minute
    $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
    setInterval(function () {

        if ($.mobile.activePage.attr("id") == "console") {

            $.get("http://tallyrecapp.dev/php/1.3.0/getPendingReqNumber.php", { "userid": userid }, processResult);

            function processResult(data, textStatus) {
                $('#pendingTeamReqs').html(data).trigger('create');
            }

            $.ajax({
                type: "POST",
                url: "http://tallyrecapp.dev/php/1.3.0/Profile/getMyTeams.php",
                data: { "username": username, "userid": userid },
                dataType: 'json',
                success: function (data) {
                    $('#MyTeamsDiv').html(data.myTeams).trigger('create');
                    $('#FollowDiv').html(data.followingTeams).trigger('create');
                }
            });
        }


        if ($.mobile.activePage.attr("id") == "PendingRequests") {

            $.get("http://tallyrecapp.dev/php/1.3.0/getMyNotifications.php", { "userid": userid }, processResult1);

            function processResult1(data, textStatus) {
                $('#mynotifications').html(data).trigger('create');
            }

        }

    }, 30000); // the "30000" here refers to the time to refresh the div.  it is in milliseconds. 

    /*
    *
    *   Creating a League
    *
    */

    $('#createleagueBtn').click(function () {

        // Validate Fields
        var x = document.forms["CreateLeagueForm"]["leagueName"].value;
        var y = document.forms["CreateLeagueForm"]["leagueCity"].value;
        var z = document.forms["CreateLeagueForm"]["leagueState"].value;

        if (x == null || x == "") {
            document.forms["CreateLeagueForm"]["leagueName"].placeholder = "League Name - Required";
            return false;
        }
        if (y == null || y == "") {
            document.forms["CreateLeagueForm"]["leagueCity"].placeholder = "City - Required";
            return false;
        }
        if (z == null || z == "") {
            document.forms["CreateLeagueForm"]["leagueState"].placeholder = "State - Required";
            return false;
        }

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        //Get Data
        var leagueName = $('#leagueName').val();
        var leagueSport = $('#leagueSport').val();
        var leagueDivision = $('#leagueDivision').val();
        if (leagueDivision == "" || leagueDivision == null) {
            leagueDivision = "-";
        }
        var leagueCity = $('#leagueCity').val();
        var leagueState = $('#leagueState').val();
        var leaguePark = $('#leaguePark').val();
        if (leaguePark == "" || leaguePark == null) {
            leaguePark = "-";
        }
        var leagueSeason = $('#leagueSeason').val();
        var leagueYear = $('#leagueYear').val();
        if (leagueYear == "" || leagueYear == null) {
            leagueYear = "-";
        }

        $.get("http://tallyrecapp.dev/php/1.3.0/League/createLeague.php", { "userid": userid, "name": leagueName, "sport": leagueSport, "division": leagueDivision, "city": leagueCity, "state": leagueState, "park": leaguePark, "season": leagueSeason, "year": leagueYear }, processResult);

        function processResult(data, textStatus) {
        }

        $.get("http://tallyrecapp.dev/php/1.3.0/League/getLeagues.php", { "username": username }, processResult2);

        function processResult2(data, textStatus) {
            $('#MyLeaguesDiv').html(data).trigger('create');

            $.mobile.changePage('#console');

            //hide Page Loading Animation
            $.mobile.hidePageLoadingMsg();
        }
    });

    $('#menuPanelOpenClose').click(function () { $("#menuPanel").panel("toggle"); });

    $('#settingsPanelOpenClose').click(function () { $("#settingsPanel").panel("toggle"); });

    $('#createTeamPanelOpenClose').click(function () { $("#createTeamPanel").panel("toggle"); });

    $('#pastTeamsPanelOpenClose').click(function () { $("#pastTeamsPanel").panel("toggle"); });

    $('#searchPanelOpenClose').click(function () { $("#searchPanel").panel("toggle"); });

    $('#notifyPanelOpenClose').click(function () { $("#notifyPanel").panel("toggle"); });

    $('#teamMainPanelOpenClose').click(function () { $("#teamMainPanel").panel("toggle"); });

    $('#mymessagespanelOpenClose').click(function () { $("#mymessagespanel").panel("toggle"); });

    $('#sendContactMessagText').keypress(function (e) { if (e.which == 13) { $('#sendContactMessageBtn').click(); return false; } });

    $("#composeMessageDiv").click(function () {
        $("#convoName").text("New Message");
        $("#messageSuggestionsDiv").css("display", "inline");
        $.mobile.changePage('#composeMessage');
    });

    $('#sendContactMessageBtn').click(function () {
        // Validate Fields
        var x = document.forms["sendContactMessageForm"]["sendContactMessagText"].value;
        if (x == null || x == "") {
            document.forms["sendContactMessageForm"]["sendContactMessagText"].placeholder = "*Message - Required";
            return false;
        }

        var toUserID = $('#sendto').val();

        if (toUserID == "noteammates" || toUserID == "" || toUserID == null) {
            alert('Please select someone to send your message to.');
        }
        else {
            //Page Loading Animation
            $.mobile.showPageLoadingMsg();

            var storage = window.localStorage;

            var message = $("#sendContactMessagText").val();
            var userid = storage.getItem("MyUserID");
            var theirUserID = $('#sendto').val();

            $.get("http://tallyrecapp.dev/php/1.3.0/Profile/chat/sendChat.php", { "userid": userid, "message": message, "touserid": toUserID }, processResult);

            function processResult(data, textStatus) {

                $.get("http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyConvo.php", { "userid": userid, "theirUserID": theirUserID }, processResult2);

                function processResult2(data, textStatus) {
                    $('#myConvoDiv').html(data).trigger('create');

                    $.ajax({
                        type: "GET",
                        url: "http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyMessages.php",
                        data: { "userid": userid },
                        dataType: 'json',
                        success: function (data) {
                            $('#myMessageContactsDiv').html(data.messagetbl).trigger('create');
                            //$('#teamHomeWLT').html(data.newmessagecount).trigger('create');
                        }
                    });

                    $('#sendContactMessagText').val("");
                    $('#sendContactMessagText').blur();

                    var fname = storage.getItem("MyFname");
                    var lname = storage.getItem("MyLname");
                    var noteMessage = "New Chat Message from " + fname + " " + lname;

                    $.get("http://tallyrecapp.dev/php/1.3.0/PushNotify/prodPushMessage.php", { "userid": userid, "message": noteMessage, "touserid": toUserID }, processResult5);

                    function processResult5(data, textStatus) {
                        //hide Page Loading Animation
                        $.mobile.hidePageLoadingMsg();
                    }
                }
            }
        }
    });

    $('#myMessages').on('click', '.seeOurConvo', function () {

        var storage = window.localStorage;

        var contactid = $(this).data('contactid');
        var contactname = $(this).data('contactname');
        var userid = storage.getItem("MyUserID");
        var theirUserID = contactid;

        $('#sendto').val(contactid).selectmenu('refresh', true);

        $.get("http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyConvo.php", { "userid": userid, "theirUserID": theirUserID }, processResult2);

        function processResult2(data, textStatus) {

            $('#myConvoDiv').html(data).trigger('create');

            $.ajax({
                type: "GET",
                url: "http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyMessages.php",
                data: { "userid": userid },
                dataType: 'json',
                success: function (data) {

                    $('#myMessageContactsDiv').html(data.messagetbl).trigger('create');
                    $('.consolePanelMessages').html(data.newmessagecount).trigger('create');
                }
            });

            $("#messageSuggestionsDiv").css("display", "none");
            $("#convoName").text(contactname);
            $.mobile.changePage('#composeMessage');
        }

    });


    $('#composeMessage').on('change', '#sendto', function () {

        var theirUserID = $('#sendto').val();

        $.get("http://tallyrecapp.dev/php/1.3.0/Profile/chat/getMyConvo.php", { "userid": userid, "theirUserID": theirUserID }, processResult);

        function processResult(data, textStatus) {
            $('#myConvoDiv').html(data).trigger('create');
        }

    });


});        //END OnReady

/* 
*   Orientation Change 
*/

window.addEventListener("orientationchange", orientationChange, true);

function orientationChange(e) {
    var display = window.orientation;
    if (display == -90 || display == 90) {
        if ($.mobile.activePage.attr("id") == "teamSchedule") {
            $('#quickAddMoveDiv').css("display", "none");
            $('#quickAddDiv').css("display", "block");
        }
    }
    else {
        if ($.mobile.activePage.attr("id") == "teamSchedule") {
            $('#quickAddDiv').css("display", "none");
            $('#quickAddMoveDiv').css("display", "block");
        }
    }
}

/*
*
*
* Push Notification Scripts
*
*/

/*
*
*
* Push Notification Scripts
*
*/



var pushNotification;

function onDeviceReadyPush() {
    console.log('deviceready event received');

    document.addEventListener("backbutton", function (e) {
        console.log('backbutton event received');

        if ($("#home").length > 0) {
            // call this to get a new token each time. don't call it to reuse existing token.
            //pushNotification.unregister(successHandler, errorHandler);
            e.preventDefault();
            navigator.app.exitApp();
        }
        else {
            navigator.app.backHistory();
        }
    }, false);

    try {
        pushNotification = window.plugins.pushNotification;
        if (device.platform == 'android' || device.platform == 'Android') {
            console.log('registering android');
            pushNotification.register(successHandler, errorHandler, { "senderID": "798812369403", "ecb": "onNotificationGCM" }); 	// required!
        } else {
            console.log('registering iOS');
            pushNotification.register(tokenHandler, errorHandler, { "badge": "true", "sound": "true", "alert": "true", "ecb": "onNotificationAPN" }); // required!
        }
    }
    catch (err) {
        txt = "There was an error on this page.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        alert(txt);
    }
}

// handle APNS notifications for iOS
function onNotificationAPN(e) {
    if (e.alert) {
        console.log('push-notification: ' + e.alert);
        navigator.notification.alert(e.alert);
    }

    if (e.sound) {
        var snd = new Media(e.sound);
        snd.play();
    }

    if (e.badge) {
        pushNotification.setApplicationIconBadgeNumber(successHandler, e.badge);
    }
}

// handle GCM notifications for Android
function onNotificationGCM(e) {
    console.log('EVENT -> RECEIVED:' + e.event + '');

    switch (e.event) {
        case 'registered':
            if (e.regid.length > 0) {
                console.log('REGISTERED -> REGID:' + e.regid);
                // Your GCM push server needs to know the regID before it can push to this device
                // here is where you might want to send it the regID for later use.
                console.log("regID = " + e.regID);

                var storage = window.localStorage;
                var username = storage.getItem("MyUsername");
                var devicetype = "android";

                $.get("http://tallyrecapp.dev/php/1.3.0/setDeviceID.php", { "deviceid": e.regid, "username": username, "devicetype": devicetype }, processResult);

                function processResult(data, textStatus) {
                    console.log('success')
                }
            }
            break;

        case 'message':
            // if this flag is set, this notification happened while we were in the foreground.
            // you might want to play a sound to get the user's attention, throw up a dialog, etc.
            if (e.foreground) {
                console.log('--INLINE NOTIFICATION--');

                // if the notification contains a soundname, play it.
                var my_media = new Media("/android_asset/www/" + e.soundname);
                my_media.play();
            }
            else {	// otherwise we were launched because the user touched a notification in the notification tray.
                if (e.coldstart)
                    console.log('--COLDSTART NOTIFICATION--');
                else
                    console.log('--BACKGROUND NOTIFICATION--');
            }

            console.log('MESSAGE -> MSG: ' + e.payload.message);
            console.log('MESSAGE -> MSGCNT: ' + e.payload.msgcnt);
            break;

        case 'error':
            console.log('ERROR -> MSG:' + e.msg);
            break;

        default:
            console.log('EVENT -> Unknown, an event was received and we do not know what it is');
            break;
    }
}

function tokenHandler(result) {
    console.log('token: ' + result);
    // Your iOS push server needs to know the token before it can push to this device
    // here is where you might want to send it the token for later use.

    var storage = window.localStorage;
    var username = storage.getItem("MyUsername");
    var devicetype = "ios";

    $.get("http://tallyrecapp.dev/php/1.3.0/setDeviceID.php", { "deviceid": result, "username": username, "devicetype": devicetype }, processResult);

    function processResult(data, textStatus) {
        console.log('success')
    }
}

function successHandler(result) {
    console.log('success:' + result);
}

function errorHandler(error) {
    console.log('error:' + error);
}

document.addEventListener('deviceready', onDeviceReadyPush, true);

/*
*
*
* iAd
*
*/


var app = {
    initialize: function () {
        this.bind();
    },
    bind: function () {
        document.addEventListener('deviceready', this.deviceready, false);
    },
    deviceready: function () {
        // note that this is an event handler so the scope is that of the event
        // so we need to call app.report(), and not this.report()
        app.report('deviceready');

        // listen for orientation changes
        window.addEventListener('orientationchange', window.plugins.iAdPlugin.orientationChanged, false);
        // listen for the "iAdBannerViewDidLoadAdEvent" that is sent by the iAdPlugin
        document.addEventListener('iAdBannerViewDidLoadAdEvent', iAdBannerViewDidLoadAdEventHandler, false);
        // listen for the "iAdBannerViewDidFailToReceiveAdWithErrorEvent" that is sent by the iAdPlugin
        document.addEventListener('iAdBannerViewDidFailToReceiveAdWithErrorEvent', iAdBannerViewDidFailToReceiveAdWithErrorEventHandler, false);

        var adAtBottom = false;
        setTimeout(function () {
            window.plugins.iAdPlugin.prepare(adAtBottom); // by default, ad is at Top
        }, 1000);
        window.plugins.iAdPlugin.orientationChanged(true); //trigger immediately so iAd knows its orientation on first load
    },
    report: function (id) {
        console.log("report:" + id);
    }
};

app.initialize();

function onOrientationChange() {
    //alert(window.orientation);
}

function iAdBannerViewDidFailToReceiveAdWithErrorEventHandler(evt) {
    // Happens when Ad goes away
    window.plugins.iAdPlugin.showAd(false);
}

function iAdBannerViewDidLoadAdEventHandler(evt) {
    // if we got this event, a new ad is loaded
    window.plugins.iAdPlugin.showAd(true);
}

function lastAdLoadedInterval() {

}

function showAdClicked(evt) {
    window.plugins.iAdPlugin.showAd(evt.checked);
}