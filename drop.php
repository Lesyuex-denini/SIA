<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'sholaire_enrollment';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Drop course functionality
if (isset($_GET['drop_course_id']) && isset($_SESSION['user_id'])) {
    $courseId = $_GET['drop_course_id'];
    $userId = $_SESSION['user_id'];

    // Check if the course is assigned to the user
    $checkQuery = "SELECT id FROM enrollments WHERE id = :course_id AND user_id = :user_id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
    $checkStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Drop the course if it exists for the user
        $dropQuery = "DELETE FROM enrollments WHERE id = :course_id AND user_id = :user_id";
        $dropStmt = $pdo->prepare($dropQuery);
        $dropStmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $dropStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($dropStmt->execute()) {
            echo "<script>alert('Course dropped successfully.'); window.location.href = 'enrolled.php';</script>";
        } else {
            echo "<script>alert('Failed to drop the course.');</script>";
        }
    } else {
        echo "<script>alert('You are not authorized to drop this course.');</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'enrolled.php';</script>";
}
?>