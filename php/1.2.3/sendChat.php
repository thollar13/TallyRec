<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="chat"; // Table name 


    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

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