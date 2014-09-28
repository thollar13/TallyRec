<?php

ob_start();

$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="roster"; // Table name 


// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Define Variables
$message = $_REQUEST['message'];
$teamid = $_REQUEST['teamid'];
$teamname = $_REQUEST['teamname'];

// To protect mysqli injection (more detail about mysqli injection)
$message = stripslashes($message);
$teamid = stripslashes($teamid);
$teamname = stripslashes($teamname);

$message = mysqli_real_escape_string($message);
$teamid = mysqli_real_escape_string($teamid);
$teamname = mysqli_real_escape_string($teamname);

//Check for selected userid
$sql="SELECT UserID FROM roster where (TeamID = '$teamid') AND (Inactive != '1')";
$result=mysqli_query($sql);

$notetype = "1";

/*
if (strlen($message)>40) {
    $message = substr($message, 0, 40) . "...";
}
*/

$count=mysqli_num_rows($result);

$userid = array();
$totalarraycount = "0";

if($count==0){
}
else {
    
    while ($row = mysqli_fetch_assoc($result)) {
        // Getting total users and their ID's
        $userid[] = $row['UserID'];        
        $totalarraycount++;
        
    }
        $arraycount = "0";
        
        // Adding Team note to personal notifications
        while ($arraycount<=$totalarraycount) {
            
            $sql="INSERT INTO notes (NoteType, Message, Active, UserID, FromTeam, FromTeamID, TimeStamp) VALUES ('$notetype', '$message','1', '$userid[$arraycount]', '$teamname', '$teamid', now())";
            $result = mysqli_query($sql);
            
            //Increase counter
            $arraycount++;
            
        }
}

    echo "Success";

ob_end_flush();

?>