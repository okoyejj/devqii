<?php
session_start();

const APPLY_REDIRECT = 'apply.php';
const THANK_YOU_REDIRECT = 'thank-you.html';

$config_paths = [
    __DIR__ . '/../devqii-config/config.php',
    __DIR__ . '/config.php'
];

foreach ($config_paths as $config_path) {
    if (is_readable($config_path)) {
        require_once $config_path;
        break;
    }
}

defined('ADMIN_EMAIL') || define('ADMIN_EMAIL', 'info@devqii.co.uk');
defined('MAILER_ENABLED') || define('MAILER_ENABLED', false);

if (!function_exists('send_mail')) {
    function send_mail($subject, $body, $reply_to) {
        return false;
    }
}

function sanitize_input($value) {
    return trim(strip_tags($value));
}

function set_flash($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . APPLY_REDIRECT);
    exit;
}

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    set_flash('Security validation failed. Please try again.', 'error');
    header('Location: ' . APPLY_REDIRECT);
    exit;
}

if (!empty($_POST['website'])) {
    set_flash('Spam detected. Please try again.', 'error');
    header('Location: ' . APPLY_REDIRECT);
    exit;
}

$fields = [
    'full_name' => 'Full name',
    'email' => 'Email',
    'telephone' => 'Telephone',
    'whatsapp' => 'WhatsApp number',
    'city' => 'City',
    'qualification' => 'Highest qualification',
    'employment_status' => 'Current employment status',
    'study_schedule' => 'Preferred study schedule',
    'contact_method' => 'Preferred contact method',
    'message' => 'Message'
];

$values = [];
$errors = [];
foreach ($fields as $key => $label) {
    $value = isset($_POST[$key]) ? sanitize_input($_POST[$key]) : '';
    $values[$key] = $value;
    if (in_array($key, ['full_name', 'email', 'telephone', 'whatsapp', 'city', 'qualification', 'employment_status', 'study_schedule', 'contact_method'], true) && $value === '') {
        $errors[] = $label . ' is required.';
    }
}
$values['consent'] = !empty($_POST['consent']) ? '1' : '';

$allowed_values = [
    'qualification' => ['GCE Advanced Level', 'Baccalauréat', 'Equivalent recognised qualification'],
    'employment_status' => ['Employed', 'Self-employed', 'Student', 'Unemployed'],
    'study_schedule' => ['Evenings', 'Saturdays', 'Evenings and Saturdays'],
    'contact_method' => ['Email', 'Telephone', 'WhatsApp']
];

foreach ($allowed_values as $key => $allowed) {
    if ($values[$key] !== '' && !in_array($values[$key], $allowed, true)) {
        $errors[] = $fields[$key] . ' contains an invalid selection.';
    }
}

if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}

if ($values['consent'] === '') {
    $errors[] = 'Consent is required.';
}

if (!empty($errors)) {
    $_SESSION['old_input'] = $values;
    set_flash(implode(' ', $errors), 'error');
    header('Location: ' . APPLY_REDIRECT);
    exit;
}

$subject = 'DEVQII Application from ' . $values['full_name'];
$message = "New application\n\n";
foreach ($values as $key => $value) {
    if ($key === 'consent') {
        continue;
    }
    $message .= ucfirst(str_replace('_', ' ', $key)) . ': ' . $value . "\n";
}

$sent = false;
if (defined('MAILER_ENABLED') && MAILER_ENABLED) {
    $sent = send_mail($subject, $message, $values['email']);
}

if (!$sent) {
    $headers = [
        'From: ' . ADMIN_EMAIL,
        'Reply-To: ' . $values['email']
    ];
    $sent = @mail(ADMIN_EMAIL, $subject, $message, implode("\r\n", $headers));
}

if ($sent) {
    set_flash('Thank you. Your application has been received. We will contact you shortly.', 'success');
    header('Location: ' . THANK_YOU_REDIRECT);
    exit;
}

$_SESSION['old_input'] = $values;
set_flash('Your application could not be sent right now. Please contact us directly at info@devqii.co.uk.', 'error');
header('Location: ' . APPLY_REDIRECT);
exit;
