<?php

ob_start();

    require('../../constants.php');

    // Define Variable
    $email = $_REQUEST['email'];
    $username = $_REQUEST['username'];
    
    // To protect mysqli injection (more detail about mysqli injection)
    $email = stripslashes($email);
    $username = stripslashes($username);
    
    $sql="SELECT * FROM $tbl_name WHERE email='$email'";
    $result=$dbh->prepare($sql);
    $result->execute();

    // mysqli_num_row is counting table row
    $count=$result->rowCount();

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==0){
    
        $sql="SELECT * FROM $tbl_name WHERE Username='$username'";
        $result=$dbh->prepare($sql);
        $result->execute();

        // mysqli_num_row is counting table row
        $count=$result->rowCount();

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