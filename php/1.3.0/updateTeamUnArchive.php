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
$sql="SELECT RosterID FROM $tbl_name WHERE (UserID = '$userid') AND (TeamID = '$teamid') AND (Inactive != '1')";
$result=mysqli_query($sql);

$row = mysqli_fetch_assoc($result);

$rosterid = $row["RosterID"];

// Mark Player as archived on Roster
$sql="UPDATE $tbl_name SET Archived='0' WHERE (RosterID='$rosterid')";
$result = mysqli_query($sql);

ob_end_flush();

?>