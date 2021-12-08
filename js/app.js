// Client-side form validation using jQuery Validation Plugin
// Documentation : https://jqueryvalidation.org/validate/

$(document).ready(function() {

    // Select a todo form using add_todo id and use validate() method which is accessible through jQuery Validate Plugin to validate the selected form.
    $("#add_todo").validate({

        // Define custom rules 
        rules: {

            // Properties are derived from the name attribute 
            // todo title
            title: {

                // todo title is a required field and should be at least 5 characters long.
                required: true,
                minlength: 5

            },

            // todo details content
            text: {

                // todo content is a required field and should be at least 10 characters long.
                required: true,
                minlength: 10

            },

            // Date the todo was created on
            date: {

                // Date input is a required field. 
                required: true

            }
        },

        // Define custom messages for the following form fields. If the inputs do not fulfill the rules defined above (not long enough or missing), these error messages will be shown to the user.
        messages: {

            // todo title
            title: "Please enter a title that is at least 5 character's long.",

            // todo details content
            text: "Please enter a description that is at least 10 character's long.",

            // Date the todo was created on
            date: "Please enter a due date for this to-do."
            
        },

        // Callback for handling the actual submit when the form is valid. Submit the form (the form currently being validate as a DOM element) after it gets validated. 
        submitHandler: function(form) {
            form.submit();
            
        }
    });


    // // message box fadeout
    // // var msgBox = document.querySelector(".alert-success");
    // setTimeout(function(){
    //     $(".alert-success").fadeOut();
    // }, 2000);

});