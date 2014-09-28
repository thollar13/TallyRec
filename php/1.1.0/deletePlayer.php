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
$userid = $_REQUEST['userid'];

// To protect mysqli injection (more detail about mysqli injection)
$rosterid = stripslashes($rosterid);
$rosterid = mysqli_real_escape_string($rosterid);

    $sql="SELECT UserID FROM $tbl_name WHERE RosterID='$rosterid'";
    $result=mysqli_query($sql);
    
    $row = mysqli_fetch_assoc($result);
    
    if ($userid == $row['UserID']) {
        echo "DeleteSelf";
    }
    else {
    
        $sql="UPDATE $tbl_name SET Inactive='1' WHERE (RosterID='$rosterid')";
        $result=mysqli_query($sql);
        echo "Success";
    }


ob_end_flush();


?>