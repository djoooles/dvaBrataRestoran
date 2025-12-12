<div class="container" style="padding-top: 100px;">
    <h1 class="section-title">Galerija</h1>
    
    <!-- Filter za kategorije -->
    <div class="gallery-filters">
        <button class="gallery-filter-btn active" data-filter="all">📷 Sve</button>
        <button class="gallery-filter-btn" data-filter="restoran">🍽️ Restoran</button>
        <button class="gallery-filter-btn" data-filter="hrana">🍖 Hrana</button>
        <button class="gallery-filter-btn" data-filter="prenociste">🏨 Prenoćište</button>
        <button class="gallery-filter-btn" data-filter="dogadjaji">🎉 Događaji</button>
    </div>
    
    <!-- Galerija grid -->
    <div class="gallery-grid-full">
        <!-- Restoran slike -->
        <div class="gallery-item" data-category="restoran">
            <img src="assets/pictures/place1.jpg" alt="Enterijer restorana">
            <div class="gallery-caption">Enterijer restorana</div>
        </div>
        
        <div class="gallery-item" data-category="restoran">
            <img src="assets/pictures/place2.jpg" alt="Spoljašnjost">
            <div class="gallery-caption">Spoljašnjost restorana</div>
        </div>
        
        <!-- Hrana slike -->
        <div class="gallery-item" data-category="hrana">
            <img src="assets/pictures/food.jpg" alt="Tradicionalna hrana">
            <div class="gallery-caption">Tradicionalna jela</div>
        </div>
        
        <div class="gallery-item" data-category="hrana">
            <img src="assets/pictures/food1.jpg" alt="Specijaliteti">
            <div class="gallery-caption">Specijaliteti kuće</div>
        </div>
        
        <div class="gallery-item" data-category="hrana">
            <img src="assets/pictures/food3.jpg" alt="Domaća kuhinja">
            <div class="gallery-caption">Domaća kuhinja</div>
        </div>
        
        <div class="gallery-item" data-category="hrana">
            <img src="assets/pictures/hrana.jpg" alt="Jela sa roštilja">
            <div class="gallery-caption">Roštilj specijaliteti</div>
        </div>
        
        <!-- Prenoćište slike -->
        <div class="gallery-item" data-category="prenociste">
            <img src="assets/pictures/place2.jpg" alt="Soba za prenoćište">
            <div class="gallery-caption">Udobna soba</div>
        </div>
        
        <div class="gallery-item" data-category="prenociste">
            <img src="assets/pictures/place1.jpg" alt="Kupatilo">
            <div class="gallery-caption">Moderno kupatilo</div>
        </div>
        
        <!-- Događaji slike -->
        <div class="gallery-item" data-category="dogadjaji">
            <img src="assets/pictures/meni.jpg" alt="Venčanje">
            <div class="gallery-caption">Organizacija venčanja</div>
        </div>
        
        <div class="gallery-item" data-category="dogadjaji">
            <img src="assets/pictures/hrana2.jpg" alt="Rođendan">
            <div class="gallery-caption">Rođendanske proslave</div>
        </div>
        
        <!-- Dodatne slike -->
        <div class="gallery-item" data-category="restoran">
            <img src="assets/pictures/place1.jpg" alt="Bar sekcija">
            <div class="gallery-caption">Bar sa širokim izborom</div>
        </div>
        
        <div class="gallery-item" data-category="hrana">
            <img src="assets/pictures/meni.jpg" alt="Doručak">
            <div class="gallery-caption">Doručak za goste</div>
        </div>
    </div>
    
    <!-- Lightbox overlay -->
    <div id="galleryLightbox" class="lightbox">
        <span class="lightbox-close">&times;</span>
        <div class="lightbox-content">
            <img id="lightboxImage" src="" alt="">
            <div id="lightboxCaption"></div>
        </div>
        <a class="lightbox-prev">&#10094;</a>
        <a class="lightbox-next">&#10095;</a>
    </div>
</div>

<style>
/* Galerija stilovi */
.gallery-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 30px 0;
    justify-content: center;
    padding: 20px;
    background: #f9f5f0;
    border-radius: 15px;
}

.gallery-filter-btn {
    background: white;
    border: 2px solid var(--secondary);
    color: var(--dark);
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.gallery-filter-btn:hover,
.gallery-filter-btn.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.gallery-grid-full {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.gallery-item {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 250px;
    cursor: pointer;
}

.gallery-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 15px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-caption {
    transform: translateY(0);
}

/* Lightbox stilovi */
.lightbox {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.9);
    justify-content: center;
    align-items: center;
}

.lightbox-content {
    max-width: 90%;
    max-height: 90%;
    position: relative;
}

.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 10px;
}

#lightboxCaption {
    color: white;
    text-align: center;
    padding: 15px;
    font-size: 1.1rem;
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 2001;
}

.lightbox-prev,
.lightbox-next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -50px;
    color: white;
    font-weight: bold;
    font-size: 30px;
    transition: 0.3s;
    user-select: none;
}

.lightbox-prev {
    left: 20px;
    border-radius: 0 3px 3px 0;
}

.lightbox-next {
    right: 20px;
    border-radius: 3px 0 0 3px;
}

.lightbox-prev:hover,
.lightbox-next:hover {
    background-color: rgba(255,255,255,0.1);
}

/* Responsive galerija */
@media (max-width: 768px) {
    .gallery-grid-full {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .gallery-item {
        height: 200px;
    }
    
    .gallery-filters {
        padding: 15px;
        gap: 8px;
    }
    
    .gallery-filter-btn {
        padding: 8px 15px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .gallery-grid-full {
        grid-template-columns: 1fr;
    }
    
    .gallery-filters {
        flex-direction: column;
    }
    
    .gallery-filter-btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
// Galerija filter
document.addEventListener('DOMContentLoaded', function() {
    // Filter funkcionalnost
    const filterButtons = document.querySelectorAll('.gallery-filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            galleryItems.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // Lightbox funkcionalnost
    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImg = document.getElementById('lightboxImage');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-prev');
    const nextBtn = document.querySelector('.lightbox-next');
    
    let currentIndex = 0;
    const allImages = Array.from(galleryItems);
    
    galleryItems.forEach((item, index) => {
        item.addEventListener('click', function() {
            currentIndex = index;
            openLightbox(this);
        });
    });
    
    function openLightbox(item) {
        const imgSrc = item.querySelector('img').src;
        const caption = item.querySelector('.gallery-caption').textContent;
        
        lightboxImg.src = imgSrc;
        lightboxCaption.textContent = caption;
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) closeLightbox();
    });
    
    function closeLightbox() {
        lightbox.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    function changeImage(direction) {
        currentIndex += direction;
        
        if (currentIndex < 0) currentIndex = allImages.length - 1;
        if (currentIndex >= allImages.length) currentIndex = 0;
        
        const newItem = allImages[currentIndex];
        const imgSrc = newItem.querySelector('img').src;
        const caption = newItem.querySelector('.gallery-caption').textContent;
        
        lightboxImg.src = imgSrc;
        lightboxCaption.textContent = caption;
    }
    
    prevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        changeImage(-1);
    });
    
    nextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        changeImage(1);
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (lightbox.style.display === 'flex') {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') changeImage(-1);
            if (e.key === 'ArrowRight') changeImage(1);
        }
    });
});
</script>
