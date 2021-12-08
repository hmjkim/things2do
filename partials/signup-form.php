<!-- Sign Up Form -->
<div class="row justify-content-center">
    <div class="col-sm-6">        
        <div class="card mb-5 mt-5">
            <div class="card-body"> 
                <h3 class="mb-5">Sign Up</h3>

                <!-- POST doesn't use URL (instead uses http request). The data will be sent to signup.php -->
                <form action="app/signup.php" method="POST">
                
                    <div class="form-group">
                        <label for="signup_email">Email address</label>
                        <input type="text" class="form-control" id="signup_email" name="signup_email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="signup_password">Password</label>
                        <input type="password" class="form-control" id="signup_password" name="signup_password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="signup_password_confirm">Re-type Password</label>
                        <input type="password" class="form-control" id="signup_password_confirm" name="signup_password_confirm" placeholder="Password">
                    </div>                                
                    <input name="signup_submit" type="submit" class="btn btn-purple" value="Sign Up">
                </form>
            </div>
        </div>
    </div>
</div>
