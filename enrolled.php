<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Enrolled Courses</title>
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

    <!-- Main Content -->
    <div class="flex-1 bg-white p-12 overflow-y-auto">
        <div class="max-w-12xl mx-auto bg-white shadow-lg rounded-lg p-10">
            <h1 class="text-6xl font-bold text-gray-800 mb-6">Enrolled Courses</h1>
            <div id="enrolled-courses-container">
            </div>
        </div>
    </div>

    <script>
        const userId = <?php echo $userId; ?>;

        fetch(`http://localhost:3000/api/data.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                const coursesContainer = document.getElementById('enrolled-courses-container');
                console.log(data);
                const enrolledCourses = data.filter(course => course.user_id == userId);

                console.log(enrolledCourses);

                if (enrolledCourses.length > 0) {
                    const table = document.createElement('table');
                    table.classList.add('min-w-full', 'table-auto');

                    // Table header
                    const thead = document.createElement('thead');
                    thead.classList.add('bg-gray-200');
                    thead.innerHTML = `
                <tr>
                    <th class="px-6 py-3 text-left text-xl text-gray-700">Course</th>
                    <th class="px-6 py-3 text-left text-xl text-gray-700">Section</th>
                    <th class="px-6 py-3 text-left text-xl text-gray-700">Schedule</th>
                    <th class="px-6 py-3 text-left text-xl text-gray-700">Room</th>
                    <th class="px-6 py-3 text-left text-xl text-gray-700">Credit Units</th>
                    <th class="px-6 py-3 text-left text-xl text-gray-700">Action</th>
                </tr>
            `;
                    table.appendChild(thead);

                    // Table body
                    const tbody = document.createElement('tbody');
                    enrolledCourses.forEach(course => {
                        const row = document.createElement('tr');
                        row.classList.add('border-b');

                        row.innerHTML = `
                    <td class="px-6 py-3">${course.subject}</td>
                    <td class="px-6 py-3">${course.section}</td>
                    <td class="px-6 py-3">${course.schedule}</td>
                    <td class="px-6 py-3">${course.room}</td>
                    <td class="px-6 py-3">${course.credit_units}</td>
                    <td class="px-6 py-3">
                        <a href="drop.php?drop_course_id=${course.id}" class="text-red-500 hover:text-red-700 font-semibold">Drop</a>
                    </td>
                `;
                        tbody.appendChild(row);
                    });
                    table.appendChild(tbody);
                    coursesContainer.appendChild(table);
                } else {
                    coursesContainer.innerHTML = '<p class="text-lg text-gray-700">You are not enrolled in any courses yet.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching courses:', error);
                document.getElementById('enrolled-courses-container').innerHTML = '<p class="text-lg text-gray-700">Failed to load enrolled courses.</p>';
            });

    </script>
</body>

</html>