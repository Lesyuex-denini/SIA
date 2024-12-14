<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated.']);
    exit();
}

include '../db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $name = isset($data['name']) ? htmlspecialchars($data['name']) : null;
    $contact = isset($data['contact']) ? htmlspecialchars($data['contact']) : null;
    $biography = isset($data['biography']) ? htmlspecialchars($data['biography']) : null;
    $links = isset($data['links']) ? htmlspecialchars($data['links']) : null;

    $updateFields = [];
    $params = ['user_id' => $_SESSION['user_id']];

    if ($name) {
        $updateFields[] = "name = :name";
        $params['name'] = $name;
    }
    if ($contact) {
        $updateFields[] = "contact = :contact";
        $params['contact'] = $contact;
    }
    if ($biography) {
        $updateFields[] = "biography = :biography";
        $params['biography'] = $biography;
    }
    if ($links) {
        $updateFields[] = "links = :links";
        $params['links'] = $links;
    }

    if (empty($updateFields)) {
        echo json_encode(['error' => 'No fields to update.']);
        exit();
    }

    $updateSQL = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = :user_id";
    $stmt = $pdo->prepare($updateSQL);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['error' => 'No changes were made.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>