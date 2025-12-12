<?php
// Konfiguracija za jezike
session_start();

// Podržani jezici
$supported_languages = ["sr", "en"];

// Podrazumevani jezik
$default_language = "sr";

// Proveri jezik iz sesije ili GET parametra
if (isset($_GET["lang"]) && in_array($_GET["lang"], $supported_languages)) {
    $_SESSION["language"] = $_GET["lang"];
}

// Postavi trenutni jezik
if (isset($_SESSION["language"])) {
    $current_language = $_SESSION["language"];
} else {
    $current_language = $default_language;
}

// Flag ikone za jezike
$language_flags = [
    "sr" => "🇷🇸",
    "en" => "🇬🇧"
];

// Učitaj jezički fajl
$lang_file = "languages/{$current_language}.php";
if (file_exists($lang_file)) {
    $translations = include($lang_file);
} else {
    // Fallback na srpski
    $translations = [];
}

// Funkcija za prevod (samo ako već ne postoji)
// Funkcija za prevod (samo ako već ne postoji)
if (!function_exists('__')) {
    function __($key) {
        global $translations;
        return isset($translations[$key]) ? $translations[$key] : $key;
    }
}
// Email konfiguracija
define('OWNER_EMAIL', 'djole8793@gmail.com'); // Zamenite sa vašim emailom
define('SITE_EMAIL', 'noreply@dvabrata.com');
define('SITE_NAME', 'Restoran i Prenoćište Dva Brata');

// Funkcija za slanje email-a
function sendReservationEmail($data) {
    $to = OWNER_EMAIL;
    $subject = "Nova rezervacija - " . SITE_NAME;
    
    $message = "
    <html>
    <head>
        <title>Nova rezervacija</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #8B4513; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background: #f9f9f9; }
            .detail { margin: 10px 0; padding: 10px; background: white; border-left: 4px solid #8B4513; }
            .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>NOVA REZERVACIJA</h2>
            </div>
            <div class='content'>
                <div class='detail'><strong>Ime i prezime:</strong> {$data['full_name']}</div>
                <div class='detail'><strong>Email:</strong> {$data['email']}</div>
                <div class='detail'><strong>Telefon:</strong> {$data['phone']}</div>
                <div class='detail'><strong>Datum:</strong> {$data['date']}</div>
                <div class='detail'><strong>Vreme:</strong> {$data['time']}</div>
                <div class='detail'><strong>Broj gostiju:</strong> {$data['guests']}</div>
    ";
    
    if ($data['reservation_type'] === 'room') {
        $message .= "
                <div class='detail'><strong>Tip sobe:</strong> {$data['room_type']}</div>
                <div class='detail'><strong>Broj noći:</strong> {$data['nights']}</div>
                <div class='detail'><strong>Doručak:</strong> {$data['breakfast']}</div>
                <div class='detail'><strong>Ukupna cena:</strong> " . number_format($data['total_price'], 0, ',', '.') . " RSD</div>
        ";
    }
    
    $message .= "
                <div class='detail'><strong>Napomene:</strong><br>" . nl2br($data['notes']) . "</div>
            </div>
            <div class='footer'>
                <p>Ova poruka je automatski generisana sa sajta " . SITE_NAME . ".</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . SITE_EMAIL . "\r\n";
    $headers .= "Reply-To: {$data['email']}\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    return mail($to, $subject, $message, $headers);
}
?>