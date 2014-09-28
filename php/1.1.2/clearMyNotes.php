<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="notes"; // Table name 


    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Define Variables
    $userid = $_REQUEST['userid'];


    // To protect mysqli injection (more detail about mysqli injection)
    $userid = stripslashes($userid);
    $userid = mysqli_real_escape_string($userid);

    $sql="UPDATE $tbl_name SET Active='0' WHERE (UserID='$userid')";
    $result = mysqli_query($sql);
    
    echo "Success";

ob_end_flush();

?>