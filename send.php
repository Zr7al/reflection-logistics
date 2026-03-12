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
// If this field is filled, it is definitely a bot.
if (!empty($_POST['honeypot'])) {
    // We return success to the bot so it stops trying, but we don't send the email.
    echo json_encode(['success' => true, 'message' => 'Spam filtered.']);
    exit;
}

// 2. DATA SANITIZATION
$name     = strip_tags(trim($_POST['name'] ?? ''));
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$company  = strip_tags(trim($_POST['company'] ?? ''));
$service  = strip_tags(trim($_POST['service'] ?? ''));
$message  = nl2br(strip_tags(trim($_POST['message'] ?? ''))); // Preserve line breaks
$dateFrom = strip_tags(trim($_POST['date_from'] ?? ''));
$dateTo   = strip_tags(trim($_POST['date_to'] ?? ''));

// 3. VALIDATION
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$company || !$service) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid name, email, and company.']);
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
    $mail->setFrom(SMTP_USER, 'Reflection Logistics Website');
    $mail->addAddress(SMTP_USER); 
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "New Inquiry — " . ucfirst($service) . " | $company";

    // Handle Accounting specific fields
    $accountingRow = '';
    if ($service === 'accounting' && $dateFrom && $dateTo) {
        $accountingRow = "
        <tr style='background:#f9f9f9;'>
            <td style='border:1px solid #eee;'><b>Date Range</b></td>
            <td style='border:1px solid #eee;'>$dateFrom — $dateTo</td>
        </tr>";
    }

    $mail->Body = "
    <div style='font-family:sans-serif; max-width:600px; color:#333;'>
        <h2 style='color:#c8391a; border-bottom:2px solid #c8391a; padding-bottom:10px;'>New Logistics Inquiry</h2>
        <table cellpadding='10' style='width:100%; border-collapse:collapse; border:1px solid #eee;'>
            <tr><td style='width:30%; border:1px solid #eee;'><b>Client Name</b></td><td style='border:1px solid #eee;'>$name</td></tr>
            <tr style='background:#f9f9f9;'><td style='border:1px solid #eee;'><b>Email</b></td><td style='border:1px solid #eee;'>$email</td></tr>
            <tr><td style='border:1px solid #eee;'><b>Company</b></td><td style='border:1px solid #eee;'>$company</td></tr>
            <tr style='background:#f9f9f9;'><td style='border:1px solid #eee;'><b>Service</b></td><td style='border:1px solid #eee;'>" . strtoupper($service) . "</td></tr>
            $accountingRow
            <tr><td colspan='2' style='border:1px solid #eee;'><b>Message:</b><br><br>$message</td></tr>
        </table>
        <p style='font-size:12px; color:#888; margin-top:20px;'>This email was sent from the Reflection Logistics Contact Form.</p>
    </div>";

    $mail->send();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
}