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

$sql="SELECT * FROM $tbl_name WHERE (username = '$username') AND (Archived != '1') AND ( manager = '2') ORDER BY name ASC";
$result = mysqli_query($sql);    
// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider' data-role='button' data-icon='search' data-iconpos='notext'>Following</li>";
    echo "<li data-icon='search'><a href='#search'>Search for teams to follow...</a></li>";

// Get SQL Results
while ($row = mysqli_fetch_assoc($result)) {
    
    echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
    
    echo "<a data-teamid='" . $row["teamid"] . "' data-teamname='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-teamnote='" . $row["AcceptTeamNote"] . "' data-chat='" . $row["AcceptChat"] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
    
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