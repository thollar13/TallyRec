<?php

ob_start();

require("constants.php");
$tbl_name="roster"; // Table name 

// Define Variables
$rosterid = $_REQUEST['rosterid'];

// To protect mysqli injection (more detail about mysqli injection)
$rosterid = stripslashes($rosterid);
$rosterid = mysqli_real_escape_string($rosterid);

    // mysqli Create User
    $sql="UPDATE $tbl_name SET Inactive='1' WHERE (RosterID='$rosterid')";
    $result=mysqli_query($sql);

    echo "Success";


ob_end_flush();


?>