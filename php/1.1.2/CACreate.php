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

    // Define SQL Variables
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $email = $_REQUEST['email'];
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $phone = $_REQUEST['phone'];

    // To protect mysqli injection (more detail about mysqli injection)
    $username = stripslashes($username);
    $username = mysqli_real_escape_string($username);
    $password = stripslashes($password);
    $password = mysqli_real_escape_string($password);
    $password = md5($password);
    $email = stripslashes($email);
    $email = mysqli_real_escape_string($email);
    $fname = stripslashes($fname);
    $fname = mysqli_real_escape_string($fname);
    $lname = stripslashes($lname);
    $lname = mysqli_real_escape_string($lname);
    $phone = stripslashes($phone);
    $phone = mysqli_real_escape_string($phone);

    // mysqli Create User
    $sql="INSERT INTO $tbl_name (Username, Email, FName, LName, UserPassword, Phone, Active, AccountCreated) VALUES ('$username', '$email', '$fname', '$lname','$password', '$phone', '1', now())";
    $result=mysqli_query($sql);

    $sql="SELECT * FROM $tbl_name WHERE email='$email'";
    $result=mysqli_query($sql);

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==0){
        echo "E-C";
    }
    else {
        echo "No Errors";
    }

ob_end_flush();

?>