<?php

ob_start();
require("constants.php");
$tbl_name="teamroster"; // Table name 

// Load  Variables
$teamid = $_REQUEST['teamid'];

$sql="SELECT * FROM $tbl_name WHERE (teamid = '$teamid') AND (Inactive != '1') AND (manager != '2')";
$result = mysqli_query($sql);    
$counter = 0;

// Get SQL Results
while ($row = mysqli_fetch_assoc($result)) {    
    $counter++;     
}   

echo "Players: " . $counter;

ob_end_flush();

?>