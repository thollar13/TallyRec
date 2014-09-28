<?php

ob_start();
require("constants.php");
$tbl_name="myteams"; // Table name 


// Set Variable
$leagueid = $_REQUEST['leagueid'];
$leaguename = $_REQUEST['leaguename'];
$leaguesportid = $_REQUEST['leaguesportid'];
$userid = $_REQUEST['userid'];

// To protect mysqli injection
$leagueid = stripslashes($leagueid);
$leagueid = mysqli_real_escape_string($leagueid);
$leaguename = stripslashes($leaguename);
$leaguename = mysqli_real_escape_string($leaguename);
$leaguesportid = stripslashes($leaguesportid);
$leaguesportid = mysqli_real_escape_string($leaguesportid);
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);


/*
 *
 * Get My Teams
 *
 */
 
$sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid')";
$result=mysqli_query($sql);
$count=mysqli_num_rows($result);


$myteamid = array();
$myteammanagercode = array();
$myteamcount = 0;
$mychat = array();
$myfollow = array();
$mynote = array();

if ($count == 0) {
}
else {
    while ($row = mysqli_fetch_assoc($result)) {
    
        $myteamid[] = $row['teamid'];
        $myteammanagercode[] = $row['manager'];
        $mychat[] = $row['AcceptChat'];
        $myfollow[] = $row['AcceptFollowNote'];
        $mynote[] = $row['AcceptTeamNote'];
        
        $myteamcount++;
    }
}

$rosterdata = "";


/*
*
* Get Teams in League  
*
*/

$sql="SELECT DISTINCT(name), teamid, name, city, State, Park FROM $tbl_name WHERE (LeagueID = '$leagueid') ORDER BY Name ASC";
$result=mysqli_query($sql);
$count=mysqli_num_rows($result);

$rosterdata =  $rosterdata . "<ul data-role='listview' data-inset='true'>";
    $rosterdata =  $rosterdata . "<li data-role='list-divider'>";
        $rosterdata =  $rosterdata . "<div class='ui-grid-a'>";
            $rosterdata =  $rosterdata . "<div class='ui-block-a' style='text-align: left;'>League Roster</div>";
            $rosterdata =  $rosterdata . "<div class='ui-block-b' style='text-align: right;' id='leagueRosterCount'>League Total: 0</div>";
        $rosterdata =  $rosterdata . "</div>";
    $rosterdata =  $rosterdata . "</li>";


