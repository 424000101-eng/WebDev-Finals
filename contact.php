<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please ensure all fields are filled out correctly and a subject is provided.'
        ]);
        exit;
    }

    if (strlen($message) < 20) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Your message body must be at least 20 characters long.'
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Thank you, ' . $name . '! Your portfolio message regarding "' . $subject . '" has been successfully and securely processed by our PHP backend.'
    ]);
    exit;

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request delivery architecture execution.'
    ]);
    exit;
}
?>