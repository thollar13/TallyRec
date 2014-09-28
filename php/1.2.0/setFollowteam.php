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

// Get UserID
$sql="SELECT UserID FROM user WHERE (username = '$username') LIMIT 1";
$result=mysqli_query($sql);

$row = mysqli_fetch_assoc($result);
$userid = $row['UserID'];


    //Check to see if already following or on team
    $sql="SELECT * FROM myteams WHERE (username = '$username') AND (teamid = '$teamid')";
    $result=mysqli_query($sql);

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    if($count==0){
    
        // Check for roster number marked Inactive
        $sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (teamid = '$teamid') LIMIT 1";
        $result=mysqli_query($sql);

        // mysqli_num_row is counting table row
        $count=mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $rosterid = $row['RosterID'];
        
            if($count==0){
                // Create User
                $sql="INSERT INTO $tbl_name (TeamID, UserID, Manager, TimeStamp) VALUES ('$teamid', '$userid', '2', now())";
                $result=mysqli_query($sql);
            }
            else {
                //Update Roster
                $sql="UPDATE $tbl_name SET Inactive='0', Archived='0', Manager='2', TimeStamp=now() WHERE (RosterID='$rosterid')";
                $result = mysqli_query($sql);
            }
    }
    else {
    //Do Nothing
    }
    
    echo "Success";

ob_end_flush();


?>