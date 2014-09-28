<?php

ob_start();

require("constants.php");
$tbl_name="roster"; // Table name 

// Define Variables
$rosterid = $_REQUEST['rosterid'];
$rostername = $_REQUEST['rostername'];
$rosternumber = $_REQUEST['rosternumber'];


// To protect mysqli injection (more detail about mysqli injection)
$rostername = stripslashes($rostername);
$rosternumber = stripslashes($rosternumber);

$rostername = mysqli_real_escape_string($rostername);
$rosternumber = mysqli_real_escape_string($rosternumber);

    $sql="UPDATE $tbl_name SET Nickname='$rostername', PlayerNumber='$rosternumber' WHERE (RosterID='$rosterid')";
    $result = mysqli_query($sql);

ob_end_flush();

?>