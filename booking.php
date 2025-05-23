<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'travel';

// Connect to DB
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM bookings ORDER BY booking_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Records</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="booking.css"> -->
      <link rel="stylesheet" href="css/admin.css"> 
     <link rel="stylesheet" href="css/user,mess,booking.css">
</head>
<body>

<h1>All Bookings</h1>
<nav>
        <div class="admin">
            <div class="add">
                <h1>Ethiopian Tourism Admin</h1>
                <ul>
                    <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="add_packages.php"><i class="fas fa-plus-circle"></i> Add Package</a></li>
                    <li><a href="crud.php" class="active"><i class="fas fa-eye"></i> View Packages</a></li>
                    <li><a href="booking.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
                    <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
                </ul>
            </div>
        </div>
    </nav>


<div class="logout">
        <div class="login_header">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>


<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Location</th>
            <th>Guests</th>
            <th>Arrival</th>
            <th>Leaving</th>
            <th>Booking Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['guests']) ?></td>
                <td><?= htmlspecialchars($row['arrivals']) ?></td>
                <td><?= htmlspecialchars($row['leaving']) ?></td>
                <td><?= htmlspecialchars($row['booking_date']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <div class="no-data">No booking data found.</div>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>
