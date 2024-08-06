<?php
// Path to the JSON file
$jsonFilePath = 'users.json';

// Retrieve form data
$name = $_GET['name'];
$email = $_GET['email'];
$number = $_GET['number'];
$password = $_GET['pass'];
$confirmPassword = $_GET['confirm_pass'];

// Validate form data
if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($number)) {
    $message = urlencode('Please fill all the fields.');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

if (!preg_match('/^\d{10}$/', $number)) {
    $message = urlencode('Invalid phone number. Please enter a 10-digit number.');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}
if ($password !== $confirmPassword) {
    $message = urlencode('Passwords do not match.');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Read existing data from the JSON file
if (file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    $users = json_decode($jsonData, true);
    if ($users === null) {
        $users = [];
    }
} else {
    $users = [];
}

// Check if email already exists
foreach ($users as $user) {
    if ($user['email'] === $email) {
        $message = urlencode('Email already exists.');
        echo json_encode(['status' => 'error', 'message' => $message]);
        exit();
    }
}

// Add new user data
$newUser = [
    'name' => $name,
    'email' => $email,
    'number' => $number,
    'password' => $hashedPassword,
];
$users[] = $newUser;

// Save the updated user data back to the JSON file
file_put_contents($jsonFilePath, json_encode($users, JSON_PRETTY_PRINT));

// create Folder for user ================================
// Specify the name of the folder to be created
$folderName = $email . '-data';

// Path where you want to create the folder (adjust this path as needed)
$folderPath = '../user_data/' . $folderName;

// Check if the folder does not already exist
if (!file_exists($folderPath)) {
    // Attempt to create the folder
    if (mkdir($folderPath)) {
        // Data to be converted to JSON format
        $data = [];
        // Specify the file name and path where you want to create the JSON file
        $fav = 'fav.json';
        $filepath = $folderPath . '/' . $fav; // Replace with your desired directory path
        // Convert PHP array to JSON format
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        // Write JSON data to file
        if (file_put_contents($filepath, $jsonData)) {
        }
        // Specify the file name and path where you want to create the JSON file
        $watch_list = 'watch_list.json';
        $filepath = $folderPath . '/' . $watch_list; // Replace with your desired directory path
        // Convert PHP array to JSON format
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        // Write JSON data to file
        if (file_put_contents($filepath, $jsonData)) {
        }
    }
}
// create Folder for user ================================
// Redirect to login page with success message
$message = urlencode('Registration successful. You can now login.');
echo json_encode(['status' => 'success', 'message' => $message]);
exit();
