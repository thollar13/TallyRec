<?php

// Get UserID and Username
ob_start();
$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="PastGames"; // Table name 


// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Set variable
$teamid = $_REQUEST['teamid'];

// mysqli Submit Chat
$sql="SELECT * FROM $tbl_name WHERE teamid = '$teamid' LIMIT 1";
$result=mysqli_query($sql);  

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);


if($count==0){
    // Do Nothing
    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider' style='text-align: center; font-size: 8pt;'>Previous</li>";
        echo "<li style='text-align: center; font-size: 8pt;'>";
            echo "No Events";
        echo "</li>";
    echo "</ul>";
}
else {    

    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider' style='text-align: center; font-size: 8pt;'>Previous</li>";
        echo "<li style='text-align: center; font-size: 8pt;'>";
        
            //Check for Home or Away
            if ($row['HomeAway']=="0"){    
            echo "@ ";
            }
            echo $row['Opponent'];
            echo "<br />";
            if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-") {
                echo "&nbsp;";
            }
            else {
                if ($row['HomeAway']=="1"){
                    //Home
                    if ($row['HomeScore']>$row['AwayScore']){
                        echo "Won ";
                    }
                    elseif ($row['HomeScore']<$row['AwayScore']) {
                        echo "Lost ";
                    } 
                    else{
                    echo "Tied ";
                    }
                    echo $row['HomeScore'] . " - " . $row['AwayScore'];
                }
                else {
                    //Away
                    if ($row['HomeScore']>$row['AwayScore']){
                        echo "Lost ";
                    }
                    elseif ($row['HomeScore']<$row['AwayScore']) {
                        echo "Won ";
                    }
                    else{
                        echo "Tied ";
                    }
                    echo $row['AwayScore'] . " - " . $row['HomeScore'];
                }
            }
        }
        echo "</li>";
    echo "</ul>";


ob_end_flush();

?>