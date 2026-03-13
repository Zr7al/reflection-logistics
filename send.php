<?php
/**
 * Reflection Logistics — Secure Contact Form Handler
 * Implements rate limiting, honeypot, and strict sanitization.
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';
require 'config.php';

header('Content-Type: application/json; charset=utf-8');
// 1. CORS RESTRICTION: Only allow requests from the production domain
header('Access-Control-Allow-Origin: https://reflectionlogistics.com');

// 2. REQUEST METHOD VALIDATION
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// 3. RATE LIMITING (Session-based)
// Prevents rapid-fire submissions from the same user session (30-second cooldown)
session_start();
$limit = 30; // seconds
if (isset($_SESSION['last_submit_time']) && (time() - $_SESSION['last_submit_time'] < $limit)) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please wait a moment before trying again.']);
    exit;
}

// 4. HONEYPOT SPAM PROTECTION
// Hidden field that only bots will see and fill.
if (!empty($_POST['website'])) {
    // Return success to the bot to stop it, but don't process the email.
    echo json_encode(['success' => true, 'message' => 'Message processed (filtered).']);
    exit;
}

// 5. DATA SANITIZATION & STRICT VALIDATION
// Strip tags and trim to prevent XSS and malformed data
$name     = strip_tags(trim($_POST['name'] ?? ''));
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$company  = strip_tags(trim($_POST['company'] ?? ''));
$service  = strip_tags(trim($_POST['service'] ?? ''));
$message  = strip_tags(trim($_POST['message'] ?? ''));
$dateFrom = strip_tags(trim($_POST['date_from'] ?? ''));
$dateTo   = strip_tags(trim($_POST['date_to'] ?? ''));

// Validate required fields and formats
if (empty($name) || strlen($name) > 100) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid name (max 100 chars).']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

if (empty($service) || empty($message) || strlen($message) > 3000) {
    echo json_encode(['success' => false, 'message' => 'Please complete all required fields (message max 3000 chars).']);
    exit;
}

// 6. PREVENT EMAIL HEADER INJECTION
// PHPMailer handles this internally, but we ensure inputs are clean of newlines
$name    = str_replace(["\r", "\n"], '', $name);
$subject_service = str_replace(["\r", "\n"], '', $service);

$mail = new PHPMailer(true);

try {
    // 7. SAFE PHPMailer CONFIGURATION
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;

    // Recipients
    $mail->setFrom(SMTP_USER, 'Reflection Logistics Website');
    $mail->addAddress(CONTACT_RECEIVER); // Use designated receiver from config
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "New Inquiry — " . ucfirst($subject_service) . " | $company";

    // Handle Accounting specific fields safely
    $accountingRow = '';
    if ($service === 'accounting' && !empty($dateFrom) && !empty($dateTo)) {
        $accountingRow = "
        <tr style='background:#f9f9f9;'>
            <td style='border:1px solid #eee;'><b>Date Range</b></td>
            <td style='border:1px solid #eee;'>" . htmlspecialchars($dateFrom) . " — " . htmlspecialchars($dateTo) . "</td>
        </tr>";
    }

    $safe_message = nl2br(htmlspecialchars($message));

    $mail->Body = "
    <div style='font-family:sans-serif; max-width:600px; color:#333;'>
        <h2 style='color:#c8391a; border-bottom:2px solid #c8391a; padding-bottom:10px;'>New Logistics Inquiry</h2>
        <table cellpadding='10' style='width:100%; border-collapse:collapse; border:1px solid #eee;'>
            <tr><td style='width:30%; border:1px solid #eee;'><b>Client Name</b></td><td style='border:1px solid #eee;'>" . htmlspecialchars($name) . "</td></tr>
            <tr style='background:#f9f9f9;'><td style='border:1px solid #eee;'><b>Email</b></td><td style='border:1px solid #eee;'>" . htmlspecialchars($email) . "</td></tr>
            <tr><td style='border:1px solid #eee;'><b>Company</b></td><td style='border:1px solid #eee;'>" . htmlspecialchars($company) . "</td></tr>
            <tr style='background:#f9f9f9;'><td style='border:1px solid #eee;'><b>Service</b></td><td style='border:1px solid #eee;'>" . strtoupper(htmlspecialchars($service)) . "</td></tr>
            $accountingRow
            <tr><td colspan='2' style='border:1px solid #eee;'><b>Message:</b><br><br>$safe_message</td></tr>
        </table>
        <p style='font-size:12px; color:#888; margin-top:20px;'>This email was sent from the Reflection Logistics Contact Form.</p>
    </div>";

    $mail->send();
    
    // Update rate limit timestamp only on successful send
    $_SESSION['last_submit_time'] = time();
    
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // 8. PROPER JSON ERROR RESPONSES
    // Generic error to avoid leaking SMTP details to the client
    error_log("Mailer Error: " . $mail->ErrorInfo);
    echo json_encode(['success' => false, 'message' => 'Sorry, we encountered a technical issue. Please try again later.']);
}