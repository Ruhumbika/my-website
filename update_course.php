<?php
require 'connect.php'; // Adjust based on your actual path

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $brief_description = $_POST['brief_description'];
    $semester = $_POST['semester'];
    $year_of_study = $_POST['year_of_study'];
    $instructor = $_POST['instructor'];
    $department = $_POST['department'];
    $grade = $_POST['grade'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("UPDATE courses SET course_name = ?, course_code = ?, brief_description = ?, semester = ?, year_of_study = ?, instructor = ?, department = ?, grade = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $course_name, $course_code, $brief_description, $semester, $year_of_study, $instructor, $department, $grade, $id);

    if ($stmt->execute()) {
        // Redirect to the view courses page with a success message
        header("Location: view_courses.php?message=Course updated successfully");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}
?>
