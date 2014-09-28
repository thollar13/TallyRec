<?php

require("constants.php");

foreach($dbh->query('SELECT * from user WHERE UserID = 1') as $row) {
    print_r($row);
}
?>