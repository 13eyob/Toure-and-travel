<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'travel';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $del = "DELETE FROM packages WHERE id='$id'";
    $data = mysqli_query($conn, $del);
    if($data) {
        header("location:package.php");
        exit();
    }
}

$query = "SELECT * FROM packages";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Packages Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
  <link rel="stylesheet" href="css/admin.css">
   <link rel="stylesheet" href="css/crud.css">
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
        <div class="info">
            <h2>Tour Packages Management</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Image</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr> 
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo substr(htmlspecialchars($row['description']), 0, 50) . '...'; ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo $row['duration']; ?> days</td>
                            <td>
                                <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Tour Package">
                            </td>
                            <td class="action-column update-column">
                                <a href="update_package.php?id=<?php echo $row['id'] ?>" class="action-btn update-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                            <td class="action-column delete-column">
                                <a onclick="return confirm('Are you sure you want to delete this tour package?');" 
                                   href="crud.php?id=<?php echo $row['id']; ?>"
                                   class="action-btn delete-btn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>