<?php

    // Include functions.php file that contains SITE_URL, and functions that start the session and convert special characters to HTML Entities. 
    require_once("../functions.php");

    // Connect to the database by including our connection (connect.php). If it is already included, don't include it again.
    require_once("connect.php");

    // Access the email and password the user typed in the login form using POST superglobal and store them in variables
    $login_email = $_POST["login_email"];
    $login_password = $_POST["login_password"];

    // Check to see if the login request data is coming from the login form by making sure there is Login value associated with login_submit. This prevents anyone maliciously attempting to access the logged in page using a direct URL.
    if(!isset($_POST["login_submit"])) {

        // If the user did not come using a login form, redirect them to the homepage
        header("Location: " . SITE_URL);

        // Kill/stop the script
        die();

    }

    // Check to see if any of the fields in login form is empty
    if(empty($login_email) || empty($login_password)) {

        // If so, redirect the user to the homepage with a message saying required fields must be completed.
        header("Location: " . SITE_URL . "?msg=empty_fields&type=error");

        // Kill/stop the script
        die();

    }

    // Create a SQL query that selects all columns of data associated with a user that has the logged in email address from users table in database
    $user_sql = "SELECT * FROM users WHERE user_email = ?";
    
    // Prepare our query and store it in user_stmt variable
    $user_stmt = $connection->prepare($user_sql);

    // Update the parameter by binding and substituting the placeholder with an email address used for login
    $user_stmt->bind_param("s", $login_email);

    // Execute and run our prepared statement
    $user_stmt->execute();

    // Manage the result by getting the data from the result set. Store that info in the result variable. There will be one row in database that matches the login email. 
    $result = $user_stmt->get_result();

    // Grab the following data entry row from the result set as an associative array and store it in a new variable called user_data. This user data variable will contain the user's information who tried to login. (user id, email, password)
    $user_data = $result->fetch_assoc();

    // Using a built-in PHP function, password_verify(), we are verifying that a password the user typed in the login form matches the encrypted password (hash) in the database.
    // syntax: password_verify( PASSWORD, HASHED PASSWORD)
    // Check to see if the password provided by the user and the password in database match
    if (password_verify($login_password, $user_data["user_password"])) {

        // To work with sessions and access SESSION superglobal, we need to initialize it first. Start the session.
        ws_session_start();

        // Store the login status in SESSION superglobal
        // The user is logged in
        $_SESSION["logged_in"] = true;

        // Match the user id stored in the session to user id in database
        $_SESSION["user_id"] = $user_data["user_id"];

        // When the password is correct, log the user in with a welcome message and direct him/her to the homepage which will then show todos application content that belongs to that user. (done in index.php)
        header("Location: " . SITE_URL . "?type=success&msg=login");

    // If the passwords do not match in other words password is incorrect,
    } else {

        // Redirect the user to the homepage with an error message notifying the password was not correct.
        header("Location: " . SITE_URL . "?type=error&msg=pwd_incorrect");

        // Kill/stop the script
        die();
        
    }
