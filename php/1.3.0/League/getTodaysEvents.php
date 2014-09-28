<?php

ob_start();
require("constants.php");
$tbl_name="scheduleall"; // Table name 

// Load  Variables
$leagueid = $_REQUEST['leagueid'];

$today = date("Y-m-d");

$sql="SELECT * FROM $tbl_name WHERE (Inactive != '1') AND (leagueid = '$leagueid') AND (Date = '$today') ORDER BY Date ASC, TIME ASC";
$result = mysqli_query($sql);    

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

// No games on Schedule
if($count==0){
    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider' style='text-align: center; font-size: 8pt;'>Today's Events</li>";
        echo "<li style='text-align: center; font-size: 8pt;'>No Events</li>";
    echo "</ul>";
}
else{
    echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider' style='text-align: center; font-size: 8pt;'>Today's Events</li>";
    
    $counter = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
    
        if ($counter<3) {
            if ($row['EventType']=="1"){
                echo "<li style='text-align: center; font-size: 8pt;'>" . $row['AwayTeam'] . ": " . $row['HomeTeam'] . "<br/>" . $row['Time'] . "</li>";
            }
            else if ($row['EventType']=="2"){
                echo "<li style='text-align: center; font-size: 8pt;'>" . $row['AwayTeam'] . ": " . $row['HomeTeam'] . "<br/>" . $row['Time'] .  "</li>";
            }
            else {
                echo "<li style='text-align: center; font-size: 8pt;'>" . $row['AwayTeam'] . " @ " . $row['HomeTeam'] . "<br/>" . $row['Time'] .  "</li>";
            }
        }
        else if ($counter==3) {
                echo "<li style='text-align: center; font-size: 8pt;'><a href='#leagueSchedule' style='text-decoration:none;color:#fff;font-size:8pt;'>See Schedule For All Events</a></li>";
        }
        else {
        }
        
        $counter++;
    }
   
}

ob_end_flush();

?>