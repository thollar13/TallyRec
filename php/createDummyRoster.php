<?php

ob_start();

    require("constants.php");
    $tbl_name="dummyuser"; // Table name 

    // Define Variables
    $rosterFname = $_REQUEST['rosterFname'];
    $rosterLname = $_REQUEST['rosterLname'];
    $rosternumber = $_REQUEST['rosternumber'];
    $phonenumber = $_REQUEST['rosterphonenumber'];
    $teamid = $_REQUEST['teamid'];

    // To protect mysqli injection (more detail about mysqli injection)
    $rostername = stripslashes($rostername);
    $rosternumber = stripslashes($rosternumber);
    $phonenumber = stripslashes($phonenumber);

    $rostername = mysqli_real_escape_string($rostername);
    $rosternumber = mysqli_real_escape_string($rosternumber);
    $phonenumber = mysqli_real_escape_string($phonenumber);

    // Create Dummy Player
    $sql="INSERT INTO $tbl_name (FName, LName, Active, TimeStamp, Phone) VALUES ('$rosterFname', '$rosterLname','1', now(), '$phonenumber')";
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
    
    echo $phonenumber;

ob_end_flush();

?>