<!DOCTYPE html>
<html lang="<?php echo isset($current_language) ? $current_language : 'sr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo __('meta_description'); ?>">
    <meta name="keywords" content="<?php echo __('keywords'); ?>">
    <title><?php echo __('site_name'); ?> - <?php echo ucfirst(__($page)); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <span class="logo-icon">🍽️</span>
                    <?php echo __('site_name'); ?>
                </div>
                
                <!-- Jezički prekidač -->
                <div class="language-switcher">
                    <a href="?lang=sr&page=<?php echo $page; ?>" class="lang-btn <?php echo (isset($current_language) && $current_language == 'sr') ? 'active' : ''; ?>">
                        🇷🇸
                    </a>
                    <a href="?lang=en&page=<?php echo $page; ?>" class="lang-btn <?php echo (isset($current_language) && $current_language == 'en') ? 'active' : ''; ?>">
                        🇬🇧
                    </a>
                </div>
                
                <button class="menu-toggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                
                <ul class="nav-links">
                    <li><a href="?page=pocetna" <?php echo ($page == 'pocetna') ? 'class="active"' : ''; ?>><?php echo __('home'); ?></a></li>
                    <li><a href="?page=onama" <?php echo ($page == 'onama') ? 'class="active"' : ''; ?>><?php echo __('about'); ?></a></li>
                    <li><a href="?page=meni" <?php echo ($page == 'meni') ? 'class="active"' : ''; ?>><?php echo __('menu'); ?></a></li>
                    <li><a href="?page=galerija" <?php echo ($page == 'galerija') ? 'class="active"' : ''; ?>><?php echo __('gallery'); ?></a></li>
                    <li><a href="?page=kontakt" <?php echo ($page == 'kontakt') ? 'class="active"' : ''; ?>><?php echo __('contact'); ?></a></li>
                    <li><a href="?page=rezervacije" <?php echo ($page == 'rezervacije') ? 'class="active"' : ''; ?>><?php echo __('reservations'); ?></a></li>
                </ul>
            </nav>
        </div>
    </header>