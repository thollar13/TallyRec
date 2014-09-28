<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="user"; // Table name 

    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Define Variable
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];

    // To protect mysqli injection (more detail about mysqli injection)
    $email = stripslashes($email);
    $email = mysqli_real_escape_string($email);
    $password = stripslashes($password);
    $password = mysqli_real_escape_string($password);
    $password = md5($password);

    $sql="SELECT * FROM $tbl_name WHERE Username='$username' AND UserPassword='$password'";
    $result=mysqli_query($sql);

    //Getting Default Team From Database
    $row = mysqli_fetch_assoc($result);

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==1){
    
        $tallyrecversion = "1.2.0";
        
        $sql="UPDATE $tbl_name SET AppVersion='$tallyrecversion', LastLogin=now() WHERE (Username='$username')";
        $result = mysqli_query($sql);
        
        echo "Success";
    }
    else {
        echo "E-L";
    }

ob_end_flush();

?>