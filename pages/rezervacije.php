<?php
// Obrada forme za rezervaciju soba
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prikupljanje podataka iz forme
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $room_type = $_POST['room_type'] ?? '';
    $guests = $_POST['guests'] ?? 1;
    $breakfast = isset($_POST['breakfast']) ? 'Da' : 'Ne';
    $notes = $_POST['notes'] ?? '';
    
    // Validacija
    $errors = [];
    
    if (empty($full_name)) $errors[] = 'Ime i prezime je obavezno polje';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Unesite ispravnu email adresu';
    if (empty($phone)) $errors[] = 'Telefon je obavezno polje';
    if (empty($check_in)) $errors[] = 'Datum prijave je obavezno polje';
    if (empty($check_out)) $errors[] = 'Datum odjave je obavezno polje';
    if (empty($room_type)) $errors[] = 'Tip sobe je obavezno polje';
    
    // Proveri da li je datum odjave posle datuma prijave
    if (!empty($check_in) && !empty($check_out)) {
        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);
        if ($check_out_date <= $check_in_date) {
            $errors[] = 'Datum odjave mora biti posle datuma prijave';
        }
    }
    
    if (empty($errors)) {
        // Cene po noći (u RSD)
        $room_prices = [
            'single' => 3500,
            'double' => 5000,
            'suite' => 8000
        ];
        
        // Izračunaj broj noći
        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);
        $nights = $check_out_date->diff($check_in_date)->days;
        
        // Izračunaj cenu
        $room_price = $room_prices[$room_type] ?? 0;
        $total_price = $room_price * $nights;
        
        // Dodaj doručak ako je izabran (+500 RSD po noći po osobi)
        if ($breakfast === 'Da') {
            $total_price += (500 * $guests * $nights);
        }
        
        // Email za vlasnika
        $to_owner = "djole8793@gmail.com";
        $subject_owner = "Nova rezervacija sobe - Restoran Dva Brata";
        
        // Formatiraj datume za čitanje
        $formatted_check_in = date('d.m.Y.', strtotime($check_in));
        $formatted_check_out = date('d.m.Y.', strtotime($check_out));
        
        // Nazivi soba
        $room_names = [
            'single' => 'Jednokrevetna soba',
            'double' => 'Dvokrevetna soba',
            'suite' => 'Apartman (suite)'
        ];
        $room_name = $room_names[$room_type] ?? $room_type;
        
        $message_owner = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Nova rezervacija sobe</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #8B4513; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f9f9f9; padding: 30px; border: 1px solid #ddd; }
                .details { margin: 20px 0; }
                .detail-item { margin: 10px 0; padding: 10px; background: white; border-left: 4px solid #8B4513; }
                .total { font-size: 1.2em; font-weight: bold; color: #8B4513; padding: 15px; background: #fff8f0; border-radius: 5px; }
                .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 0.9em; color: #666; }
                .alert { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🛏️ NOVA REZERVACIJA SOBE</h1>
                    <p>Restoran i Prenoćište \"Dva Brata\"</p>
                </div>
                
                <div class='content'>
                    <div class='alert'>
                        <strong>⏰ HITNO!</strong> Nova rezervacija sobe zahteva potvrdu.
                    </div>
                    
                    <h2>Detalji rezervacije</h2>
                    
                    <div class='details'>
                        <div class='detail-item'>
                            <strong>👤 Gost:</strong> $full_name
                        </div>
                        
                        <div class='detail-item'>
                            <strong>📧 Email:</strong> $email
                        </div>
                        
                        <div class='detail-item'>
                            <strong>📱 Telefon:</strong> $phone
                        </div>
                        
                        <div class='detail-item'>
                            <strong>📅 Prijava:</strong> $formatted_check_in
                        </div>
                        
                        <div class='detail-item'>
                            <strong>📅 Odjava:</strong> $formatted_check_out
                        </div>
                        
                        <div class='detail-item'>
                            <strong>🌙 Broj noći:</strong> $nights
                        </div>
                        
                        <div class='detail-item'>
                            <strong>🛏️ Tip sobe:</strong> $room_name
                        </div>
                        
                        <div class='detail-item'>
                            <strong>👥 Broj gostiju:</strong> $guests
                        </div>
                        
                        <div class='detail-item'>
                            <strong>🍳 Doručak:</strong> $breakfast
                        </div>";
        
        if (!empty($notes)) {
            $message_owner .= "
                        <div class='detail-item'>
                            <strong>📝 Napomene:</strong><br>
                            " . nl2br(htmlspecialchars($notes)) . "
                        </div>";
        }
        
        $message_owner .= "
                        <div class='total'>
                            💰 <strong>Ukupna cena:</strong> " . number_format($total_price, 0, ',', '.') . " RSD
                        </div>
                    </div>
                    
                    <div class='footer'>
                        <p><strong>Vreme rezervacije:</strong> " . date('d.m.Y. H:i:s') . "</p>
                        <p>Ova poruka je automatski generisana. Molimo kontaktirajte gosta što pre.</p>
                        <p>
                            <a href='mailto:$email' style='background: #8B4513; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px;'>
                                📧 Odgovori gostu
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Headers za HTML email
        $headers_owner = "MIME-Version: 1.0\r\n";
        $headers_owner .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers_owner .= "From: Restoran Dva Brata <noreply@dvabrata.com>\r\n";
        $headers_owner .= "Reply-To: $email\r\n";
        $headers_owner .= "X-Mailer: PHP/" . phpversion();
        
        // Pošalji email vlasniku
        if (mail($to_owner, $subject_owner, $message_owner, $headers_owner)) {
            // Pošalji potvrdu korisniku
            $subject_user = "Potvrda rezervacije sobe - Restoran Dva Brata";
            
            $message_user = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Potvrda rezervacije sobe</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #8B4513; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background: #f9f9f9; padding: 30px; border: 1px solid #ddd; }
                    .details { margin: 20px 0; }
                    .detail-item { margin: 10px 0; padding: 10px; background: white; border-left: 4px solid #8B4513; }
                    .contact-info { background: #e8f4fc; padding: 20px; border-radius: 5px; margin: 20px 0; }
                    .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 0.9em; color: #666; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>✅ POTVRDA REZERVACIJE SOBE</h1>
                        <p>Restoran i Prenoćište \"Dva Brata\"</p>
                    </div>
                    
                    <div class='content'>
                        <h2>Poštovani $full_name,</h2>
                        
                        <p>Hvala Vam što ste izabrali naše prenoćište! Primili smo Vašu rezervaciju i u najkraćem roku ćemo Vas kontaktirati da potvrdimo dostupnost.</p>
                        
                        <h3>📋 Detalji Vaše rezervacije:</h3>
                        
                        <div class='details'>
                            <div class='detail-item'>
                                <strong>📅 Prijava:</strong> $formatted_check_in
                            </div>
                            
                            <div class='detail-item'>
                                <strong>📅 Odjava:</strong> $formatted_check_out
                            </div>
                            
                            <div class='detail-item'>
                                <strong>🌙 Broj noći:</strong> $nights
                            </div>
                            
                            <div class='detail-item'>
                                <strong>🛏️ Tip sobe:</strong> $room_name
                            </div>
                            
                            <div class='detail-item'>
                                <strong>👥 Broj gostiju:</strong> $guests
                            </div>
                            
                            <div class='detail-item'>
                                <strong>🍳 Doručak:</strong> $breakfast
                            </div>";
            
            if ($total_price > 0) {
                $message_user .= "
                            <div class='detail-item'>
                                <strong>💰 Proizračunata cena:</strong> " . number_format($total_price, 0, ',', '.') . " RSD<br>
                                <small><em>*Konačnu cenu potvrdiće naš osoblje prilikom potvrde rezervacije</em></small>
                            </div>";
            }
            
            if (!empty($notes)) {
                $message_user .= "
                            <div class='detail-item'>
                                <strong>📝 Vaše napomene:</strong><br>
                                " . nl2br(htmlspecialchars($notes)) . "
                            </div>";
            }
            
            $message_user .= "
                        </div>
                        
                        <div class='contact-info'>
                            <h3>📞 Kontakt informacije:</h3>
                            <p><strong>Telefon:</strong> 0631020209</p>
                            <p><strong>Email:</strong> djole8793@gmail.com</p>
                            <p><strong>Radno vreme recepcije:</strong> 08:00 - 23:00</p>
                        </div>
                        
                        <div class='footer'>
                            <p><strong>Važno:</strong></p>
                            <ul>
                                <li>Ova poruka je automatska potvrda prijema Vaše rezervacije</li>
                                <li>Naš osoblje će Vas kontaktirati u roku od 24 sata da potvrdi rezervaciju</li>
                                <li>Za hitna pitanja pozovite nas na 0631020209</li>
                                <li>Prijava: od 14:00 | Odjava: do 12:00</li>
                            </ul>
                            <p style='margin-top: 20px;'>Srdačno,<br><strong>Tim Restorana i Prenoćišta \"Dva Brata\"</strong></p>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $headers_user = "MIME-Version: 1.0\r\n";
            $headers_user .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers_user .= "From: Restoran Dva Brata <rezervacije@dvabrata.com>\r\n";
            $headers_user .= "Reply-To: djole8793@gmail.com\r\n";
            
            // Pošalji potvrdu korisniku
            mail($email, $subject_user, $message_user, $headers_user);
            
            $success_message = "✅ Hvala Vam na rezervaciji sobe! Poslali smo Vam potvrdu na email i kontaktiraćemo Vas u najkraćem roku.";
            
            // Sačuvaj rezervaciju u fajl
            saveReservationToFile($full_name, $email, $phone, $check_in, $check_out, $nights, $guests, $room_type, $breakfast, $notes, $total_price);
            
        } else {
            $error_message = "❌ Došlo je do greške prilikom slanja rezervacije. Molimo pokušajte ponovo ili nas pozovite na 0631020209.";
        }
    } else {
        $error_message = "❌ " . implode('<br>❌ ', $errors);
    }
}

// Funkcija za čuvanje rezervacije u fajl
function saveReservationToFile($name, $email, $phone, $check_in, $check_out, $nights, $guests, $room_type, $breakfast, $notes, $price) {
    $log_data = [
        'vreme' => date('Y-m-d H:i:s'),
        'ime' => $name,
        'email' => $email,
        'telefon' => $phone,
        'prijava' => $check_in,
        'odjava' => $check_out,
        'noci' => $nights,
        'gosti' => $guests,
        'soba' => $room_type,
        'dorucak' => $breakfast,
        'napomene' => $notes,
        'cena' => $price
    ];
    
    $log_line = json_encode($log_data, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    @file_put_contents('rezervacije_soba.log', $log_line, FILE_APPEND | LOCK_EX);
}
?>

<!-- CSS za rezervacijsku stranicu -->
<style>
:root {
    --primary: #8B4513;
    --secondary: #D2691E;
    --accent: #800000;
    --light: #F5F5DC;
    --dark: #333333;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f5f5dc 0%, #fff8f0 100%);
    min-height: 100vh;
}

.reservation-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px;
}

.reservation-header {
    text-align: center;
    margin-bottom: 50px;
    position: relative;
}

.section-title {
    font-size: 2.8rem;
    color: var(--primary);
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: var(--secondary);
    border-radius: 2px;
}

.reservation-intro {
    font-size: 1.2rem;
    color: #666;
    max-width: 800px;
    margin: 30px auto;
    line-height: 1.8;
    padding: 0 20px;
}

/* Stepper */
.stepper {
    display: flex;
    justify-content: space-between;
    margin: 50px auto 40px;
    position: relative;
    max-width: 900px;
}

.stepper::before {
    content: '';
    position: absolute;
    top: 25px;
    left: 10%;
    right: 10%;
    height: 3px;
    background: #ddd;
    z-index: 1;
}

.step {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
    padding: 0 10px;
}

.step-circle {
    width: 50px;
    height: 50px;
    background: white;
    border: 3px solid #ddd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-weight: bold;
    font-size: 1.2rem;
    transition: all 0.4s ease;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.step.active .step-circle {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
}

.step.completed .step-circle {
    background: #28a745;
    color: white;
    border-color: #28a745;
}

.step-label {
    font-size: 0.95rem;
    color: #666;
    font-weight: 500;
    transition: all 0.3s;
}

.step.active .step-label {
    color: var(--primary);
    font-weight: bold;
    font-size: 1rem;
}

/* Form Sections */
.tab-content {
    display: none;
    animation: fadeIn 0.5s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-section {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    border: 1px solid rgba(139, 69, 19, 0.1);
}

.form-section h3 {
    color: var(--primary);
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--secondary);
    font-size: 1.8rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    color: var(--dark);
    font-weight: 600;
    font-size: 1.05rem;
}

.form-control, .form-select {
    width: 100%;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s;
    background: white;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
}

.form-control:hover, .form-select:hover {
    border-color: #b0b0b0;
}

/* Date pickers */
.date-picker-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
}

.date-input {
    position: relative;
}

.date-input i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary);
}

/* Calendar */
.calendar-container {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    margin: 20px 0;
    border: 1px solid #eee;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 0 10px;
}

.calendar-nav {
    background: var(--primary);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.calendar-nav:hover {
    background: var(--secondary);
    transform: scale(1.1);
}

.calendar-month {
    font-weight: bold;
    color: var(--dark);
    font-size: 1.4rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 8px;
}

.calendar-day-header {
    text-align: center;
    padding: 12px;
    font-weight: bold;
    color: var(--dark);
    background: #f8f8f8;
    border-radius: 8px;
    font-size: 0.9rem;
}

.calendar-day {
    text-align: center;
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 500;
    position: relative;
    min-height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar-day:hover:not(.disabled):not(.empty) {
    background: #f9f5f0;
    border-color: var(--secondary);
    transform: translateY(-2px);
}

.calendar-day.selected {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    box-shadow: 0 5px 15px rgba(139, 69, 19, 0.2);
}

.calendar-day.check-in {
    background: rgba(139, 69, 19, 0.1);
    border-color: var(--primary);
    color: var(--primary);
}

.calendar-day.check-out {
    background: rgba(128, 0, 0, 0.1);
    border-color: var(--accent);
    color: var(--accent);
}

.calendar-day.in-range {
    background: rgba(139, 69, 19, 0.05);
    border-color: #ffcc99;
}

.calendar-day.today {
    border-color: var(--accent);
    background: #fff0f0;
}

.calendar-day.disabled {
    color: #ccc;
    cursor: not-allowed;
    background: #f9f9f9;
    text-decoration: line-through;
}

.calendar-day.empty {
    visibility: hidden;
}

/* Room Cards */
.room-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin: 25px 0;
}

.room-card {
    border: 3px solid #eee;
    border-radius: 15px;
    padding: 25px;
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
    background: white;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.room-card:hover {
    border-color: var(--secondary);
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.room-card.selected {
    border-color: var(--primary);
    background: linear-gradient(135deg, rgba(139, 69, 19, 0.05) 0%, rgba(255, 255, 255, 1) 100%);
    box-shadow: 0 10px 25px rgba(139, 69, 19, 0.15);
}

.room-card h4 {
    color: var(--primary);
    margin-bottom: 15px;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.room-price {
    font-size: 1.4rem;
    color: var(--accent);
    font-weight: bold;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 2px dashed #eee;
}

.room-features {
    list-style: none;
    margin: 20px 0;
    padding: 0;
    flex-grow: 1;
}

.room-features li {
    margin: 12px 0;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #555;
}

.room-features i {
    color: var(--primary);
    width: 20px;
    text-align: center;
}

/* Summary */
.reservation-summary {
    background: linear-gradient(135deg, #f9f5f0 0%, #fff8f0 100%);
    padding: 30px;
    border-radius: 15px;
    margin-top: 30px;
    border-left: 5px solid var(--primary);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.reservation-summary h4 {
    color: var(--primary);
    margin-bottom: 25px;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin: 15px 0;
    padding: 12px 0;
    border-bottom: 1px dashed #ddd;
    align-items: center;
}

.summary-total {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary);
    margin-top: 20px;
    padding-top: 20px;
    border-top: 3px solid var(--primary);
    display: flex;
    justify-content: space-between;
}

/* Messages */
.message {
    padding: 20px 25px;
    border-radius: 10px;
    margin: 25px 0;
    text-align: left;
    font-size: 1.1rem;
    line-height: 1.6;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    animation: slideIn 0.5s ease;
}

@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 1px solid #b1dfbb;
    border-left: 5px solid #28a745;
}

.error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 1px solid #f1b0b7;
    border-left: 5px solid #dc3545;
}

/* Contact Info */
.contact-info-box {
    background: linear-gradient(135deg, #e8f4fc 0%, #f0f7ff 100%);
    padding: 30px;
    border-radius: 15px;
    margin: 30px 0;
    border-left: 5px solid #007bff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.contact-info-box h4 {
    color: #007bff;
    margin-bottom: 20px;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin: 20px 0;
    padding: 15px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.info-item i {
    color: #007bff;
    font-size: 1.2rem;
    margin-top: 3px;
}

/* Buttons */
.form-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    gap: 20px;
}

.btn-prev, .btn-next {
    padding: 16px 35px;
    border-radius: 12px;
    font-weight: bold;
    cursor: pointer;
    border: 2px solid var(--primary);
    transition: all 0.3s;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 180px;
    justify-content: center;
}

.btn-prev {
    background: white;
    color: var(--primary);
}

.btn-next {
    background: var(--primary);
    color: white;
}

.btn-prev:hover {
    background: #f9f9f9;
    transform: translateX(-5px);
}

.btn-next:hover {
    background: var(--secondary);
    border-color: var(--secondary);
    transform: translateX(5px);
}

.btn-submit {
    width: 100%;
    padding: 20px;
    background: linear-gradient(135deg, var(--accent) 0%, #600018 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
    box-shadow: 0 10px 25px rgba(128, 0, 0, 0.2);
}

.btn-submit:hover {
    background: linear-gradient(135deg, #600018 0%, var(--accent) 100%);
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(128, 0, 0, 0.3);
}

.btn-submit:active {
    transform: translateY(0);
}

/* Room availability */
.availability-status {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9rem;
    font-weight: bold;
    margin-top: 10px;
}

.available {
    background: #d4edda;
    color: #155724;
}

.unavailable {
    background: #f8d7da;
    color: #721c24;
}

/* Responsive */
@media (max-width: 768px) {
    .reservation-container {
        padding: 20px 15px;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .stepper {
        flex-direction: column;
        gap: 30px;
        align-items: center;
    }
    
    .stepper::before {
        display: none;
    }
    
    .step {
        width: 100%;
        max-width: 300px;
    }
    
    .form-section {
        padding: 25px;
    }
    
    .room-options {
        grid-template-columns: 1fr;
    }
    
    .calendar-grid {
        gap: 5px;
    }
    
    .calendar-day {
        padding: 12px 5px;
        min-height: 50px;
        font-size: 0.9rem;
    }
    
    .date-picker-group {
        grid-template-columns: 1fr;
    }
    
    .form-buttons {
        flex-direction: column;
    }
    
    .btn-prev, .btn-next {
        width: 100%;
    }
}

/* Loading animation */
.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Checkbox styles */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 10px;
    transition: all 0.3s;
}

.checkbox-group:hover {
    background: #f0f0f0;
}

.checkbox-group input[type="checkbox"] {
    width: 22px;
    height: 22px;
    cursor: pointer;
    accent-color: var(--primary);
}

.checkbox-group span {
    font-weight: 500;
    color: var(--dark);
}

/* Textarea */
.textarea {
    min-height: 120px;
    resize: vertical;
}

/* Nights counter */
.nights-counter {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f9f5f0;
    padding: 15px;
    border-radius: 10px;
    margin-top: 20px;
}

.nights-counter span {
    font-weight: bold;
    color: var(--primary);
}
</style>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // GLOBALNE VARIJABLE
    // ============================================
    let currentStep = 1;
    let selectedRoom = '';
    let selectedGuests = 2;
    let withBreakfast = true;
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let checkInDate = '';
    let checkOutDate = '';
    let nights = 0;
    
    // ============================================
    // INICIJALIZACIJA
    // ============================================
    initBookingSystem();
    
    function initBookingSystem() {
        initCalendar();
        updateStepper();
        updateSummary();
        setupEventListeners();
        
        // Inicijalno selektuj datume
        setTimeout(() => {
            selectDefaultDates();
            updateSummary();
        }, 100);
    }
    
    // ============================================
    // KALENDAR FUNKCIONALNOST
    // ============================================
    function initCalendar() {
        updateCalendarDisplay();
        setupCalendarNavigation();
    }
    
    function updateCalendarDisplay() {
        const monthNames = [
            'Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun',
            'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'
        ];
        
        const monthElement = document.querySelector('.calendar-month');
        if (monthElement) {
            monthElement.textContent = `${monthNames[currentMonth]} ${currentYear}`;
        }
        
        generateCalendarDays();
    }
    
    function generateCalendarDays() {
        const calendarGrid = document.querySelector('.calendar-grid');
        if (!calendarGrid) return;
        
        // Očisti postojeće dane
        const existingDays = calendarGrid.querySelectorAll('.calendar-day:not(.calendar-day-header)');
        existingDays.forEach(day => day.remove());
        
        // Prvi dan u mesecu
        const firstDay = new Date(currentYear, currentMonth, 1);
        const startingDay = firstDay.getDay();
        const adjustedStart = startingDay === 0 ? 6 : startingDay - 1;
        
        // Broj dana u mesecu
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        
        // Prazna polja pre prvog dana
        for (let i = 0; i < adjustedStart; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-day empty';
            calendarGrid.appendChild(emptyCell);
        }
        
        // Dana u mesecu
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const isCurrentMonth = currentMonth === today.getMonth() && currentYear === today.getFullYear();
        
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;
            
            // Datum ovog dana
            const currentDate = new Date(currentYear, currentMonth, day);
            currentDate.setHours(0, 0, 0, 0);
            
            // Proveri da li je dan u prošlosti
            if (currentDate < today) {
                dayElement.classList.add('disabled');
                dayElement.title = 'Ovaj datum nije dostupan';
            } else {
                dayElement.addEventListener('click', function() {
                    selectDate(currentDate);
                });
            }
            
            // Označi današnji dan
            if (isCurrentMonth && day === today.getDate()) {
                dayElement.classList.add('today');
            }
            
            // Označi selektovane datume
            if (checkInDate || checkOutDate) {
                const dateString = formatDate(currentDate);
                
                if (dateString === checkInDate) {
                    dayElement.classList.add('check-in');
                    dayElement.innerHTML = `<strong>${day}</strong><br><small>Prijava</small>`;
                } else if (dateString === checkOutDate) {
                    dayElement.classList.add('check-out');
                    dayElement.innerHTML = `<strong>${day}</strong><br><small>Odjava</small>`;
                } else if (isDateInRange(currentDate)) {
                    dayElement.classList.add('in-range');
                }
            }
            
            calendarGrid.appendChild(dayElement);
        }
    }
    
    function setupCalendarNavigation() {
        const prevBtn = document.querySelector('.calendar-nav.prev');
        const nextBtn = document.querySelector('.calendar-nav.next');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                updateCalendarDisplay();
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                updateCalendarDisplay();
            });
        }
    }
    
    function selectDate(date) {
        const dateString = formatDate(date);
        
        if (!checkInDate) {
            // Prvi klik - postavi check-in
            checkInDate = dateString;
            document.getElementById('check_in').value = checkInDate;
        } else if (!checkOutDate) {
            // Drugi klik - postavi check-out
            const checkIn = new Date(checkInDate);
            if (date > checkIn) {
                checkOutDate = dateString;
                document.getElementById('check_out').value = checkOutDate;
                
                // Izračunaj broj noći
                const diffTime = Math.abs(date - checkIn);
                nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            } else {
                // Ako je check-out pre check-in, resetuj
                checkInDate = dateString;
                checkOutDate = '';
                document.getElementById('check_in').value = checkInDate;
                document.getElementById('check_out').value = '';
                nights = 0;
            }
        } else {
            // Resetuj i počni ponovo
            checkInDate = dateString;
            checkOutDate = '';
            nights = 0;
            document.getElementById('check_in').value = checkInDate;
            document.getElementById('check_out').value = '';
        }
        
        updateCalendarDisplay();
        updateSummary();
    }
    
    function selectDefaultDates() {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        checkInDate = formatDate(today);
        checkOutDate = formatDate(tomorrow);
        
        // Izračunaj broj noći
        const diffTime = Math.abs(tomorrow - today);
        nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        document.getElementById('check_in').value = checkInDate;
        document.getElementById('check_out').value = checkOutDate;
    }
    
    function isDateInRange(date) {
        if (!checkInDate || !checkOutDate) return false;
        
        const dateString = formatDate(date);
        const checkIn = new Date(checkInDate);
        const checkOut = new Date(checkOutDate);
        
        return date > checkIn && date < checkOut;
    }
    
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    
    // ============================================
    // STEPPER I NAVIGACIJA
    // ============================================
    function updateStepper() {
        // Ažuriraj korake
        document.querySelectorAll('.step').forEach((step, index) => {
            const stepNumber = index + 1;
            step.classList.remove('active', 'completed');
            
            if (stepNumber < currentStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('active');
            }
        });
        
        // Ažuriraj tabove
        document.querySelectorAll('.tab-content').forEach((content, index) => {
            const tabNumber = index + 1;
            content.classList.remove('active');
            
            if (tabNumber === currentStep) {
                content.classList.add('active');
                // Scroll to top of form
                content.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
        
        // Ažuriraj dugmad
        updateNavigationButtons();
    }
    
    function updateNavigationButtons() {
        const prevBtn = document.querySelector('.btn-prev');
        const nextBtn = document.querySelector('.btn-next');
        const submitBtn = document.querySelector('.btn-submit');
        
        if (prevBtn) {
            prevBtn.style.display = currentStep === 1 ? 'none' : 'flex';
            prevBtn.innerHTML = '<i class="fas fa-arrow-left"></i> Prethodni korak';
        }
        
        if (nextBtn) {
            const isLastStep = currentStep === 4;
            nextBtn.innerHTML = isLastStep ? 'Potvrdi rezervaciju <i class="fas fa-arrow-right"></i>' : 'Sledeći korak <i class="fas fa-arrow-right"></i>';
            nextBtn.style.display = isLastStep ? 'none' : 'flex';
        }
        
        if (submitBtn) {
            submitBtn.style.display = currentStep === 4 ? 'flex' : 'none';
        }
    }
    
    // ============================================
    // REZIME I CENE
    // ============================================
    function updateSummary() {
        // Cene soba
        const roomPrices = {
            'single': 3500,
            'double': 5000,
            'suite': 8000
        };
        
        // Nazivi soba
        const roomNames = {
            'single': 'Jednokrevetna soba',
            'double': 'Dvokrevetna soba',
            'suite': 'Apartman (suite)'
        };
        
        // Izračun
        let roomPrice = selectedRoom ? roomPrices[selectedRoom] || 0 : 0;
        let total = 0;
        let breakfastCost = 0;
        
        if (selectedRoom && nights > 0) {
            total = roomPrice * nights;
            if (withBreakfast) {
                breakfastCost = 500 * selectedGuests * nights;
                total += breakfastCost;
            }
        }
        
        // Ažuriranje prikaza
        const totalPriceElement = document.getElementById('total-price');
        if (totalPriceElement) {
            totalPriceElement.textContent = formatPrice(total) + ' RSD';
        }
        
        // Ažuriranje elemenata u sumarnom prikazu
        updateSummaryElement('summary-check-in', checkInDate ? formatDisplayDate(checkInDate) : '-');
        updateSummaryElement('summary-check-out', checkOutDate ? formatDisplayDate(checkOutDate) : '-');
        updateSummaryElement('summary-nights', nights);
        updateSummaryElement('summary-guests', selectedGuests);
        
        if (selectedRoom) {
            updateSummaryElement('summary-room', `${roomNames[selectedRoom]} - ${formatPrice(roomPrice)} RSD/noć`);
            updateSummaryElement('summary-breakfast', withBreakfast ? 
                `Sa doručkom (+${formatPrice(breakfastCost)} RSD)` : 
                'Bez doručka');
            
            // Prikaži sekcije za sobu
            showRoomSections(true);
        } else {
            // Sakrij sekcije za sobu
            showRoomSections(false);
        }
        
        // Ažuriraj broj noći u step 1
        const nightsElement = document.getElementById('nights-count');
        if (nightsElement) {
            nightsElement.textContent = nights;
            nightsElement.parentElement.style.display = nights > 0 ? 'flex' : 'none';
        }
    }
    
    function updateSummaryElement(id, value) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
        }
    }
    
    function showRoomSections(show) {
        const roomElements = document.querySelectorAll('.room-summary, .nights-summary, .breakfast-summary, .total-summary');
        roomElements.forEach(el => {
            el.style.display = show ? 'flex' : 'none';
        });
    }
    
    function formatPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function formatDisplayDate(dateString) {
        const date = new Date(dateString);
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        return date.toLocaleDateString('sr-RS', options);
    }
    
    // ============================================
    // VALIDACIJA
    // ============================================
    function validateCurrentStep() {
        let isValid = true;
        let errorMessage = '';
        
        switch(currentStep) {
            case 1: // Datumi boravka
                if (!checkInDate) {
                    errorMessage = 'Molimo izaberite datum prijave.';
                    isValid = false;
                }
                if (!checkOutDate) {
                    errorMessage = errorMessage ? errorMessage + '\nMolimo izaberite datum odjave.' : 'Molimo izaberite datum odjave.';
                    isValid = false;
                }
                if (nights < 1) {
                    errorMessage = errorMessage ? errorMessage + '\nBroj noći mora biti najmanje 1.' : 'Broj noći mora biti najmanje 1.';
                    isValid = false;
                }
                break;
                
            case 2: // Izbor sobe
                const reservationType = document.querySelector('input[name="reservation_type"]:checked');
                
                if (!selectedRoom) {
                    errorMessage = 'Molimo izaberite tip sobe.';
                    isValid = false;
                }
                
                // Validacija broja gostiju
                const guestsInput = document.getElementById('guests');
                const guests = parseInt(guestsInput?.value || 0);
                
                if (isNaN(guests) || guests < 1 || guests > 4) {
                    errorMessage = 'Broj gostiju mora biti između 1 i 4.';
                    isValid = false;
                }
                
                // Proveri kapacitet sobe
                if (selectedRoom === 'single' && guests > 1) {
                    errorMessage = 'Jednokrevetna soba je za 1 gosta.';
                    isValid = false;
                }
                break;
                
            case 3: // Kontakt podaci
                const name = document.getElementById('full_name')?.value.trim();
                const email = document.getElementById('email')?.value.trim();
                const phone = document.getElementById('phone')?.value.trim();
                
                if (!name) {
                    errorMessage = 'Molimo unesite Vaše ime i prezime.';
                    isValid = false;
                }
                
                if (!email || !isValidEmail(email)) {
                    errorMessage = errorMessage ? errorMessage + '\nMolimo unesite ispravnu email adresu.' : 'Molimo unesite ispravnu email adresu.';
                    isValid = false;
                }
                
                if (!phone) {
                    errorMessage = errorMessage ? errorMessage + '\nMolimo unesite Vaš broj telefona.' : 'Molimo unesite Vaš broj telefona.';
                    isValid = false;
                }
                break;
        }
        
        if (!isValid && errorMessage) {
            showError(errorMessage);
        }
        
        return isValid;
    }
    
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function showError(message) {
        // Kreiraj ili ažuriraj error message
        let errorDiv = document.querySelector('.error-message');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message message error';
            document.querySelector('.form-section').prepend(errorDiv);
        }
        
        errorDiv.innerHTML = `
            <div style="display: flex; align-items: flex-start; gap: 15px;">
                <div style="font-size: 1.5rem;">❌</div>
                <div>
                    <strong>Molimo ispravite sledeće greške:</strong>
                    <div style="margin-top: 10px;">${message.replace(/\n/g, '<br>')}</div>
                </div>
            </div>
        `;
        
        // Automatski sakrij nakon 10 sekundi
        setTimeout(() => {
            errorDiv.remove();
        }, 10000);
    }
    
    // ============================================
    // EVENT LISTENERI
    // ============================================
    function setupEventListeners() {
        // Selekcija sobe
        document.querySelectorAll('.room-card').forEach(card => {
            card.addEventListener('click', function() {
                // Ukloni selektovanje sa svih soba
                document.querySelectorAll('.room-card').forEach(c => {
                    c.classList.remove('selected');
                });
                
                // Selektuj kliknutu sobu
                this.classList.add('selected');
                
                // Sačuvaj tip sobe
                selectedRoom = this.dataset.room;
                
                // Ažuriraj radio dugme
                const roomRadio = document.querySelector(`input[name="room_type"][value="${selectedRoom}"]`);
                if (roomRadio) {
                    roomRadio.checked = true;
                }
                
                updateSummary();
            });
        });
        
        // Broj gostiju
        const guestsInput = document.getElementById('guests');
        if (guestsInput) {
            guestsInput.addEventListener('change', function() {
                selectedGuests = parseInt(this.value) || 1;
                updateSummary();
            });
        }
        
        // Doručak
        const breakfastCheckbox = document.getElementById('breakfast');
        if (breakfastCheckbox) {
            breakfastCheckbox.addEventListener('change', function() {
                withBreakfast = this.checked;
                updateSummary();
            });
        }
        
        // Navigacioni dugmadi
        const prevBtn = document.querySelector('.btn-prev');
        const nextBtn = document.querySelector('.btn-next');
        const submitBtn = document.querySelector('.btn-submit');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateStepper();
                }
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (validateCurrentStep()) {
                    if (currentStep < 4) {
                        currentStep++;
                        updateStepper();
                    }
                }
            });
        }
        
        // Form submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Proveri validaciju za poslednji korak
                if (!validateCurrentStep()) {
                    e.preventDefault();
                    return false;
                }
                
                // Prikaži loading state
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="loading"></span> Šaljem rezervaciju...';
                    submitBtn.disabled = true;
                    
                    // Vrati originalno stanje nakon 5 sekundi (ako se nešto desi)
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 5000);
                }
            });
        }
        
        // Real-time validacija kontakt podataka
        const nameInput = document.getElementById('full_name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        
        if (nameInput) {
            nameInput.addEventListener('blur', function() {
                validateField(this, this.value.trim() !== '', 'Ime i prezime je obavezno polje');
            });
        }
        
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                const isValid = this.value.trim() !== '' && isValidEmail(this.value.trim());
                validateField(this, isValid, 'Unesite ispravnu email adresu');
            });
        }
        
        if (phoneInput) {
            phoneInput.addEventListener('blur', function() {
                validateField(this, this.value.trim() !== '', 'Telefon je obavezno polje');
            });
        }
        
        // Date inputs change
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        
        if (checkInInput) {
            checkInInput.addEventListener('change', function() {
                checkInDate = this.value;
                calculateNights();
                updateCalendarDisplay();
                updateSummary();
            });
        }
        
        if (checkOutInput) {
            checkOutInput.addEventListener('change', function() {
                checkOutDate = this.value;
                calculateNights();
                updateCalendarDisplay();
                updateSummary();
            });
        }
    }
    
    function calculateNights() {
        if (checkInDate && checkOutDate) {
            const checkIn = new Date(checkInDate);
            const checkOut = new Date(checkOutDate);
            const diffTime = Math.abs(checkOut - checkIn);
            nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        } else {
            nights = 0;
        }
    }
    
    function validateField(field, isValid, errorMessage) {
        const parent = field.parentElement;
        const errorSpan = parent.querySelector('.field-error');
        
        if (!isValid) {
            field.style.borderColor = '#dc3545';
            if (!errorSpan) {
                const error = document.createElement('span');
                error.className = 'field-error';
                error.style.color = '#dc3545';
                error.style.fontSize = '0.9rem';
                error.style.display = 'block';
                error.style.marginTop = '5px';
                error.textContent = errorMessage;
                parent.appendChild(error);
            }
        } else {
            field.style.borderColor = '#28a745';
            if (errorSpan) {
                errorSpan.remove();
            }
        }
    }
});
</script>

