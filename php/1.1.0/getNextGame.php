<?php

// Get UserID and Username
ob_start();
$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="FutureGames"; // Table name 


// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Set variable
if(!isset($_SESSION)){session_start(); }
$teamid = $_REQUEST['teamid'];
$teamname = $_REQUEST['teamname'];

// mysqli Submit Chat
$sql="SELECT * FROM $tbl_name WHERE teamid = '$teamid' LIMIT 1";
$result=mysqli_query($sql);  

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==0){
    
    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider' style='text-align: center; font-size: 8pt;'>Next Game</li>";
        echo "<li style='text-align: center; font-size: 8pt;'>";
            echo "No Games";
        echo "</li>";
    echo "</ul>";
}
else {
    
        echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider' style='text-align: center; font-size: 8pt;'>Next Game</li>";
            echo "<li style='text-align: center; font-size: 8pt;'>";
                
            //Check if Home or Away
            if ($row['HomeAway']=="1"){
                
                echo $row['Opponent'];
            }
            else {
                
                echo "@ " . $row['Opponent'];
            }
            
                    echo "<br />";
                    // Game Date
                    $month =  substr($row["Date"], 5, 2);
                    if ($month>"11"){echo "Dec.";}
                    else if ($month>"10"){echo "Nov.";}
                    else if ($month>"9"){echo "Oct.";}
                    else if ($month>"8"){echo "Sept.";}
                    else if ($month>"7"){echo "Aug.";}
                    else if ($month>"6"){echo "July";}
                    else if ($month>"5"){echo "June";}
                    else if ($month>"4"){echo "May";}
                    else if ($month>"3"){echo "Apr.";}
                    else if ($month>"2"){echo "Mar.";}
                    else if ($month>"1"){echo "Feb.";}
                    else {echo "Jan.";}
                    
                    echo " " . substr($row["Date"], 8);
                echo " at ";
                // Game Time 
                    if ($row['Time']==""||$row['Time']=="0"){
                        echo "nbsp;";
                    }
                    else {
                        echo $row['Time'];
                    }
            echo "</li>";
        echo "</ul>";    
}

ob_end_flush();                
                
?>