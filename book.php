<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Trip</title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/book.css">
</head>
<body>
   <!-- Header Section -->
   <section class="header">
       <a href="home.php" class="logo">Travel</a>
       <nav class="navbar">
           <a href="home.php">Home</a>
           <a href="about.php">About</a>
           <a href="contact.php">Contact</a>
            <a href="logout.php">Logout</a>
         
       </nav>
       <div id="menu-btn" class="fas fa-bars"></div>
   </section>
   <!-- Header Section End -->
   
   <div class="heading" style="background: url('images/bg5.jpg') no-repeat center center; background-size: cover;">
       <h1>Book Now</h1>
   </div>
   
   <!-- Error/Success Messages -->
   <?php if(!empty($errors)): ?>
       <div class="error-message">
           <h3>Please fix the following errors:</h3>
           <ul>
               <?php foreach($errors as $error): ?>
                   <li><?php echo htmlspecialchars($error); ?></li>
               <?php endforeach; ?>
           </ul>
       </div>
   <?php endif; ?>
   
   <?php if(isset($_GET['success'])): ?>
       <div class="success-message">
        <h2>Submit successfuly</h2>
    
       </div>
   <?php endif; ?>
   
   <!-- Booking Form -->
   <section class="booking">
       <h1 class="heading-title">book your trip!</h1>
       <form action="book_form.php" method="post" class="book-form">
           <div class="flex">
               <div class="inputBox">
                   <span>name :</span>
                   <input type="text" placeholder="enter your name" name="name" value="<?php echo isset($form_data['name']) ? htmlspecialchars($form_data['name']) : ''; ?>" required>
               </div>
               <div class="inputBox">
                   <span>email :</span>
                   <input type="email" placeholder="enter your email" name="email" value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>" required>
               </div>
               <div class="inputBox">
                   <span>phone :</span>
                   <input type="text" placeholder="enter your phone" name="phone" value="<?php echo isset($form_data['phone']) ? htmlspecialchars($form_data['phone']) : ''; ?>">
               </div>
               <div class="inputBox">
                   <span>address :</span>
                   <input type="text" placeholder="enter your address" name="address" value="<?php echo isset($form_data['address']) ? htmlspecialchars($form_data['address']) : ''; ?>" required>
               </div>
               <div class="inputBox">
                   <span>where to:</span>
                   <input type="text" placeholder="place you want to visit" name="location" value="<?php echo isset($form_data['location']) ? htmlspecialchars($form_data['location']) : ''; ?>" required>
               </div>
               <div class="inputBox">
                   <span>how many :</span>
                   <input type="number" placeholder="number of guests" name="guests" min="1" value="<?php echo isset($form_data['guests']) ? htmlspecialchars($form_data['guests']) : ''; ?>" required>
               </div>
               <div class="inputBox">
                   <span>arrivals :</span>
                   <input type="date" name="arrivals" value="<?php echo isset($form_data['arrivals']) ? htmlspecialchars($form_data['arrivals']) : ''; ?>" required>
               </div>
               <div class="inputBox">
                   <span>leaving :</span>
                   <input type="date" name="leaving" value="<?php echo isset($form_data['leaving']) ? htmlspecialchars($form_data['leaving']) : ''; ?>" required>
               </div>
           </div>
           <input type="submit" value="submit" class="btn" name="send">
       </form>
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
