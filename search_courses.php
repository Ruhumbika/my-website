<?php
require 'connect.php'; // Adjust based on your actual path

// Fetch search results
$search = $_GET['search'];
$sql = "SELECT * FROM courses WHERE course_name LIKE ? OR course_code LIKE ?";
$stmt = $conn->prepare($sql);
$search_term = "%$search%";
$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

// Educational words
$words = [
    "Empower your knowledge!",
    "Learn. Grow. Succeed.",
    "Education is the key to success.",
    "Expand your horizons.",
    "Knowledge is power.",
    "Shape your future today!"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #ff7e5f, #feb47b); /* Attractive color mixture */
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .search-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 25px;
            margin-top: 20px;
            text-align: center;
            border: 1px solid #ced4da;
        }
        .search-container .form-control {
            border-radius: 25px;
            border: 1px solid #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s;
        }
        .search-container .form-control:focus {
            border-color: #0056b3;
        }
        .search-container .btn {
            border-radius: 25px;
            padding: 12px 25px;
            background: #007bff;
            color: white;
            font-weight: bold;
            transition: background 0.3s, box-shadow 0.3s;
        }
        .search-container .btn:hover {
            background: #0056b3;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .dynamic-notification {
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            animation: text-animate 5s infinite;
        }
        @keyframes text-animate {
            0% { color: #ff6347; }
            25% { color: #ffeb3b; }
            50% { color: #4caf50; }
            75% { color: #00bcd4; }
            100% { color: #ff6347; }
        }
        .table-wrapper {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 25px;
            margin-top: 20px;
        }
        .table {
            border-radius: 12px;
            overflow: hidden;
        }
        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
        }
        .profile-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-top: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .profile-card img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .profile-card h3 {
            color: #007bff;
            font-size: 28px;
            margin-top: 15px;
        }
        .profile-card p {
            color: #333;
            font-size: 18px;
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
        .dynamic-words {
            font-size: 22px;
            color: #007bff;
            white-space: nowrap;
            overflow: hidden;
            animation: color-change 10s infinite;
        }
        @keyframes color-change {
            0% { color: #ff6347; }
            25% { color: #ffeb3b; }
            50% { color: #4caf50; }
            75% { color: #00bcd4; }
            100% { color: #ff6347; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Search Section -->
        <div class="search-container">
            <h2>Find Your Course</h2>
            <form action="search_courses.php" method="get">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search courses" aria-label="Search courses">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Dynamic Notification Section -->
        <div class="notification-container">
            <div class="dynamic-notification">
                <div class="dynamic-words">
                    <?php echo $words[array_rand($words)]; ?>
                </div>
            </div>
        </div>

        <!-- Courses Table Section -->
        <div class="table-wrapper">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Course Name</th>
                        <th scope="col">Course Code</th>
                        <th scope="col">Brief Description</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Year of Study</th>
                        <th scope="col">Instructor</th>
                        <th scope="col">Department</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['brief_description']); ?></td>
                        <td><?php echo htmlspecialchars($row['semester']); ?></td>
                        <td><?php echo htmlspecialchars($row['year_of_study']); ?></td>
                        <td><?php echo htmlspecialchars($row['instructor']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                        <td><?php echo htmlspecialchars($row['grade']); ?></td>
                        <td>
                            <a href='update_form.php?id=<?php echo $row['id']; ?>' class='btn btn-warning btn-sm'>Update</a>
                            <a href='delete_course.php?id=<?php echo $row['id']; ?>' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Developer Profile Section -->
        <div class="profile-card">
            <img src="img/rjayprofile1.png" alt="Profile Picture">
            <h3>About the Developer</h3>
            <p>Hello! I’m Ruhumbika Mtumba John, the creator of this website. I’m passionate about web development and committed to providing a great learning experience. Feel free to ask me about my journey or how I developed this site. Let’s explore the world of knowledge together!</p>
            <p>Contact: <a href="tel:+254787550399">0787550399</a> | Email: <a href="mailto:ruhumbikamtumbajohn@gmail.com">ruhumbikamtumbajohn@gmail.com</a></p>
            <p>Connect with me on social media:</p>
            <div class="social-links">
                <a href="https://www.youtube.com/c/ruhumbikamtumbajohn" target="_blank">
                    <img src="https://img.icons8.com/ios-filled/50/000000/youtube-play.png" alt="YouTube">
                </a>
                <a href="https://www.tiktok.com/@rjay20020701" target="_blank">
                    <img src="https://img.icons8.com/ios-filled/50/000000/tiktok.png" alt="TikTok">
                </a>
                <a href="https://twitter.com/Rjay20020701" target="_blank">
                    <img src="https://img.icons8.com/ios-filled/50/000000/twitter.png" alt="Twitter">
                </a>
                <a href="https://www.instagram.com/rjay.huduma" target="_blank">
                    <img src="https://img.icons8.com/ios-filled/50/000000/instagram-new.png" alt="Instagram">
                </a>
                <a href="https://www.facebook.com/rjay" target="_blank">
                    <img src="https://img.icons8.com/ios-filled/50/000000/facebook.png" alt="Facebook">
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
