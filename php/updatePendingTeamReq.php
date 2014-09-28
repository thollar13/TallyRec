<?php

ob_start();

    require("constants.php");
    $tbl_name="roster"; // Table name 

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