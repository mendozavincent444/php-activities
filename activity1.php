<?php
    $name = "Vincent Gabriel Mendoza";

    $counter = 0;

    for ($i = 0; $i < strlen($name); $i++) {
        if ($name[$i] == "a" || $name[$i] == "e" || $name[$i] == "i" || $name[$i] == "o" || $name[$i] == "u") {
            $counter++;
        }
    
    }


    echo $name;
    echo "<br>";
    echo "No. of vowels: $counter";
?>