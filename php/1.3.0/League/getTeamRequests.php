<?php

ob_start();

require("constants.php");
$tbl_name="teams"; // Table name 

// Load  Variables
$leagueid = $_REQUEST['leagueid'];

$sql="SELECT * FROM $tbl_name WHERE (LeagueRequest = '$leagueid') AND (Inactive != '1') ORDER BY Name ASC";
$result = mysqli_query($sql);    
// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider'>Teams Requesting to Join League</li>";

if($count==0){
    echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top' style='text-align: center;font-size: 8pt;'>";
        echo "No Requests";
    echo "</li>";
}
else {

    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {
        
        echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top' style='text-align: center;font-size: 8pt;'>";
        
        echo $row["Name"];

        echo "</li>"; 
    }
}

echo "</ul>";

ob_end_flush();

?>