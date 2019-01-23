<?php

    $link = mysqli_connect("localhost", "root", "", "travel");

    if (mysqli_connect_error()) {
        
        die ("There was an error connecting to the database");
        
    } 

    $query = "SELECT * FROM enquiry";

    if ($result = mysqli_query($link, $query)) {
        
        while($row = mysqli_fetch_array($result))
        
        echo "name is\t".$row[2]."\tmobile no\t".$row[4]."\temail is\t".$row[5]."<br>";
        echo "<br>";
        
    }


?>

<form method="post">

<p><input type="button" value="send"</p>

</form>