// JScript File

$(document).delegate("#leagueMain", "pagebeforecreate", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var LeagueName = storage.getItem("GotoLeague");
    var LeagueID = storage.getItem("GotoLeagueID");
    var UserID = storage.getItem("MyUserID");
    var LeagueManagerID = storage.getItem("GotoLeagueManageID");
    var sport = storage.getItem("GotoLeagueSport");

    setLeagueName();
    setLeagueSportImg();

    function setLeagueName() {

        $('.SelectedTeamName').text(LeagueName);
    }

    function setLeagueSportImg() {

        var sportimg = "<img src='images/sport/" + sport + ".png' class='SportImgLarge' />";
        $('#leagueSportImageDiv').html(sportimg).trigger('create');
    }

    getTodaysEvents();

    function getTodaysEvents() {
        $.get("http://tallyrecapp.dev/php/1.3.0/League/getTodaysEvents.php", { "leagueid": LeagueID }, processResult);

        function processResult(data, textStatus) {
            $('#leagueEventsTodayDiv').html(data).trigger('create');
        }

    }
    
    getLeagueNote();

    // Get the Latest Team Notification
    function getLeagueNote() {
        var teamManager = storage.getItem("GotoTeamManageID");
        $.get("http://tallyrecapp.dev/php/1.3.0/League/Chat/getLeagueNotes.php", { "leagueid": LeagueID, "leaguemanager": LeagueManagerID }, processResult);

        function processResult(data, textStatus) {
            $('#leagueNote').html(data).trigger('create');
        }
    }


    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

$(document).delegate("#leagueRoster", "pagebeforecreate", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var LeagueName = storage.getItem("GotoLeague");
    var LeagueID = storage.getItem("GotoLeagueID");
    var UserID = storage.getItem("MyUserID");
    var LeagueManagerID = storage.getItem("GotoLeagueManageID");
    var sport = storage.getItem("GotoLeagueSport");

    setLeagueName();

    function setLeagueName() {

        $('.SelectedTeamName').text(LeagueName);
    }

    getLeagueRoster();

    function getLeagueRoster() {

        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/League/getRosters.php",
            data: { "leagueid": LeagueID, "leaguename": LeagueName, "leaguesportid": sport, "userid": UserID },
            dataType: 'json',
            success: function (data) {
                $('#leagueRosterDiv').html(data.roster).trigger('create');
                $('#leagueRosterCount').html(data.count).trigger('create');
            }
        });

    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

$(document).delegate("#leagueSettings", "pagebeforecreate", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var LeagueName = storage.getItem("GotoLeague");
    var LeagueID = storage.getItem("GotoLeagueID");
    var UserID = storage.getItem("MyUserID");
    var LeagueManagerID = storage.getItem("GotoLeagueManageID");
    var sport = storage.getItem("GotoLeagueSport");

    setLeagueName();

    function setLeagueName() {

        $('.SelectedTeamName').text(LeagueName);
    }

    getTeamSettings();

    // Get Settings Data
    function getTeamSettings() {

        var GoToLeague = storage.getItem("GotoLeague");
        var GoToLeagueSport = storage.getItem("GotoLeagueSport");
        var GoToLeagueDivision = storage.getItem("GotoLeagueDivision");
        var GoToLeagueState = storage.getItem("GotoLeagueState");
        var GoToLeagueCity = storage.getItem("GotoLeagueCity");
        var GoToLeaguePark = storage.getItem("GotoLeaguePark");
        var GotoLeagueSeason = storage.getItem("GotoLeagueSeason");
        var GotoLeagueYear = storage.getItem("GotoLeagueYear");
        var GoToLeagueNote = storage.getItem("GotoLeagueNote");
        var GoToLeagueChat = storage.getItem("GotoLeagueChat");
        var GoToLeagueFollowers = storage.getItem("GotoLeagueFollowers");

        $('#leaguesettingsName').val(GoToLeague);
        $('#leaguesettingsDivision').val(GoToLeagueDivision);
        $('#leaguesettingsState').val(GoToLeagueState);
        $('#leaguesettingsCity').val(GoToLeagueCity);
        $('#leaguesettingsPark').val(GoToLeaguePark);
        $('#leaguesettingsYear').val(GotoLeagueYear);

        if (GotoLeagueSeason == "1") {
            $("#leaguesettingsSeason>option:eq(0)").attr('selected', true);
        }
        else if (GotoLeagueSeason == "2") {
            $("#leaguesettingsSeason>option:eq(1)").attr('selected', true);
        }
        else if (GotoLeagueSeason == "3") {
            $("#leaguesettingsSeason>option:eq(2)").attr('selected', true);
        }
        else {
            $("#leaguesettingsSeason>option:eq(3)").attr('selected', true);
        }

        if (GoToLeagueSport == "1") {
            $("#leaguesettingSport>option:eq(0)").attr('selected', true);
        }
        else if (GoToLeagueSport == "2") {
            $("#leaguesettingSport>option:eq(1)").attr('selected', true);
        }
        else if (GoToLeagueSport == "3") {
            $("#leaguesettingSport>option:eq(2)").attr('selected', true);
        }
        else if (GoToLeagueSport == "4") {
            $("#leaguesettingSport>option:eq(3)").attr('selected', true);
        }
        else if (GoToLeagueSport == "16") {
            $("#leaguesettingSport>option:eq(4)").attr('selected', true);
        }
        else if (GoToLeagueSport == "5") {
            $("#leaguesettingSport>option:eq(5)").attr('selected', true);
        }
        else if (GoToLeagueSport == "19") {
            $("#leaguesettingSport>option:eq(6)").attr('selected', true);
        }
        else if (GoToLeagueSport == "6") {
            $("#leaguesettingSport>option:eq(7)").attr('selected', true);
        }
        else if (GoToLeagueSport == "17") {
            $("#leaguesettingSport>option:eq(8)").attr('selected', true);
        }
        else if (GoToLeagueSport == "7") {
            $("#leaguesettingSport>option:eq(9)").attr('selected', true);
        }
        else if (GoToLeagueSport == "8") {
            $("#leaguesettingSport>option:eq(10)").attr('selected', true);
        }
        else if (GoToLeagueSport == "15") {
            $("#leaguesettingSport>option:eq(11)").attr('selected', true);
        }
        else if (GoToLeagueSport == "9") {
            $("#leaguesettingSport>option:eq(12)").attr('selected', true);
        }
        else if (GoToLeagueSport == "10") {
            $("#leaguesettingSport>option:eq(13)").attr('selected', true);
        }
        else if (GoToLeagueSport == "11") {
            $("#leaguesettingSport>option:eq(14)").attr('selected', true);
        }
        else if (GoToLeagueSport == "12") {
            $("#leaguesettingSport>option:eq(15)").attr('selected', true);
        }
        else if (GoToLeagueSport == "18") {
            $("#leaguesettingSport>option:eq(16)").attr('selected', true);
        }
        else if (GoToLeagueSport == "13") {
            $("#leaguesettingSport>option:eq(17)").attr('selected', true);
        }
        else if (GoToLeagueSport == "14") {
            $("#leaguesettingSport>option:eq(18)").attr('selected', true);
        }
        else {
            $("#leaguesettingSport>option:eq(19)").attr('selected', true);
        }

        //Chat settings
        if (GoToLeagueFollowers == "1") {
            $("#leaguefollowerNoteYes").attr("checked", true).trigger('create');
            $("#leaguefollowerNoteNo").attr("checked", false).trigger('create');
        }
        else {
            $("#leaguefollowerNoteYes").attr("checked", false).trigger('create');
            $("#leaguefollowerNoteNo").attr("checked", true).trigger('create');
        }

        //league Note settings
        if (GoToLeagueNote == "1") {
            $("#leagueNoteYes").attr("checked", true).trigger('create');
            $("#leagueNoteNo").attr("checked", false).trigger('create');
        }
        else {
            $("#leagueNoteYes").attr("checked", false).trigger('create');
            $("#leagueNoteNo").attr("checked", true).trigger('create');
        }

        //Chat settings
        if (GoToLeagueChat == "1") {
            $("#leaguechatNoteYes").attr("checked", true).trigger('create');
            $("#leaguechatNoteNo").attr("checked", false).trigger('create');
        }
        else {
            $("#leaguechatNoteYes").attr("checked", false).trigger('create');
            $("#leaguechatNoteNo").attr("checked", true).trigger('create');
        }

    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});

$(document).delegate("#leagueEditSchedule", "pagebeforeshow", function () {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var LeagueName = storage.getItem("GotoLeague");
    var LeagueID = storage.getItem("GotoLeagueID");
    var UserID = storage.getItem("MyUserID");
    var LeagueManagerID = storage.getItem("GotoLeagueManageID");
    var sport = storage.getItem("GotoLeagueSport");
    var eventid = storage.getItem("SelectedGameEventID");
    var hometeamid = storage.getItem("SelectedGameHomeTeamID");
    var awayteamid = storage.getItem("SelectedGameAwayTeamID");

    setLeagueName();

    function setLeagueName() {

        $('.SelectedTeamName').text(LeagueName);
    }

    setDDLs();

    function setDDLs() {
        if (eventid == "0") {
            $('#leagueawayteam').val(awayteamid).selectmenu('refresh', true);
            $('#leaguehometeam').val(hometeamid).selectmenu('refresh', true);
        }
        else if (eventid == "1") {
            $('#leaguepracticeteam').val(hometeamid).selectmenu('refresh', true);
        }
        else if (eventid == "2") {
            $('#leagueallteam').val(hometeamid).selectmenu('refresh', true);
        }
    }


    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();
});

$(document).delegate("#leagueSchedule", "pagebeforecreate", function () {

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var LeagueName = storage.getItem("GotoLeague");
    var LeagueID = storage.getItem("GotoLeagueID");
    var UserID = storage.getItem("MyUserID");
    var LeagueManagerID = storage.getItem("GotoLeagueManageID");
    var sport = storage.getItem("GotoLeagueSport");

    setLeagueName();

    function setLeagueName() {

        $('.SelectedTeamName').text(LeagueName);
    }

    getLeagueSchedule();

    function getLeagueSchedule() {
        $.get("http://tallyrecapp.dev/php/1.3.0/League/getSchedule.php", { "leagueid": LeagueID, "manage": LeagueManagerID }, processResult);

        function processResult(data, textStatus) {
            $('#leagueScheduleDiv').html(data).trigger('create');
        }
    }


    getLeagueTeams();

    function getLeagueTeams() {
        $.ajax({
            type: "POST",
            url: "http://tallyrecapp.dev/php/1.3.0/League/getLeagueTeams.php",
            data: { "leagueid": LeagueID },
            dataType: 'json',
            success: function (data) {
                $('#leagueawayteamDDL').html(data.awayteams).trigger('create');
                $('#leaguehometeamDDL').html(data.hometeams).trigger('create');
                $('#leagueallteamsDDL').html(data.allteams).trigger('create');
                $('#leaguepracticeteamsDDL').html(data.practiceteams).trigger('create');
            }
        });
    }
});


/* Team Chat */
$(document).delegate("#leagueChat", "pagebeforecreate", function (e) {

    //Page Loading Animation
    $.mobile.showPageLoadingMsg();

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    // Get Variable from Storage
    var LeagueName = storage.getItem("GotoLeague");
    var LeagueID = storage.getItem("GotoLeagueID");
    var UserID = storage.getItem("MyUserID");
    var LeagueManagerID = storage.getItem("GotoLeagueManageID");
    var sport = storage.getItem("GotoLeagueSport");

    setTeamName();

    /* Universal Functions */

    // Set Team Name On All Pages
    function setTeamName() {

        $('.SelectedTeamName').text(LeagueName);
    }

    setTeamChat();

    // Get the Team Chat
    function setTeamChat() {
        $.get("http://tallyrecapp.dev/php/1.3.0/League/Chat/getChat.php", { "leagueid": LeagueID, "userid": UserID }, processResult);

        function processResult(data, textStatus) {
            if (data == "NoMessages") {
            }
            else {
                $('#leagueChatMessages').html(data).trigger('create');

            }
        }
    }

    //hide Page Loading Animation
    $.mobile.hidePageLoadingMsg();

});


/*
*
* On Document Ready -----------------------------------------------
*
*/

$(document).ready(function () {

    // Starting LocalStorage (PhoneGap)
    var storage = window.localStorage;

    var LeagueManagerID = storage.getItem("GotoLeagueManageID");
    /*
    *
    *   Roster Functions
    *
    */

    $('#leagueCreateTeam').click(function () {

        // Validate Fields
        var w = document.forms["leagueCreateTeamForm"]["leagueCreateTeamName"].value;

        if (w == null || w == "") {
            document.forms["leagueCreateTeamForm"]["leagueCreateTeamName"].placeholder = "Team Name - Required";
            return false;
        }

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        $('#leagueCreateTeamName').blur();

        var userid = storage.getItem("MyUserID");
        var leagueID = storage.getItem("GotoLeagueID");
        var league = storage.getItem("GotoLeague");
        var city = storage.getItem("GotoLeagueCity");
        var state = storage.getItem("GotoLeagueState");
        var park = storage.getItem("GotoLeaguePark");
        var sport = storage.getItem("GotoLeagueSport");
        var teamname = $('#leagueCreateTeamName').val();

        //create team
        $.get("http://tallyrecapp.dev/php/1.3.0/League/createTeam.php", { "userid": userid, "teamname": teamname, "sport": sport, "state": state, "city": city, "park": park, "league": league, "leagueid": leagueID }, processResult);

        function processResult(data, textStatus) {

            if (data == "Success") {
                //Do Nothing
            }
        }

        //refresh roster list
        $.ajax({
            type: "GET",
            url: "http://tallyrecapp.dev/php/1.3.0/League/getRosters.php",
            data: { "leagueid": LeagueID, "leaguename": league, "leaguesportid": sport, "userid": userid },
            dataType: 'json',
            success: function (data) {
                $('#leagueRosterDiv').html(data.roster).trigger('create');
                $('#leagueRosterCount').html(data.count).trigger('create');
            }
        });

        $('#leagueCreateTeamName').val('');

        //hide Page Loading Animation
        $.mobile.hidePageLoadingMsg();

    });

    $('#saveLeagueSettings').click(function () {

        //Page Loading Animation
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");

        // Get League Data
        var leaguename = $('#leaguesettingsName').val();
        var leaguesport = $('#leaguesettingSport').val();
        var leaguedivision = $('#leaguesettingsDivision').val();
        if (leaguedivision == "" || leaguedivision == null) {
            leaguedivision = "-";
        }
        var leaguecity = $('#leaguesettingsCity').val();
        var leaguestate = $('#leaguesettingsState').val();
        var leaguepark = $('#leaguesettingsPark').val();
        if (leaguepark == "" || leaguepark == null) {
            leaguepark = "-";
        }
        var leagueseason = $('#leaguesettingsSeason').val();
        var leagueyear = $('#leaguesettingsYear').val();
        if (leagueyear == "" || leagueyear == null) {
            leagueyear = "-";
        }

        storage.setItem("GotoLeague", leaguename);
        storage.setItem("GotoLeagueState", leaguestate);
        storage.setItem("GotoLeagueCity", leaguecity);
        storage.setItem("GotoLeaguePark", leaguepark);
        storage.setItem("GotoLeagueSport", leaguesport);
        storage.setItem("GotoLeagueSeason", leagueseason);
        storage.setItem("GotoLeagueYear", leagueyear);
        storage.setItem("GotoLeagueDivision", leaguedivision);

        // Update Team Settings
        $.get("http://tallyrecapp.dev/php/1.3.0/League/updateLeagueSettings.php", { "leagueid": LeagueID, "name": leaguename, "sport": leaguesport, "division": leaguedivision, "state": leaguestate, "city": leaguecity, "park": leaguepark, "season": leagueseason, "year": leagueyear }, processResult);

        function processResult(data, textStatus) {

        }

        // Re-Set team name
        $('.SelectedTeamName').text(leaguename);

        // Re-Set Team Sport Images
        var sportimg = "<img src='images/sport/" + leaguesport + ".png' class='SportImgLarge' />";
        $('#leagueSportImageDiv').html(sportimg).trigger('create');

        //hide Page Loading Animation
        $.mobile.hidePageLoadingMsg();

        $.mobile.changePage('#leagueMain');
    });

    //Saves TeamNote Notification settings
    $('input:radio[name=leaguefollowerNote]').click(function () {

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");
        var UserID = storage.getItem("MyUserID");

        var leaguefollowers = $('input:radio[name=leaguefollowerNote]:checked').val();
        storage.setItem("GotoLeagueFollowers", leaguefollowers);

        var leaguenote = $('input:radio[name=leagueNote]:checked').val();
        storage.setItem("GotoLeagueNote", leaguenote);

        var leaguechat = $('input:radio[name=leaguechatNote]:checked').val();
        storage.setItem("GotoLeagueChat", leaguechat);

        $.get("http://tallyrecapp.dev/php/1.3.0/League/updateNotificationSettings.php", { "leaguefollowers": leaguefollowers, "leaguenote": leaguenote, "leaguechat": leaguechat, "userid": UserID, "leagueid": LeagueID }, processResult);

        function processResult(data, textStatus) {
            //Do Nothing
        }
    });

    //Saves TeamNote Notification settings
    $('input:radio[name=leagueNote]').click(function () {

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");
        var UserID = storage.getItem("MyUserID");

        var leaguefollowers = $('input:radio[name=leaguefollowerNote]:checked').val();
        storage.setItem("GotoLeagueFollowers", leaguefollowers);

        var leaguenote = $('input:radio[name=leagueNote]:checked').val();
        storage.setItem("GotoLeagueNote", leaguenote);

        var leaguechat = $('input:radio[name=leaguechatNote]:checked').val();
        storage.setItem("GotoLeagueChat", leaguechat);

        $.get("http://tallyrecapp.dev/php/1.3.0/League/updateNotificationSettings.php", { "leaguefollowers": leaguefollowers, "leaguenote": leaguenote, "leaguechat": leaguechat, "userid": UserID, "leagueid": LeagueID }, processResult);

        function processResult(data, textStatus) {
            //Do Nothing
        }
    });

    //Saves Chat Notification settings
    $('input:radio[name=leaguechatNote]').click(function () {

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");
        var UserID = storage.getItem("MyUserID");

        var leaguefollowers = $('input:radio[name=leaguefollowerNote]:checked').val();
        storage.setItem("GotoLeagueFollowers", leaguefollowers);

        var leaguenote = $('input:radio[name=leagueNote]:checked').val();
        storage.setItem("GotoLeagueNote", leaguenote);

        var leaguechat = $('input:radio[name=leaguechatNote]:checked').val();
        storage.setItem("GotoLeagueChat", leaguechat);

        $.get("http://tallyrecapp.dev/php/1.3.0/League/updateNotificationSettings.php", { "leaguefollowers": leaguefollowers, "leaguenote": leaguenote, "leaguechat": leaguechat, "userid": UserID, "leagueid": LeagueID }, processResult);

        function processResult(data, textStatus) {
            //Do Nothing
        }
    });

    // Archive League
    $('#archiveleagueBtn').click(function () {

        var ask = confirm("Archive League?")

        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");
        var UserID = storage.getItem("MyUserID");

        if (ask == true) {
            $.get("http://tallyrecapp.dev/php/1.3.0/League/updateLeagueArchive.php", { "leagueid": LeagueID, "userid": UserID }, processResult);

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
        //Hide Loading
        $.mobile.hidePageLoadingMsg();
    });

    // Delete League
    $('#deleteleagueBtn').click(function () {
        var ask = confirm("Delete League?")

        //Show loading
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");
        var UserID = storage.getItem("MyUserID");

        if (ask == true) {

            $.get("http://tallyrecapp.dev/php/1.3.0/League/updateLeagueDelete.php", { "leagueid": LeagueID, "userid": UserID }, processResult);

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

    //Add Event to League
    $('#addLeagueEventBtn').click(function () {

        //Show loading
        $.mobile.showPageLoadingMsg();

        var storage = window.localStorage;

        storage.setItem("SelectedGameID", "");
        storage.setItem("SelectedGameHomeTeamID", "");
        storage.setItem("SelectedGameAwayTeamID", "");

        $('#leagueGameOpponent').val("");
        $('#LeagueGameDate').val("");

        //Time
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (hours > 11) {

            if (hours == 12) {
            }
            else {
                hours = hours - 12;
            }

            var time = (hours + ":" + minutes + " " + "PM");
        }
        else {
            var time = (hours + ":" + minutes + " " + "AM");
        }
        $('#leagueGameTime').val(time);

        GamePark = storage.getItem("GotoLeaguePark");
        if (GamePark == "-") {
            GamePark = "";
        }
        $('#leagueGamePark').val(GamePark);

        var string = "<select id='leagueGameHomeAway' data-mini='true' style='font-size: 8pt;'data-type='horizontal'><option value='1' selected='selected'>Home</option><option value='0'>Away</option></select>";
        $("#leagueGameHomeAwayDD").html(string).trigger('create');

        GameCity = storage.getItem("GotoLeagueCity");
        $('#leagueGameCity').val(GameCity);

        GameState = storage.getItem("GotoLeagueState");
        $('#leagueGameState').val(GameState);

        $('#leagueGameHomeScore').val("");
        $('#leagueGameAwayScore').val("");
        $('#leagueAwayScoreTeam').html('Away Team:');
        $('#leagueHomeScoreTeam').html('Home Team:');


        //Determine if new game or edit game
        $('#leagueDeleteGameBtn').css("display", "none");

        $.mobile.changePage('#leagueEditSchedule');

        //Hide Loading
        $.mobile.hidePageLoadingMsg();

    });

    $('#teamEditRoster').on('click', '#leagueEventType', function () {
    //$('#leagueEventType').live('change', function () {

        var sel = $('#leagueEventType').val();

        if (sel == "game") {
            $('#leagueGameOption').css("display", "block");
            $('#leagueEventOption').css("display", "none");
            $('#leaguePracticeOption').css("display", "none");
        }
        else if (sel == "practice") {
            $('#leagueGameOption').css("display", "none");
            $('#leagueEventOption').css("display", "none");
            $('#leaguePracticeOption').css("display", "block");
        }
        else if (sel == "other") {
            $('#leagueEventOption').css("display", "block");
            $('#leagueGameOption').css("display", "none");
            $('#leaguePracticeOption').css("display", "none");
        }

    });

    $('#leagueDeleteGameBtn').click(function () {
        var ask = confirm("Delete Event?")

        //Show loading
        $.mobile.showPageLoadingMsg();

        var gameid = storage.getItem("SelectedGameID");
        var LeagueID = storage.getItem("GotoLeagueID");
        var LeagueManagerID = storage.getItem("GotoLeagueManageID");

        if (ask == true) {
            $.get("http://tallyrecapp.dev/php/1.3.0/deleteGame.php", { "gameid": gameid }, processResult);

            function processResult(data, textStatus) {

                //Get Schedule
                $.get("http://tallyrecapp.dev/php/1.3.0/League/getSchedule.php", { "leagueid": LeagueID, "manage": LeagueManagerID }, processResult1);

                function processResult1(data, textStatus) {
                    $('#leagueScheduleDiv').html(data).trigger('create');

                    $.mobile.changePage('#leagueSchedule');


                    //Hide Loading
                    $.mobile.hidePageLoadingMsg();
                }
            }
        }
        else {
            return false;
        }
    });

    $('#leagueSaveGameBtn').click(function () {

        var sel = $('#leagueEventType').val();

        //Validation
        if (sel == "other") {
            var w = $('#leagueGameCity').val();
            var x = $('#leagueGameState').val();
            var y = $('#leagueEventName').val();

            if (w == null || w == "") {
                document.forms["leagueEventForm"]["leagueGameCity"].placeholder = "City - Required";
                return false;
            }
            if (x == null || x == "") {
                document.forms["leagueEventForm"]["leagueGameState"].placeholder = "State - Required";
                return false;
            }
            if (y == null || y == "") {
                document.forms["leagueEventForm"]["leagueEventName"].placeholder = "Event Name - Required";
                return false;
            }
        }
        else if (sel == "practice") {
            var w = $('#leagueGameCity').val();
            var x = $('#leagueGameState').val();

            if (w == null || w == "") {
                document.forms["leagueEventForm"]["leagueGameCity"].placeholder = "City - Required";
                return false;
            }
            if (x == null || x == "") {
                document.forms["leagueEventForm"]["leagueGameState"].placeholder = "State - Required";
                return false;
            }
        }
        else {

            if ($('#leagueawayteam').val() == $('#leaguehometeam').val()) {
                alert("Away Team can not be the same as Home Team, please change one.");
                return false;
            }

            var w = $('#leagueGameCity').val();
            var x = $('#leagueGameState').val();

            if (w == null || w == "") {
                document.forms["leagueEventForm"]["leagueGameCity"].placeholder = "City - Required";
                return false;
            }
            if (x == null || x == "") {
                document.forms["leagueEventForm"]["leagueGameState"].placeholder = "State - Required";
                return false;
            }
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        var storage = window.localStorage;

        var leagueid = storage.getItem("GotoLeagueID");
        var gameid = storage.getItem("SelectedGameID");
        if (gameid == "") {
            gameid = "0"
        }

        if (sel == "other") {
            var eventtype = "2";
            var hometeamid = $('#leagueallteam').val();
            var hometeamname = $('#leagueallteam option:selected').text();
            var awayteamid = "0";
            var awayteamname = $('#leagueEventName').val();

        }
        else if (sel == "practice") {
            $('#GameOpponent').val('Practice');
            var eventtype = "1";
            var hometeamid = $('#leaguepracticeteam').val();
            var hometeamname = $('#leaguepracticeteam option:selected').text();
            var awayteamid = "0";
            var awayteamname = "Practice";
        }
        else {
            var eventtype = "0";
            var hometeamid = $('#leaguehometeam').val();
            var hometeamname = $('#leaguehometeam option:selected').text();
            var awayteamid = $('#leagueawayteam').val();
            var awayteamname = $('#leagueawayteam option:selected').text();
        }

        var gamelocation = $('#leagueGamePark').val();
        if (gamelocation == "" || gamelocation == null) {
            gamelocation = "-";
        }
        var gamedate = $('#LeagueGameDate').val();
        if (gamedate == "" || gamedate == null) {
            gamedate = "-";
        }
        var gametime = $('#leagueGameTime').val();
        if (gametime == "" || gametime == null) {
            gametime = "-";
        }
        var gamecity = $('#leagueGameCity').val();
        if (gamecity == "" || gamecity == null) {
            gamecity = "-";
        }
        var gamestate = $('#leagueGameState').val();
        if (gamestate == "" || gamestate == null) {
            gamestate = "-";
        }
        var homescore = $('#leagueGameHomeScore').val();
        if (homescore == "" || homescore == null) {
            homescore = "-";
        }
        var awayscore = $('#leagueGameAwayScore').val();
        if (awayscore == "" || awayscore == null) {
            awayscore = "-";
        }

        $.get("http://tallyrecapp.dev/php/1.3.0/League/creategame.php", { "leagueid": leagueid, "gameid": gameid, "eventtype": eventtype, "hometeamid": hometeamid, "hometeamname": hometeamname, "awayteamid": awayteamid, "awayteamname": awayteamname, "gamelocation": gamelocation, "gamedate": gamedate, "gametime": gametime, "gamecity": gamecity, "gamestate": gamestate, "homescore": homescore, "awayscore": awayscore }, processResult);

        function processResult(data, textStatus) {

            $.get("http://tallyrecapp.dev/php/1.3.0/League/getSchedule.php", { "leagueid": leagueid, "manage": LeagueManagerID }, processResult1);

            function processResult1(data, textStatus) {
                $('#leagueScheduleDiv').html(data).trigger('create');

                $.mobile.changePage('#leagueSchedule');

                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
        }

    });

    $('#leagueSchedule').on('click', '.EditLeagueGameBtn', function () {
    //$('.EditLeagueGameBtn').live("click", function () {

        //Show loading
        $.mobile.showPageLoadingMsg();

        var gameid = $(this).data('gameid');
        var hometeam = $(this).data('hometeam');
        var hometeamid = $(this).data('hometeamid');
        var awayteam = $(this).data('awayteam');
        var awayteamid = $(this).data('awayteamid');
        var date = $(this).data('date');
        var time = $(this).data('time');
        var park = $(this).data('park');
        var city = $(this).data('city');
        var state = $(this).data('state');
        var homescore = $(this).data('homescore');
        if (homescore == "-") {
            homescore = "";
        }
        var awayscore = $(this).data('awayscore');
        if (awayscore == "-") {
            awayscore = "";
        }
        var eventtype = $(this).data('eventtype');

        storage.setItem("SelectedGameID", gameid);
        storage.setItem("SelectedGameHomeTeamID", hometeamid);
        storage.setItem("SelectedGameAwayTeamID", awayteamid);
        storage.setItem("SelectedGameEventID", eventtype);

        $('#LeagueGameDate').val(date);
        $('#leagueGameTime').val(time);
        $('#leagueGamePark').val(park);
        $('#leagueGameCity').val(city);
        $('#leagueGameState').val(state);

        $('#leagueGameAwayScore').val(awayscore);
        $('#leagueGameHomeScore').val(homescore);

        if (eventtype == "0") {
            $('#leagueGameOption').css("display", "block");
            $('#leagueEventOption').css("display", "none");
            $('#leaguePracticeOption').css("display", "none");
            var contents = "<select id='leagueEventType' data-mini='true' style='font-size: 8pt;'><option value='game' selected='selected'>Game</option><option value='practice'>Practice</option><option value='other'>Other</option></select>";
            $('#leagueEventTypeDiv').html(contents).trigger('create');
        }
        else if (eventtype == "1") {
            $('#leagueGameOption').css("display", "none");
            $('#leagueEventOption').css("display", "none");
            $('#leaguePracticeOption').css("display", "block");
            var contents = "<select id='leagueEventType' data-mini='true' style='font-size: 8pt;'><option value='game'>Game</option><option value='practice' selected='selected'>Practice</option><option value='other'>Other</option></select>";
            $('#leagueEventTypeDiv').html(contents).trigger('create');
        }
        else if (eventtype == "2") {
            $('#leagueEventOption').css("display", "block");
            $('#leagueGameOption').css("display", "none");
            $('#leaguePracticeOption').css("display", "none");
            var contents = "<select id='leagueEventType' data-mini='true' style='font-size: 8pt;'><option value='game' selected='selected'>Game</option><option value='practice'>Practice</option><option value='other' selected='selected'>Other</option></select>";
            $('#leagueEventTypeDiv').html(contents).trigger('create');
            $('#leagueEventName').val(awayteam);

        }

        $('#leagueDeleteGameBtn').css("display", "block");

        $.mobile.changePage('#leagueEditSchedule');

        //Hide Loading
        $.mobile.hidePageLoadingMsg();
    });


    /*
    *   League Chat
    */
    $('#sendLeagueChatBtn').click(function () {

        // Validate Fields
        var w = document.forms["sendleaguechatform"]["LeagueChatMessageInput"].value;

        if (w == null || w == "") {
            document.forms["sendleaguechatform"]["LeagueChatMessageInput"].placeholder = "Message - Required";
            return false;
        }

        //Show loading
        $.mobile.showPageLoadingMsg();

        $('#LeagueChatMessageInput').blur();

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");
        var UserID = storage.getItem("MyUserID");
        var LeagueName = storage.getItem("GotoLeague");

        var message = $('#LeagueChatMessageInput').val();
        var noteMessage = "New Chat Message from, " + LeagueName;
        var teamnote = "0";

        $.get("http://tallyrecapp.dev/php/1.3.0/League/Chat/sendChat.php", { "leagueid": LeagueID, "userid": UserID, "message": message, "teamnote": teamnote }, processResult);

        function processResult(data, textStatus) {

            $.get("http://tallyrecapp.dev/php/1.3.0/League/Chat/getChat.php", { "leagueid": LeagueID, "userid": UserID }, processResult1);

            function processResult1(data, textStatus) {
                if (data == "NoMessages") {
                }
                else {

                    $('#LeagueChatMessageInput').val('');
                    $('#leagueChatMessages').html(data).trigger('create');
                }

                /*
                $.get("http://tallyrecapp.dev/php/1.3.0/PushNotify/League/prodPushChatNote.php", { "leagueid": LeagueID, "leaguename": LeagueName, "message": noteMessage, "myuserid": UserID }, processResult2);

                function processResult2(data, textStatus) {
                //Hide Loading
                $.mobile.hidePageLoadingMsg();
                }
                */

                //Hide Loading
                $.mobile.hidePageLoadingMsg();
            }
        }
    });

    var leagueNoteCount = "0";

    $('#leagueMain').on('click', '#NewLeagueNoteBtn', function () {
    //$('#NewLeagueNoteBtn').live('click', function () {
        if (leagueNoteCount == "0") {
            $('#NewLeagueNote').css("display", "block");
            leagueNoteCount = "1";
        }
        else {
            $('#NewLeagueNote').css("display", "none");
            leagueNoteCount = "0";
        }
    });

    $('#leagueMain').on('click', '#LeagueNoteSendBtn', function () {
    //$('#LeagueNoteSendBtn').live('click', function () {
        // Validate Fields
        var w = document.forms["LeagueNoteForm"]["LeagueNoteMessage"].value;

        if (w == null || w == "") {
            document.forms["LeagueNoteForm"]["LeagueNoteMessage"].placeholder = "Message - Required";
            return false;
        }

        //Page Loading Animation
        $('#LeagueNoteMessage').blur();
        $.mobile.showPageLoadingMsg();

        // Get Variable from Storage
        var LeagueID = storage.getItem("GotoLeagueID");
        var UserID = storage.getItem("MyUserID");
        var LeagueName = storage.getItem("GotoLeague");
        var LeagueManagerID = storage.getItem("GotoLeagueManageID");

        var message = $('#LeagueNoteMessage').val();
        var teamnote = "1";

        $.get("http://tallyrecapp.dev/php/1.3.0/League/Chat/sendChat.php", { "leagueid": LeagueID, "userid": UserID, "message": message, "teamnote": teamnote }, processResult);

        function processResult(data, textStatus) {

            /*
            $.get("http://tallyrecapp.dev/php/1.3.0/PushNotify/League/prodPushTeamNote.php", { "leagueid": LeagueID, "leaguename": LeagueName, "message": message, "myuserid": UserID }, processResult2);

            function processResult2(data, textStatus) {
            }
            */
            $.get("http://tallyrecapp.dev/php/1.3.0/League/Chat/getLeagueNotes.php", { "leagueid": LeagueID, "leaguemanager": LeagueManagerID }, processResult3);

            function processResult3(data, textStatus) {
                $('#leagueNote').html(data).trigger('create');

                //hide Page Loading Animation
                $.mobile.hidePageLoadingMsg();
            }
        }

    });


    /*
    *
    *   Enter Key Functions
    *
    */

    //League Settings
    $('#leaguesettingsName').keypress(function (e) {
        if (e.which == 13) {
            $('#saveLeagueSettings').click();
            return false;
        }
    });

    $('#leaguesettingsDivision').keypress(function (e) {
        if (e.which == 13) {
            $('#saveLeagueSettings').click();
            return false;
        }
    });

    $('#leaguesettingsCity').keypress(function (e) {
        if (e.which == 13) {
            $('#saveLeagueSettings').click();
            return false;
        }
    });

    $('#leaguesettingsState').keypress(function (e) {
        if (e.which == 13) {
            $('#saveLeagueSettings').click();
            return false;
        }
    });

    $('#leaguesettingsPark').keypress(function (e) {
        if (e.which == 13) {
            $('#saveLeagueSettings').click();
            return false;
        }
    });

    $('#leaguesettingsYear').keypress(function (e) {
        if (e.which == 13) {
            $('#saveLeagueSettings').click();
            return false;
        }
    });

    // League Add Team

    $('#leagueCreateTeamName').keypress(function (e) {
        if (e.which == 13) {
            $('#leagueCreateTeam').click();
            return false;
        }
    });

    $('#LeagueChatMessageInput').keypress(function (e) {
        if (e.which == 13) {
            $('#sendLeagueChatBtn').click();
            return false;
        }
    });

    $('#leagueMain').on('click', '#LeagueNoteMessage', function (e) {
    //$('#LeagueNoteMessage').live('keypress', function (e) {
        if (e.which == 13) {
            $('#LeagueNoteSendBtn').click();
            return false;
        }
    });

});                                  //End OnReady