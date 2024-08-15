<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
// add_course.php

// Include the database connection
require 'connect.php';

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $course_name = mysqli_real_escape_string($conn, $_POST['cname']);
    $course_code = mysqli_real_escape_string($conn, $_POST['ccode']);
    $brief_description = mysqli_real_escape_string($conn, $_POST['cbe']);
    $semester = mysqli_real_escape_string($conn, $_POST['SOS']);
    $year_of_study = mysqli_real_escape_string($conn, $_POST['YOS']);
    $instructor = mysqli_real_escape_string($conn, $_POST['cinstructor']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);

    // Debugging output
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO courses (course_name, course_code, brief_description, semester, year_of_study, instructor, department, grade)
            VALUES ('$course_name', '$course_code', '$brief_description', '$semester', '$year_of_study', '$instructor', '$department', '$grade')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to the view_courses.php page upon successful insertion
        header('Location: view_courses.php');
        exit(); // Ensure no further code is executed after redirect
    } else {
        // Display an error message if query fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
