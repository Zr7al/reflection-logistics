<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';
require 'config.php';

header('Content-Type: application/json; charset=utf-8');
// Restrict CORS to the production origin; remove wildcard to prevent abuse
header('Access-Control-Allow-Origin: https://reflectionlogistics.com');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// 1. HONEYPOT SECURITY CHECK
// Bots will see this hidden field and fill it out automatically.
if (!empty($_POST['honeypot'])) {
    // Return success to trick the bot into stopping, but do not send the email.
    echo json_encode(['success' => true, 'message' => 'Filtered as spam.']);
    exit;
}

// 2. DATA SANITIZATION
$name     = strip_tags(trim($_POST['applicant_name'] ?? ''));
$email    = filter_var(trim($_POST['applicant_email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone    = strip_tags(trim($_POST['applicant_phone'] ?? ''));
$position = strip_tags(trim($_POST['position'] ?? ''));

// 3. FIELD VALIDATION
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$position) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid name, email, and position.']);
    exit;
}

// 4. CV UPLOAD VALIDATION
if (empty($_FILES['cv']['tmp_name']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'CV file is required and must be uploaded correctly.']);
    exit;
}

// Verify MIME Type for security (don't trust the file extension alone)
$allowedTypes = [
    'application/pdf', 
    'application/msword', 
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $_FILES['cv']['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Please upload a PDF or Word document.']);
    exit;
}

// Limit file size to 5MB
if ($_FILES['cv']['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'File too large. Max 5MB allowed.']);
    exit;
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;

    // Recipients
    $mail->setFrom(SMTP_USER, 'Reflection Logistics Careers');
    $mail->addAddress(SMTP_USER); 
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "Job Application — $position | $name";

    $phoneRow = $phone ? "<tr><td style='border:1px solid #eee;'><b>Phone</b></td><td style='border:1px solid #eee;'>$phone</td></tr>" : '';

    $mail->Body = "
    <div style='font-family:sans-serif; max-width:600px; color:#333;'>
        <h2 style='color:#c8391a; border-bottom:2px solid #c8391a; padding-bottom:10px;'>New Job Application</h2>
        <table cellpadding='10' style='width:100%; border-collapse:collapse; border:1px solid #eee;'>
            <tr style='background:#f9f9f9;'><td style='width:140px; border:1px solid #eee;'><b>Position</b></td><td style='border:1px solid #eee;'><b style='color:#c8391a'>$position</b></td></tr>
            <tr><td style='border:1px solid #eee;'><b>Applicant Name</b></td><td style='border:1px solid #eee;'>$name</td></tr>
            <tr style='background:#f9f9f9;'><td style='border:1px solid #eee;'><b>Email</b></td><td style='border:1px solid #eee;'><a href='mailto:$email'>$email</a></td></tr>
            $phoneRow
        </table>
        <p style='margin-top:16px; color:#555; font-size:13px;'>The applicant's CV is attached to this email.</p>
    </div>";

    // Attach CV with a clean, standardized filename
    $safePosition = preg_replace('/[^a-zA-Z0-9]/', '_', $position);
    $extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
    $mail->addAttachment(
        $_FILES['cv']['tmp_name'],
        "CV_{$name}_{$safePosition}.{$extension}"
    );

    $mail->send();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
}