<?php

ob_start();
require("constants.php");
$tbl_name="roster"; // Table name 

// Define SQL Variables
$userid = $_REQUEST['userid'];
$leagueid = $_REQUEST['leagueid'];

// Get Roster Number
$sql="SELECT RosterID FROM $tbl_name WHERE (UserID = '$userid') AND (LeagueID = '$leagueid') AND (Inactive != '1')";
$result=mysqli_query($sql);

$row = mysqli_fetch_assoc($result);

$rosterid = $row["RosterID"];

// Mark Player as archived on Roster
$sql="UPDATE $tbl_name SET Archived='1' WHERE (RosterID='$rosterid')";
$result = mysqli_query($sql);

ob_end_flush();

?>