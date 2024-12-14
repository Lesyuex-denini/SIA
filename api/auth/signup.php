<?php
// Include database connection
include '../../db/db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['error' => 'Invalid data received.']);
    exit;
}

$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

// Check if email already exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch();
if ($user) {
    echo json_encode(['error' => 'Email is already registered.']);
    exit;
}

// Insert new user into the database
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Error creating account. Please try again.']);
}
?>