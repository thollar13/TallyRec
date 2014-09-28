<?php

    $user="thomas_user"; // mysqli username 
    $pass="thomas123"; // mysqli password 

    try {
    $dbh = new PDO('mysql:host=localhost;dbname=tallyrec', $user, $pass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>

