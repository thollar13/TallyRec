<?php

ob_start();

    require("constants.php");
    $tbl_name="user"; // Table name 

    // Define $myusername and $mypassword from form
    $username = $_REQUEST['username'];

    // To protect mysqli injection (more detail about mysqli injection)
    $username = stripslashes($username);
    $username = mysqli_real_escape_string($username);

    // mysqli Update Password
    $sql="SELECT Email FROM $tbl_name WHERE (Username='$username')";
    $result=mysqli_query($sql);
    $row = mysqli_fetch_assoc($result);
    $email = $row["Email"];

    echo $email;

ob_end_flush();


?>