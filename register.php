<?php
include 'connect.php'; // Include the connection script

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $fname = htmlspecialchars($_POST['fname']);
    $sname = htmlspecialchars($_POST['sname']);
    $lname = htmlspecialchars($_POST['lname']);
    $uname = htmlspecialchars($_POST['uname']);
    $uemail = htmlspecialchars($_POST['uemail']);
    $ucontacts = htmlspecialchars($_POST['ucontacts']);
    $upassword = htmlspecialchars($_POST['upassword']);

    // Hash the password for security
    $hashed_password = password_hash($upassword, PASSWORD_DEFAULT);

    // File upload
    $cvfile = $_FILES['ucvfile']['name'];
    $cvfile_tmp = $_FILES['ucvfile']['tmp_name'];
    $cvfile_error = $_FILES['ucvfile']['error'];

    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($cvfile);

    // Validate and move the uploaded file
    if ($cvfile_error === UPLOAD_ERR_OK) {
        if (move_uploaded_file($cvfile_tmp, $upload_file)) {
            echo "File uploaded successfully.";
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "Error uploading file.";
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM register WHERE uname = ? OR uemail = ?");
    $stmt->bind_param("ss", $uname, $uemail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username or email already exists, redirect to login page with a message
        echo "<script>alert('Username or email already exists. Please log in.'); window.location.href = 'login.php';</script>";
        exit();
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO register (fname, sname, lname, uname, uemail, ucontacts, cvfile, upassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Check if statement preparation was successful
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssss", $fname, $sname, $lname, $uname, $uemail, $ucontacts, $cvfile, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('New record created successfully'); window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="register.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="mb-3">
                <label for="fname" class="form-label">First Name:</label>
                <input type="text" id="fname" name="fname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="sname" class="form-label">Surname:</label>
                <input type="text" id="sname" name="sname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name:</label>
                <input type="text" id="lname" name="lname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="uname" class="form-label">Username:</label>
                <input type="text" id="uname" name="uname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="uemail" class="form-label">Email:</label>
                <input type="email" id="uemail" name="uemail" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ucontacts" class="form-label">Contacts:</label>
                <input type="text" id="ucontacts" name="ucontacts" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="upassword" class="form-label">Password:</label>
                <input type="password" id="upassword" name="upassword" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ucvfile" class="form-label">Upload CV:</label>
                <input type="file" id="ucvfile" name="ucvfile" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="submit" value="Register" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>
