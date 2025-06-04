<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$connection = mysqli_connect('localhost', 'root', '', 'travel');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['send'])) {
    // Sanitize input data
    $name = mysqli_real_escape_string($connection, trim($_POST['name']));
    $email = mysqli_real_escape_string($connection, trim($_POST['email']));
    $phone = mysqli_real_escape_string($connection, trim($_POST['phone']));
    $address = mysqli_real_escape_string($connection, trim($_POST['address']));
    $location = mysqli_real_escape_string($connection, trim($_POST['location']));
    $guests = (int)$_POST['guests'];
    $arrivals = $_POST['arrivals'];
    $leaving = $_POST['leaving'];
   
    // Validate fields
    $errors = [];
    
    // Name validation (only letters and spaces)
    if(empty($name)) {
        $errors[] = "Name is required";
    } elseif(!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors[] = "Name should contain only letters and spaces";
    }
    
    // Email validation
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    // Phone validation (exactly 10 digits)
    if(empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif(!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be 10 digits and contain only numbers";
    }
    
    // Address validation
    if(empty($address)) {
        $errors[] = "Address is required";
    }
    
    // Location validation
    if(empty($location)) {
        $errors[] = "Destination is required";
    }
    
    // Guests validation (number >= 1)
    if(empty($guests)) {
        $errors[] = "Number of guests is required";
    } elseif($guests < 1) {
        $errors[] = "Number of guests must be at least 1";
    }
    
    // Date validations
    if(empty($arrivals)) {
        $errors[] = "Arrival date is required";
    }
    if(empty($leaving)) {
        $errors[] = "Departure date is required";
    }
    if(!empty($arrivals) && !empty($leaving) && strtotime($leaving) <= strtotime($arrivals)) {
        $errors[] = "Departure date must be after arrival date";
    }

    if(empty($errors)) {
        // Prepare the SQL query using prepared statements
        $stmt = $connection->prepare("INSERT INTO bookings (name, email, phone, address, location, guests, arrivals, leaving) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssiss", $name, $email, $phone, $address, $location, $guests, $arrivals, $leaving);
        
        if($stmt->execute()) {
            header('Location: book.php?success=1');
            exit();
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
    }

    // If there are errors, store them in session and redirect back
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: book.php');
    exit();
} else {
    header('Location: book.php');
    exit();
}
?>