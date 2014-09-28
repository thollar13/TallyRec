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
    $AcceptDeny = $_REQUEST['AcceptDeny'];

    // To protect mysqli injection (more detail about mysqli injection)
    $rosterid = stripslashes($rosterid);
    $rosterid = mysqli_real_escape_string($rosterid);
    $AcceptDeny = stripslashes($AcceptDeny);
    $AcceptDeny = mysqli_real_escape_string($AcceptDeny);

    if ($AcceptDeny == "0") {
    
        // mysqli Create User
        $sql="UPDATE $tbl_name SET Manager='$AcceptDeny' WHERE (RosterID='$rosterid')";
        $result=mysqli_query($sql);

        echo "Success - On The Team";
    }
    else if ($AcceptDeny == "1") {
    
        // mysqli Create User
        $sql="UPDATE $tbl_name SET Inactive='1' WHERE (RosterID='$rosterid')";
        $result=mysqli_query($sql);

        echo "Success - Team Denied.";
    
    }
    else {
        echo "Error - There was a problem with your request.";
    }

ob_end_flush();


?>