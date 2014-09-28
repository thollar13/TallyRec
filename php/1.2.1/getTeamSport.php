<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="team"; // Table name 

    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Define $myusername and $mypassword from form
    $teamid = $_REQUEST['teamid'];

    // To protect mysqli injection (more detail about mysqli injection)
    $teamid = stripslashes($teamid);
    $teamid = mysqli_real_escape_string($teamid);

    // mysqli Update Password
    $sql="SELECT SportID FROM $tbl_name WHERE (TeamID='$teamid')";
    $result=mysqli_query($sql);
    $row = mysqli_fetch_assoc($result);
    $sport = $row["SportID"];

    echo "<img src='images/sport/" . $sport . ".png' class='SportImgLarge' />";

ob_end_flush();

?>