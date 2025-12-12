<div class="container" style="min-height: 60vh; padding-top: 100px;">
    <h1 class="section-title"><?php echo __('contact_title'); ?></h1>
    
    <div class="contact-info">
        <div class="contact-details">
            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <div class="contact-text">
                    <h3><?php echo __('address'); ?></h3>
                    <p>Niš, Avrama Levca 31</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">📞</div>
                <div class="contact-text">
                    <h3><?php echo __('phone'); ?></h3>
                    <p>0631020209</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">🕒</div>
                <div class="contact-text">
                    <h3><?php echo __('working_hours'); ?></h3>
                    <p><strong><?php echo $current_language == 'sr' ? 'Restoran:' : 'Restaurant:'; ?></strong> 08:00 - 23:00</p>
                    <p><strong><?php echo $current_language == 'sr' ? 'Recepcija:' : 'Reception:'; ?></strong> 00-24h</p>
                </div>
            </div>
            
            <a href="tel:0631020209" class="btn"><?php echo __('contact_call_us'); ?></a>
        </div>
        
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2759.4722699235917!2d22.0456102!3d43.3118304!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4755af0054156a93%3A0xaf032baab10a2432!2sRestoran%20DVA%20BRATA!5e1!3m2!1ssr!2srs!4v1764260670805!5m2!1ssr!2srs" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>