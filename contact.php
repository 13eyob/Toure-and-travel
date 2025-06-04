<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection
    $host = "localhost";
    $user = "root";
    $pass = ""; // your DB password
    $dbname = "travel";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        $_SESSION['error'] = "Database connection failed!";
        header("Location: contact.php");
        exit();
    }

    // Get and sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: contact.php");
        exit();
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Your message has been sent successfully!";
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to form
    header("Location: contact.php");
    exit();
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Travel Ethiopia</title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Custom CSS -->
      <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/contact.css">
</head>
<body>
<body>

  <!-- Header -->
  <header class="header">
       <a href="home.php" class="logo">Travel</a>
       <nav class="navbar">
           <a href="home.php">Home</a>
           <a href="about.php" class="active">About</a>
           <a href="contact.php">Contact</a>
          <a href="gallery.php">Gallery</a>
          <a href="login_register.php" class="login-btn">Login</a>
           
       </nav>
       <div id="menu-btn" class="fas fa-bars"></div>
   </header>

   <div class="heading" style="background:url(images/bg9.jpg)">
       <h1>Contact Us</h1>
   </div>

  <!-- Contact Form -->
  <main>
    <div class="contact-form">
      <h2>Contact Us</h2>

      <?php if (isset($_SESSION['message'])): ?>
        <p class="success-message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
      <?php endif; ?>

  <form action="contact.php" method="POST">
        <input type="text" name="name" placeholder="Your Full Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </main>

  <!-- Footer Section starts -->
<section class="footer">
    <div class="box-container">

        <div class="box">
            <h3>Quick Links</h3>
            <a href="home.php"><i class="fas fa-angle-right"></i> Home</a>
            <a href="about.php"><i class="fas fa-angle-right"></i> About</a>
            <a href="contact.php"><i class="fas fa-angle-right"></i>ContactC</a>
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
            <a href="https://t.me/eyu13_a" target="_blank"><i class="fab fa-telegram"></i> Telegram</a>
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
