<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="sport"; // Table name 
    
   

    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    $sql="SELECT * FROM $tbl_name ORDER BY SportName";
    $result = mysqli_query($sql);    
    
    echo "<select name='select-choice-1' id='newTeamSport' data-mini='true'>";
    
        // Get SQL Results
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row["SportID"] . "'>" . $row["SportName"] . "</option>";
        }
        echo "<option value='100'>Other</option>";
    echo "</select>";

ob_end_flush();                            
                            
?>