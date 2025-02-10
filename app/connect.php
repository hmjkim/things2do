<?php

    // 1. CONNECTING DATABASE
    // ----------
    // To access data in MySQL database, we need to connect to the server first. To connect to MySQL, we should know information such as username, password, database name, and server name.

    // server username
    $username = "";

    // server password for the given username above
    $password = "";

    // database we are trying to connect
    $database ="";

    // location of the server we are connecting to 
    $host = "localhost";

    // Open a new connection to the MySQL server in object oriented style by creating a new mysqli() object
    $connection = new mysqli($host, $username, $password, $database);
    
    // 2. VALIDATING CONNECTION TO DATABASE
    // -----------
    // In object oriented style, check to see if there is any connection error. If there is, this function ($connection->connect_errno) returns an error code from the last connection attempt. 
    if($connection->connect_errno) {
        echo "Failed to connect to MySQL: " . $connection->connect_errno;

        // End/kill the current script after displaying connection error
        die();
        
    }
?>
