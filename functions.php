<?php

    // define() function is a built-in PHP function that defines a named constant (syntax: define(CONSTANT_NAME, VALUE, CASE_INSENSITIVE BOOL))
    // We are defining the SITE_URL constant as homepage as it will be used to redirect the user back to home with the header function
    define("SITE_URL", "http://things2do.heatherkim.ca/");

    // Start a function name with a custom prefix to facilitate testing/debugging process (so that we can know easily identify that the problem is from the function that we made)
    // ws: web scripting
    function ws_session_start() {

        // session_status() : returns the current session status
        // 0 = session disabled and not able to use it
        // 1 = sessions are supported/enabled but none is currently running sessions (doesn't exist yet)
        // 2 = session is enabled and it is already running (sessions already exists)

        // If the sessions are enabled but not running,
        if (session_status() === 1) {

            // then start the session
            session_start();
            
        }
    }

    // Create a function that prevents cross-site scripting attacks. These attack the website by running unintended external JavaScript and attempt to steal session/ login info and user keystrokes.
    function ws_html_spc($data) {

        // Using htmlspecialchars(), a built-in PHP function, return the data after converting special characters to HTML Entities so that they don't get rendered as HTML.
        // eg. data input that has "<script>" will be converted to "&lt;script&gt;"
        return htmlspecialchars($data);

    }
?>