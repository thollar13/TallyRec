<?php

ob_start();

require("../../../constants.php");
$tbl_name="myteams"; // Table name 

// Load  Variables
$username = $_REQUEST['username'];

$sql="SELECT * FROM $tbl_name WHERE (username = '$username') AND (Archived != '1') AND ( manager = '2') ORDER BY name ASC";
$result = $dbh->prepare($sql);  
$result->execute();  
// mysqli_num_row is counting table row
$count=$result->rowCount();

echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider' data-role='button' data-icon='search' data-iconpos='notext'>Following</li>";
    echo "<li data-icon='search'><a href='#search'>Search for teams to follow...</a></li>";

// Get SQL Results
while ($row = $result->fetch()) {
    
    echo "<li>";
    
    echo "<a data-teamid='" . $row["teamid"] . "' data-leagueid='" . $row["LeagueID"] . "' data-teamname='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-teamnote='" . $row["AcceptTeamNote"] . "' data-chat='" . $row["AcceptChat"] . "' data-sport='" . $row["SportID"] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
    
    //Set Sport Image
    echo "<img src='images/sport/" . $row["SportID"] . ".png' alt='' class='ui-li-icon' />";
        
    echo $row["name"];
        
    echo "</a>";
    echo "</li>";
 
}
if($count=="0"){
}
echo "</ul>";

ob_end_flush();

?>