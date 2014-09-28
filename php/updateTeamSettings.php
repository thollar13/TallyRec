<?php

ob_start();

require("constants.php");
$tbl_name="team"; // Table name 

// Define $myusername and $mypassword from form
$teamid = $_REQUEST['teamid'];
$teamname = $_REQUEST['teamname'];
$sport = $_REQUEST['sport'];
$state = $_REQUEST['state'];
$city = $_REQUEST['city'];
$park = $_REQUEST['park'];
$league = $_REQUEST['league'];

// To protect mysqli injection (more detail about mysqli injection)
$teamid = stripslashes($teamid);
$teamid = mysqli_real_escape_string($teamid);
$teamname = stripslashes($teamname);
$teamname = mysqli_real_escape_string($teamname);
$sport = stripslashes($sport);
$sport = mysqli_real_escape_string($sport);
$state = stripslashes($state);
$state = mysqli_real_escape_string($state);
$city = stripslashes($city);
$city = mysqli_real_escape_string($city);
$park = stripslashes($park);
$park = mysqli_real_escape_string($park);
$league = stripslashes($league);
$league = mysqli_real_escape_string($league);

// mysqli Update Password
$sql="UPDATE $tbl_name SET NAME='$teamname', SportID='$sport', State='$state', City='$city', Park='$park', League='$league' WHERE (TeamID='$teamid')";
$result=mysqli_query($sql);


ob_end_flush();


?>