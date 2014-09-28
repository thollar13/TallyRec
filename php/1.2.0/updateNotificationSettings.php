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

// Define $myusername and $mypassword from form
$teamnote = $_REQUEST['teamnote'];
$teamchat = $_REQUEST['teamchat'];
$teamfollowers = $_REQUEST['teamfollowers'];
$userid = $_REQUEST['userid'];
$teamid = $_REQUEST['teamid'];

// To protect mysqli injection (more detail about mysqli injection)
$teamnote = stripslashes($teamnote);
$teamnote = mysqli_real_escape_string($teamnote);
$teamchat = stripslashes($teamchat);
$teamchat = mysqli_real_escape_string($teamchat);
$teamfollowers = stripslashes($teamfollowers);
$teamfollowers = mysqli_real_escape_string($teamfollowers);
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);
$teamid = stripslashes($teamid);
$teamid = mysqli_real_escape_string($teamid);

// mysqli Update Password
$sql="UPDATE $tbl_name SET AcceptTeamNote='$teamnote', AcceptChat='$teamchat', AcceptFollowNote='$teamfollowers' WHERE (UserID='$userid') AND (TeamID='$teamid')";
$result=mysqli_query($sql);

ob_end_flush();


?>