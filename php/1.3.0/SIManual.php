<?php
ob_start();

    require("../../constants.php");
    $tbl_name="user"; // Table name 
    
    // Define Variable
    $username=$_REQUEST["username"];
    $password=$_REQUEST["password"];
    
    // To protect mysqli injection (more detail about mysqli injection)
    // $email = stripslashes($email);
    // $email = mysqli_real_escape_string($email);
    // $password = stripslashes($password);
    // $password = mysqli_real_escape_string($password);
    // $password = md5($password);

    $sql="SELECT * FROM $tbl_name WHERE Username='$username' AND UserPassword='$password'";
    $result = $dbh->prepare($sql);
    $result->execute();

    // mysqli_num_row is counting table row
    $count = $result->rowCount(); 

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==1){
    
        $tallyrecversion = "1.3.0";
        
        $sql="UPDATE $tbl_name SET AppVersion='$tallyrecversion', LastLogin=now() WHERE (Username='$username')";
        $result = $dbh->prepare($sql);
        $result->execute();
    
        echo "Success";
    }
    else {
        echo "E-L";
    }

ob_end_flush();

?>