<?php

ob_start();

    // Set Database variable    
    require("constants.php");
    $tbl_name="user"; // Table name 

    // Define Variable
    $email = $_REQUEST['email'];
    $username = $_REQUEST['username'];
    
    // To protect mysqli injection (more detail about mysqli injection)
    $email = stripslashes($email);
    $email = mysqli_real_escape_string($email);
    $username = stripslashes($username);
    $username = mysqli_real_escape_string($username);
    
    $sql="SELECT * FROM $tbl_name WHERE email='$email'";
    $result=mysqli_query($sql);

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==0){
    
        $sql="SELECT * FROM $tbl_name WHERE Username='$username'";
        $result=mysqli_query($sql);

        // mysqli_num_row is counting table row
        $count=mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row
        if($count==0){
            //Do nothing    
            echo "No Errors";
        }
        else {
            //Username in use
            echo "E-U";
        }
    
    }
    else {
        //Email in use
        echo "E-E";
    }

ob_end_flush();

?>