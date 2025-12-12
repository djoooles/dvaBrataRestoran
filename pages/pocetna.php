

<!-- ============================================
     POČETNA STRANICA - KOMPLETNO POPRAVLJENA
============================================ -->

<!-- Hero sekcija -->
<section class="hero" id="pocetna" style="background: linear-gradient(135deg, #3E2723 0%, #2c1b1b 100%);">
    <div class="container">
        <div class="hero-content">
            <h1 style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                <?php echo isset($translations['hero_title']) ? $translations['hero_title'] : 'Dobrodošli u Dva Brata'; ?>
            </h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 1.5rem; margin-bottom: 40px;">
                <?php echo isset($translations['hero_subtitle']) ? $translations['hero_subtitle'] : 'Restoran i prenoćište sa tradicijom'; ?>
            </p>
            <a href="?page=rezervacije" class="btn" style="display: inline-block; padding: 15px 40px; background: #800020; color: white; text-decoration: none; border-radius: 50px; font-weight: bold;">
                <?php echo isset($translations['hero_button']) ? $translations['hero_button'] : 'Rezervišite sada'; ?>
            </a>
            
            <!-- Meni dugme -->
            <div style="margin-top: 20px;">
                <a href="?page=meni" class="btn-secondary" style="display: inline-block; padding: 12px 30px; border: 2px solid #8B4513; color: #8B4513; text-decoration: none; border-radius: 50px; font-weight: bold;">
                    <i class="fas fa-utensils"></i> 
                    <?php echo isset($translations['menu_title']) ? $translations['menu_title'] : 'Naš Meni'; ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- O nama preview -->
<section id="onama-preview" style="background: #F5F5DC; padding: 100px 0;">
    <div class="container">
        <h2 class="section-title" style="color: #8B4513; text-align: center; font-size: 2.5rem; margin-bottom: 60px;">
            <?php echo isset($translations['about_title']) ? $translations['about_title'] : 'O nama'; ?>
        </h2>
        <div class="about-content" style="display: flex; align-items: center; gap: 50px;">
            <div class="about-text" style="flex: 1;">
                <p style="color: #3E2723; font-size: 1.1rem; line-height: 1.8; margin-bottom: 20px;">
                    <?php echo isset($translations['about_preview_text']) ? $translations['about_preview_text'] : 'Restoran i prenoćište "Dva Brata" osnovano je 2025. godine...'; ?>
                </p>
                <a href="?page=onama" class="btn-secondary" style="display: inline-block; padding: 12px 30px; border: 2px solid #8B4513; color: #8B4513; text-decoration: none; border-radius: 50px; font-weight: bold;">
                    <?php echo isset($translations['nav_about']) ? $translations['nav_about'] : 'Saznaj više'; ?> →
                </a>
            </div>
            <div class="about-image" style="flex: 1; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
                <div style="background: #D2B48C; height: 300px; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: #3E2723;">
                    <i class="fas fa-image" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Usluge -->
<section id="usluge" class="services" style="background: linear-gradient(135deg, #D2B48C 0%, #e9dcc9 100%); padding: 100px 0; position: relative;">
    <div class="container">
        <h2 class="section-title" style="color: #8B4513; text-align: center; font-size: 2.5rem; margin-bottom: 60px;">
            <?php echo isset($translations['services_title']) ? $translations['services_title'] : 'Naše usluge'; ?>
        </h2>
        <div class="services-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
            
            <!-- Restoran -->
            <div class="service-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="service-image" style="background: #D2B48C; height: 200px; display: flex; align-items: center; justify-content: center; color: #3E2723;">
                    <i class="fas fa-utensils" style="font-size: 3rem;"></i>
                </div>
                <div class="service-content" style="padding: 25px;">
                    <h3 style="color: #8B4513; margin-bottom: 15px; font-size: 1.4rem;">
                        <?php echo isset($translations['restaurant_service']) ? $translations['restaurant_service'] : 'Restoran'; ?>
                    </h3>
                    <p style="color: #3E2723; font-size: 1rem; line-height: 1.6;">
                        <?php echo isset($translations['restaurant_service_desc']) ? $translations['restaurant_service_desc'] : 'Naš restoran nudi bogat izbor tradicionalnih jela...'; ?>
                    </p>
                </div>
            </div>
            
            <!-- Prenoćište -->
            <div class="service-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="service-image" style="background: #D2B48C; height: 200px; display: flex; align-items: center; justify-content: center; color: #3E2723;">
                    <i class="fas fa-bed" style="font-size: 3rem;"></i>
                </div>
                <div class="service-content" style="padding: 25px;">
                    <h3 style="color: #8B4513; margin-bottom: 15px; font-size: 1.4rem;">
                        <?php echo isset($translations['accommodation_service']) ? $translations['accommodation_service'] : 'Prenoćište'; ?>
                    </h3>
                    <p style="color: #3E2723; font-size: 1rem; line-height: 1.6;">
                        <?php echo isset($translations['accommodation_service_desc']) ? $translations['accommodation_service_desc'] : 'Udobne sobe sa svim modernim sadržajima...'; ?>
                    </p>
                </div>
            </div>
            
            <!-- Organizacija događaja -->
            <div class="service-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="service-image" style="background: #D2B48C; height: 200px; display: flex; align-items: center; justify-content: center; color: #3E2723;">
                    <i class="fas fa-calendar-alt" style="font-size: 3rem;"></i>
                </div>
                <div class="service-content" style="padding: 25px;">
                    <h3 style="color: #8B4513; margin-bottom: 15px; font-size: 1.4rem;">
                        <?php echo isset($translations['events_service']) ? $translations['events_service'] : 'Organizacija događaja'; ?>
                    </h3>
                    <p style="color: #3E2723; font-size: 1rem; line-height: 1.6;">
                        <?php echo isset($translations['events_service_desc']) ? $translations['events_service_desc'] : 'Organizujemo različite događaje poput venčanja...'; ?>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Galerija preview -->
