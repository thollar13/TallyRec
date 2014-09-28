<?php

ob_start();
require("constants.php");
$tbl_name="league"; // Table name 

// Set Variable
$userid = $_REQUEST['userid'];
$name = $_REQUEST['name'];
$sport = $_REQUEST['sport'];
$division = $_REQUEST['division'];
$state = $_REQUEST['state'];
$city = $_REQUEST['city'];
$park = $_REQUEST['park'];
$season = $_REQUEST['season'];
$year = $_REQUEST['year'];

// To protect mysqli injection
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);
$name = stripslashes($name);
$name = mysqli_real_escape_string($name);
$sport = stripslashes($sport);
$sport = mysqli_real_escape_string($sport);
$division = stripslashes($division);
$division = mysqli_real_escape_string($division);
$state = stripslashes($state);
$state = mysqli_real_escape_string($state);
$city = stripslashes($city);
$city = mysqli_real_escape_string($city);
$park = stripslashes($park);
$park = mysqli_real_escape_string($park);
$season = stripslashes($season);
$season = mysqli_real_escape_string($season);
$year = stripslashes($year);
$year = mysqli_real_escape_string($year);


// Create Team
$sql="INSERT INTO $tbl_name (Name, SportID, Division, City, State, Park, Year, Season, Active, CreatedTimeStamp) VALUES ('$name','$sport', '$division', '$city', '$state', '$park', '$year', '$season', '1', now())";
$result=mysqli_query($sql);

// Get TeamID    
$sql="SELECT LeagueID FROM $tbl_name WHERE (Name = '$name') AND (SportID ='$sport') AND (State ='$state') AND (City ='$city') AND (Park ='$park') ORDER BY CreatedTimeStamp DESC LIMIT 1";
$result=mysqli_query($sql);
$row = mysqli_fetch_assoc($result);
$leagueid = $row['LeagueID'];

// Create Roster
$tbl_name="roster"; // Table name 
$sql="INSERT INTO $tbl_name (LeagueID, UserID, Manager) VALUES ('$leagueid','$userid', '4')";
$result=mysqli_query($sql);

//echo "Success";
echo "Success";

ob_end_flush();

?>