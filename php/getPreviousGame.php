<?php

// Get UserID and Username
ob_start();
require("constants.php");
$tbl_name="PastGames"; // Table name 

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
    echo "NoGames";
}
else {    
        
    // Check for null characters
    if ($row['HomeScore']=="0"&&$row['AwayScore']=="0"||$row['HomeScore']==""&&$row['AwayScore']=="") {
        //Do Nothing
        echo "NoGames";
    }
    else {
        
    echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider' style='font-size: 7pt; text-align: center'>Previous Game</li>";
            echo "<li style='font-size: 7pt; text-align: center;'>";
                echo "<table style='width: 100%;'>";
                    echo "<tr>";
                    
                        if ($row['HomeAway']=="1"){
                            echo "<td style='text-align: center;'>" . $row['Opponent'] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td style='text-align: center;'>";
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
                        echo "</td>";
                    }
                    else{
                            echo "<td style='text-align: center;'>@ " . $row['Opponent'] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td style='text-align: center;'>";
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
                        echo "</td>";
                    }
                        
                    echo "</tr>";
                echo "</table>";
            echo "</li>";
        echo "</ul>";
    }
}


ob_end_flush();

?>
