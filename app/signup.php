<?php
    // Include functions.php file that contains SITE_URL, and functions that start the session and convert special characters to HTML Entities. 
    require_once("../functions.php");

    // Connect to the database by including the connection. If this file is already included, don't include it again.
    require_once("connect.php");

    // Create variables that stores the value associated with the key in POST variables. Key in the key-value pair of the POST variables is from name attribute in form. 
    $email = $_POST["signup_email"];
    $password = $_POST["signup_password"];
    $password_confirm = $_POST["signup_password_confirm"];

    // password_hash() is a built-in PHP function that encrypts the password using a strong hashing algorithm. We are using PASSWORD_DEFAULT algorithm in this case to protect the passwords. Store the hashed password in a new variable.
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // If someone tries to access the signup.php file directly, redirect them to the homepage. (it is likely that someone is trying to access the website maliciously)
    // Check to see if signup was completed and submitted using the signup form.
    if (!isset($_POST["signup_submit"])) {

        // If not, redirect to home.
        header("Location: ". SITE_URL);

        // Kill/stop the script.
        die();

    }

    // Check to see if any of the fields in signup form (email, password, re-type password) is empty.
    if(empty($email) || empty($password) || empty($password_confirm)) {

        // If so, redirect the user to homepage with a message notifying required fields must be completed. 
        header("Location: " . SITE_URL . "?msg=empty_fields&type=error");

        // Kill/stop the script.
        die();

    }

    // filter_var is a built-in PHP function that filters a variable with a specified filter. 
    // syntax: filter_var( VALUE to filter, FILTER TYPE , OPTIONS)
    // We are using a type called FILTER_VALIDATE_EMAIL which validates whether the value is a valid email address. 
    // Check to see the email user typed in is NOT a valid email format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // If not valid, redirect the user to homepage with a error message saying it's an invalid email address.
        header("Location: " . SITE_URL . "?msg=invalid_email&type=error");

        // Kill/stop the script.
        die();

    }

    // During the signing up, if the password typed in does not match with the confirm password,
    if($password !== $password_confirm){

        // Redirect the user to homepage with an error message
        header("Location: " . SITE_URL . "?msg=pwd_mismatch&type=error");

        // Kill/stop the script
        die();

    }

    // Check to see if the user with that email address already exists in database
    // Create a SQL query that finds a user from the users table that has the same email address as the one the user typed in. A placeholder will be updated using bind_param() function later.
    $user_sql = "SELECT user_id FROM users 
                WHERE user_email = ?";

    // Prepare our query and store it in a user statement variable
    $user_stmt = $connection->prepare($user_sql);

    // Update the parameter by substituting the placeholder and binding the variable with an email the user typed in. The value was accessed using a $_POST superglobal. (variable defined above) 
    // The built-in PHP function, bind_param(), prevents SQL injections, which are attacks trying to run unintended SQL commands to manipulate sensitive user information, by requiring users to specify the data type.
    // This will take whatever the user types in as a string even a malicious attempt of running SQL commands.
    $user_stmt->bind_param("s", $email);

    // Execute and run our prepared statement 
    $user_stmt->execute();

    // Manage the result by getting the data from the result set to see what would be returned. Store that info in user_result variable
    $user_result = $user_stmt->get_result();

    // Check to see if there is an instance/row containing that email exist in database (num_rows = 1 meaning there is one row in database)
    // We are being extra cautious by using greater than (>) because there could be an instance where same emails exist and we want to send an error message for that case as well
    if($user_result->num_rows >= 1) {

        // If the user already exists, redirect the user with an error message notifying there is another user with that same email already.
        header("Location: " . SITE_URL . "?msg=user_exists&type=error");

        // Kill/stop the script
        die();

    }

    // Create a SQL query that will insert the values into user_email and user_password columns in users table. Values/parameters are unspecified for now but will be defined and bound later using bind_param().
    // todo: we are not including user_id since it is auto incremented (will be automatically increased/updated as the data is added)
    $insert_sql = "INSERT INTO users (user_email, user_password) VALUES (?, ?)";

    // Prepare our query and store it in insert_stmt variable
    $insert_stmt = $connection->prepare($insert_sql);

    // Update the parameters by binding and substituting the placeholder with the variables defined above. The email and password typed in by the user after encrypting it will be added. (Data types - $email: string, $password_hashed: string)
    $insert_stmt->bind_param("ss", $email, $password_hashed);

    // Execute and run our prepared query statement
    $insert_stmt->execute();

    // Redirect to the homepage and display a message telling a user that a new user account has been created. 
    header("Location: " . SITE_URL . "?msg=new_user&type=success");

