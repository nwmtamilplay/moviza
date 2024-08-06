<?php
// Path to the JSON file
$jsonFilePath = 'users.json';

// Retrieve form data
$email = $_REQUEST['email'] ?? '';
$password = $_REQUEST['pass'] ?? '';

// Validate form data
if (empty($email) || empty($password)) {
    $message = urlencode('Please fill all the fields.');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

// Read existing data from the JSON file
if (file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    $users = json_decode($jsonData, true);
} else {
    $users = [];
}

// Verify user credentials
$userFound = false;
foreach ($users as $user) {
    if ($user['email'] === $email && password_verify($password, $user['password'])) {
        $userFound = true;
        break;
    }
}

// Handle login result
if ($userFound) {
    // Login successful
    session_start();
    $_SESSION['email'] = $email; // Store email in session (adjust as needed)
    $message = urlencode('Login Successful');
    echo json_encode(['status' => 'success', 'message' => $message]);
    exit();
} else {
    // Login failed
    $message = urlencode('Invalid email or password.');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}
