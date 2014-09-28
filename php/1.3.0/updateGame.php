<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="game"; // Table name 


    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");
    
    // Define Variables
        $teamid = $_REQUEST['teamid'];
        $eventtype = $_REQUEST['eventtype'];
        if ($_REQUEST['GameOpponent'] == "" || $_REQUEST['GameOpponent'] == null) {
            $gameopponent = " ";
        }
        else {
            $gameopponent = $_REQUEST['GameOpponent'];
        }
        if ($_REQUEST['GamePark'] == "" || $_REQUEST['GamePark'] == null) {
            $gamelocation = " ";
        }
        else {
            $gamelocation = $_REQUEST['GamePark'];
        }
        if ($_REQUEST['GameDate'] == "" || $_REQUEST['GameDate'] == null) {
            $gamedate = " ";
        }
        else {
            $gamedate = $_REQUEST['GameDate'];
        }
        if ($_REQUEST['GameTime'] == "" || $_REQUEST['GameTime'] == null) {
            $gametime = " ";
        }
        else {
            $gametime = $_REQUEST['GameTime'];
        }
        if ($_REQUEST['GameHomeAway'] == "" || $_REQUEST['GameHomeAway'] == null) {
            $gamehomeaway = " ";
        }
        else {
            $gamehomeaway = $_REQUEST['GameHomeAway'];
        }
        if ($_REQUEST['gameid'] == "" || $_REQUEST['gameid'] == null) {
            $gameid = " ";
        }
        else {
            $gameid = $_REQUEST['gameid'];
        }
        if ($_REQUEST['GameCity'] == "" || $_REQUEST['GameCity'] == null) {
            $gamecity = " ";
        }
        else {
            $gamecity = $_REQUEST['GameCity'];
        }
        if ($_REQUEST['GameState'] == "" || $_REQUEST['GameState'] == null) {
            $gamestate = " ";
        }
        else {
            $gamestate = $_REQUEST['GameState'];
        }
        if ($_REQUEST['GameHomeScore'] == "" || $_REQUEST['GameHomeScore'] == null) {
            $homescore = " ";
        }
        else {
            $homescore = $_REQUEST['GameHomeScore'];
        }
        if ($_REQUEST['GameAwayScore'] == "" || $_REQUEST['GameAwayScore'] == null) {
            $awayscore = " ";
        }
        else {
            $awayscore = $_REQUEST['GameAwayScore'];
        }
        
    // To protect mysqli injection (more detail about mysqli injection)
    $gameopponent = stripslashes($gameopponent);
    $gamelocation = stripslashes($gamelocation);
    $fieldnum = stripslashes($fieldnum);
    $gamedate = stripslashes($gamedate);
    $gametime = stripslashes($gametime);
    $gamecity = stripslashes($gamecity);
    $gamestate = stripslashes($gamestate);
    $homescore = stripslashes($homescore);
    $awayscore = stripslashes($awayscore);

    $gameopponent = mysqli_real_escape_string($gameopponent);
    $gamelocation = mysqli_real_escape_string($gamelocation);
    $fieldnum = mysqli_real_escape_string($fieldnum);
    $gamedate = mysqli_real_escape_string($gamedate);
    $gametime = mysqli_real_escape_string($gametime);
    $gamecity = mysqli_real_escape_string($gamecity);
    $gamestate = mysqli_real_escape_string($gamestate);
    $homescore = mysqli_real_escape_string($homescore);
    $awayscore = mysqli_real_escape_string($awayscore);

    if ($gameid == "0") { 
        $sql="INSERT INTO $tbl_name (Opponent, Park, Date, Time, HomeAway, TeamID, City, State, HomeScore, AwayScore, EventType) VALUES ('$gameopponent', '$gamelocation', '$gamedate', '$gametime', '$gamehomeaway', '$teamid', '$gamecity', '$gamestate', '$homescore', '$awayscore', '$eventtype')";
        $result = mysqli_query($sql);
    }
    else {
        $sql="UPDATE $tbl_name SET City='$gamecity', State='$gamestate', Opponent='$gameopponent', Park='$gamelocation', Date='$gamedate', Time='$gametime', HomeAway='$gamehomeaway', HomeScore='$homescore', AwayScore='$awayscore', EventType='$eventtype' WHERE (GameID='$gameid')";
        $result = mysqli_query($sql);
    }
    
    
ob_end_flush();

?>