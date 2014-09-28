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

// Define Variables
$rosterid = $_REQUEST['rosterid'];
$rostername = $_REQUEST['rostername'];
$rosternumber = $_REQUEST['rosternumber'];
$managercode = $_REQUEST['managercode'];

// To protect mysqli injection (more detail about mysqli injection)
$rostername = stripslashes($rostername);
$rosternumber = stripslashes($rosternumber);
$managercode = stripslashes($managercode);

$rostername = mysqli_real_escape_string($rostername);
$rosternumber = mysqli_real_escape_string($rosternumber);
$managercode = mysqli_real_escape_string($managercode);

    $sql="UPDATE $tbl_name SET Nickname='$rostername', PlayerNumber='$rosternumber', Manager='$managercode' WHERE (RosterID='$rosterid')";
    $result = mysqli_query($sql);

ob_end_flush();

?>