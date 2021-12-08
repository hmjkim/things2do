<?php

    // Refactor and clean up the codebase by moving duplicated statements to the start of the file
    // Connect to the database by including our connection (connect.php). If it is already included, don't include it again.
    require_once("app/connect.php");

    // Include functions file that contains SITE_URL, functions that start the session and convert special characters to HTML Entities. 
    require_once("functions.php");

    // Start the session to work with PHP Sessions
    ws_session_start();

?>

<!-- todos Content -->
    <div class="container"> 
        
        <!-- Create New todos -->
        
        <div class="new-task row mb-5">
            <div class="card col-sm-12">
                <div class="py-5 px-4 card-body">
                    <h2 class="mb-4">Add A New Task</h2>
                    <!-- action: specifies where the form should send the data to upon submission (location to insert.php file in this case) -->
                    <!-- method: defines how the data is sent (Using post method, data will be sent inside of the HTTP transaction and will not be visible to the user (Post method is more secure and used to add/manipulate the data) -->
                    <form id="add_todo" action="app/insert.php" method="post">

                        <div class="form-group">
                            <label for="cat">Category</label>
                            <select class="form-control" name="cat" id="cat">
                                
                                <?php

                                    // Create a query that selects all columns from cats table
                                    $sql = "SELECT * FROM cats";

                                    // Prepare our query and store it in a statement variable
                                    $stmt = $connection->prepare($sql);

                                    // Execute and run our prepared statement
                                    $stmt->execute();

                                    // Manage the data by getting a result set from a prepared and executed statement and store it in a variable named result
                                    $result = $stmt->get_result();

                                    // Grab the following data entry from the result set as an associative array and store it in a row variable. Every time loop runs, the row of returned data will be added as the next row. Loop through the result set and display the following code until there are no more results.
                                    while($row = $result->fetch_assoc()) {

                                        // Dropdown selection area will consist of category names with the value being its corresponding id
                                        // Make sure the data pulled from database have any special characters converted to HTML Entities using the function we created to prevent malicious scripting attempts 
                                        echo "<option value='" . ws_html_spc($row["cat_id"]). "'>" . ws_html_spc($row["cat_name"]). "</option>";

                                    }
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" type="text" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="text">Details</label>
                            <textarea class="form-control" name="text" id="text"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Due Date</label>
                            <input class="form-control" type="date" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="completed" name="completed" value="1">
                                <label class="form-check-label" for="completed">Completed</label>
                            </div>
                        </div>

                        <!-- Add todo button changed to an input tag for consistency -->
                        <input name="todo_submit" type="submit" class="btn btn-purple" value="Add to My List">

                    </form>
                </div>
            </div>
        </div>
        <div class="todo-list row my-5">
            <div class="col-sm-12">
                <?php

                    // My Todo List
                    // ----------

                    // Store the user id session information in a variable
                    $user_id = $_SESSION["user_id"];

                    // Select all(*) columns that have todo_status of 0 from the todos table in the database and put them in a variable called sql
                    // JOIN keyword is used to combine/join rows from two or more tables and merge the matching values together using ON keyword.
                    // JOIN syntax: JOIN (table_name we want to join) ON (matching records from different tables)
                    // We are selecting todos that are active (0 = active 1 = completed) and joining the cats table to combine the matching category data 
                    // Add another filtering option using AND to display todos that belong to the currently logged in user in the session.
                    $sql = "SELECT * FROM todos
                            JOIN cats ON todos.todo_cat_id = cats.cat_id
                            WHERE todo_status = 0
                                AND todos.todo_user_id = ?";

                    // Prepare our SQL query and create a variable called stmt (statement) that holds our prepared query statement. A prepared statement is used to execute the same statement repeatedly with high efficiency. It also helps avoiding SQL injection attacks.
                    $stmt = $connection->prepare($sql);

                    // Bind the variable to the prepared statement as parameter
                    // Update the placeholder with the user id in session 
                    $stmt->bind_param("i", $user_id);

                    // Execute previously prepared statement and run our query
                    $stmt->execute();

                    // Manage the returned data by getting a result set from a prepared statement and store it in a variable named result
                    $result = $stmt->get_result();

                    echo "<h2 class='mt-4 mb-4'>My Todo List</h2>";
                    echo "<div class='row mb-6'>";

                        // fetch_assoc() grabs the next entry in the result as an associative array
                        // Store that fetched array in a variable called row
                        // while there is data to be fetched from the database, run this code inside the while loop (this creates a card for each todo)
                        // The row of returned data will be added as a next row every time the loop runs until there are no more results.
                        while($row = $result->fetch_assoc()):

                            echo "<div class='col-md-6'>";
                                echo "<div class='card mb-5'>";
                                    echo "<div class='card-body'>";
                                    
                                        // todo's id will be displayed in the URL as part of name/value pair derived from the result
                                        // The path of the link indicates the URL of that particular todo being sent to completed.php
                                        // Make sure the data pulled from database have any special characters converted to HTML Entities using the function we created to prevent malicious scripting attempts 
                                        echo "<a class='float-right btn btn-purple' href='app/completed.php?id=".  ws_html_spc($row["todo_id"]). "'>completed</a>";

                                        // As cats table has been joined to todos table, we can now use cat_name to display category name
                                        echo "<strong>" . ws_html_spc($row["cat_name"]). "</strong>";

                                        // Grab the value of title that is associated with todo_title key in the associative array and display it on screen
                                        echo "<h3>" . ws_html_spc($row["todo_title"]). "</h3>";

                                        // Grab the value of todo's content/text that is associated with todo_text key in the associative array and display it on screen
                                        echo "<p>" . ws_html_spc($row["todo_text"]). "</p>";

                                        // Grab the value of the date the todo was created on that is associated with todo_date key in the associative array and display it on screen
                                        echo "<p>" . ws_html_spc($row["todo_date"]). "</p>";

                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";

                        // end of while loop
                        endwhile;

                    echo "</div>";

                    // Completed todoS
                    // ----------

                    // Select all(*) columns that has todo_status of 1 from a table named todos in database and put them in a sql variable
                    // We are selecting todos that have been completed (0 = active 1 = completed) and combining cats table to merge the matching category data from cats and todos tables.
                    // Add another filtering option using AND to display todos that belong to the currently logged in user in the session.
                    $sql = "SELECT * FROM todos
                            JOIN cats ON todos.todo_cat_id = cats.cat_id
                            WHERE todo_status = 1
                                AND todos.todo_user_id = ?";
                    
                    // Prepare our query and store it in stmt variable
                    $stmt = $connection->prepare($sql);

                    // Update the placeholder with the user id stored in the session
                    $stmt->bind_param("i", $user_id);

                    // Execute and run our prepared statement
                    $stmt->execute();

                    // Manage the returned data by getting a result set from the statement and store it in a result variable
                    $result = $stmt->get_result();

                    echo "<h2 class='mt-4 mb-4'>Completed Todos</h2>";
                    echo "<div class='row mb-6'>";

                        // Create a variable called row which holds an associative array fetched and returned from the result set
                        // Loop through the array and display the following code on screen until there are no more data/results to grab from the database
                        while($row = $result->fetch_assoc()):
                            
                            echo "<div class='col-md-6'>";
                                echo "<div class='card text-white bg-dark mb-5'>";
                                    echo "<div class='card-body'>";

                                        // When clicking on Delete button, the data of that particular todo with the specified id will be sent to delete.php and removed accordingly.
                                        // Make sure the data pulled from database have any special characters converted to HTML Entities using the function we created to prevent malicious scripting attempts.
                                        echo "<a class='float-right btn btn-red' href='app/delete.php?id=" . ws_html_spc($row["todo_id"]). "'>Delete</a>";

                                        // As cats table has been joined to todos table, we can now use cat_name to display category name
                                        echo "<strong>" . ws_html_spc($row["cat_name"]). "</strong>";

                                        // Display the todo's title by grabbing the value associated with todo_title key from the key value pair in the the associative array
                                        echo "<h3>" . ws_html_spc($row["todo_title"]). "</h3>";

                                        // Display the todo's content by grabbing the value associated with todo_text key from the key value pair in the associative array
                                        echo "<p>" . ws_html_spc($row["todo_text"]). "</p>";

                                        // Display the date the todo was created on by grabbing the value associated with todo_date key from the key value pair in the associative array
                                        echo "<p>" . ws_html_spc($row["todo_date"]). "</p>";

                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";

                        // end of while loop
                        endwhile;

                    echo "</div>";
                ?>
            </div>
        </div>
    </div>
</section>
<!-- End of todos -->
