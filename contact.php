<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$errors = [];

// Server-side Form Validation
if (empty($name)) {
    $errors[] = "Full Name is required on the server side.";
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid Email Address is required.";
}
if (empty($subject)) {
    $errors[] = "Subject line cannot be blank.";
}
if (empty($message) || strlen($message) < 20) {
    $errors[] = "Message requires a detailed description (minimum 20 characters).";
}

// Database Insertion Logic (Only executes if validation passes)
if (empty($errors)) {
    $servername = "localhost";
    $username   = "root";       // Default XAMPP username
    $password   = "";           // Default XAMPP password is empty
    $dbname     = "webdev_db";  // Your phpMyAdmin database name
    $port       = 3307;         // Your custom XAMPP MySQL port

    // Establish connection with the explicitly defined port 3307
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check if connection was successful
    if ($conn->connect_error) {
        $errors[] = "Database connection failed: " . $conn->connect_error;
    } else {
        // Sanitize string inputs to secure against SQL Injection vectors
        $s_name    = $conn->real_escape_string($name);
        $s_email   = $conn->real_escape_string($email);
        $s_subject = $conn->real_escape_string($subject);
        $s_message = $conn->real_escape_string($message);

        // SQL execution query
        $sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$s_name', '$s_email', '$s_subject', '$s_message')";

        if ($conn->query($sql) !== TRUE) {
            $errors[] = "Failed to store message in database: " . $conn->error;
        }

        // Close connection handler
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Form Processing Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <?php if (!empty($errors)): ?>
                    <div class="card border-danger shadow-sm">
                        <div class="card-header bg-danger text-white fw-bold">Data Processing & Validation Failure</div>
                        <div class="card-body">
                            <p class="text-danger">The server intercepted structural discrepancies while processing your submission:</p>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="index.html" class="btn btn-outline-danger mt-3">Return to Form</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card border-success shadow-sm">
                        <div class="card-header bg-success text-white fw-bold">Transmission Successfully Authenticated & Saved</div>
                        <div class="card-body">
                            <h3 class="h5 mb-4 text-success">Thank you, <?php echo htmlspecialchars($name); ?>! Your message has been safely recorded.</h3>
                            
                            <h6 class="fw-bold text-muted border-bottom pb-2">Submission Log Meta Summary</h6>
                            <table class="table table-bordered bg-white mt-2">
                                <tr>
                                    <th style="width: 30%;">Sender Email</th>
                                    <td><?php echo htmlspecialchars($email); ?></td>
                                </tr>
                                <tr>
                                    <th>Subject Topic</th>
                                    <td><?php echo htmlspecialchars($subject); ?></td>
                                </tr>
                                <tr>
                                    <th>Sanitized Content</th>
                                    <td><p class="mb-0 text-secondary"><?php echo nl2br(htmlspecialchars($message)); ?></p></td>
                                </tr>
                            </table>
                            
                            <div class="alert alert-info small mt-4">
                                <strong>Security Notice:</strong> Outputs were fully escaped using server-side <code>htmlspecialchars()</code> parsing to neutralize cross-site scripting (XSS) vectors, and inputs were processed using database escaping sequences to secure against SQL injection attacks.
                            </div>
                            
                            <a href="index.html" class="btn btn-success mt-3">Back to Home</a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>
</html>