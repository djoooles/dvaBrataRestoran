// Mobilni meni
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector(".menu-toggle");
    const navLinks = document.querySelector(".nav-links");
    
    if (menuToggle) {
        menuToggle.addEventListener("click", function() {
            navLinks.classList.toggle("active");
            this.setAttribute("aria-expanded", 
                this.getAttribute("aria-expanded") === "true" ? "false" : "true");
        });
    }
    
    // Zatvori meni kada se klikne na link
    document.querySelectorAll(".nav-links a").forEach(link => {
        link.addEventListener("click", () => {
            navLinks.classList.remove("active");
            document.querySelector(".menu-toggle").setAttribute("aria-expanded", "false");
        });
    });
    
    // Scroll efekat za header
    window.addEventListener("scroll", function() {
        const header = document.querySelector("header");
        if (window.scrollY > 100) {
            header.classList.add("scrolled");
        } else {
            header.classList.remove("scrolled");
        }
    });
    
    // Animacije pri skrolovanju
    const fadeElements = document.querySelectorAll(".fade-in");
    
    const fadeInOnScroll = () => {
        fadeElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add("visible");
            }
        });
    };
    
    window.addEventListener("scroll", fadeInOnScroll);
    window.addEventListener("load", fadeInOnScroll);
});