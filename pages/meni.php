cd C:\xampp\htdocs\restoran-dva-brata\pages

@'
<div class="container" style="padding-top: 100px;">
    <h1 class="section-title">Naš Jelovnik</h1>
    
    <!-- Download meni opcija -->
    <div class="menu-download" style="text-align: center; margin-bottom: 40px; background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="color: var(--primary); margin-bottom: 15px;">📥 Preuzmite kompletan meni</h3>
        <a href="#" class="btn" style="display: inline-block; margin: 10px;">
            <i class="fas fa-file-pdf"></i> PDF Meni
        </a>
        <a href="#" class="btn-secondary" style="display: inline-block; margin: 10px;">
            <i class="fas fa-print"></i> Štampaj meni
        </a>
    </div>
    
    <!-- FILTER PO KATEGORIJAMA -->
    <div class="menu-filters">
        <button class="filter-btn active" data-filter="all">🍽️ Sve</button>
        <button class="filter-btn" data-filter="predjela">🥗 Predjela</button>
        <button class="filter-btn" data-filter="glavna">🍖 Glavna jela</button>
        <button class="filter-btn" data-filter="pica">🍕 Pica</button>
        <button class="filter-btn" data-filter="deserti">🍰 Deserti</button>
        <button class="filter-btn" data-filter="pice">🍷 Pića</button>
    </div>
    
    <!-- Kategorije menija -->
    <div class="menu-categories">
        <!-- Predjela -->
        <div class="menu-category" data-category="predjela">
            <h2 class="category-title">🍽️ Predjela</h2>
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Domaća supa</h3>
                        <span class="item-price">250 RSD</span>
                    </div>
                    <p class="item-description">Tradicionalna supa od povrća sa domaćim rezancima</p>
                </div>
                
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Kajmak sa čvarcima</h3>
                        <span class="item-price">380 RSD</span>
                    </div>
                    <p class="item-description">Domaći kajmak sa hrskavim čvarcima i lepinjom</p>
                </div>
                
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Šopska salata</h3>
                        <span class="item-price">320 RSD</span>
                    </div>
                    <p class="item-description">Sveže povrće sa sirevima i domaćim prelivom</p>
                </div>
            </div>
        </div>
        
        <!-- Glavna jela -->
        <div class="menu-category" data-category="glavna">
            <h2 class="category-title">🍖 Glavna jela</h2>
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Karađorđeva šnicla</h3>
                        <span class="item-price">890 RSD</span>
                    </div>
                    <p class="item-description">Punjenje od kajmaka i šunke, pržena u prezli</p>
                    <span class="item-badge">Specijalitet kuće</span>
                </div>
                
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Roštilj mix</h3>
                        <span class="item-price">1.250 RSD</span>
                    </div>
                    <p class="item-description">Ćevapi, pljeskavica, ražnjići, kobasice, pečenje</p>
                    <span class="item-badge">Za 2 osobe</span>
                </div>
                
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Domaći musaka</h3>
                        <span class="item-price">650 RSD</span>
                    </div>
                    <p class="item-description">Slojevi krompira i mlevene junetine sa pavlakom</p>
                </div>
            </div>
        </div>
        
        <!-- Pica -->
        <div class="menu-category" data-category="pica">
            <h2 class="category-title">🍕 Pica</h2>
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Kapričoza</h3>
                        <span class="item-price">720 RSD</span>
                    </div>
                    <p class="item-description">Šunka, pečurke, masline, origano</p>
                </div>
                
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Dva Brata specijal</h3>
                        <span class="item-price">850 RSD</span>
                    </div>
                    <p class="item-description">Kulen, kajmak, pečurke, pavlaka, luk</p>
                    <span class="item-badge">Kućni specijalitet</span>
                </div>
            </div>
        </div>
        
        <!-- Deserti -->
        <div class="menu-category" data-category="deserti">
            <h2 class="category-title">🍰 Deserti</h2>
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Palačinke sa džemom</h3>
                        <span class="item-price">280 RSD</span>
                    </div>
                    <p class="item-description">Domaće palačinke sa izborom džemova</p>
                </div>
                
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Štrudla sa višnjama</h3>
                        <span class="item-price">320 RSD</span>
                    </div>
                    <p class="item-description">Sveža štrudla sa višnjama i vanil šlagom</p>
                </div>
            </div>
        </div>
        
        <!-- Pića -->
        <div class="menu-category" data-category="pice">
            <h2 class="category-title">🍷 Pića</h2>
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Domaca rakija</h3>
                        <span class="item-price">200 RSD</span>
                    </div>
                    <p class="item-description">Šljivovica, dunjevaca, kajsijevača</p>
                </div>
                
                <div class="menu-item">
                    <div class="item-header">
                        <h3>Vina (0.75l)</h3>
                        <span class="item-price">1.200-2.500 RSD</span>
                    </div>
                    <p class="item-description">Crvena, bela, rose - domaća i uvozna</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alergeni info -->
    <div class="allergen-info" style="margin-top: 50px; padding: 20px; background: #f8f8f8; border-radius: 10px;">
        <h4 style="color: var(--primary); margin-bottom: 10px;">⚕️ Informacije o alergenima</h4>
        <p>Molimo vas da obavestite konobara ukoliko imate alergije na: mleko, jaja, orašaste plodove, gluten, soju, ribu, školjke.</p>
    </div>
</div>

<style>
/* Stilovi za meni stranicu */
.menu-categories {
    margin-top: 40px;
}

.menu-category {
    margin-bottom: 50px;
}

.category-title {
    color: var(--primary);
    font-size: 1.8rem;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--secondary);
}

.menu-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
}

.menu-item {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid var(--primary);
}

.menu-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.item-header h3 {
    color: var(--dark);
    font-size: 1.2rem;
    margin: 0;
}

.item-price {
    color: var(--accent);
    font-weight: bold;
    font-size: 1.1rem;
    background: #f8f0e8;
    padding: 5px 15px;
    border-radius: 20px;
}

.item-description {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 10px;
}

.item-badge {
    display: inline-block;
    background: var(--secondary);
    color: var(--dark);
    font-size: 0.8rem;
    padding: 3px 10px;
    border-radius: 12px;
    font-weight: 500;
    margin-top: 5px;
}

/* Stilovi za filter */
.menu-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 40px;
    justify-content: center;
    padding: 15px;
    background: #f9f5f0;
    border-radius: 15px;
}

.filter-btn {
    background: white;
    border: 2px solid var(--secondary);
    color: var(--dark);
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: var(--secondary);
    transform: translateY(-2px);
}

.filter-btn.active {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: white;
    border-color: var(--primary);
}

/* Responsive za meni */
@media (max-width: 768px) {
    .menu-items {
        grid-template-columns: 1fr;
    }
    
    .item-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .item-price {
        align-self: flex-start;
    }
    
    .menu-filters {
        gap: 8px;
    }
    
    .filter-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .menu-filters {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-btn {
        justify-content: center;
        padding: 10px;
    }
}
</style>

<!-- JavaScript za filter -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const menuCategories = document.querySelectorAll('.menu-category');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Ukloni active klasu sa svih dugmadi
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Dodaj active na kliknuto dugme
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // Prikaži/sakrij kategorije
            menuCategories.forEach(category => {
                if (filterValue === 'all') {
                    category.style.display = 'block';
                } else {
                    if (category.getAttribute('data-category') === filterValue) {
                        category.style.display = 'block';
                    } else {
                        category.style.display = 'none';
                    }
                }
            });
        });
    });
});
</script>
