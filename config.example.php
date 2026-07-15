<?php
// Rename this file to config.php in a directory above public_html when deploying to GoDaddy.
// Example: /home/username/devqii-config/config.php

define('ADMIN_EMAIL', 'info@devqii.co.uk');
define('MAILER_ENABLED', false);
define('MAILER_HOST', 'smtp.example.com');
define('MAILER_PORT', 587);
define('MAILER_USERNAME', 'your-smtp-username');
define('MAILER_PASSWORD', 'your-smtp-password');
define('MAILER_ENCRYPTION', 'tls');
define('MAILER_FROM', 'info@devqii.co.uk');

function send_mail($subject, $body, $reply_to) {
    if (!class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        return false;
    }

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = MAILER_HOST;
    $mail->Port = MAILER_PORT;
    $mail->SMTPAuth = true;
    $mail->Username = MAILER_USERNAME;
    $mail->Password = MAILER_PASSWORD;
    $mail->SMTPSecure = MAILER_ENCRYPTION;
    $mail->setFrom(MAILER_FROM, 'DEVQII Admissions');
    $mail->addAddress(ADMIN_EMAIL);
    $mail->addReplyTo($reply_to);
    $mail->Subject = $subject;
    $mail->Body = $body;

    return $mail->send();
}
