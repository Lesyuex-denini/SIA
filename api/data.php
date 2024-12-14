<?php
$host = 'localhost';
$dbname = 'sholaire_enrollment';
$username = 'root';
$password = '';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Corrected SQL query
$sql = "SELECT * FROM enrollments";

// Execute the query
$result = $conn->query($sql);

// Check if the query returned any results
if ($result->num_rows > 0) {
    // Fetch all results into an associative array
    $enrollments = $result->fetch_all(MYSQLI_ASSOC);

    // Return the results as a JSON response
    echo json_encode($enrollments, JSON_PRETTY_PRINT);
} else {
    echo json_encode('', JSON_PRETTY_PRINT); // No results
}

// Close the connection
$conn->close();
?>