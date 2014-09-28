<?php


ob_start();
$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
//$tbl_name="chatroom"; // Table name 
$tbl_name="ChatRoomAndroid"; // Table name

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Set variable
$teamid = $_REQUEST['teamid'];
$userid = $_REQUEST['userid'];

// mysqli Submit Chat
$sql="SELECT * FROM $tbl_name WHERE ToTeamID = '$teamid' LIMIT 500";
$result=mysqli_query($sql);  
$counter = 0;

$count=mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==0){
 echo "NoMessages";
}
else {

    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {
    
        $Date = date_parse($row['TimeStamp']);
    
        if ($row['UserID'] == $userid) {
        
            echo "<div id='chatSender'>";
                    echo "<p class='chatTimeStampRecipient' style='font-size:8pt;'><span style='font-size: 8pt;'>";
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
                    echo "</span></p>";
                echo "<table class='rightchat'>";
                    echo "<tr>";
                        echo "<td style='text-align: right; font-size:8pt; font-weight: bold;'>";
                            // Name
                            echo $row['Fname'] . " " . $row['Lname'];
                        echo "&nbsp;";
                            echo "<hr />";
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td style='font-size:8pt; color: white;'>";
                            // Message
                            echo $row['Message'];
                        echo "</td>";
                    echo "</tr>";
                echo "</table>";
            echo "</div>";
            echo "<br />";
    
        }
    
    else {
    
            echo "<div id='chatRecipient'>";
                echo "<p class='chatTimeStampSender' style='font-size:8pt;'>";
                    echo "<span style='font-size: 8pt;'>";
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
                echo "</p>";
                echo "<table class='leftchat'>";
                    echo "<tr>";
                        echo "<td style='text-align: left; font-size:8pt; font-weight: bold;'> &nbsp;";
                            // Name
                            echo $row['Fname'] . " " . $row['Lname'];
                            echo "<hr />";
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td style='font-size:8pt;'>";
                        echo $row['Message'];
                        echo "</td>";
                    echo "</tr>";
                echo "</table>";
            echo "</div>";
            echo "<br />";
      
        $counter++;     
    }
    }
}
ob_end_flush();

?>