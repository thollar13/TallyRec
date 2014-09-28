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

    // Define Variables
    $userid = $_REQUEST['userid'];
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $phone = $_REQUEST['phone'];
    $photo = $_REQUEST['photo'];
    
    

    // To protect mysqli injection (more detail about mysqli injection)
    $email = stripslashes($email);
    $email = mysqli_real_escape_string($email);
    $fname = stripslashes($fname);
    $fname = mysqli_real_escape_string($fname);
    $lname = stripslashes($lname);
    $lname = mysqli_real_escape_string($lname);
    $password = stripslashes($password);
    $password = mysqli_real_escape_string($password);
    $password = md5($password);
    $phone = stripslashes($phone);
    $phone = mysqli_real_escape_string($phone);

    // mysqli Create User
    $sql="UPDATE $tbl_name SET FName='$fname', LName='$lname', Email='$email', UserPassword='$password', Phone='$phone', ImgURL='$photo' WHERE (UserID='$userid')";
    $result=mysqli_query($sql);

    echo "Success";

ob_end_flush();


?>