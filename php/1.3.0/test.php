<?php

$contactID = array('1', '5', '8');


// Check to see if ID is in Array    
if (in_array('5', $contactID)) {
    
    
    $key = array_search('5', $contactID);
        
        $set = $contactID[$key];
        $set++;
        $contactID[$key] = $set;
        
        echo $contactID[$key];
        
        echo "<br/>test";       
}

?>