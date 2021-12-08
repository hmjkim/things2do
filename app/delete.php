<?php
    
    // Include functions.php file which contains the SITE_URL constant. If this file is already included, don't include it again.
    require_once("../functions.php");

    // Connect to the database by including our connection file. If it is already included, don't include it again.
    require_once("connect.php");

    // Check to see if the todo's id is in the URL as part of GET variables.(deleting a todo using a button) This prevents anyone maliciously attempting to access the delete.php file using a direct URL.
    if(!isset($_GET["id"])) {

        // If not, redirect the user to the homepage
        header("Location: " . SITE_URL);

        // Kill/stop the script
        die();
        
    }
        
    // Define a variable
    // Superglobal $_GET contains an array of all query variables that are sent through the URL. Access the value that is associated with key called id from the URL and store it in a todo_id variable
    $todo_id = $_GET["id"];

    // Create a query that will delete a todo with that particular id(unspecified as of now but will be updated using bind param) from the todos table
    // DELETE command syntax: DELETE FROM (table_name) WHERE (filtering condition)
    $sql = "DELETE FROM todos WHERE todo_id = ?";

    // Prepare our query and store it in delete_stmt variable
    $delete_stmt = $connection->prepare($sql);

    // Update the parameter by binding and substituting the placeholder with id from the URL
    $delete_stmt->bind_param("i", $todo_id);

    // Execute and run the prepared statement
    $delete_stmt->execute();

    // Redirect the user to homepage defined in SITE_URL constant
    header("Location: " . SITE_URL);

?>