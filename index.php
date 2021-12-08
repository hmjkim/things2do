<?php 
    
    // Include the functions file that contains SITE URL and a session starting function. If it already exists, do not include it again. However, upon failure such as missing file, it will result in a fatal error and stop the script. 
    require_once("functions.php");

    // Sessions are used to save information across pages and will store the data as a file in the server. They will expire once the browser has been closed. PHP sessions are accessible through the superglobal $_SESSION which has a key-value pair. We are going to use sessions to store login states. PHP Sessions need to be initialized in order for it to start.  Start the session by calling the custom function we created which uses a built-in PHP function, session_start().
    ws_session_start();

    // Include header.php located in partials folder and insert the content. Upon failure such as missing the file, it will result in a fatal error and stop the script.
    require_once("partials/header.php");     

    // Include a file that displays messages. If it already exists, do not include it again. Upon failure such as missing the file, it will result in a fatal error and stop the script.
    require_once("partials/messages.php");

    // If the logged in state is set (the user is logged in),
    if(isset($_SESSION["logged_in"])){

        // then display todo application content
        require_once("partials/todos.php");

    // if the user is NOT logged in,    
    } else {

        // Display a form that allows users to create a new account and sign up 
        require_once("partials/signup-form.php"); 
        
    }

    // Include footer.php located in partials folder and insert the content. Upon failure such as missing the file, it will result in fatal error and stop the script.
    require_once("partials/footer.php"); 

?>