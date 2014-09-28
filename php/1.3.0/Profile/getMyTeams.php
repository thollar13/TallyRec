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
$result = $dbh->prepare($sql);    
$result->execute();
$count=$result->rowCount();


if($count==0){
//No Teams

    $followingTeams = "";
    
    $followingTeams = $followingTeams . "<ul data-role='listview' data-inset='true'><li data-role='list-divider'>Following</li><li data-icon='search'><a href='#search'>Search for teams to follow...</a></li></ul>";

}
else {
//Teams Found
    
    /*
    *
    *   Get Team Information
    *
    */
    
    $numberOfTeams;

    while ($row = $result->fetch()) {
        
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
         
            $myTeams = $myTeams . "<ul data-role='listview' data-inset='true'><li data-role='list-divider'>My Teams</li>";
            $followingTeams = $followingTeams . "<ul data-role='listview' data-inset='true'><li data-role='list-divider'>Following</li><li data-icon='search'><a href='#search'>Search for teams to follow...</a></li>";
         
            $loop = 0;
            $myteamscount = 0;
            $followteamscount = 0;
            
             // Get SQL Results
             while ($loop<$numberOfTeams) {
             
                 if ($myTeamManager[$loop] == "0" || $myTeamManager[$loop] == "1") {
                 
                     $myTeams = $myTeams . "<li class='ui-icon-nodisc'>";

                     $myTeams = $myTeams . "<a data-teamid='" . $myTeamID[$loop] . "' data-teamname='" . $myTeamName[$loop] . "' data-manager='" . $myTeamManager[$loop] . "' data-city='" . $myTeamCity[$loop] . "' data-state='" . $myTeamState[$loop] . "' data-park='" . $myTeamPark[$loop] . "' data-sport='" . $myTeamSport[$loop] . "'";
                     if (strlen($myTeamLeagueID[$loop]) >= 1) {
                         $myTeams = $myTeams . "data-leagueid='" . $myTeamLeagueID[$loop] . "' ";
                     }
                     $myTeams = $myTeams . "data-league='" . $myTeamLeague[$loop] . "' data-teamnote='" . $myTeamNote[$loop] . "' data-chat='" . $myTeamChat[$loop] . "' data-followers='" . $myTeamFollow[$loop] . "' data-archived='no' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
                     
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
                }
                
                 else if ($myTeamManager[$loop] == "2") {

                     $followingTeams = $followingTeams . "<li>";

                     $followingTeams = $followingTeams . "<a data-teamid='" . $myTeamID[$loop] . "' data-teamname='" . $myTeamName[$loop] . "' data-manager='" . $myTeamManager[$loop] . "' data-city='" . $myTeamCity[$loop] . "' data-state='" . $myTeamState[$loop] . "' data-park='" . $myTeamPark[$loop] . "' data-sport='" . $myTeamSport[$loop] . "'";
                     if (strlen($myTeamLeagueID[$loop]) >= 1) {
                         $followingTeams = $followingTeams . "data-leagueid='" . $myTeamLeagueID[$loop] . "' ";
                     }
                     $followingTeams = $followingTeams . "data-league='" . $myTeamLeague[$loop] . "' data-teamnote='" . $myTeamNote[$loop] . "' data-chat='" . $myTeamChat[$loop] . "' data-followers='" . $myTeamFollow[$loop] . "' data-archived='no' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
                     
                     $followingTeams = $followingTeams . "<img src='images/sport/" . $myTeamSport[$loop] . ".png' alt='' class='ui-li-icon' />";                
                     
                     $followingTeams = $followingTeams . $myTeamName[$loop];

                     $followingTeams = $followingTeams . "</a>";
                     $followingTeams = $followingTeams . "</li>";
                     
                     $followteamscount++;
                 }
                 
                $loop++;
             }
             
             if($myteamscount == 0){
                 $myTeams = $myTeams . "<li style='font-size: 10pt;'>No Teams</li>";
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