<?php
require 'connect.php'; // Adjust the path if necessary

header('Content-Type: application/json');

// Fetch all courses from the database
$sql = "SELECT course_name, course_code, brief_description FROM courses";
$result = $conn->query($sql);

$courses = array();
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode($courses);

$conn->close();
?>
