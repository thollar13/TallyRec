<?php

ob_start();

// Set Database variable    
require("constants.php");
$tbl_name="user"; // Table name 

// Define Variable
$username = $_REQUEST['username'];

// To protect mysqli injection (more detail about mysqli injection)
$username = stripslashes($username);
$username = mysqli_real_escape_string($username);

if ($username == "" || $username == null){
    //Must Have Username To Proceed
    echo "Unauthorized Access";
}
else {

    $sql="SELECT * FROM $tbl_name WHERE (Username ='$username')";
    $result=mysqli_query($sql);

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    if($count==0){
    //Do Nothing
    }
    else {
    
        $sql="SELECT * FROM $tbl_name WHERE Username='$username'";
        $result=mysqli_query($sql);
        $row = mysqli_fetch_assoc($result);
        
        
        echo "INSERT INTO USER (FName, LName, Email, UserPassword, ImgURL, Phone, DefaultTeamID, DefaultTeamName, Username) VALUES ('" . $row['FName'] . "', '" . $row['LName'] . "', '" . $row['Email'] . "', '" . $row['UserPassword'] . "', '" . $row['ImgURL'] . "', '" . $row['Phone'] . "', '" . $row['DefaultTeamID'] . "', '" . $row['DefaultTeamName'] . "', '" . $row['Username'] . "')";
    
    }
}

ob_end_flush();

?>