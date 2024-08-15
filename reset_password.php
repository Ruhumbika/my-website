<?php
include 'connect.php'; // Include the connection script

$message = "";
$reset_error = "";
$step = "verify"; // Default step

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $step = isset($_POST['step']) ? $_POST['step'] : "verify";

    if ($step == "verify") {
        // Handle the initial verification step
        $uname = isset($_POST['uname']) ? htmlspecialchars($_POST['uname']) : '';
        $uemail = isset($_POST['uemail']) ? htmlspecialchars($_POST['uemail']) : '';
        $ucontacts = isset($_POST['ucontacts']) ? htmlspecialchars($_POST['ucontacts']) : '';

        $stmt = $conn->prepare("SELECT id FROM register WHERE uname = ? AND uemail = ? AND ucontacts = ?");
        if ($stmt === false) {
            die('Error preparing the SQL statement: ' . $conn->error);
        }
        $stmt->bind_param("sss", $uname, $uemail, $ucontacts);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $step = "reset"; // Move to the reset step
        } else {
            $reset_error = "Invalid details. User not found.";
        }
        $stmt->close();
    } elseif ($step == "reset") {
        // Handle the reset password step
        $uname = isset($_POST['uname']) ? htmlspecialchars($_POST['uname']) : '';
        $uemail = isset($_POST['uemail']) ? htmlspecialchars($_POST['uemail']) : '';
        $ucontacts = isset($_POST['ucontacts']) ? htmlspecialchars($_POST['ucontacts']) : '';
        $new_password = isset($_POST['new_password']) ? htmlspecialchars($_POST['new_password']) : '';
        $confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : '';

        if ($new_password !== $confirm_password) {
            $reset_error = "Passwords do not match.";
        } else {
            $stmt = $conn->prepare("SELECT id FROM register WHERE uname = ? AND uemail = ? AND ucontacts = ?");
            if ($stmt === false) {
                die('Error preparing the SQL statement: ' . $conn->error);
            }
            $stmt->bind_param("sss", $uname, $uemail, $ucontacts);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id);
                $stmt->fetch();
                $stmt->close();

                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE register SET upassword = ? WHERE id = ?");
                if ($stmt === false) {
                    die('Error preparing the SQL statement: ' . $conn->error);
                }
                $stmt->bind_param("si", $new_password_hash, $user_id);
                if ($stmt->execute()) {
                    $message = "Password reset successful.";
                    $step = "final"; // Move to the final step
                } else {
                    $reset_error = "Error updating the password.";
                }
                $stmt->close();
            } else {
                $reset_error = "Invalid details. User not found.";
            }
            $conn->close();
        }
    } elseif ($step == "final") {
        // Handle the final choice
        if (isset($_POST['continue'])) {
            header("Location: index.html");
            exit();
        } else {
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Internal CSS -->
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .notification {
            position: absolute;
            top: 20px;
            width: 90%;
            left: 5%;
            padding: 20px;
            border-radius: 10px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            display: none;
        }
        .notification.show {
            display: block;
        }
        .notification.left {
            left: 0;
        }
        .notification.right {
            right: 0;
        }
        .notification.center {
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>

    <div class="container">
        <?php if ($reset_error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $reset_error; ?>
            </div>
        <?php endif; ?>

        <?php if ($step == "verify"): ?>
            <!-- Verification form -->
            <form action="reset_password.php" method="post">
                <input type="hidden" name="step" value="verify">
                <div class="form-group">
                    <label for="uname" class="form-label">Username:</label>
                    <input type="text" id="uname" name="uname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="uemail" class="form-label">Email:</label>
                    <input type="email" id="uemail" name="uemail" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ucontacts" class="form-label">Contact Number:</label>
                    <input type="text" id="ucontacts" name="ucontacts" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verify Details</button>
            </form>
        <?php elseif ($step == "reset"): ?>
            <!-- Reset password form -->
            <form action="reset_password.php" method="post">
                <input type="hidden" name="step" value="reset">
                <input type="hidden" name="uname" value="<?php echo htmlspecialchars($uname); ?>">
                <input type="hidden" name="uemail" value="<?php echo htmlspecialchars($uemail); ?>">
                <input type="hidden" name="ucontacts" value="<?php echo htmlspecialchars($ucontacts); ?>">
                <div class="form-group">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
        <?php elseif ($step == "final"): ?>
            <!-- Final step -->
            <div class="notification center show" id="final-notification" style="background-image: url('img/notification-background.png');">
                <h4>Password reset successful.</h4>
                <form action="reset_password.php" method="post">
                    <input type="hidden" name="step" value="final">
                    <button type="submit" name="continue" class="btn btn-success w-100 mb-2">Continue</button>
                    <button type="submit" name="no" class="btn btn-danger w-100">No, take me to login</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Developer Info Button -->
        <a href="developer_detail.php" class="btn btn-info w-100 mt-3">Learn About the Developer</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
