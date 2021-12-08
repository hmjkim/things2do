<?php  

    // Include functions.php file that contains SITE_URL, and functions that start the session and convert special characters to HTML Entities. 
    require_once("functions.php");

    // Connect to the database by including our connection (connect.php). If it is already included, don't include it again.
    require_once("app/connect.php");

    // Start the session with our function from functions.php
    // We need to make sure that the session starts if is not running.
    ws_session_start();
    
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <!-- Clicking on the logo (PHP todo App) will direct the user to home -->
    <a class="navbar-brand h1 mb-0" href="<?php echo SITE_URL; ?>">Things2Do</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_nav" aria-controls="navbar_nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar_nav">

        <?php 

            // If the user is logged in
            if(isset($_SESSION["logged_in"])): 

        ?>

            <!-- then show the Logout button that will direct the user to homepage-->
            <a href="<?php echo SITE_URL . "app/logout.php?logout=1"; ?>" class="ml-auto btn btn-purple" >Logout</a>

        <?php 

            // otherwise (if the user is NOT logged in), show login form and the Login button
            else: 

        ?>

            <form action="./app/login.php" method="POST" class="form-inline ml-auto">
                <div class="form-group">
                    <label for="login_email" class="mr-3 ml-3">Email address</label>
                    <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="login_password" class="mr-3 ml-3">Password</label>
                    <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
                </div>

                <!-- Login Button -->
                <input name="login_submit" type="submit" class="btn btn-purple ml-3" value="Login">

            </form> 

        <?php 

            // end of if/else statement
            endif; 
            
        ?>  

    </div>
</nav>