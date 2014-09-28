<?php

ob_start();

require("constants.php");
$tbl_name="chat"; // Table name 

// Set Variable
$userid = $_REQUEST['userid'];
$message = $_REQUEST['message'];
$touserid = $_REQUEST['touserid'];

// To protect mysqli injection
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);
$message = stripslashes($message);
$message = mysqli_real_escape_string($message);
$touserid = stripslashes($touserid);
$touserid = mysqli_real_escape_string($touserid);

// mysqli Submit Chat
$sql="INSERT INTO $tbl_name (UserID, Message, TimeStamp, ToUserID, Manager, Active) VALUES ('$userid', '$message', now(), '$touserid', '0', '1')";
$result=mysqli_query($sql);

ob_end_flush();

?>