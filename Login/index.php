<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Modal container */
        .modal {
            display: none; /* Initially hidden */
            position: fixed; /* Fixed position */
            top: 0; /* Align top */
            left: 0; /* Align left */
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1000; /* Ensure it appears on top */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            display: flex; /* Enable flexbox for centering */
        }

        /* Modal content */
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 400px; /* Width of the modal */
            max-width: 100%; /* Ensure it doesn't overflow */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            position: relative; /* For positioning the close button */
        }

        /* Close button for modal */
        .close-btn {
            position: absolute;
            top: 2px;
            right: 10px;
            font-size: 25px;
            color: #aaa;
            cursor: pointer;
        }

        .close-btn:hover {
            color: black;
        }

        /* Button styles */
        .role-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .role-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<?php session_start(); ?>

<body>

    <div class="main">

        <!-- Sign in form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sign in image"></figure>
                        <a href="javascript:void(0)" class="signup-image-link" id="signup-btn">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form method="POST" action="./controller/login.php" autocomplete="off" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username" required/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Modal for Sign Up Options -->
    <div id="signup-modal" class="modal">
        <div class="modal-content">
            <!-- Close Button inside modal -->
            <span class="close-btn" id="close-modal">&times;</span>
            <button id="merchant-btn" class="role-btn">Merchant</button>
            <button id="user-btn" class="role-btn">User</button>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
  if(isset($_SESSION['status']) && $_SESSION['status_code'] !='') {
      ?>
      <script>
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "<?php echo $_SESSION['status_code']; ?>",
          title: "<?php echo $_SESSION['status']; ?>"
        });
      </script>
      <?php
      unset($_SESSION['status']);
      unset($_SESSION['status_code']);
  }     
?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        // Ensure the modal is hidden when the page loads
        document.getElementById('signup-modal').style.display = 'none';

        // Open the modal when the "Create an account" link is clicked
        document.getElementById('signup-btn').onclick = function() {
            document.getElementById('signup-modal').style.display = 'flex'; // Show modal
        }

        // Close the modal when the "x" button inside the modal is clicked
        document.getElementById('close-modal').onclick = function() {
            document.getElementById('signup-modal').style.display = 'none'; // Hide modal
        }

        // Handle role selection
        document.getElementById('merchant-btn').onclick = function() {
            window.location.href = 'registerVendor.php'; // Redirect to merchant signup page
        }

        document.getElementById('user-btn').onclick = function() {
            window.location.href = 'registerUser.php'; // Redirect to user signup page
        }
    </script>

</body>
</html>
