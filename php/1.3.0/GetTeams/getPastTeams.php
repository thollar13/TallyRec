<?php

ob_start();

require("../../../constants.php");
$tbl_name="myteams"; // Table name 

// Load  Variables
$username=$_REQUEST['username'];
$userid=$_REQUEST['userid'];

//Protect From SQL Injection
$username = stripslashes($username);
// $username = mysqli_real_escape_string($username);
$userid = stripslashes($userid);
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

$sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (Archived = '1') ORDER BY name ASC";
$result = $dbh->prepare($sql);    
$result->execute();
$count=$result->rowCount();


if($count==0){
    //No Teams
    
    $myTeams = $myTeams . "<ul data-role='listview' data-inset='true'><li data-role='list-divider'>My Past Teams</li>";
    $myTeams = $myTeams . "<li style='font-size:8pt;'>No Past Teams At This Time</li>";     
    $myTeams = $myTeams . "</ul>";

}
else {
    //Teams Found
    
    /*
     *
     *   Get Team Information
     *
     */
    
    $numberOfTeams;

    while ($row = $result->rowCount()) {
        
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
        $result = $dbh->prepare($sql);    
        $result->execute();

        // mysqli_num_row is counting table row
        $count=($result->rowCount());

        $win = 0;
        $loss = 0;
        $tie = 0;

        // No games on Schedule
        if($count==0){
            $myTeamRecord[$loop] = "0-0-0";
        }
        else{
            while ($row = $result->rowCount()) {

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
    
    $loop = 0;
    $myteamscount = 0;
    
    $start = 1;
    
    $myTeams = $myTeams . "<ul data-role='listview' data-inset='true'><li data-role='list-divider'>My Past Teams</li>";
    
    // Get SQL Results
    while ($loop<$numberOfTeams) {
            
        $myTeams = $myTeams . "<li class='ui-icon-nodisc'>";

        $myTeams = $myTeams . "<a data-teamid='" . $myTeamID[$loop] . "' data-teamname='" . $myTeamName[$loop] . "' data-manager='" . $myTeamManager[$loop] . "' data-city='" . $myTeamCity[$loop] . "' data-state='" . $myTeamState[$loop] . "' data-park='" . $myTeamPark[$loop] . "' data-sport='" . $myTeamSport[$loop] . "'";
        if (strlen($myTeamLeagueID[$loop]) >= 1) {
            $myTeams = $myTeams . "data-leagueid='" . $myTeamLeagueID[$loop] . "' ";
        }
        $myTeams = $myTeams . "data-league='" . $myTeamLeague[$loop] . "' data-teamnote='" . $myTeamNote[$loop] . "' data-chat='" . $myTeamChat[$loop] . "' data-followers='" . $myTeamFollow[$loop] . "' data-archived='yes' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
        
        $myTeams = $myTeams . "<img src='images/sport/" . $myTeamSport[$loop] . ".png' alt='' class='ui-li-icon' />";                
        
        $myTeams = $myTeams . $myTeamName[$loop];
        
        if ($myTeamSport[$loop] == "16"){
        }
        else {
            $myTeams = $myTeams . "<span style='font-size: 8pt;'> &nbsp; " . $myTeamRecord[$loop] . "</span>";
        }
        
        $myTeams = $myTeams . "<span style='font-size:8pt;'><br/>";
        if ($myTeamPark[$loop] == "-") {
        }
        else {
            $myTeams = $myTeams . $myTeamPark[$loop] . " - ";
        }
        $myTeams = $myTeams . $myTeamCity[$loop] . ", " . $myTeamState[$loop];
        
        
        $myTeams = $myTeams . "</span>";
        
        $myTeams = $myTeams . "</a>";
        $myTeams = $myTeams . "</li>";
            
            $myteamscount++;
        
        $loop++;
    }
    
    if($myteamscount == "0"){
        $myTeams = $myTeams . "<li>None</li>";
    }
    
    $myTeams = $myTeams . "</ul>";
    
}



//Create Array
$arr = array(
    'myPastTeams' => $myTeams,
);

echo json_encode($arr);

ob_end_flush();

?>