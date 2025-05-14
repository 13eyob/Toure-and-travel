document.querySelector('#menu-btn').addEventListener('click', () => {
    document.querySelector('.navbar').classList.toggle('active');
});

document.querySelector('#menu-btn').addEventListener('click', () => {
    document.querySelector('.navbar').classList.toggle('active');
    document.querySelector('#menu-btn').classList.toggle('fa-times');
});

window.onscroll = () => {
    const navbar = document.querySelector('.navbar');
    const menuBtn = document.querySelector('#menu-btn');
    
    if (navbar.classList.contains('active')) {
        navbar.classList.remove('active');
        menuBtn.classList.remove('fa-times');
    }
};

// Initialize Swiper
const homeSwiper = new Swiper('.home-slider', {
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});

document.addEventListener('DOMContentLoaded', function() {
    // Package load more functionality
    const loadMoreBtn = document.querySelector('.package .load-more .btn');
    const packages = document.querySelectorAll('.package .box');
    let visibleCount = 6; // Number of packages to show initially
    const increment = 6; // Number of packages to add each click
    
    // Function to show packages
    function showPackages() {
        packages.forEach((pkg, index) => {
            if (index < visibleCount) {
                pkg.classList.add('visible');
            } else {
                pkg.classList.remove('visible');
            }
        });
        
        // Hide load more button if all packages are visible
        if (visibleCount >= packages.length) {
            loadMoreBtn.parentElement.style.display = 'none';
        }
    }
    
    // Initial show
    showPackages();
    
    // Load more click handler
    loadMoreBtn.addEventListener('click', function() {
        visibleCount += increment;
        showPackages();
        
        // Smooth scroll to newly loaded items
        const lastVisible = document.querySelectorAll('.package .box.visible');
        lastVisible[lastVisible.length-1].scrollIntoView({behavior: 'smooth', block: 'nearest'});
    });
});
