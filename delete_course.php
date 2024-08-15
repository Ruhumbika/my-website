<?php
require 'connect.php'; // Adjust based on your actual path

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
        // Redirect to the page that shows options to delete or update data
        header("Location: view_courses.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "No ID provided";
}
?>
