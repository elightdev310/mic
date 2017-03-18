<?php
echo "Checking PDO:  ";
$hostname = "localhost";
$username = "medicali_db";
$password = "9y3bvZ9bRiHK";

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=medicali_db", $username, $password);
    echo "Connected to database"; // check for connection
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }

phpinfo();
?>
