<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => "error",
        "message" => "Direct script access configurations are denied."
    ]);
    exit();
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "webdev_db";
$port = 3307; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => "Database node offline. Verify XAMPP MySQL port 3307 is active."
    ]);
    exit();
}

$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode([
        "status" => "error",
        "message" => "All form entry fields are mandatory to complete processing."
    ]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "The provided address pattern is not a valid academic email routing structure."
    ]);
    exit();
}

if (strlen($message) < 20) {
    echo json_encode([
        "status" => "error",
        "message" => "Message criteria unfulfilled. Body depth must exceed 20 characters."
    ]);
    exit();
}

$name_clean    = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email_clean   = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$subject_clean = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$message_clean = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

$stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name_clean, $email_clean, $subject_clean, $message_clean);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Your inquiry has been successfully recorded in the phpMyAdmin database!"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Internal processing table exception occurred: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
exit();
?>