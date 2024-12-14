<?php
header('Content-Type: application/json');
include '../db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['email']) || !isset($data['password'])) {
        echo json_encode(['error' => 'Email and password are required.']);
        exit();
    }

    $email = $data['email'];
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];

        echo json_encode(['message' => 'Login successful', 'user_id' => $user['id']]);
    } else {
        echo json_encode(['error' => 'Invalid email or password.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>