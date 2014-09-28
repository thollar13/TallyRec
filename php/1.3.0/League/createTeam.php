<?php

ob_start();
require("constants.php");
$tbl_name="team"; // Table name 

// Set Variable
$userid = $_REQUEST['userid'];
$teamname = $_REQUEST['teamname'];
$sport = $_REQUEST['sport'];
$state = $_REQUEST['state'];
$city = $_REQUEST['city'];
$park = $_REQUEST['park'];
$league = $_REQUEST['league'];
$leagueid = $_REQUEST['leagueid'];

// To protect mysqli injection
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);
$teamname = stripslashes($teamname);
$teamname = mysqli_real_escape_string($teamname);
$sport = stripslashes($sport);
$sport = mysqli_real_escape_string($sport);
$state = stripslashes($state);
$state = mysqli_real_escape_string($state);
$city = stripslashes($city);
$city = mysqli_real_escape_string($city);
$park = stripslashes($park);
$park = mysqli_real_escape_string($park);
$league = stripslashes($league);
$league = mysqli_real_escape_string($league);
$leagueid = stripslashes($leagueid);
$leagueid = mysqli_real_escape_string($leagueid);

// Create Team
$sql="INSERT INTO $tbl_name (Name, SportID, State, City, Park, LeagueID, League, TimeStamp) VALUES ('$teamname','$sport', '$state', '$city', '$park', '$leagueid', '$league', now())";
$result=mysqli_query($sql);

// Get TeamID    
$sql="SELECT TeamID FROM $tbl_name WHERE (Name = '$teamname') AND (SportID ='$sport') AND (State ='$state') AND (City ='$city') AND (Park ='$park') AND (League ='$league') ORDER BY TimeStamp DESC LIMIT 1";
$result=mysqli_query($sql);
$row = mysqli_fetch_assoc($result);
$teamid = $row['TeamID'];

// Create Roster
$tbl_name="roster"; // Table name 
$sql="INSERT INTO $tbl_name (TeamID, UserID, Manager) VALUES ('$teamid','$userid', '4')";
$result=mysqli_query($sql);

echo "Success";

ob_end_flush();

?>