<div class="reservation-container">
    <div class="reservation-header">
        <h1 class="section-title">🛏️ Rezervacija Soba</h1>
        <p class="reservation-intro">
            Rezervišite svoju sobu u našem prenoćištu "Dva Brata". Izaberite datume boravka, tip sobe i ostavite nam Vaše podatke.
            Naš tim će Vas kontaktirati u najkraćem roku da potvrdi rezervaciju.
        </p>
        
        <?php if ($success_message): ?>
            <div class="message success">
                <?php echo $success_message; ?>
                <div style="margin-top: 15px;">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="color: #155724; text-decoration: underline;">
                        Napravite novu rezervaciju
                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Stepper -->
    <div class="stepper">
        <div class="step" data-step="1">
            <div class="step-circle">1</div>
            <div class="step-label">Datumi boravka</div>
        </div>
        <div class="step" data-step="2">
            <div class="step-circle">2</div>
            <div class="step-label">Izbor sobe</div>
        </div>
        <div class="step" data-step="3">
            <div class="step-circle">3</div>
            <div class="step-label">Vaši podaci</div>
        </div>
        <div class="step" data-step="4">
            <div class="step-circle">4</div>
            <div class="step-label">Potvrda</div>
        </div>
    </div>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="reservation-form">
        
        <!-- Korak 1: Datumi boravka -->
        <div class="tab-content active" id="step-1">
            <div class="form-section">
                <h3><i class="far fa-calendar-alt"></i> Izaberite datume boravka</h3>
                
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button type="button" class="calendar-nav prev">‹</button>
                        <div class="calendar-month">Januar 2024</div>
                        <button type="button" class="calendar-nav next">›</button>
                    </div>
                    
                    <div class="calendar-grid">
                        <div class="calendar-day-header">Pon</div>
                        <div class="calendar-day-header">Uto</div>
                        <div class="calendar-day-header">Sre</div>
                        <div class="calendar-day-header">Čet</div>
                        <div class="calendar-day-header">Pet</div>
                        <div class="calendar-day-header">Sub</div>
                        <div class="calendar-day-header">Ned</div>
                        <!-- Dana će biti dinamički dodati JavaScript-om -->
                    </div>
                </div>
                
                <div class="date-picker-group">
                    <div class="form-group date-input">
                        <label for="check_in"><i class="fas fa-sign-in-alt"></i> Datum prijave</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" required>
                        <i class="far fa-calendar"></i>
                    </div>
                    
                    <div class="form-group date-input">
                        <label for="check_out"><i class="fas fa-sign-out-alt"></i> Datum odjave</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" required>
                        <i class="far fa-calendar"></i>
                    </div>
                </div>
                
                <div class="nights-counter" style="display: none;">
                    <span>Broj noći:</span>
                    <span id="nights-count">0</span>
                </div>
                
                <div style="margin-top: 20px; padding: 15px; background: #f0f7ff; border-radius: 10px;">
                    <p style="margin: 0; color: #0066cc;">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Napomena:</strong> Prijava: od 14:00 | Odjava: do 12:00
                    </p>
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="button" class="btn-next">
                    Sledeći korak <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Korak 2: Izbor sobe -->
        <div class="tab-content" id="step-2">
            <div class="form-section">
                <h3><i class="fas fa-hotel"></i> Izaberite tip sobe</h3>
                
                <div class="room-options">
                    <!-- Jednokrevetna soba -->
                    <div class="room-card" data-room="single">
                        <h4><i class="fas fa-user"></i> Jednokrevetna soba</h4>
                        <p style="color: #666; font-size: 0.95rem; margin: 15px 0; line-height: 1.5;">
                            Udobna soba sa jednim krevetom, idealna za pojedince.
                        </p>
                        <ul class="room-features">
                            <li><i class="fas fa-check"></i> 1 krevet (90x200)</li>
                            <li><i class="fas fa-wifi"></i> Besplatan WiFi</li>
                            <li><i class="fas fa-car"></i> Besplatan parking</li>
                            <li><i class="fas fa-bath"></i> Privatno kupatilo</li>
                            <li><i class="fas fa-snowflake"></i> Klima uredjaj</li>
                        </ul>
                        <div class="room-price">3.500 RSD / noć</div>
                        <div class="availability-status available">✓ Dostupno</div>
                        <input type="radio" name="room_type" value="single" style="display: none;">
                    </div>
                    
                    <!-- Dvokrevetna soba -->
                    <div class="room-card" data-room="double">
                        <h4><i class="fas fa-users"></i> Dvokrevetna soba</h4>
                        <p style="color: #666; font-size: 0.95rem; margin: 15px 0; line-height: 1.5;">
                            Prostrana soba sa dva odvojena kreveta, idealna za parove ili prijatelje.
                        </p>
                        <ul class="room-features">
                            <li><i class="fas fa-check"></i> 2 kreveta (90x200)</li>
                            <li><i class="fas fa-wifi"></i> Besplatan WiFi</li>
                            <li><i class="fas fa-car"></i> Besplatan parking</li>
                            <li><i class="fas fa-bath"></i> Privatno kupatilo</li>
                            <li><i class="fas fa-snowflake"></i> Klima uredjaj</li>
                            <li><i class="fas fa-tv"></i> Flat TV</li>
                        </ul>
                        <div class="room-price">5.000 RSD / noć</div>
                        <div class="availability-status available">✓ Dostupno</div>
                        <input type="radio" name="room_type" value="double" style="display: none;">
                    </div>
                    
                    <!-- Apartman -->
                    <div class="room-card" data-room="suite">
                        <h4><i class="fas fa-crown"></i> Apartman (Suite)</h4>
                        <p style="color: #666; font-size: 0.95rem; margin: 15px 0; line-height: 1.5;">
                            Luksuzni apartman sa dnevnom sobom i spavaćom sobom.
                        </p>
                        <ul class="room-features">
                            <li><i class="fas fa-check"></i> 2-3 kreveta</li>
                            <li><i class="fas fa-wifi"></i> Besplatan WiFi</li>
                            <li><i class="fas fa-car"></i> Besplatan parking</li>
                            <li><i class="fas fa-bath"></i> Privatno kupatilo</li>
                            <li><i class="fas fa-snowflake"></i> Klima uredjaj</li>
                            <li><i class="fas fa-tv"></i> Smart TV</li>
                            <li><i class="fas fa-coffee"></i> Mini bar</li>
                        </ul>
                        <div class="room-price">8.000 RSD / noć</div>
                        <div class="availability-status available">✓ Dostupno</div>
                        <input type="radio" name="room_type" value="suite" style="display: none;">
                    </div>
                </div>
                
                <!-- Broj gostiju -->
                <div class="form-group guests-section" style="margin-top: 30px;">
                    <label for="guests"><i class="fas fa-users"></i> Broj gostiju</label>
                    <select name="guests" id="guests" class="form-select" required>
                        <option value="1">1 gost</option>
                        <option value="2" selected>2 gosta</option>
                        <option value="3">3 gosta</option>
                        <option value="4">4 gosta</option>
                    </select>
                </div>
                
                <!-- Doručak -->
                <div class="form-group">
                    <label class="checkbox-group">
                        <input type="checkbox" name="breakfast" id="breakfast" checked>
                        <span><i class="fas fa-coffee"></i> Želim doručak (+500 RSD/gost/noć)</span>
                    </label>
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="button" class="btn-prev">
                    <i class="fas fa-arrow-left"></i> Prethodni korak
                </button>
                <button type="button" class="btn-next">
                    Sledeći korak <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Korak 3: Vaši podaci -->
        <div class="tab-content" id="step-3">
            <div class="form-section">
                <h3><i class="fas fa-user-circle"></i> Vaši kontakt podaci</h3>
                
                <div class="form-group">
                    <label for="full_name"><i class="fas fa-user"></i> Ime i prezime *</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Unesite Vaše puno ime i prezime" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email adresa *</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="vas.email@primer.com" required>
                </div>
                
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Telefon *</label>
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="0631020209" required>
                </div>
                
                <!-- Napomene -->
                <div class="form-group">
                    <label for="notes"><i class="fas fa-sticky-note"></i> Posebni zahtevi ili napomene</label>
                    <textarea name="notes" id="notes" class="form-control textarea" placeholder="Ako imate posebne zahteve, alergije, dolazak sa ljubimcem ili bilo šta drugo što bismo trebali da znamo..."></textarea>
                </div>
                
                <!-- Rezime rezervacije -->
                <div class="reservation-summary">
                    <h4><i class="fas fa-clipboard-list"></i> Rezime Vaše rezervacije</h4>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-sign-in-alt"></i> Prijava:</span>
                        <span id="summary-check-in">-</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-sign-out-alt"></i> Odjava:</span>
                        <span id="summary-check-out">-</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-moon"></i> Broj noći:</span>
                        <span id="summary-nights">0</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-users"></i> Broj gostiju:</span>
                        <span id="summary-guests">2</span>
                    </div>
                    
                    <div class="summary-item room-summary" style="display: none;">
                        <span><i class="fas fa-bed"></i> Tip sobe:</span>
                        <span id="summary-room">-</span>
                    </div>
                    
                    <div class="summary-item breakfast-summary" style="display: none;">
                        <span><i class="fas fa-coffee"></i> Doručak:</span>
                        <span id="summary-breakfast">-</span>
                    </div>
                    
                    <div class="summary-item total-summary" style="display: none;">
                        <span><i class="fas fa-money-bill-wave"></i> Ukupna cena:</span>
                        <span id="total-price">0 RSD</span>
                    </div>
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="button" class="btn-prev">
                    <i class="fas fa-arrow-left"></i> Prethodni korak
                </button>
                <button type="button" class="btn-next">
                    Sledeći korak <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Korak 4: Potvrda -->
        <div class="tab-content" id="step-4">
            <div class="form-section">
                <h3><i class="fas fa-check-circle"></i> Potvrda rezervacije</h3>
                
                <div class="reservation-summary">
                    <h4><i class="fas fa-clipboard-check"></i> Pregled Vaše rezervacije</h4>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-sign-in-alt"></i> Prijava:</span>
                        <span id="final-check-in">-</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-sign-out-alt"></i> Odjava:</span>
                        <span id="final-check-out">-</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-moon"></i> Broj noći:</span>
                        <span id="final-nights">0</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-users"></i> Broj gostiju:</span>
                        <span id="final-guests">2</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-bed"></i> Tip sobe:</span>
                        <span id="final-room">-</span>
                    </div>
                    
                    <div class="summary-item">
                        <span><i class="fas fa-coffee"></i> Doručak:</span>
                        <span id="final-breakfast">-</span>
                    </div>
                    
                    <div class="summary-total">
                        <span><i class="fas fa-money-bill-wave"></i> Ukupna cena:</span>
                        <span id="final-price">0 RSD</span>
                    </div>
                </div>
                
                <div class="contact-info-box">
                    <h4><i class="fas fa-info-circle"></i> Važne informacije</h4>
                    <p>Naš tim će Vas kontaktirati u roku od 24 sata da potvrdi rezervaciju. Molimo proverite Vaš email i telefon.</p>
                    
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Kontakt telefon</strong><br>
                            Za hitna pitanja možete nas pozvati na: <strong>0631020209</strong>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email adresa</strong><br>
                            Pišite nam na: <strong>djole8793@gmail.com</strong>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Radno vreme recepcije</strong><br>
                            Pon-Ned: 08:00 - 23:00
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-door-open"></i>
                        <div>
                            <strong>Vreme prijave/odjave</strong><br>
                            Prijava: od 14:00 | Odjava: do 12:00
                        </div>
                    </div>
                </div>
                
                <p style="margin-top: 20px; color: #666; line-height: 1.6; padding: 15px; background: #f9f9f9; border-radius: 10px;">
                    <strong><i class="fas fa-exclamation-circle"></i> Napomena:</strong> 
                    Ova rezervacija će biti potvrđena nakon što Vas kontaktira naš osoblje. Ako ne primite poziv ili email u roku od 24 sata, molimo kontaktirajte nas direktno.
                </p>
                
                <button type="submit" class="btn-submit" name="submit_reservation">
                    <i class="fas fa-paper-plane"></i> Pošaljite rezervaciju
                </button>
                
                <div style="margin-top: 20px; text-align: center; color: #666; font-size: 0.9rem;">
                    <p>Klikom na "Pošaljite rezervaciju" potvrđujete da ste pročitali i prihvatili naše uslove rezervacije.</p>
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="button" class="btn-prev">
                    <i class="fas fa-arrow-left"></i> Prethodni korak
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Dodatni JavaScript za ažuriranje finalnog rezimea
document.addEventListener('DOMContentLoaded', function() {
    // Funkcija za ažuriranje finalnog rezimea
    function updateFinalSummary() {
        // Nazivi soba
        const roomNames = {
            'single': 'Jednokrevetna soba',
            'double': 'Dvokrevetna soba',
            'suite': 'Apartman (suite)'
        };
        
        // Ažuriraj finalne vrednosti
        updateFinalElement('final-check-in', checkInDate ? formatDisplayDate(checkInDate) : '-');
        updateFinalElement('final-check-out', checkOutDate ? formatDisplayDate(checkOutDate) : '-');
        updateFinalElement('final-nights', nights);
        updateFinalElement('final-guests', selectedGuests);
        updateFinalElement('final-room', selectedRoom ? roomNames[selectedRoom] : '-');
        updateFinalElement('final-breakfast', withBreakfast ? 'Da (+500 RSD/gost/noć)' : 'Ne');
        
        // Izračunaj i prikaži finalnu cenu
        const roomPrices = {
            'single': 3500,
            'double': 5000,
            'suite': 8000
        };
        
        let total = 0;
        if (selectedRoom && nights > 0) {
            total = roomPrices[selectedRoom] * nights;
            if (withBreakfast) {
                total += (500 * selectedGuests * nights);
            }
        }
        
        const finalPriceElement = document.getElementById('final-price');
        if (finalPriceElement) {
            finalPriceElement.textContent = formatPrice(total) + ' RSD';
        }
    }
    
    function updateFinalElement(id, value) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
        }
    }
    
    // Dodaj event listener za promene
    document.addEventListener('summaryUpdated', function() {
        updateFinalSummary();
    });
    
    // Simulacija eventa
    const originalUpdateSummary = window.updateSummary;
    window.updateSummary = function() {
        if (originalUpdateSummary) originalUpdateSummary();
        document.dispatchEvent(new CustomEvent('summaryUpdated'));
    };
    
    // Inicijalno ažuriranje
    updateFinalSummary();
});
</script>