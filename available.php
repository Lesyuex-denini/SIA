<?php

?>
<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 20px;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
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

    <!-- Available Courses Content -->
    <div class="flex-1 bg-white p-12 overflow-y-auto">
        <div class="max-w-12xl mx-auto bg-white shadow-lg rounded-lg p-10">
            <h1 class="text-6xl font-bold text-gray-800 mb-6">Available Courses</h1>
            <div class="space-y-5">
                <button onclick="showSchedules('GE_Elective_2_Living_in_the_IT_Era')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">GE Elective 2 - Living in the IT Era</h2>
                </button>
                <button onclick="showSchedules('Data_Mining_and_Warehousing')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">Data Mining and Warehousing</h2>
                </button>
                <button onclick="showSchedules('Mobile_Computing')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">Mobile Computing</h2>
                </button>
                <button onclick="showSchedules('Prof_Elective_3')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">Prof Elective 3</h2>
                </button>
                <button onclick="showSchedules('IT_Elective_2')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">IT Elective 2</h2>
                </button>
                <button onclick="showSchedules('Information_Assurance_and_Security_1')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">Information Assurance and Security 1</h2>
                </button>
                <button onclick="showSchedules('Application_Development_and_Emerging_Technologies')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">Application Development and Emerging Technologies</h2>
                </button>
                <button onclick="showSchedules('Networking_2')"
                    class="bg-[#EBD9B4] p-8 rounded-lg shadow-md hover:bg-[#DEAA79] transition duration-300 w-full text-left">
                    <h2 class="text-3xl font-semibold text-black">Networking 2</h2>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 z-50 flex items-center justify-center">
        <div id="modal-content" class="bg-white p-10 rounded-lg shadow-lg max-w-3xl w-full relative">
            <button onclick="closeModal()" class="modal-close text-gray-600 font-bold">&times;</button>
        </div>
    </div>

    <script>
        const schedules = {
            GE_Elective_2_Living_in_the_IT_Era: [
                { section: "IT31S1", schedule: "Mon, Wed, Fri - 10:00 AM to 11:30 AM", room: "A-2 205", creditUnits: 3 },
                { section: "IT31S2", schedule: "Tue, Thu - 2:00 PM to 3:30 PM", room: "A-2 206", creditUnits: 3 }
            ],
            Data_Mining_and_Warehousing: [
                { section: "IT31S1", schedule: "Tue, Thu - 1:00 PM to 2:30 PM", room: "A-207", creditUnits: 3 },
                { section: "IT31S2", schedule: "Mon, Wed, Fri - 3:00 PM to 4:30 PM", room: "A-208", creditUnits: 3 }
            ],
            Mobile_Computing: [
                { section: "IT31S1", schedule: "Mon, Wed, Fri - 2:00 PM to 3:30 PM", room: "A-209", creditUnits: 3 },
                { section: "IT31S2", schedule: "Tue, Thu - 10:00 AM to 11:30 AM", room: "A-210", creditUnits: 3 }
            ],
            Prof_Elective_3: [
                { section: "IT31S1", schedule: "Tue, Thu - 10:00 AM to 11:30 AM", room: "A-211", creditUnits: 3 },
                { section: "IT31S2", schedule: "Mon, Wed, Fri - 1:00 PM to 2:30 PM", room: "A-212", creditUnits: 3 }
            ],
            IT_Elective_2: [
                { section: "IT31S1", schedule: "Mon, Wed, Fri - 1:00 PM to 2:30 PM", room: "A-213", creditUnits: 3 },
                { section: "IT31S2", schedule: "Tue, Thu - 3:00 PM to 4:30 PM", room: "A-214", creditUnits: 3 }
            ],
            Information_Assurance_and_Security_1: [
                { section: "IT31S1", schedule: "Tue, Thu - 3:00 PM to 4:30 PM", room: "A-215", creditUnits: 3 },
                { section: "IT31S2", schedule: "Mon, Wed, Fri - 10:00 AM to 11:30 AM", room: "A-205", creditUnits: 3 }
            ],
            Application_Development_and_Emerging_Technologies: [
                { section: "IT31S1", schedule: "Mon, Wed, Fri - 3:00 PM to 4:30 PM", room: "A-206", creditUnits: 3 },
                { section: "IT31S2", schedule: "Tue, Thu - 1:00 PM to 2:30 PM", room: "A-2 207", creditUnits: 3 }
            ],
            Networking_2: [
                { section: "IT31S1", schedule: "Mon, Wed, Fri - 9:00 AM to 10:30 AM", room: "A-208", creditUnits: 3 },
                { section: "IT31S2", schedule: "Tue, Thu - 2:00 PM to 3:30 PM", room: "A-2 209", creditUnits: 3 }
            ]
        };

        function showSchedules(subject) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            modalContent.innerHTML = '';

            if (schedules[subject]) {
                schedules[subject].forEach(schedule => {
                    const scheduleDiv = document.createElement('div');
                    scheduleDiv.className = 'bg-gray-100 p-4 rounded-lg shadow-md mb-4';
                    scheduleDiv.innerHTML = `
                    <h2 class="text-xl font-semibold text-gray-800">${subject.replace(/_/g, ' ').replace(/([A-Z])/g, ' $1').trim()}</h2>
                    <p class="text-gray-700 mt-2">Section: ${schedule.section}</p>
                    <p class="text-gray-700 mt-2">Schedule: ${schedule.schedule}</p>
                    <p class="text-gray-700 mt-2">Room: ${schedule.room}</p>
                    <p class="text-gray-700 mt-2">Credit Units: ${schedule.creditUnits}</p>
                    <button onclick="enrollCourse('${subject}', '${schedule.section}', '${schedule.schedule}', '${schedule.room}', ${schedule.creditUnits})"
                        class="mt-4 bg-yellow-500 text-white font-bold py-2 px-4 rounded hover:bg-yellow-600 transition duration-300">
                        Enroll
                    </button>
                `;
                    modalContent.appendChild(scheduleDiv);
                });

                modal.classList.remove('hidden');
            } else {
                alert("No schedules available for this course.");
            }
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function enrollCourse(subject, section, schedule, room, creditUnits) {
            fetch('enroll.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    subject: subject,
                    section: section,
                    schedule: schedule,
                    room: room,
                    credit_units: creditUnits
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                    closeModal();
                })
                .catch(error => {
                    console.error('Error enrolling course:', error);
                    alert('An error occurred. Please try again.');
                    closeModal();
                });
        }
    </script>
</body>

</html>