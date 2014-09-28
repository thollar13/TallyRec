<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="dummyuser"; // Table name 


    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Define Variables
    $rosterFname = $_REQUEST['rosterFname'];
    $rosterLname = $_REQUEST['rosterLname'];
    $rosternumber = $_REQUEST['rosternumber'];
    $teamid = $_REQUEST['teamid'];

    // To protect mysqli injection (more detail about mysqli injection)
    $rostername = stripslashes($rostername);
    $rosternumber = stripslashes($rosternumber);

    $rostername = mysqli_real_escape_string($rostername);
    $rosternumber = mysqli_real_escape_string($rosternumber);

    // Create Dummy Player
    $sql="INSERT INTO $tbl_name (FName, LName, Active, TimeStamp) VALUES ('$rosterFname', '$rosterLname','1', now())";
    $result=mysqli_query($sql);

    // Get DummyID
    $sql="SELECT DummyUserID FROM $tbl_name WHERE (FName = '$rosterFname') AND (LName ='$rosterLname') ORDER BY TimeStamp DESC LIMIT 1";
    $result=mysqli_query($sql);
    $row = mysqli_fetch_assoc($result);
    $DummyID = $row['DummyUserID'];

    // Create Roster Spot
    $tbl_name = "roster";
    $sql="INSERT INTO $tbl_name (TeamID, DummyUserID, Manager, PlayerNumber, TimeStamp) VALUES ('$teamid','$DummyID', '0', '$rosternumber', now())";
    $result=mysqli_query($sql);

ob_end_flush();

?>