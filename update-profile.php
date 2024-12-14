<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : $_SESSION['name'];
    $contact = isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : $_SESSION['contact'];
    $biography = isset($_POST['biography']) ? htmlspecialchars($_POST['biography']) : $_SESSION['biography'];
    $links = isset($_POST['links']) ? htmlspecialchars($_POST['links']) : $_SESSION['links'];

    // Data to send to the API
    $data = [
        'user_id' => $_SESSION['user_id'],
        'name' => $name,
        'contact' => $contact,
        'biography' => $biography,
        'links' => $links,
    ];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['profile_picture']['name']));
        $upload_dir = 'uploads/profile_pictures/';  // Path where to store uploaded files

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Validate file type and size
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_extension), $allowed_types)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        $max_size = 2 * 1024 * 1024;  // 2MB max size
        if ($_FILES['profile_picture']['size'] > $max_size) {
            die("File size exceeds the maximum allowed size of 2MB.");
        }

        // Create a unique name for the uploaded file
        $new_file_name = uniqid('profile_', true) . '.' . $file_extension;
        $file_path = $upload_dir . $new_file_name;

        // Move the uploaded file to the destination folder
        if (move_uploaded_file($file_tmp, $file_path)) {
            $data['profile_picture'] = $file_path;  // Add file path to API data
        } else {
            die("Error uploading the file.");
        }
    }

    // Debugging: Print the data that will be sent to the API
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    // API call to update the profile
    $api_url = 'https://yourapiendpoint.com/updateProfile';  // Replace with your actual API endpoint

    $headers = [
        'Content-Type: application/json',  // Add this if the API expects JSON format
    ];

    // Use cURL to send data (Include profile picture if uploaded)
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  // Send the data as JSON
    $response = curl_exec($ch);
    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Get the HTTP response code
    $error = curl_error($ch);  // Capture any cURL errors
    curl_close($ch);

    // Debugging: Print the response from the API
    echo "<pre>";
    echo "Response Code: " . $response_code . "\n";
    echo "Raw Response: " . var_export($response, true) . "\n";
    echo "cURL Error: " . $error . "\n";  // Show cURL error message
    echo "</pre>";

    // Handle API response
    if ($response && $response_data = json_decode($response, true)) {
        if (isset($response_data['success']) && $response_data['success']) {
            // Update session variables with new profile information
            $_SESSION['name'] = $name;
            $_SESSION['contact'] = $contact;
            $_SESSION['biography'] = $biography;
            $_SESSION['links'] = $links;
            $_SESSION['profile_picture'] = isset($data['profile_picture']) ? $data['profile_picture'] : $_SESSION['profile_picture'];

            // Only redirect if the update was successful
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Failed to update profile: " . $response_data['error'];
        }
    } else {
        echo "Failed to update profile. Response body is empty.";
    }
}
