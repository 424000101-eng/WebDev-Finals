<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($subject) || empty($message) || strlen($message) < 20) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Submission Error</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light d-flex align-items-center vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card border-danger shadow">
                            <div class="card-header bg-danger text-white text-center py-3">
                                <h3>⚠️ Validation Error</h3>
                            </div>
                            <div class="card-body p-4 text-center">
                                <p class="lead text-dark">Your message could not be sent. Please ensure all fields are filled out correctly, a subject is provided, and your message is at least 20 characters long.</p>
                                <a href="index.html" class="btn btn-danger mt-3">Go Back to Form</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ';
        exit;
    }

    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Message Sent Successfully</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light d-flex align-items-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card border-success shadow">
                        <div class="card-header bg-success text-white text-center py-3">
                            <h3>✅ Message Received!</h3>
                        </div>
                        <div class="card-body p-4 text-center">
                            <p class="lead text-dark">Thank you, <strong>' . $name . '</strong>! Your portfolio message regarding <strong>"' . $subject . '"</strong> has been successfully and securely processed by our PHP backend.</p>
                            <a href="index.html" class="btn btn-success mt-3">Return to Portfolio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ';
} else {
    header("Location: index.html");
    exit;
}
?>