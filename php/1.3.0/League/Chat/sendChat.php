<?php

ob_start();

require("constants.php");
$tbl_name="chat"; // Table name 

// Set Variable
$userid = $_REQUEST['userid'];
$message = $_REQUEST['message'];
$leagueid = $_REQUEST['leagueid'];
$teamnote = $_REQUEST['teamnote'];

// To protect mysqli injection
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);
$message = stripslashes($message);
$message = mysqli_real_escape_string($message);
$leagueid = stripslashes($leagueid);
$leagueid = mysqli_real_escape_string($leagueid);
$teamnote = stripslashes($teamnote);
$teamnote = mysqli_real_escape_string($teamnote);

// mysqli Submit Chat
$sql="INSERT INTO $tbl_name (UserID, Message, TimeStamp, ToLeagueID, Manager) VALUES ('$userid', '$message', now(), '$leagueid', '$teamnote')";
$result=mysqli_query($sql);

ob_end_flush();

?>