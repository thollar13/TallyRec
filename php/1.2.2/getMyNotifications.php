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
    $sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (Active = '1') ORDER BY TimeStamp DESC";
    
    $result=mysqli_query($sql);
    $count=mysqli_num_rows($result);

    // No Active Notifications
    if($count==0){
    
        echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider'>Notifications</li>";
            echo "<li style='font-size: 8pt;'>You have no notifications</li>";
        echo "</ul>";

    }
    else {
        
        echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider'>Notifications</li>";
            
            while ($row = mysqli_fetch_assoc($result)) {
            
                echo "<li>";
                echo "<table style='width:100%;'>";
                    echo "<tr>";     
                        echo "<td style='width:80%;'>";
                                echo $row['FromTeam'];
                                echo "<br />";
                                echo "<span style='font-size: 10pt;'>";
                                        echo $row['Message'];
                                echo "</span>";
                                echo "<br />";
                                echo "<span style='font-size: 8pt;color:#C0C0C0;'> ";
                        
                                    $Date = date_parse($row['TimeStamp']);
                                    //Time
                                    if (date("Y-m-d") == substr($row['TimeStamp'], 0, 10)) {
                                        echo "Today at ";
                                    }
                                    else {
                                        echo $Date['month'] . "/" . $Date['day'] . "/" . $Date['year'] . " at ";
                                    }
                                        // Checking for PM
                                        if ($Date['hour']>12) {
                                            echo ($Date['hour']-12) . ":";
            
                                            // Checking for single digit.
                                            if (strlen($Date['minute'])>1) {
                                                echo $Date['minute'];
                                            }
                                            else {
                                                echo "0" . $Date['minute'];    
                                            } 
                                            echo " PM";
                                        }
                                        else {
                                            if ($Date['hour'] == "0") {
                                                echo "12:";
                                            }
                                            else {
                                                echo $Date['hour'] . ":";
                                                }
                                
                                            if (strlen($Date['minute'])>1) {
                                                echo $Date['minute'];
                                            }
                                            else {
                                                echo "0" . $Date['minute'];    
                                            } 
                                            echo " AM";
                                            }
                   
                                echo "</span>";
                        echo "</td>";
                        echo "<td style='text-align:center;'>";
                            echo "<a class='clearOneNote' data-mini='true' data-role='button' data-note='" . $row['NoteID'] . "'>Clear</a>";
                        echo "</td>";
                    echo "</tr>";                    
                echo "</table>";
                
                echo "</li>";
            
            }
            
        echo "</ul>";
    
    }
    echo $phone;

ob_end_flush();

?>