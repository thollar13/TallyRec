<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="notes"; // Table name 

    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Define $myusername and $mypassword from form
    $userid = $_REQUEST['userid'];

    // To protect mysqli injection (more detail about mysqli injection)
    $userid = stripslashes($userid);
    $userid = mysqli_real_escape_string($userid);

    // mysqli Update Password
    $sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (Active = '1')";
    
    $result=mysqli_query($sql);
    $count=mysqli_num_rows($result);

    // No Active Notifications
    if($count==0){
    
        echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider'>Notifications</li>";
            echo "<li>You have no notifications</li>";
        echo "</ul>";

    }
    else {
        
        echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider'>Notifications</li>";
            
            while ($row = mysqli_fetch_assoc($result)) {
            
                echo "<li>";
                    echo $row['FromTeam'];
                echo "<br /><span style='font-size: 8pt;'>";
                        echo $row['Message'];
                echo "</span></li>";
            
            }
            
        echo "</ul>";
    
    }
    echo $phone;

ob_end_flush();

?>