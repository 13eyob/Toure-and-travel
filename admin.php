<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'travel';

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Verify admin status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Function to safely count rows
function countTableRows($conn, $tableName, $condition = "") {
    $sql = "SELECT * FROM $tableName";
    if (!empty($condition)) {
        $sql .= " WHERE $condition";
    }
    
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        error_log("Error in query for table $tableName: " . mysqli_error($conn));
        return 0;
    }
    
    return mysqli_num_rows($result);
}

// Get all counts
$total_tourists = countTableRows($conn, "users");
$total_packages = countTableRows($conn, "packages");
$total_bookings = countTableRows($conn, "bookings");
$total_completed = countTableRows($conn, "bookings", "status = 'completed'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethiopian Tourism Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">

</head>
<body>
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    
    <nav>
        <div class="admin">
            <div class="add">
                <h1>Ethiopian Tourism Admin</h1>
                <ul>
                    <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="add_packages.php"><i class="fas fa-plus-circle"></i> Add Package</a></li>
                    <li><a href="crud.php"><i class="fas fa-eye"></i> View Packages</a></li>
                    <li><a href="booking.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
                    <li><a href="messages.php"><i class="fas fa-envelope"></i> Messeges</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="logout">
        <div class="login_header">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="info">
            <h1>Dashboard Overview</h1>
            
            <div class="card-container">
                <div class="card">
                    <div class="tot">
                        <h3>Registered Tourists</h3>
                        <p><?php echo $total_tourists; ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="tot">
                        <h3>Tour Packages</h3>
                        <p><?php echo $total_packages; ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="tot">
                        <h3>Total Bookings</h3>
                        <p><?php echo $total_bookings; ?></p>
                    </div>
                </div>

              
            </div>
        </div>
    </div>
</body>
</html>