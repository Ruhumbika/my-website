<?php
include 'connect.php'; // Adjust the path as necessary

$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

$courses = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

echo json_encode($courses);

$conn->close();
?>
