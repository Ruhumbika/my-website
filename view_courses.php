<?php
require 'connect.php'; // Adjust based on your actual path

// Fetch all courses
$result = $conn->query("SELECT * FROM courses");

// Check if there's a message to display
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(135deg, #ff7e5f, #feb47b); /* Attractive color mixture */
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        #footer {
            width: 100%;
            /* Make the footer div full width */
            padding: 10px 0;
            /* Add some padding for spacing */
            background-color: #f8f9fa;
            /* Light background color */
        }

        #end {
            margin: 6px;
            /* Remove default margins */
            /* Adjust font size */
        }

        #footer p {
            margin: 8.5%;
            /* Ensure there's no additional margin */
        }

        .contact-info {
            background: linear-gradient(135deg, #1e3c72, #2a5298); /* Vibrant gradient background */
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .contact-info h3 {
            color: #fff;
        }

        .contact-info a {
            color: #ffd700; /* Golden color for links */
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }
        
        
        .social-links {
            margin-top: 15px;
        }
        .social-links a {
            margin: 0 10px;
            display: inline-block;
            color: #333;
            text-decoration: none;
        }
        .social-links img {
            width: 30px;
            height: 30px;
            vertical-align: middle;
        }
        .contacts{
            display: block; /* Display each contact item on a new line */
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
            color: #555;
        }
        .contacts a {
            color: #007bff;
            text-decoration: none;
        }

        .contacts a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <button class="btn btn-primary my-5">
            <a href="search.html" class="text-light" style="text-decoration: none;">Search Course</a>
        </button>

        <?php if ($message): ?>
        <div class="alert alert-success mt-4" role="alert" id="success-message">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <h2 class="my-4" id="end">Courses List</h2>
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Course Code</th>
                    <th>Brief Description</th>
                    <th>Semester</th>
                    <th>Year of Study</th>
                    <th>Instructor</th>
                    <th>Department</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['brief_description']); ?></td>
                    <td><?php echo htmlspecialchars($row['semester']); ?></td>
                    <td><?php echo htmlspecialchars($row['year_of_study']); ?></td>
                    <td><?php echo htmlspecialchars($row['instructor']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                    <td><?php echo htmlspecialchars($row['grade']); ?></td>
                    <td>
                        <!-- Buttons are in the same line horizontally -->
                        <a href="update_form.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                        <a href="delete_course.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Contact Information Section -->
        <div class="contact-info text-center">
            <h3>About the Developer</h3>
            <p>Hello! I’m Ruhumbika Mtumba John, the creator of this website. I’m passionate about web development and committed to providing a great learning experience. Feel free to ask me about my journey or how I developed this site. Let’s explore the world of knowledge together!</p>
            <p class="contacts">Contact: <a href="tel:+254787550399">0787550399</a> | Email: <a href="mailto:ruhumbikamtumbajohn@gmail.com">ruhumbikamtumbajohn@gmail.com</a></p>
            <p>Connect with me on social media:</p>
            <div class="social-links">
            <p>
                <a href="https://www.youtube.com/c/ruhumbikamtumbajohn" target="_blank">
                <img src="https://img.icons8.com/ios-filled/50/000000/youtube-play.png" alt="YouTube">
                </a> |
                <a href="https://www.tiktok.com/@rjay20020701" target="_blank">
                <img src="https://img.icons8.com/ios-filled/50/000000/tiktok.png" alt="TikTok">
                </a> |
                <a href="https://twitter.com/Rjay20020701" target="_blank">
                <img src="https://img.icons8.com/ios-filled/50/000000/twitter.png" alt="Twitter">
                </a> |
                <a href="https://www.instagram.com/rjay.huduma" target="_blank">
                <img src="https://img.icons8.com/ios-filled/50/000000/instagram-new.png" alt="Instagram">
                </a> |
                <a href="https://www.facebook.com/rjay" target="_blank">
                <img src="https://img.icons8.com/ios-filled/50/000000/facebook.png" alt="Facebook">
                </a>
            </p>
            </div>
        </div>
    </div>

    <div id="footer" class="text-center mt-5">
        <p id="end" class="my-4">OFFICIAL RUHUMBIKA'S WEBSITE<br>©2024</p>
        <p id="cd"></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
    // Automatically hide success message after 5 seconds
    setTimeout(function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000); // 5 seconds
    </script>
</body>

</html>
