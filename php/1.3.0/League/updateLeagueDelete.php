<?php

ob_start();
require("constants.php");
$tbl_name="roster"; // Table name 

// Define SQL Variables
$userid = $_REQUEST['userid'];
$leagueid = $_REQUEST['leagueid'];

// Get Roster Number
$sql="SELECT RosterID, Manager FROM $tbl_name WHERE (UserID = '$userid') AND (LeagueID = '$leagueid') AND (Inactive != '1')";
$result=mysqli_query($sql);

$row = mysqli_fetch_assoc($result);

$rosterid = $row["RosterID"];
$manageID = $row["Manager"];

if ($manageID == "4") {

    // Get total number of managers
    $sql="SELECT Count(Manager) AS totalManagers FROM $tbl_name WHERE (Manager = '4') AND (LeagueID = '$leagueid') AND (Inactive != '1')";
    $result=mysqli_query($sql);
    $row = mysqli_fetch_assoc($result);

    $totalManagers = $row["totalManagers"];
    
    if ($totalManagers >= "2"){
        // Mark Player as inactive on Roster
        $sql="UPDATE $tbl_name SET Inactive='1' WHERE (RosterID='$rosterid')";
        $result = mysqli_query($sql);
        
    }
    else {
        
        // Mark Player as inactive on Roster
        $sql="UPDATE $tbl_name SET Inactive='1' WHERE (RosterID='$rosterid')";
        $result = mysqli_query($sql);
        
        // Mark Team as inactive
        $sql="UPDATE League SET Active='0', DeletedTimeStamp=now() WHERE (LeagueID='$leagueid')";
        $result = mysqli_query($sql);
    }
}
else {
    // Mark Player as inactive on Roster
    $sql="UPDATE $tbl_name SET Inactive='1' WHERE (RosterID='$rosterid')";
    $result = mysqli_query($sql);
}
echo "done";

ob_end_flush();

?>