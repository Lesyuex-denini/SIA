<?php
// Include the database connection if needed for other functionalities
include 'db_connection.php';

$login_error = $signup_error = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enrollment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        h2,
        p {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row h-screen">
        <div class="bg-[#DEAA79] text-black flex flex-col items-center justify-center p-8 md:w-1/2">
            <div class="w-38 h-38 bg-white rounded-full flex items-center justify-center mb-6 overflow-hidden">
                <img src="logo.png" alt="Company Logo" width="200" height="200" />
            </div>
            <h2 class="text-4xl font-bold mb-2">Welcome back To</h2>
            <p class="text-8xl font-bold mb-4">SHOLAIRE</p>
            <p class="text-lg mb-4" style="font-size: 1.3rem;">Already have an account?</p><br>
            <button class="bg-white text-black py-3 px-12 rounded hover:bg-[#FDDBBB] transition font-bold"
                id="toggleButton">SIGN IN</button>
        </div>

        <div class="bg-white flex flex-col items-center justify-center p-8 md:w-1/2">
            <!-- Login Form -->
            <div class="form-panel bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-md "
                style="width: 600px; max-width: 800px" id="loginForm">
                <h2 class="text-4xl font-bold mb-6 text-center">Sign In to Access</h2>
                <form id="loginFormRequest" class="flex flex-col">
                    <input type="email" name="email" class="border border-gray-300 rounded py-4 px-3 mb-4"
                        placeholder="Email" required />
                    <input type="password" name="password" class="border border-gray-300 rounded py-4 px-3 mb-4"
                        placeholder="Password" required />
                    <a href="#" class="text-sm text-gray-600 mb-4 text-center">Forgot your password?</a>
                    <button type="submit" id="loginButton"
                        class="bg-[#DEAA79] text-black py-4 px-4 rounded font-bold hover:bg-[#A59D84] transition">LOGIN</button>
                </form>
                <p id="loginErrorMessage" class="text-red-500 mt-4 text-center"></p>
            </div>

            <!-- Sign Up Form -->
            <div class="form-panel bg-gray-50 border border-gray-200 rounded-lg p-6 w-full max-w-md shadow-md hidden"
                style="width: 600px; max-width: 800px" id="signUpForm">
                <h2 class="text-4xl font-bold mb-6 text-center">Create Account</h2>
                <form id="signupFormRequest" class="flex flex-col">
                    <input type="text" name="name" class="border border-gray-300 rounded py-4 px-3 mb-4"
                        placeholder="Name" required />
                    <input type="email" name="email" class="border border-gray-300 rounded py-4 px-3 mb-4"
                        placeholder="Email" required />
                    <input type="password" name="password" class="border border-gray-300 rounded py-2 px-3 mb-4"
                        placeholder="Password" required />
                    <button type="submit" id="signupButton"
                        class="bg-[#DEAA79] text-black py-4 px-4 font-bold rounded hover:bg-[#A59D84] transition">SIGN
                        UP</button>
                </form>
                <p id="signupErrorMessage" class="text-red-500 mt-4 text-center"></p>
            </div>
        </div>
    </div>

    <script>
        const toggleButton = document.getElementById("toggleButton");
        const loginForm = document.getElementById("loginForm");
        const signUpForm = document.getElementById("signUpForm");

        toggleButton.addEventListener("click", () => {
            loginForm.classList.toggle("hidden");
            signUpForm.classList.toggle("hidden");
            toggleButton.textContent = loginForm.classList.contains("hidden") ? "SIGN IN" : "SIGN UP";
        });

        // Login Form Submission
        document.getElementById('loginFormRequest').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;

            try {
                const response = await fetch('/api/auth/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email, password })
                });

                const result = await response.json();

                if (result.error) {
                    document.getElementById('loginErrorMessage').textContent = result.error;
                } else {
                    window.location.href = "dashboard.php";
                }
            } catch (error) {
                document.getElementById('loginErrorMessage').textContent = 'Something went wrong. Please try again.';
            }
        });

        // Signup Form Submission
        document.getElementById('signupFormRequest').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.querySelector('input[name="name"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;

            try {
                // Send data to the server for user registration
                const response = await fetch('/api/auth/signup.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ name, email, password })
                });

                const result = await response.json();

                if (result.error) {
                    document.getElementById('signupErrorMessage').textContent = result.error;
                } else {
                    document.getElementById('signupErrorMessage').textContent = 'Signup successful! You can now log in.';
                    setTimeout(() => {
                        window.location.href = "login.php";
                    }, 2000);
                }
            } catch (error) {
                document.getElementById('signupErrorMessage').textContent = 'Something went wrong. Please try again.';
            }
        });



    </script>
</body>

</html>