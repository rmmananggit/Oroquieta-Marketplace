<?php
session_start();
include('../Admin/config/config.php');

// Check if OTP form is submitted
if (isset($_POST['verify_otp'])) {
    // Combine the OTP values from the array into a single string
    $otpEntered = implode('', $_POST['otp']);
    $userId = $_SESSION['auth_user']['userId']; // Assuming userId is stored in the session

    // Retrieve OTP and role from the database
    $query = "SELECT otp, role FROM users WHERE user_id = '$userId' LIMIT 1";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data && $data['otp'] === $otpEntered) {
        // OTP matches, update account status to Active
        $updateQuery = "UPDATE users SET account_status = 'Active' WHERE user_id = '$userId'";
        if (mysqli_query($con, $updateQuery)) {
            $_SESSION['status'] = "Your account is now verified. You can now log in!";
            $_SESSION['status_code'] = "success";
            header("Location: ../Login/index.php");
            exit();
        } else {
            $_SESSION['status'] = "Error updating account status!";
            $_SESSION['status_code'] = "error";
            header("Location: ../otp.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Invalid OTP!";
        $_SESSION['status_code'] = "error";
        header("Location: ../Login/otp.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f8f9fa; }
        .otp-input { width: 50px; height: 50px; text-align: center; font-size: 1.5rem; margin: 0 5px; border: 1px solid #ced4da; border-radius: 5px; }
        .otp-input:focus { border-color: #007bff; outline: none; }
    </style>
</head>
<body>
    <div class="card border-0 shadow-lg" style="width: 400px;">
        <div class="card-body text-center p-5">
            <h4 class="mb-3">Verify Your Identity</h4>
            <p class="text-muted mb-4">Enter the OTP sent to your email</p>
            <form method="POST">
                <div class="form-group d-flex justify-content-center">
                    <input type="text" maxlength="1" class="otp-input" name="otp[]" autofocus>
                    <input type="text" maxlength="1" class="otp-input" name="otp[]">
                    <input type="text" maxlength="1" class="otp-input" name="otp[]">
                    <input type="text" maxlength="1" class="otp-input" name="otp[]">
                    <input type="text" maxlength="1" class="otp-input" name="otp[]">
                    <input type="text" maxlength="1" class="otp-input" name="otp[]">
                </div>
                <button type="submit" name="verify_otp" class="btn btn-primary btn-block mt-4">Verify</button>
                <p class="text-muted mt-3">
                    Didn't receive the code? <a href="#" class="text-primary">Resend</a>
                </p>
            </form>
        </div>
    </div>

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    </script>
</body>
</html>
