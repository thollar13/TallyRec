<?php

ob_start();

require("constants.php"); 
$tbl_name="roster"; // Table name 

// Define Variables
$teamid = $_REQUEST['teamid'];
$userid = $_REQUEST['userid'];
$username = $_REQUEST['username'];

// To protect mysqli injection (more detail about mysqli injection)
$teamid = stripslashes($teamid);
$teamid = mysqli_real_escape_string($teamid);
$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);
$username = stripslashes($username);
$username = mysqli_real_escape_string($username);

    $sql="SELECT * FROM myteams WHERE (username = '$username') AND (teamid = '$teamid')";
    $result=mysqli_query($sql);

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==0){

        // mysqli Create User
        $sql="INSERT INTO $tbl_name (TeamID, UserID, Manager, TimeStamp) VALUES ('$teamid', '$userid', '2', now())";
        $result=mysqli_query($sql);
    }
    else {
    }
    
    echo "Success";

ob_end_flush();


?>