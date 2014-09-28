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

// Define $myusername and $mypassword from form
$username = $_REQUEST['username'];

// To protect mysqli injection (more detail about mysqli injection)
$username = stripslashes($username);
$username = mysqli_real_escape_string($username);

// mysqli Update Password
$sql="SELECT * FROM $tbl_name WHERE (Username='$username')";
$result=mysqli_query($sql);
$row = mysqli_fetch_assoc($result);

$userid = $row["UserID"];
$fname = $row["FName"];
$lname = $row["LName"];
$avatar = $row["ImgURL"];
$email = $row["Email"];
$phone = $row["Phone"];

if ($avatar == "images/portraits/Male.png") {
    $avatar = "Male";
}
else if ($avatar == "images/portraits/Female.png") {
    $avatar = "Female";
}
else {
    $avatar = "Unknown";
}



    //Create Array
    $arr = array(
        'userid' => $userid,
        'fname' => $fname,
        'lname' => $lname,
        'avatar' => $avatar,
        'email' => $email,
        'phone' => $phone
    );

    echo json_encode($arr);

ob_end_flush();


?>