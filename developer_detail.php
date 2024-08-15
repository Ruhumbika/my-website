<?php
require 'connect.php'; // Adjust based on your actual path

// Initialize the search variable safely
$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    // Fetch search results
    $sql = "SELECT * FROM courses WHERE course_name LIKE ? OR course_code LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%$search%";
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = []; // Default to an empty array if no search term is provided
}

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
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ff7e5f, #feb47b); /* Attractive color mixture */
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .notification-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .notification {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .notification h2 {
            color: #007bff;
        }
        .dynamic-notification {
            font-size: 26px;
            font-weight: bold;
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
        .modal-content {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
        }
        .modal-body img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .modal-body h3 {
            color: #007bff;
        }
        .modal-body p {
            color: #333;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Existing content for reset password -->

        <!-- Button to trigger developer info modal -->
        <div class="text-center mt-4">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#developerModal">
                Learn About the Developer
            </button>
        </div>

        <!-- Developer Information Modal -->
        <div class="modal fade" id="developerModal" tabindex="-1" aria-labelledby="developerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="developerModalLabel">About the Developer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="img/rjayprofile1.png" alt="Profile Picture">
                        <h3>Ruhumbika Mtumba John</h3>
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
            </div>
        </div>

        <!-- Existing content for reset password -->
        <!-- Your form or other content goes here -->
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
