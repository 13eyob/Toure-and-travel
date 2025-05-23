 let menu = document.querySelector('#menu-btn');
 let navbar = document.querySelector('header .navbar');

 menu.onclick = () =>{
     menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
 };



document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper('.home-slider', {
        loop: true,
        grabCursor: true,
        effect: 'fade',
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});