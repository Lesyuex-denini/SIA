<?php
session_start();


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


header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
error_log(print_r($data, true));


if (isset($data['subject'], $data['section'], $data['schedule'], $data['room'], $data['credit_units']) && isset($_SESSION['user_id'])) {
    $subject = $data['subject'];
    $section = $data['section'];
    $schedule = $data['schedule'];
    $room = $data['room'];
    $credit_units = $data['credit_units'];


    $userId = $_SESSION['user_id'];

    try {
        $query = "INSERT INTO enrollments (user_id, subject, section, schedule, room, credit_units) 
                  VALUES (:user_id, :subject, :section, :schedule, :room, :credit_units)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':schedule', $schedule);
        $stmt->bindParam(':room', $room);
        $stmt->bindParam(':credit_units', $credit_units, PDO::PARAM_INT);

        $stmt->execute();

        $response = [
            'success' => true,
            'message' => 'Successfully enrolled in ' . $subject . ' - ' . $section
        ];
    } catch (PDOException $e) {
        $response = [
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid data received or user not logged in.'
    ];
}

echo json_encode($response);
?>