<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$name = $_SESSION['name'] ?? 'Default Name';
$contact = $_SESSION['contact'] ?? 'Not provided';
$biography = $_SESSION['biography'] ?? 'No biography provided';
$links = $_SESSION['links'] ?? 'No links provided';
$profile_picture = $_SESSION['profile_picture'] ?? 'uploads/profile_pictures/default-profile.png';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <div class="flex-1 p-12">
        <div class="bg-white rounded-lg p-16 shadow-md">
            <div class="flex items-center mb-20">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile picture of the user"
                    class="w-36 h-36 rounded-full mr-6">
                <h1 class="text-5xl font-bold text-gray-800"><?php echo htmlspecialchars($name); ?></h1>
            </div>

            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-2">Contact Information</h2>
                <p class="text-lg"><?php echo htmlspecialchars($contact); ?></p>
            </div>

            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-2">Biography</h2>
                <p class="text-lg"><?php echo htmlspecialchars($biography); ?></p>
            </div>

            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-2">Links</h2>
                <p class="text-lg"><?php echo htmlspecialchars($links); ?></p>
            </div>
        </div>
        <button
            class="mt-6 bg-[#DEAA79] text-white py-2 px-4 rounded-lg font-bold shadow-md hover:bg-[#A59D84] transition"
            onclick="openModal()">Edit Profile</button>

        <!-- Modal Structure -->
        <div id="editProfileModal"
            class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="modal-content relative bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                <button onclick="closeModal()" class="close-btn text-[#DEAA79] text-xl absolute top-4 right-4">
                    &times;
                </button>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Edit Profile</h2>
                <form method="POST" action="update-profile.php" enctype="multipart/form-data">
                    <div class="mb-4">
                        <p class="font-semibold text-gray-800">Name</p>
                        <input id="name" name="name" type="text" placeholder="Enter your name..."
                            value="<?php echo htmlspecialchars($name); ?>"
                            class="border border-gray-300 p-2 w-full rounded">
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold text-gray-800">Contact</p>
                        <textarea id="contact" name="contact" placeholder="Enter your contact details..."
                            class="border border-gray-300 p-2 w-full rounded"><?php echo htmlspecialchars($contact); ?></textarea>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold text-gray-800">Biography</p>
                        <textarea id="biography" name="biography" placeholder="Tell us about yourself..."
                            class="border border-gray-300 p-2 w-full rounded"><?php echo htmlspecialchars($biography); ?></textarea>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold text-gray-800">Links</p>
                        <textarea id="links" name="links" placeholder="Enter links..."
                            class="border border-gray-300 p-2 w-full rounded"><?php echo htmlspecialchars($links); ?></textarea>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold text-gray-800">Profile Picture</p>
                        <input type="file" name="profile_picture" class="border border-gray-300 p-2 w-full rounded">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-[#DEAA79] text-white py-2 px-4 rounded-lg font-bold shadow-md hover:bg-[#A59D84] transition">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
        }
    </script>
</body>

</html>