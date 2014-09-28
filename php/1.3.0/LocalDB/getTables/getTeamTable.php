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

    /*
    * Get UserID
    */
    
    $sql="SELECT UserID FROM $tbl_name WHERE (Username ='$username')";
    $result=mysqli_query($sql);
    $row = mysqli_fetch_assoc($result);

    $userid = $row['UserID'];
    
    /*
    * Get Associated TeamID's From Roster
    */
    
    $teamid = array();
    $arraycount = 0;
    
    $sql="SELECT TeamID FROM Roster WHERE (UserID ='$userid') AND (Inactive != '1')";
    $result=mysqli_query($sql);
    $count=mysqli_num_rows($result);

    if($count==0){
        //Do Nothing
    }
    else {
        while ($row = mysqli_fetch_assoc($result)) {
            $teamid[] = $row['TeamID'];
            $arraycount++;
        }
    }    
    
    /*
    * Get Team Information
    */   
    
    $countloop = 0;
    
    while ($countloop<=$arraycount){
        $sql="SELECT * FROM Team WHERE (TeamID ='$teamid[$countloop]') AND (Inactive != '1')";
        $result=mysqli_query($sql);
        $row = mysqli_fetch_assoc($result);
        
        if ($row['Name'] == "" || $row['Name'] == null){
        }
        else {
            echo "INSERT INTO TEAM (Name, SportID, City, State, Park, League, Inactive) VALUES ('" . $row['Name'] . "', '" . $row['SportID'] . "', '" . $row['City'] . "', '" . $row['State'] . "', '" . $row['Park'] . "', '" . $row['League'] . "', '" . $row['Inactive'] . "')";
        echo "<br/>";
        }
    
        $countloop++;
    }
    
}

ob_end_flush();

?>