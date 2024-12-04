<?php
require_once("phpqrcode/qrlib.php");

// Path where the QR code will be saved
$filepath = 'images/gulaid_qr.png';

// Path to the logo
$logoPath = 'images/android_qr_logo.png'; // Replace with your logo's actual path

// URL or text for the QR code
$qr_code_link = "https://storage.googleapis.com/app-tester-4aa51.appspot.com/static/payment_gateway/v0.0.8.apk";

// Create the QR code
QRcode::png($qr_code_link, $filepath, QR_ECLEVEL_H, 9, 2, true);

// Start overlaying the logo
$QR = imagecreatefrompng($filepath); // Load the generated QR code
$logo = imagecreatefrompng($logoPath); // Load the logo

// Get dimensions of QR code and logo
$QR_width = imagesx($QR);
$QR_height = imagesy($QR);
$logo_width = imagesx($logo);
$logo_height = imagesy($logo);

// Scale logo to fit inside QR code
$logo_qr_width = $QR_width / 5; // Logo will take up 1/5 of the QR code
$scale = $logo_qr_width / $logo_width;
$logo_qr_height = $logo_height * $scale;

// Calculate position to place the logo at the center of the QR code
$x = ($QR_width - $logo_qr_width) / 2;
$y = ($QR_height - $logo_qr_height) / 2;

// Merge logo into QR code
imagecopyresampled(
    $QR,
    $logo,
    $x,
    $y,
    0,
    0,
    $logo_qr_width,
    $logo_qr_height,
    $logo_width,
    $logo_height
);

// Save the final QR code with the logo
imagepng($QR, $filepath);

// Cleanup
imagedestroy($QR);
imagedestroy($logo);

echo "QR Code with logo generated successfully!";
