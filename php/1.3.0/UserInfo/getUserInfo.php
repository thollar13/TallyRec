<?php

ob_start();

require("../../../constants.php");
$tbl_name="user"; // Table name 

// Define $myusername and $mypassword from form
$username=$_REQUEST["username"];

// To protect mysqli injection (more detail about mysqli injection)
$username = stripslashes($username);
// $username = mysqli_real_escape_string($username);

// mysqli Update Password
$sql="SELECT * FROM $tbl_name WHERE (Username='$username')";
$result = $dbh->prepare($sql);
$result->execute();

$userid = $row->UserID;
$fname = $row->FName;
$lname = $row->LName;
$avatar = $row->ImgURL;
$email = $row->Email;
$phone = $row->Phone;

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