<?php

ob_start();

    require("constants.php");
    $tbl_name="game"; // Table name 

    // Define SQL Variables
    $gameid = $_REQUEST['gameid'];

    $sql="UPDATE $tbl_name SET Inactive='1' WHERE GameID='$gameid'";
    $result = mysqli_query($sql);

ob_end_flush();

?>