<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/stylee.css">
</head>
<body>

<!-- Header Section -->
<section class="header">
    <a href="home.php" class="logo">Travel</a>
    <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
         <a href="contact.php">Contact</a>
        <a href="login_register.php" class="login-btn">Login</a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>

<!-- Home Section -->
<section class="home">
    <div class="home-slider swiper">
        <div class="swiper-wrapper">

            <div class="swiper-slide slide" style="background:url(images/bg1.jpg) no-repeat">
                <div class="content">
                    <span>Explore, Discover, Ethiopia</span>
                    <h3>Travel around Ethiopia</h3>
                    <a href="login_register.php" class="btn">Discover More</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background:url(images/bg3.jpg) no-repeat">
                <div class="content">
                    <span>Explore, Discover, Ethiopia</span>
                    <h3>Make your tour worthwhile</h3>
                    <a href="package.php" class="btn">Discover More</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background:url(images/landmark.jpg) no-repeat">
                <div class="content">
                    <span>Explore, Discover, Ethiopia</span>
                    <h3>Unforgettable Moments Await</h3>
                    <a href="package.php" class="btn">Discover More</a>
                </div>
            </div>

        </div>
        <!-- Swiper Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Services Section -->
<section class="service">
    <h1 class="heading-title">Our Services</h1>
    <div class="box-container">

        <div class="box">
            <img src="images/coffe.png" alt="">
            <h3>Buna (Coffee) Ceremony</h3>
        </div>

        <div class="box">
            <img src="images/injeraaa.jpg" alt="">
            <h3>Cultural food</h3>
        </div>

        <div class="box">
            <img src="images/fire.png" alt="">
            <h3>Camp Fire</h3>
        </div>

        <div class="box">
            <img src="images/church.png" alt="">
            <h3>Religious Festivals</h3>
        </div>

    </div>
</section>

<!-- Home About Section -->
<section class="home-about">
    <div class="image">
        <img src="images/about.jpg" alt="About Us">
    </div>
    <div class="content">
        <h3>About us</h3>
       <p>Ethiopia, the cradle of humankind and land of origins, welcomes you to discover its ancient wonders and breathtaking landscapes. From the rock-hewn churches of Lalibela to the towering peaks of the Simien Mountains, our country offers unparalleled cultural heritage and natural beauty. </p>
        <a href="about.php" class="btn">Read More</a>
    </div>
</section>

<!-- Home Packages Section -->
<section class="home-package">
    <h1 class="heading-title">Our Packages</h1>
    <div class="box-container">

        <div class="box">
            <div class="image"><img src="images/lalibela.jpg" alt="Lalibela Rock Churches"></div>
            <div class="content">
                <h3>Lalibela Rock Churches</h3>
                <div class="location"><i class="fas fa-map-marker-alt"></i> Amhara Region, Ethiopia</div>
                <p>Explore the 11 medieval monolithic cave churches carved entirely from rock.</p>
                <div class="price">From $299 <span>$399</span></div>
                <a href="login_register.php" class="btn">login</a>
            </div>
        </div>

        <div class="box">
            <div class="image"><img src="images/fasiledes.jpg" alt="Fasil Ghebbi"></div>
            <div class="content">
                <h3>Fasil Ghebbi Castle</h3>
                <div class="location"><i class="fas fa-map-marker-alt"></i> Gondar, Ethiopia</div>
                <p>Visit the 17th-century fortress city of Gondar with its impressive castles and history.</p>
                <div class="price">From $249 <span>$329</span></div>
                <a href="login_register.php" class="btn">login</a>
            </div>
        </div>

        <div class="box">
            <div class="image"><img src="images/aksum.jpg" alt="Aksum Obelisks"></div>
            <div class="content">
                <h3>Aksum Historical Tour</h3>
                <div class="location"><i class="fas fa-map-marker-alt"></i> Tigray Region, Ethiopia</div>
                <p>Discover the ancient kingdom of Aksum with its obelisks and legends.</p>
                <div class="price">From $349 <span>$449</span></div>
                <a href="login_register.php" class="btn">Login </a>
            </div>
        </div>

        <div class="box">
            <div class="image"><img src="images/semion.jpg" alt="Simien Mountains"></div>
            <div class="content">
                <h3>Simien Mountains Trek</h3>
                <div class="location"><i class="fas fa-map-marker-alt"></i> Simien National Park</div>
                <p>3-day trekking adventure to see geladas, walia ibex, and stunning cliffs.</p>
                <div class="price">From $499 <span>$599</span></div>
                <a href="login_register.php" class="btn">Login </a>
            </div>
        </div>

        <div class="box">
            <div class="image"><img src="images/sof omer.jpg" alt="Sof Omar Caves"></div>
            <div class="content">
                <h3>Sof Omar Cave Exploration</h3>
                <div class="location"><i class="fas fa-map-marker-alt"></i> Bale Zone, Ethiopia</div>
                <p>Explore Africa’s largest cave system with a guide and headlamp.</p>
                <div class="price">From $199 <span>$279</span></div>
                <a href="login_register.php" class="btn">Login </a>
            </div>
        </div>

        <div class="box">
            <div class="image"><img src="images/blue nile.jpg" alt="Blue Nile Falls"></div>
            <div class="content">
                <h3>Blue Nile Falls Adventure</h3>
                <div class="location"><i class="fas fa-map-marker-alt"></i> Near Bahir Dar</div>
                <p>Day trip to "Smoking Water" falls and a boat ride to Lake Tana monasteries.</p>
                <div class="price">From $179 <span>$249</span></div>
                <a href="login_register.php" class="btn">Login</a>
            </div>
        </div>

    </div>
</section>

<!-- Footer Section starts -->
<section class="footer">
    <div class="box-container">

        <div class="box">
            <h3>Quick Links</h3>
            <a href="home.php"><i class="fas fa-angle-right"></i> Home</a>
            <a href="about.php"><i class="fas fa-angle-right"></i> About</a>
            <a href="contact.php"><i class="fas fa-angle-right"></i>Contact</a>
            <a href="Gallery.php"><i class="fas fa-angle-right"></i>Gallery</a>
        </div>

        <div class="box">
            <h3>Extra Links</h3>
            <a href="#"><i class="fas fa-angle-right"></i> Ask Questions</a>
            <a href="#"><i class="fas fa-angle-right"></i> About Us</a>
            <a href="#"><i class="fas fa-angle-right"></i> Privacy Policy</a>
            <a href="#"><i class="fas fa-angle-right"></i> Terms of Use</a>
        </div>

        <div class="box">
            <h3>Contact Info</h3>
            <a href="#"><i class="fas fa-phone"></i> +251-900-927-373</a>
            <a href="#"><i class="fas fa-envelope"></i> aeyob3093@gmail.com</a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Addis Ababa, Ethiopia</a>
        </div>

        <div class="box">
            <h3>Follow Us</h3>
            <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="#"><i class="fab fa-telegram"></i> Telegram</a>
        </div>

    </div>
    <div class="credit">Created by <span>Mr. Eyob</span> | All rights reserved!</div>
</section>

<!-- Footer Section ends -->

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<!-- Custom JS -->
<script src="js/script.js"></script>


</body>
</html>
