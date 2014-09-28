<?php

ob_start();

require("constants.php");
$tbl_name="league"; // Table name 

// Define $myusername and $mypassword from form
$leagueid = $_REQUEST['leagueid'];
$name = $_REQUEST['name'];
$sport = $_REQUEST['sport'];
$division = $_REQUEST['division'];
$state = $_REQUEST['state'];
$city = $_REQUEST['city'];
$park = $_REQUEST['park'];
$season = $_REQUEST['season'];
$year = $_REQUEST['year'];

// To protect mysqli injection (more detail about mysqli injection)
$leagueid = stripslashes($leagueid);
$leagueid = mysqli_real_escape_string($leagueid);
$name = stripslashes($name);
$name = mysqli_real_escape_string($name);
$sport = stripslashes($sport);
$sport = mysqli_real_escape_string($sport);
$division = stripslashes($division);
$division = mysqli_real_escape_string($division);
$state = stripslashes($state);
$state = mysqli_real_escape_string($state);
$city = stripslashes($city);
$city = mysqli_real_escape_string($city);
$park = stripslashes($park);
$park = mysqli_real_escape_string($park);
$season = stripslashes($season);
$season = mysqli_real_escape_string($season);
$year = stripslashes($year);
$year = mysqli_real_escape_string($year);

// mysqli Update Password
$sql="UPDATE $tbl_name SET NAME='$name', SportID='$sport', Division='$division', State='$state', City='$city', Park='$park', Year='$year', Season='$season' WHERE (LeagueID='$leagueid')";
$result=mysqli_query($sql);

ob_end_flush();


?>