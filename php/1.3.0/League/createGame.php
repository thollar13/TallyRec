<?php

ob_start();

require("constants.php");
$tbl_name="game"; // Table name 

// Define Variables
$leagueid = $_REQUEST['leagueid'];
$hometeamid = $_REQUEST['hometeamid'];
$hometeamname = $_REQUEST['hometeamname'];
$awayteamid = $_REQUEST['awayteamid'];
$awayteamname = $_REQUEST['awayteamname'];
$eventtype = $_REQUEST['eventtype'];
$gamelocation = $_REQUEST['gamelocation'];
$gamedate = $_REQUEST['gamedate'];
$gametime = $_REQUEST['gametime'];
$gameid = $_REQUEST['gameid'];
$gamecity = $_REQUEST['gamecity'];
$gamestate = $_REQUEST['gamestate'];
$homescore = $_REQUEST['homescore'];
$awayscore = $_REQUEST['awayscore'];


// To protect mysqli injection (more detail about mysqli injection)
$leagueid = stripslashes($leagueid);
$hometeamid = stripslashes($hometeamid);
$hometeamname = stripslashes($hometeamname);
$awayteamid = stripslashes($awayteamid);
$awayteamname = stripslashes($awayteamname);
$eventtype = stripslashes($eventtype);
$gamelocation = stripslashes($gamelocation);
$fieldnum = stripslashes($fieldnum);
$gamedate = stripslashes($gamedate);
$gametime = stripslashes($gametime);
$gamecity = stripslashes($gamecity);
$gamestate = stripslashes($gamestate);
$homescore = stripslashes($homescore);
$awayscore = stripslashes($awayscore);

$leagueid = mysqli_real_escape_string($leagueid);
$hometeamid = mysqli_real_escape_string($hometeamid);
$hometeamname = mysqli_real_escape_string($hometeamname);
$awayteamid = mysqli_real_escape_string($awayteamid);
$awayteamname = mysqli_real_escape_string($awayteamname);
$eventtype = mysqli_real_escape_string($eventtype);
$gamelocation = mysqli_real_escape_string($gamelocation);
$fieldnum = mysqli_real_escape_string($fieldnum);
$gamedate = mysqli_real_escape_string($gamedate);
$gametime = mysqli_real_escape_string($gametime);
$gamecity = mysqli_real_escape_string($gamecity);
$gamestate = mysqli_real_escape_string($gamestate);
$homescore = mysqli_real_escape_string($homescore);
$awayscore = mysqli_real_escape_string($awayscore);

if ($gameid == "0") { 

    $sql="INSERT INTO $tbl_name (HomeTeamID, HomeTeam, AwayTeamID, AwayTeam, LeagueID, Park, Date, Time, City, State, HomeScore, AwayScore, EventType) VALUES ('$hometeamid','$hometeamname', '$awayteamid','$awayteamname', '$leagueid', '$gamelocation', '$gamedate', '$gametime', '$gamecity', '$gamestate', '$homescore', '$awayscore', '$eventtype')";
    $result = mysqli_query($sql);
    
}
else {
    
    //Home Team
    $sql="UPDATE $tbl_name SET HomeTeamID='$hometeamid', HomeTeam='$hometeamname', AwayTeamID='$awayteamid', AwayTeam='$awayteamname', City='$gamecity', State='$gamestate', Park='$gamelocation', Date='$gamedate', Time='$gametime', HomeScore='$homescore', AwayScore='$awayscore', EventType='$eventtype' WHERE (GameID='$gameid')";
    $result = mysqli_query($sql);
    
}

echo "Success";

ob_end_flush();

?>