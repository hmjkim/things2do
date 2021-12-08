<?php
    
    // Include functions.php file which contains the SITE_URL constant. If this file is already included, don't include it again.
    require_once("../functions.php");

    // Connect to the database by including the connection. If this file is already included, don't include it again.
    require_once("connect.php");

    // Check to see if the todo's id is in the URL as part of GET variables.(archiving a todo using a button) This prevents anyone maliciously attempting to access the completed.php file using a direct URL.
    if(!isset($_GET["id"])) {

        // If not, redirect the user to the homepage
        header("Location: " . SITE_URL);

        // Kill/stop the script
        die();
        
    }

    // SQL UPDATE command updates data in a database where SET specifies which column and values to be updated as and WHERE is used as a filter, updating only the one that matches the provided condition.
    // Create a query which updates todo's status to completed(1), only updating that particular todo which comes through the URL (? : placeholder for unspecified parameters)
    $sql = "UPDATE todos SET todo_status = 1 WHERE todo_id = ?";

    // Prepare our query and store it in an update statement variable
    $update_stmt = $connection->prepare($sql);

    // Update the parameters by binding the variables to a prepared query as parameters.
    // The given variable will substitute the placeholder(?) in the specified data type which is integer(i) in this case. Telling mySQL what type of data to expect, it minimizes the risk of SQL injections. 
    // The updating parameter variable accesses the todo's id from GET variables on URL using $_GET superglobal
    $update_stmt->bind_param("i", $_GET["id"]);

    // Execute and run our prepared statement 
    $update_stmt->execute();

    // Using built in PHP header() function, we are sending a raw HTTP header back to the browser and returning REDIRECT (302) status code with the special case of header string, "Location: "
    // This basically redirects the user back to homepage following SITE_URL which will be defined in functions.php
    header("Location: " . SITE_URL);

?>