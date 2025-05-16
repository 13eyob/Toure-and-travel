<?php
session_start();

$host = 'localhost';
$dbname = 'travel';  // Using your existing database name
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['search'])) {
    $search_value = $_GET['my_search'];
    $sql = "SELECT * FROM packages WHERE CONCAT(title, description, location) LIKE '%$search_value%'";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM packages";
    $result = mysqli_query($conn, $sql);  
}
?>

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
    <link rel="stylesheet" href="eyob.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Header Section -->
<section class="header">
    <a href="home.php" class="logo">Travel</a>
    <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
         <a href="contact.php">Contact</a>
        <a href="logout.php" class="login-btn">Logout</a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>
 
 <div class="hero">
 <img class="cover" src="images/landmark.jpg " alt="Ethiopian Highlands Landscape">
    <div class="hero-content">
        <h1>Discover the Wonders of Ethiopia</h1>
        <p>Explore ancient history, breathtaking landscapes, and vibrant cultures</p>
    </div>
 </div>
 
 <div class="search-container">
    <form action="" method="GET" class="search-form">
        <input type="text" name="my_search" placeholder="Search tour packages..." class="search-input" value="<?php echo isset($_GET['my_search']) ? htmlspecialchars($_GET['my_search']) : '' ?>">
        <button type="submit" name="search" class="search-button">
            <i class="fas fa-search"></i> Search
        </button>
    </form>
</div>

<h2 class="section-title">Featured Tour Packages</h2>
 <div class="card-container">
    <div class="card-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="tour-card">
            <img class="tour-image" src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
            <div class="tour-details">
                <h3 class="tour-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                <p class="tour-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?></p>
                <p class="tour-description"><?php echo substr(htmlspecialchars($row['description']), 0, 100); ?>...</p>
                <div class="tour-meta">
                    <span class="tour-duration"><i class="fas fa-calendar-alt"></i> <?php echo htmlspecialchars($row['duration']); ?> days</span>
                    <span class="tour-price">
                        <?php if($row['discount_price'] > 0): ?>
                            <span class="original-price">ETB<?php echo number_format($row['price'], 2); ?></span>
                            <span class="discounted-price">ETB<?php echo number_format($row['discount_price'], 2); ?></span>
                        <?php else: ?>
                            ETB<?php echo number_format($row['price'], 2); ?>
                        <?php endif; ?>
                    </span>
                </div>
                <?php if(isset($_SESSION['email']) && !empty($_SESSION['email'])): ?>
                    <a href="book_tour.php?id=<?php echo $row['id']?>&email=<?php echo $_SESSION['email'] ?>" class="book-button">Book Now</a>
                <?php else: ?>
                    <a href="book.php" class="book-button">Book Now</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
 </div>
 
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