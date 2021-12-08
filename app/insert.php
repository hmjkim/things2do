<?php
    
    // Include functions.php file which contains the SITE_URL constant. If this file is already included, don't include it again.
    require_once("../functions.php");

    // Connect to the database by including our connection (connect.php). If this file is already included, don't include it again.
    require_once("connect.php");

    // Start the session if not already running
    ws_session_start();

    // Grab the value associated with the key in POST variables and store them in new variables
    // Even though POST variables are not visible directly in URL, key value pairs can still be accessed in PHP. Using the superglobal $_POST followed by the key name will let us access the value. The name of the key is derived from name attribute within the form.
    $todo_cat = $_POST["cat"];
    $todo_title = $_POST["title"];
    $todo_text = $_POST["text"];
    $todo_date = $_POST["date"];

    // Using ternary conditional operator, check to see if there completed variable exists. If yes, return the value of completed status (1). If not, return 0.
    $todo_status = (isset($_POST["completed"])) ? $_POST["completed"]: 0;

    // Create a variable that stores user id in session
    $user_id = $_SESSION["user_id"];

    // Check to see the user is adding a todo using the todo form. This prevents anyone maliciously attempting to access the insert.php file using a direct URL.
    if(!isset($_POST["todo_submit"])) {

        // If submit value does not exist (the user is NOT coming via the todo form), redirect the user to homepage.
        header("Location: " . SITE_URL);

        // Kill/stop the script
        die();

    }

    // Check to see if any of the fields in a todo adding form is empty including user_id from the sessions (except for todo_text which can be null)
    // empty returns true even if the value is 0 so we need to use isset for todo_status since it will be either 0 = active or 1 = completed
    if(empty($todo_cat) || empty($todo_title) || empty($todo_date) || empty($user_id) || !isset($todo_status)) {
        header("Location: " . SITE_URL . "?msg=empty_fields&type=error");
        die();
    }

    // Create a SQL query that will insert the following data into these specified columns in the todos table. Values/parameters are unspecified for now but will be defined and bound later using bind_param()
    // INSERT INTO command syntax : INSERT INTO table_name (columns we want to enter into) VALUES (corresponding data/values to be entered into the new entry)
    // 
    $sql = "INSERT INTO todos (todo_cat_id, todo_title, todo_text, todo_date, todo_status, todo_user_id) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare our query and store it in insert_stmt variable
    $insert_stmt = $connection->prepare($sql);

    // Bind the placeholder parameters with the variables defined above. Notice data types are defined here (todo_cat: integer, todo_title: string, todo_text: string, todo_date: string, todo_status: integer) 
    $insert_stmt->bind_param("isssii", $todo_cat, $todo_title, $todo_text, $todo_date, $todo_status, $user_id);

    // Execute and run our prepared query statement
    $insert_stmt->execute();

    // Redirect the user to homepage defined in SITE_URL constant
    header("Location: " . SITE_URL . "?type=success&msg=new_task");
    
?>