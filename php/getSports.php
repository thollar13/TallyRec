<?php

ob_start();

    require("constants.php");
    $tbl_name="sport"; // Table name

    $sql="SELECT * FROM $tbl_name ORDER BY SportName";
    $result = mysqli_query($sql);    
    
    echo "<select name='select-choice-1' id='newTeamSport'>";
    
        // Get SQL Results
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row["SportID"] . "'>" . $row["SportName"] . "</option>";
        }
        echo "<option value='100'>Other</option>";
    echo "</select>";

ob_end_flush();                            
                            
?>