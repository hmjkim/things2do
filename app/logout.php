<?php

    //Include functions.php file that contains SITE_URL, and functions that start the session and convert special characters to HTML Entities. 
    require_once("../functions.php");

    // Start the session using the function from functions.php if one is not already running
    ws_session_start();

    // Clicking the logout button will direct the user to the homepage with app/logout.php?logout=1 in the URL (refer to navbar.php). If logout GET variable is set in the URL, meaning the user is logged out
    if (isset($_GET["logout"])) {

        // Destroy all data registered to a session
        session_destroy();

        // Redirect the user to homepage with a message notifying logout was successful.
        header("Location: " . SITE_URL . "?msg=logout&type=success");

        // Kill/stop the script
        die();

    // Otherwise, (if the user is still logged in or someone is trying to access the logout.php file directly in a malicious way)
    } else {

        // Redirect the user to the homepage
        header("Location: " . SITE_URL);

        // Kill/stop the script
        die();
        
    }