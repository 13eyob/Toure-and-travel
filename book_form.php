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

    // Validate required fields
    $errors = [];
    if(empty($name)) $errors[] = "Name is required";
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if(empty($phone)) $errors[] = "Phone number is required";
    if(empty($address)) $errors[] = "Address is required";
    if(empty($location)) $errors[] = "Destination is required";
    if($guests < 1) $errors[] = "Number of guests must be at least 1";
    if(empty($arrivals)) $errors[] = "Arrival date is required";
    if(empty($leaving)) $errors[] = "Departure date is required";
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