if ($count == 0) {
//Do Nothing
    $rosterdata =  $rosterdata . "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top' style='text-align: center;font-size: 8pt;'>";
    $rosterdata =  $rosterdata . "<table><tr><td>";
    $rosterdata =  $rosterdata . "No Teams Currently In League";
    $rosterdata =  $rosterdata . "</td></tr></table></li>";
} 
else {
//Get Team Info

    $teamid = array();
    $teamname = array();
    $teamcity = array();
    $teamstate = array();
    $teampark = array();
    $teammanagercode = array();
    $teamchat = array();
    $teamfollow = array();
    $teamnote = array();
    
    $totalteamcount = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
    
        $teamid[] = $row['teamid'];
        $teamname[] = $row['name'];
        $teamcity[] = $row['City'];
        $teamstate[] = $row['State'];
        $teampark[] = $row['Park'];
        
        if (in_array($row['teamid'], $myteamid)) {
        
            $key = array_search($row['teamid'], $myteamid);
            $teammanagercode[] = $myteammanagercode[$key];     
            $teamchat[] = $mychat[$key];
            $teamfollow[] = $myfollow[$key];
            $teamnote[] = $mynote[$key];
        }
        else {
            $teammanagercode[] = "no";
            $teamchat[] = "no";
            $teamfollow[] = "no";
            $teamnote[] = "no";
        }
        
        $totalteamcount++;
    }
    
    /*
     *
     * Get Team Rosters  
     *
     */
     
     $counter = 0;
     $rostertotalcount = 0;
     
     $infoteamid = array();
     $infoteamname = array();
     $inforosternumber = array();
     $inforostername = array();
     $inforostermanagercode = array();
     $inforosterteamcity = array();
     $inforosterteamstate = array();
     $inforosterteampark = array();
     $inforosterchat = array();
     $inforosterfollow = array();
     $inforosterteamnote = array();
     
     
     while ($counter<=$totalteamcount) {
     
        $sql="SELECT * FROM teamroster WHERE (TeamID = '$teamid[$counter]') AND (Inactive != '1') ORDER BY Name ASC";
        $result=mysqli_query($sql);
        
        while ($row = mysqli_fetch_assoc($result)) {
        
            $infoteamid[] = $teamid[$counter];
            $infoteamname[] = $teamname[$counter];
            $inforosterteamcity[] = $teamcity[$counter];
            $inforosterteamstate[] = $teamstate[$counter];
            $inforosterteampark[] = $teampark[$counter];
            
            $inforosterchat[] = $teamchat[$counter];
            $inforosterfollow[] = $teamfollow[$counter];
            $inforosterteamnote[] = $teamnote[$counter];
            
            $inforosternumber[] = $row['playernumber'];
            
            if ($row['nickname'] == "" || $row['nickname'] == null){
                $inforostername[] = $row['lname'] . ", " . $row['fname'];
            }
            else {
                $inforostername[] = $row['nickname'];
            }
            
            $inforostermanagercode[] = $teammanagercode[$counter];
        
            $rostertotalcount++;
        }
        
        
        $counter++;
     }
     
    /*
     *
     * Create Data Tables  
     *
     */
     
     
     $loop = 0;
     $lastteam = "";
     
     $rosterdata =  $rosterdata . "<li>";
     
     while ($loop<$rostertotalcount) {
     
        if ($infoteamname[$loop] != $lastteam) {
            if($loop>0){
                $rosterdata =  $rosterdata . "</div>";
            }
        
                $rosterdata =  $rosterdata . "<div data-role='collapsible' data-collapsed='true' data-inset='false' data-mini='true' data-theme='b' data-content-theme='d'>";
                $rosterdata =  $rosterdata . "<h3>" . htmlspecialchars($infoteamname[$loop], ENT_QUOTES) . "</h3>";
            
                // Link to team
                $rosterdata =  $rosterdata . "<p>";
                $rosterdata =  $rosterdata . "<table style='font-size:8pt;'><tr><td>";
                
                if ($inforostermanagercode[$loop] == "no") {
                }
                else {
                
                    $rosterdata =  $rosterdata . "<a data-teamid='" . htmlspecialchars($infoteamid[$loop], ENT_QUOTES) . "' data-teamname='" . htmlspecialchars($infoteamname[$loop], ENT_QUOTES) . "' data-manager='" . $inforostermanagercode[$loop] . "' data-city='" . htmlspecialchars($inforosterteamcity[$loop], ENT_QUOTES) . "' data-state='" . $inforosterteamstate[$loop] . "' data-park='" . htmlspecialchars($inforosterteampark[$loop], ENT_QUOTES) . "' data-sport='" . $leaguesportid . "' data-leagueid='" . $leagueid . "' data-league='" . $leaguename . "' data-teamnote='" . $inforosterteamnote[$loop] . "' data-chat='" . $inforosterchat[$loop] . "' data-followers='" . $inforosterfollow[$loop] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
                    $rosterdata =  $rosterdata . "Jump to Team</a>";                
                }
                    
                $rosterdata =  $rosterdata . "</td></tr></table>";
                $rosterdata =  $rosterdata . "</p>";
                
            $lastteam = $infoteamname[$loop];
        }
        
            $rosterdata =  $rosterdata . "<p>";
                $rosterdata =  $rosterdata . "<table style='font-size:8pt;'><tr><td>";
                $rosterdata =  $rosterdata . htmlspecialchars($inforosternumber[$loop], ENT_QUOTES);
                $rosterdata =  $rosterdata . "</td><td>";
                $rosterdata =  $rosterdata . htmlspecialchars($inforostername[$loop], ENT_QUOTES);
                $rosterdata =  $rosterdata . "</td></tr></table>";
            $rosterdata =  $rosterdata . "</p>";
        
        $loop++;
    }
}

$rosterdata =  $rosterdata . "</div></li>";

$rosterdata =  $rosterdata . "</ul>";

$rostertotalcount = "Total: " . $rostertotalcount;

$arr = array(
    'roster' => $rosterdata,
    'count' => $rostertotalcount
);

echo json_encode($arr);

ob_end_flush();


?>