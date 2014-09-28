<?php

ob_start();

$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="myteams"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Load  Variables
$username = $_REQUEST['username'];

$myTeams = "";
$followingTeams = "";
$archivedTeams = "";

/*
 *
 * Get My Teams
 *
 */

            $sql="SELECT * FROM $tbl_name WHERE (username = '$username') AND (Archived != '1') AND (manager != '2') AND (manager != '3') ORDER BY name ASC";
            $result = mysqli_query($sql);    
            $count=mysqli_num_rows($result);

            $myTeams = "<ul data-role='listview' data-inset='true'>";
            $myTeams = $myTeams . "<li data-role='list-divider'>My Teams</li>";

            if($count==0){
                $myTeams = $myTeams . "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
                $myTeams = $myTeams . "None";
                $myTeams = $myTeams . "</li>";
            }
            else {

                while ($row = mysqli_fetch_assoc($result)) {
    
                    $myTeams = $myTeams . "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
    
                    $myTeams = $myTeams . "<a data-teamid='" . $row["teamid"] . "' data-teamname='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-city='" . htmlspecialchars($row["City"], ENT_QUOTES) . "' data-state='" . $row["State"] . "' data-park='" . htmlspecialchars($row["Park"], ENT_QUOTES) . "' data-sport='" . $row["SportID"] . "' data-league='" . htmlspecialchars($row["League"], ENT_QUOTES) . "' data-teamnote='" . $row["AcceptTeamNote"] . "' data-chat='" . $row["AcceptChat"] . "' data-followers='" . $row["AcceptFollowNote"] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
                    $myTeams = $myTeams . "<img src='images/sport/" . $row["SportID"] . ".png' alt='' class='ui-li-icon' />";                
    
                    $myTeams = $myTeams . $row["name"];

                    $myTeams = $myTeams . "</a>";
                    $myTeams = $myTeams . "</li>"; 
                }
            }

            $myTeams = $myTeams . "</ul>";

/*
*
* Get Following Teams
*
*/


            $sql="SELECT * FROM $tbl_name WHERE (username = '$username') AND (Archived != '1') AND ( manager = '2') ORDER BY name ASC";
            $result = mysqli_query($sql);    
            // mysqli_num_row is counting table row
            $count=mysqli_num_rows($result);

            $followingTeams = $followingTeams . "<ul data-role='listview' data-inset='true'>";
            $followingTeams = $followingTeams . "<li data-role='list-divider' data-role='button' data-icon='search' data-iconpos='notext'>Following</li>";
            $followingTeams = $followingTeams . "<li data-icon='search'><a href='#search'>Search for teams to follow...</a></li>";

            // Get SQL Results
            while ($row = mysqli_fetch_assoc($result)) {
                
                $followingTeams = $followingTeams . "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
                
                $followingTeams = $followingTeams . "<a data-teamid='" . $row["teamid"] . "' data-teamname='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-teamnote='" . $row["AcceptTeamNote"] . "' data-chat='" . $row["AcceptChat"] . "' data-sport='" . $row["SportID"] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
                
                //Set Sport Image
                $followingTeams = $followingTeams . "<img src='images/sport/" . $row["SportID"] . ".png' alt='' class='ui-li-icon' />";
                
                $followingTeams = $followingTeams . $row["name"];
                
                $followingTeams = $followingTeams . "</a>";
                $followingTeams = $followingTeams . "</li>";
                
            }
            if($count=="0"){
            }
            $followingTeams = $followingTeams . "</ul>";

            
/*
 *
 * Get Archived Teams
 *
 */
 
 
            $sql="SELECT * FROM $tbl_name WHERE (username = '$username') AND (Archived = '1') AND ( manager != '3') ORDER BY name ASC";
            $result = mysqli_query($sql);    
            // mysqli_num_row is counting table row
            $count=mysqli_num_rows($result);

            
            if($count==0){
                //No past teams
            }
            else {
                $archivedTeams = $archivedTeams . "<ul data-role='listview' data-inset='true'>";
                $archivedTeams = $archivedTeams . "<li data-role='list-divider'>Past Teams</li>";

                // Get SQL Results
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    $archivedTeams = $archivedTeams . "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
                    
                    $archivedTeams = $archivedTeams . "<a data-teamid='" . $row["teamid"] . "' data-teamname='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-city='" . htmlspecialchars($row["City"], ENT_QUOTES) . "' data-state='" . $row["State"] . "' data-park='" . htmlspecialchars($row["Park"], ENT_QUOTES) . "' data-sport='" . $row["SportID"] . "' data-league='" . htmlspecialchars($row["League"], ENT_QUOTES) . "' data-teamnote='" . $row["AcceptTeamNote"] . "' data-chat='" . $row["AcceptChat"] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
                    
                    //Set Sport Image
                    $archivedTeams = $archivedTeams . "<img src='images/sport/" . $row["SportID"] . ".png' alt='' class='ui-li-icon' />";
                    
                    $archivedTeams = $archivedTeams . $row["name"];
                    
                    $archivedTeams = $archivedTeams . "</a>";
                    $archivedTeams = $archivedTeams . "</li>";     
                }
                
                $archivedTeams = $archivedTeams . "</ul>";
            }   
 

//Create Array
$arr = array(
    'myTeams' => $myTeams,
    'followingTeams' => $followingTeams,
    'archivedTeams' => $archivedTeams
);

echo json_encode($arr);

ob_end_flush();

?>