<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form fields and sanitize input
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Check if fields are empty
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill out the form correctly.";
        exit;
    }

    // Set the recipient email address
    $recipient = "your-email@example.com"; // Change this to your email

    // Set the email subject
    $subject = "New contact from $name";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Set email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
