<?php

ob_start();

require("../../../constants.php");
$tbl_name="myteams"; // Table name 

// Load  Variables
$username = $_REQUEST['username'];
$userid = $_REQUEST['userid'];

//Protect From SQL Injection
// $username = stripslashes($username);
// $username = mysqli_real_escape_string($username);
// $userid = stripslashes($userid);
// $userid = mysqli_real_escape_string($userid);


$myTeamID = array();
$myTeamName = array();
$myTeamManager = array();
$myTeamCity = array();
$myTeamState = array();
$myTeamPark = array();
$myTeamSport = array();
$myTeamLeague = array();
$myTeamLeagueID = array();
$myTeamNote = array();
$myTeamChat = array();
$myTeamFollow = array();
$myTeamRecord = array();


/*
 *
 * Get My Teams
 *
 */

$sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (Archived != '1') ORDER BY name ASC";
$result = $dbh->query($sql);    
$count=$result->rowCount();;


if($count==0){
    //No Teams

}
else {
    //Teams Found
    
    /*
     *
     *   Get Team Information
     *
     */
    
    $numberOfTeams;

    while ($row = mysqli_fetch_assoc($result)) {
        
        $myTeamID[] = $row['teamid'];
        $myTeamName[] = htmlspecialchars($row['name'], ENT_QUOTES);
        $myTeamManager[] = $row['manager'];
        $myTeamCity[] = htmlspecialchars($row['City'], ENT_QUOTES);
        $myTeamState[] = htmlspecialchars($row['State'], ENT_QUOTES);
        $myTeamPark[] = htmlspecialchars($row['Park'], ENT_QUOTES);
        $myTeamSport[] = $row['SportID'];
        $myTeamLeague[] = htmlspecialchars($row['League'], ENT_QUOTES);
        $myTeamLeagueID[] = $row['LeagueID'];
        $myTeamNote[] = $row['AcceptTeamNote'];
        $myTeamChat[] = $row['AcceptChat'];
        $myTeamFollow[] = $row['AcceptFollowNote'];
        
        $numberOfTeams++;
    }
    
    /*
     *
     *  Get Team Record
     *
     */
    
    $loop = 0;
    
    while ($loop<$numberOfTeams) {
        
        $sql="SELECT * FROM schedule WHERE (teamid = '$myTeamID[$loop]') AND (Inactive != '1')";
        $result = mysqli_query($sql);    

        // mysqli_num_row is counting table row
        $count=mysqli_num_rows($result);

        $win = 0;
        $loss = 0;
        $tie = 0;

        // No games on Schedule
        if($count==0){
            $myTeamRecord[$loop] = "0-0-0";
        }
        else{
            while ($row = mysqli_fetch_assoc($result)) {

                // Determine if Win, Loss, Tie
                // Home
                if($row["HomeAway"] == "1"){
                    if ($row["HomeScore"]>$row["AwayScore"]){
                        $win =  $win + 1;
                    } elseif ($row["HomeScore"]<$row["AwayScore"]){
                        $loss =  $loss + 1;
                    } else {
                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                        }
                        else{
                            $tie =  $tie + 1;
                        }
                    }   
                }
                // Away
                else{
                    if ($row["HomeScore"]<$row["AwayScore"]){
                        $win =  $win + 1;
                    } elseif ($row["HomeScore"]>$row["AwayScore"]){
                        $loss =  $loss + 1;
                    } else {
                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                        }
                        else{
                            $tie =  $tie + 1;
                        }
                    }
                }
            }
            
            $myTeamRecord[$loop] = $win . "-" . $loss . "-" . $tie;
        }
        
        $loop++;
    }
    
    /*
     *
     *  Display Teams 
     *
     */
    
    $myTeams = "";
    $followingTeams = "";
    
    $loop = 0;
    $myteamscount = 0;
    $followteamscount = 0;
    
    $start = 1;
    
    // Get SQL Results
    while ($loop<$numberOfTeams) {
        
        if ($myTeamManager[$loop] == "0" || $myTeamManager[$loop] == "1") {
        
            if ($myteamscount == 0) {
                $myTeams = $myTeams . "<ul data-role='listview'><li data-role='list-divider'>My Teams</li>";
            }
            
            $myTeams = $myTeams . "<li>";

            $myTeams = $myTeams . "<a data-teamid='" . $myTeamID[$loop] . "' data-teamname='" . $myTeamName[$loop] . "' data-manager='" . $myTeamManager[$loop] . "' data-city='" . $myTeamCity[$loop] . "' data-state='" . $myTeamState[$loop] . "' data-park='" . $myTeamPark[$loop] . "' data-sport='" . $myTeamSport[$loop] . "'";
            if (strlen($myTeamLeagueID[$loop]) >= 1) {
                $myTeams = $myTeams . "data-leagueid='" . $myTeamLeagueID[$loop] . "' ";
            }
            $myTeams = $myTeams . "data-league='" . $myTeamLeague[$loop] . "' data-teamnote='" . $myTeamNote[$loop] . "' data-chat='" . $myTeamChat[$loop] . "' data-followers='" . $myTeamFollow[$loop] . "' data-archived='no' class='createteamlink'>";
            
            $myTeams = $myTeams . "<img src='images/sport/" . $myTeamSport[$loop] . ".png' alt='' class='ui-li-icon' />" . $myTeamName[$loop] . "</a>";
            $myTeams = $myTeams . "</li>";
            
            $myteamscount++;
        }
        
        else if ($myTeamManager[$loop] == "2") {
        
            if ($followteamscount == 0) {
                $followingTeams = $followingTeams . "<ul data-role='listview'><li data-role='list-divider'>Following</li>";
            }

            $followingTeams = $followingTeams . "<li>";
            
            $followingTeams = $followingTeams . "<a data-teamid='" . $myTeamID[$loop] . "' data-teamname='" . $myTeamName[$loop] . "' data-manager='" . $myTeamManager[$loop] . "' data-city='" . $myTeamCity[$loop] . "' data-state='" . $myTeamState[$loop] . "' data-park='" . $myTeamPark[$loop] . "' data-sport='" . $myTeamSport[$loop] . "'";
            if (strlen($myTeamLeagueID[$loop]) >= 1) {
                $followingTeams = $followingTeams . "data-leagueid='" . $myTeamLeagueID[$loop] . "' ";
            }
            $followingTeams = $followingTeams . "data-league='" . $myTeamLeague[$loop] . "' data-teamnote='" . $myTeamNote[$loop] . "' data-chat='" . $myTeamChat[$loop] . "' data-followers='" . $myTeamFollow[$loop] . "' data-archived='no' class='createteamlink'>";
            
            
            $followingTeams = $followingTeams . "<img src='images/sport/" . $myTeamSport[$loop] . ".png' alt='' class='ui-li-icon' />";                
            
            $followingTeams = $followingTeams . $myTeamName[$loop];

            $followingTeams = $followingTeams . "</a>";
            $followingTeams = $followingTeams . "</li>";
            
            $followteamscount++;
        }
        
        $loop++;
    }
    
    
    $myTeams = $myTeams . "</ul>";
    $followingTeams = $followingTeams . "</ul>";
    
}



//Create Array
$arr = array(
    'myTeams' => $myTeams,
    'followingTeams' => $followingTeams
);

echo json_encode($arr);

ob_end_flush();

?>