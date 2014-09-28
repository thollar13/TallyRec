<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="game"; // Table name 


    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Define SQL Variables
    $gameid = $_REQUEST['gameid'];

    $sql="UPDATE $tbl_name SET Inactive='1' WHERE GameID='$gameid'";
    $result = mysqli_query($sql);

ob_end_flush();

?>