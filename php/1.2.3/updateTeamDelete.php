<?php

ob_start();
$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="roster"; // Table name 


// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Define SQL Variables
$userid = $_REQUEST['userid'];
$teamid = $_REQUEST['teamid'];

// Get Roster Number
$sql="SELECT RosterID, Manager FROM $tbl_name WHERE (UserID = '$userid') AND (TeamID = '$teamid') AND (Inactive != '1')";
$result=mysqli_query($sql);

$row = mysqli_fetch_assoc($result);

$rosterid = $row["RosterID"];
$manageID = $row["Manager"];

if ($manageID == "1") {

    // Get total number of managers
    $sql="SELECT Count(Manager) AS totalManagers FROM $tbl_name WHERE (Manager = '1') AND (TeamID = '$teamid') AND (Inactive != '1')";
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
        $sql="UPDATE Team SET Inactive='1', DeleteTimeStamp=now() WHERE (TeamID='$teamid')";
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