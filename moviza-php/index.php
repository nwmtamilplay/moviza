<?php
// api.php

$data = [
    "name" => "John Doe",
    "age" => 28,
    "email" => "johndoe@example.com",
    "hobbies" => ["reading", "coding", "hiking"]
];

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
