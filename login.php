<?php
include 'connect.php'; // Include the connection script

$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['uname']) && isset($_POST['upassword'])) {
        // Collect and sanitize input data
        $uname = htmlspecialchars($_POST['uname']);
        $upassword = htmlspecialchars($_POST['upassword']);

        // Prepare and execute a query to find the user
        $stmt = $conn->prepare("SELECT upassword FROM register WHERE uname = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($upassword, $hashed_password)) {
                // Start a session and set session variables
                session_start();
                $_SESSION['username'] = $uname;
                echo "<script>alert('Login successful. Welcome back, $uname!'); window.location.href = 'index.php';</script>";
                exit();
            } else {
                $message = "Invalid username or password.";
            }
        } else {
            $message = "Username not found.";
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: #f7f7f7;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            text-align: right;
        }
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Login</h1>
        <?php if ($message != ""): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="uname" class="form-label">Username:</label>
                <input type="text" id="uname" name="uname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="upassword" class="form-label">Password:</label>
                <input type="password" id="upassword" name="upassword" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="submit" value="Login" class="btn btn-primary w-100">
            </div>
            <div class="forgot-password">
                <a href="reset_password.php">Forgot Password?</a>
            </div>
        </form>
    </div>
</body>
</html>
