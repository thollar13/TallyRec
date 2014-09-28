<?php

ob_start();

require("constants.php");
$tbl_name="roster"; // Table name 

// Define Variables
$userid = $_REQUEST['userid'];
$teamid = $_REQUEST['teamid'];

// To protect mysqli injection (more detail about mysqli injection)
$userid = stripslashes($userid);
$teamid = stripslashes($teamid);

$userid = mysqli_real_escape_string($userid);
$teamid = mysqli_real_escape_string($teamid);

$sql="SELECT * FROM roster where (teamid = '$teamid') AND (UserID = '$userid') AND (Inactive != '1') LIMIT 1;";
$result=mysqli_query($sql);

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

$rosterid = $row['RosterID'];
$manageID = $row['Manager'];

if($count==0){

    // Create Roster Spot
    $sql="INSERT INTO $tbl_name (TeamID, UserID, Manager) VALUES ('$teamid','$userid', '3')";
    $result=mysqli_query($sql);

}
else {
// Update Roster

    if ($manageID == "2") {
        $sql="UPDATE roster SET Manager='0', Archived='0' WHERE (RosterID='$rosterid')";
        $result = mysqli_query($sql);
    }

}
echo "Success";

ob_end_flush();

?>