<section id="galerija-preview" style="background: #F5F5DC; padding: 100px 0;">
    <div class="container">
        <h2 class="section-title" style="color: #8B4513; text-align: center; font-size: 2.5rem; margin-bottom: 60px;">
            <?php echo isset($translations['gallery_title']) ? $translations['gallery_title'] : 'Galerija'; ?>
        </h2>
        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            
            <div class="gallery-item" style="background: #D2B48C; height: 200px; border-radius: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #3E2723;">
                <i class="fas fa-image" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <div class="gallery-caption-preview" style="font-weight: 500; font-size: 1rem;">
                    <?php echo isset($translations['gallery_interior']) ? $translations['gallery_interior'] : 'Enterijer'; ?>
                </div>
            </div>
            
            <div class="gallery-item" style="background: #D2B48C; height: 200px; border-radius: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #3E2723;">
                <i class="fas fa-hamburger" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <div class="gallery-caption-preview" style="font-weight: 500; font-size: 1rem;">
                    <?php echo isset($translations['gallery_food']) ? $translations['gallery_food'] : 'Hrana'; ?>
                </div>
            </div>
            
            <div class="gallery-item" style="background: #D2B48C; height: 200px; border-radius: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #3E2723;">
                <i class="fas fa-star" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <div class="gallery-caption-preview" style="font-weight: 500; font-size: 1rem;">
                    <?php echo isset($translations['gallery_specialties']) ? $translations['gallery_specialties'] : 'Specijaliteti'; ?>
                </div>
            </div>
            
            <div class="gallery-item" style="background: #D2B48C; height: 200px; border-radius: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #3E2723;">
                <i class="fas fa-home" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <div class="gallery-caption-preview" style="font-weight: 500; font-size: 1rem;">
                    <?php echo isset($translations['gallery_accommodation']) ? $translations['gallery_accommodation'] : 'Prenoćište'; ?>
                </div>
            </div>
            
        </div>
        <div class="text-center" style="text-align: center; margin-top: 40px;">
            <a href="?page=galerija" class="btn-secondary" style="display: inline-block; padding: 12px 30px; border: 2px solid #8B4513; color: #8B4513; text-decoration: none; border-radius: 50px; font-weight: bold;">
                <?php echo isset($translations['gallery_title']) ? $translations['gallery_title'] : 'Galerija'; ?> →
            </a>
        </div>
    </div>
</section>

<!-- CTA sekcija -->
<section class="cta-section" style="background: linear-gradient(135deg, #3E2723 0%, #2c1b1b 100%); color: white; padding: 80px 0; text-align: center;">
    <div class="container">
        <div class="cta-content">
            <h2 style="font-size: 2.5rem; margin-bottom: 20px; color: white;">
                <?php echo isset($translations['cta_title']) ? $translations['cta_title'] : 'Spremni za rezervaciju?'; ?>
            </h2>
            <p style="font-size: 1.2rem; margin-bottom: 30px; color: rgba(255,255,255,0.9);">
                <?php echo isset($translations['cta_text']) ? $translations['cta_text'] : 'Rezervišite svoj sto ili sobu danas...'; ?>
            </p>
            <a href="?page=rezervacije" class="btn btn-large" style="display: inline-block; padding: 18px 50px; background: #800020; color: white; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 1.2rem;">
                <?php echo isset($translations['hero_button']) ? $translations['hero_button'] : 'Rezervišite sada'; ?>
            </a>
        </div>
    </div>
</section>

<style>
/* Backup CSS u slučaju da se glavni CSS ne učita */
.about-text p,
.service-content p,
.gallery-caption-preview,
.cta-content h2,
.cta-content p,
.section-title {
    color: #000000 !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
}

/* Obavezno prikaži sve */
section {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}
</style>