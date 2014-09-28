<?php

ob_start();

    require("constants.php");
    $tbl_name="chat"; // Table name 

    // Set Variable
    $userid = $_REQUEST['userid'];
    $message = $_REQUEST['message'];
    $toteamid = $_REQUEST['teamid'];
    $teamnote = $_REQUEST['teamnote'];

    // To protect mysqli injection
    $userid = stripslashes($userid);
    $userid = mysqli_real_escape_string($userid);
    $message = stripslashes($message);
    $message = mysqli_real_escape_string($message);
    $toteamid = stripslashes($toteamid);
    $toteamid = mysqli_real_escape_string($toteamid);
    $teamnote = stripslashes($teamnote);
    $teamnote = mysqli_real_escape_string($teamnote);
    
    // mysqli Submit Chat
    $sql="INSERT INTO $tbl_name (UserID, Message, TimeStamp, ToTeamID, Manager) VALUES ('$userid', '$message', now(), '$toteamid', '$teamnote')";
    $result=mysqli_query($sql);

ob_end_flush();

?>