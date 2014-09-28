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
    $rosterid = $_REQUEST['rosterid'];
    $teamid = $_REQUEST['teamid'];
    $teamname = $_REQUEST['teamname'];

    // To protect mysqli injection (more detail about mysqli injection)
    $rosterid = stripslashes($rosterid);
    $teamid = stripslashes($teamid);
    $teamname = stripslashes($teamname);

    $rosterid = mysqli_real_escape_string($rosterid);
    $teamid = mysqli_real_escape_string($teamid);
    $teamname = mysqli_real_escape_string($teamname);

        $sql="UPDATE roster SET Manager='0', Archived='0', AddedToRoster=now() WHERE (RosterID='$rosterid')";
        $result = mysqli_query($sql);
        
        
            //Check for selected userid
            $sql="SELECT UserID FROM roster WHERE RosterID='$rosterid'";
            $result=mysqli_query($sql);
            $row = mysqli_fetch_assoc($result);
            $userid = $row['UserID'];
        
                $notetype = "2";
                $message = "You have been added to the team!";
        
                $sql="INSERT INTO notes (NoteType, Message, Active, UserID, FromTeam, FromTeamID, TimeStamp) VALUES ('$notetype', '$message','1', '$userid', '$teamname', '$teamid', now())";
                $result = mysqli_query($sql);
            
            
                    //Check for token
                    $sql="SELECT Token FROM user WHERE UserID='$userid'";
                    $result=mysqli_query($sql);
                    $row = mysqli_fetch_assoc($result);
                    $token = $row['Token'];
                
                    if (strlen($token)>2) {
                        echo "Has Device";
                    }
                    else {
                        echo "Success";
                    }

ob_end_flush();

?>