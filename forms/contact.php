<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check that all required fields are filled out
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Set the recipient email address
    $to = "davidfaianunes@gmail.com";

    // Set the email subject and message
    $email_subject = "New message from $name: $subject";
    $email_message = "Name: $name\n\nEmail: $email\n\nMessage:\n$message";

    // Set the email headers
    $headers = "From: $name <$email>";

    // Send the email
    if (mail($to, $email_subject, $email_message, $headers)) {
        http_response_code(200);
        echo "Thank you for your message. We'll get back to you as soon as possible.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
