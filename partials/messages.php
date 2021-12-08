<?php
    
    // Grab the values using $_GET superglobal. These GET variables can be found in the URL as a name-value pair. If these variables show up in the URL along with the name, type and msg (messages), run the following codes below.
    if(isset($_GET["type"], $_GET["msg"])): 

    // Set the colour of the message box based on the value associated with type in query parameter using Bootstrap classes
    switch($_GET["type"]) {

        // If type=success : Green
        case "success":
            $message_class = "alert-success";
            break;

        // If type=error : Red
        case "error":
            $message_class = "alert-danger";
            break;

        // For any other cases : Blue
        default:
            $message_class = "alert-primary";

    }

    // Display corresponding messages for each case that matches the value of msg in query parameter
    switch($_GET["msg"]) {

        // A message for a new user creation
        case "new_user":
            $message = "New user created. Please sign in.";
            break;

        // A message for passwords that are not matching
        case "pwd_mismatch":
            $message = "Oops! There has been an error. Please try again and enter two matching passwords.";
            break;
        
        // A message for incorrect password
        case "pwd_incorrect":
            $message = "Oops! There has been an error. Incorrect password, please try again.";
            break;

        // A message for successful login
        case "login":
            $message = "Login success. Welcome back!";
            break;

        // A message for successful login
        case "new_task":
            $message = "A new task has been added! Check your Todo List.";
            break;

        // A message for successful logout
        case "logout":
            $message = "Logout success! See you soon.";
            break;
        
        // A message for any empty fields in the form that are required
        case "empty_fields":
            $message= "Required fields must be completed. Please try again.";
            break;

        // A message for an invalid email address
        case "invalid_email":
            $message= "Invalid email. Please try again.";
            break;

        // A message for an existing user
        case "user_exists":
            $message = "A user with that email already exists. Please log in to continue.";
            break;

        // For any other cases, display no messages
        default:
            $message = "";

    }
?>

<!-- Message box -->
<div class="row">
    <div class="col-12">

        <!-- A div for a message box with the corresponding colour and its messages -->
        <div class="alert mt-4 <?php echo $message_class; ?>">
            <?php echo $message; ?> 
        </div>

    </div>
</div>

<?php 

    // end of if statement
    endif; 
    
?>