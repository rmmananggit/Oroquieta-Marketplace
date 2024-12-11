<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up as Vendor</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<?php session_start(); ?>
<body>

    <div class="main">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up as Vendor</h2>
                        <form method="POST"  action="./controller/registerVendor.php" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="firstName"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="firstName" id="firstName" placeholder="First Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="middleName"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="middleName" id="middleName" placeholder="Middle Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="lastName"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="lastName" id="lastName" placeholder="Last Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="emailAddress"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="emailAddress" id="emailAddress" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="userName"><i class="zmdi zmdi-account"></i></i></label>
                                <input type="text" name="userName" id="userName" placeholder="Username" required/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree to all statements in  <a href="#" class="term-service">Terms of Service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sign up image"></figure>
                        <a href="index.php" class="signup-image-link">I am already a member</a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
