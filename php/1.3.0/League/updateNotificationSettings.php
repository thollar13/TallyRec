<?php

ob_start();

require("constants.php");
$tbl_name="roster"; // Table name 

// Define $myusername and $mypassword from form
$leaguenote = $_REQUEST['leaguenote'];
$leaguechat = $_REQUEST['leaguechat'];
$leaguefollowers = $_REQUEST['leaguefollowers'];
$userid = $_REQUEST['userid'];
$leagueid = $_REQUEST['leagueid'];

// To protect mysqli injection (more detail about mysqli injection)
$leaguenote = stripslashes($leaguenote);
$leaguenote = mysqli_real_escape_string($leaguenote);
$leaguechat = stripslashes($leaguechat);
$leaguechat = mysqli_real_escape_string($leaguechat);
$leaguefollowers = stripslashes($leaguefollowers);
$leaguefollowers = mysqli_real_escape_string($leaguefollowers);
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);
$leagueid = stripslashes($leagueid);
$leagueid = mysqli_real_escape_string($leagueid);

// mysqli Update Password
$sql="UPDATE $tbl_name SET AcceptLeagueNote='$leaguenote', AcceptLeagueChat='$leaguechat', AcceptLeagueFollowNote='$leaguefollowers' WHERE (UserID='$userid') AND (LeagueID='$leagueid')";
$result=mysqli_query($sql);

ob_end_flush();


?>