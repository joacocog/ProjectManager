# ProjectManager

For this project you will need a file conn.php where you have to make the connection:

<?php

$conn = new mysqli('$servername', '$username', '$password', '$databasename');

if($conn->connect_error){
    echo $conn->connect_error;
}

$conn->set_charset('utf8');

?>
