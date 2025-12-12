
<?php

// ✅ PRAVILAN REDOSLED:
// 1. Uključi config.php PRVO (za jezike i sesiju)
include_once "includes/config.php";

// 2. Definiši koja stranica se otvara
$page = isset($_GET['page']) ? $_GET['page'] : 'pocetna';

// 3. Dozvoljene stranice (DODAJ 'galerija')
$allowed_pages = ['pocetna', 'onama', 'meni', 'galerija', 'kontakt', 'rezervacije'];

// 4. Ako stranica nije dozvoljena, prikaži početnu
if (!in_array($page, $allowed_pages)) {
    $page = 'pocetna';
}

// 5. Uključi header
include "header.php";

// 6. Uključi traženu stranicu
include "pages/" . $page . ".php";

// 7. Uključi footer
include "footer.php";
?>
