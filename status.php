<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

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

$userId = $_SESSION['user_id'];

$query = "SELECT e.subject, e.credit_units
          FROM enrollments e
          WHERE e.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();

$enrolledCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Enrollment Status</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 20px;
        }
    </style>
</head>


<body class="flex h-screen bg-gray-100">
    <aside class="w-full md:w-[500px] bg-[#DEAA79] p-12 flex flex-col justify-center">
        <a href="dashboard.php"
            class="block py-5 px-4 mb-4 text-black rounded-lg font-bold bg-white hover:bg-[#FFE6A9] transition text-center">Profile</a>
        <a href="available.php"
            class="block py-5 px-4 mb-4 text-black rounded-lg font-bold bg-white hover:bg-[#FFE6A9] transition text-center">Available
            Courses</a>
        <a href="enrolled.php"
            class="block py-5 px-4 mb-4 text-black rounded-lg font-bold bg-white hover:bg-[#FFE6A9] transition text-center">Enrolled
            Courses</a>
        <a href="status.php"
            class="block py-5 px-4 mb-4 text-black rounded-lg font-bold bg-white hover:bg-[#FFE6A9] transition text-center">Enrollment
            Status</a>
        <a href="index.php"
            class="block py-5 px-4 mb-4 text-black rounded-lg font-bold bg-white hover:bg-[#FFE6A9] transition text-center">Logout</a>
    </aside>


    <div class="flex-1 bg-white p-12">
        <div class="max-w-12xl mx-auto bg-white shadow-lg rounded-lg p-10">
            <h1 class="text-6xl font-bold text-gray-800 mb-6">Enrollment Status</h1>
            <?php if (count($enrolledCourses) > 0): ?>
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xl text-gray-700">Subject</th>
                            <th class="px-6 py-3 text-left text-xl text-gray-700">Credit Units</th>
                            <th class="px-6 py-3 text-left text-xl text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enrolledCourses as $course): ?>
                            <tr class="border-b">
                                <td class="px-6 py-3"><?= htmlspecialchars($course['subject']) ?></td>
                                <td class="px-6 py-3"><?= htmlspecialchars($course['credit_units']) ?></td>
                                <td class="px-6 py-3 text-green-500 font-semibold">Currently Enrolled</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-lg text-gray-700">You are not enrolled in any courses yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>