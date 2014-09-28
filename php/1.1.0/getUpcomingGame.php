<?php


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

// mysqli Submit Chat
$sql="SELECT * FROM $tbl_name WHERE teamid = '$teamid' LIMIT 1, 1";
$result=mysqli_query($sql);  

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==0){
    // Do nothing
    echo "NoGames";
}
else {
    
    echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider' style='font-size: 7pt; text-align: center'>Upcoming Game</li>";
    echo "<li style='font-size: 7pt; text-align: center;'>";
    echo "<table style='width: 100%;'>";
    echo "<tr>";
    echo "<td style='text-align: center;'>";
        //Date
        echo substr($row["Date"], 5, 2) . "/" . substr($row["Date"], 8)  . " at " . $row["Time"];
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td style='text-align: center;'>";
        //Home or Away
        if ($row['HomeAway']=="1") {
            echo $row['Opponent'];
        }
        else {
            echo "@ " . $row['Opponent'];
        }
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</li>";
    echo "</ul>";

}


ob_end_flush();                               

?>