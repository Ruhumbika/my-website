<?php
require 'connect.php'; // Adjust based on your actual path

// Retrieve the course ID from the URL
$id = $_GET['id'];

// Fetch the course details from the database
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this course?');
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Update Course</h2>
        <form action="update_course.php" method="post" onsubmit="return confirmUpdate();" >
            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
            <div class="mb-3">
                <label for="course_name" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="course_code" class="form-label">Course Code</label>
                <input type="text" class="form-control" id="course_code" name="course_code" value="<?php echo htmlspecialchars($course['course_code']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="brief_description" class="form-label">Brief Description</label>
                <input type="text" class="form-control" id="brief_description" name="brief_description" value="<?php echo htmlspecialchars($course['brief_description']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Semester</label><br>
                <input type="radio" name="semester" value="I" <?php echo ($course['semester'] == 'I') ? 'checked' : ''; ?>> I
                <input type="radio" name="semester" value="II" <?php echo ($course['semester'] == 'II') ? 'checked' : ''; ?>> II
            </div>
            <div class="mb-3">
                <label class="form-label">Year of Study</label><br>
                <input type="radio" name="year_of_study" value="I" <?php echo ($course['year_of_study'] == 'I') ? 'checked' : ''; ?>> I
                <input type="radio" name="year_of_study" value="II" <?php echo ($course['year_of_study'] == 'II') ? 'checked' : ''; ?>> II
                <input type="radio" name="year_of_study" value="III" <?php echo ($course['year_of_study'] == 'III') ? 'checked' : ''; ?>> III
                <input type="radio" name="year_of_study" value="IV" <?php echo ($course['year_of_study'] == 'IV') ? 'checked' : ''; ?>> IV
                <input type="radio" name="year_of_study" value="V" <?php echo ($course['year_of_study'] == 'V') ? 'checked' : ''; ?>> V
            </div>
            <div class="mb-3">
                <label for="instructor" class="form-label">Instructor</label>
                <input type="text" class="form-control" id="instructor" name="instructor" value="<?php echo htmlspecialchars($course['instructor']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlspecialchars($course['department']); ?>" required>
            </div>
            <div class="mb-3" >
                <label class="form-label">Grade</label><br>
                <input type="radio" name="grade" value="A" <?php echo ($course['grade'] == 'A') ? 'checked' : ''; ?>> A
                <input type="radio" name="grade" value="B" <?php echo ($course['grade'] == 'B') ? 'checked' : ''; ?>> B
                <input type="radio" name="grade" value="C" <?php echo ($course['grade'] == 'C') ? 'checked' : ''; ?>> C
                <input type="radio" name="grade" value="D" <?php echo ($course['grade'] == 'D') ? 'checked' : ''; ?>> D
                <input type="radio" name="grade" value="F" <?php echo ($course['grade'] == 'F') ? 'checked' : ''; ?>> F
            </div>
            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
