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
        header("location:packages.php");
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
 
  <link rel="stylesheet" href="admin.css">
  <style>
    /* Table Container */
.table-container {
  overflow-x: auto;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  margin: 20px 0;
  background: white;
  position: relative;
}

/* Table Styling */
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  min-width: 800px;
}

/* Table Header */
th {
  background: linear-gradient(135deg, #4b2a6e, #6b4fa3);
  color: white;
  padding: 16px 12px;
  text-align: left;
  font-weight: 600;
  position: sticky;
  top: 0;
  z-index: 10;
  transition: all 0.3s ease;
  border-right: 1px solid rgba(255, 255, 255, 0.1);
}

th:last-child {
  border-right: none;
}

th:hover {
  background: linear-gradient(135deg, #6b4fa3, #4b2a6e);
}

/* Table Rows */
tr {
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: rgba(75, 42, 110, 0.05);
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

/* Table Cells */
td {
  padding: 14px 12px;
  border-bottom: 1px solid #eee;
  transition: all 0.3s ease;
  position: relative;
}

tr:hover td {
  color: #4b2a6e;
}

/* Image Cell */
td img {
  width: 80px;
  height: 60px;
  object-fit: cover;
  border-radius: 6px;
  border: 1px solid #eee;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

td img:hover {
  transform: scale(2.5) translateY(10px);
  z-index: 100;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  border: 2px solid white;
}

/* Action Buttons */
.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 0.9rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  min-width: 80px;
}

.action-btn i {
  margin-right: 6px;
}

.update-btn {
  background: rgba(39, 174, 96, 0.1);
  color: #27ae60;
  border: 1px solid rgba(39, 174, 96, 0.3);
}

.update-btn:hover {
  background: #27ae60;
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
}

.delete-btn {
  background: rgba(231, 76, 60, 0.1);
  color: #e74c3c;
  border: 1px solid rgba(231, 76, 60, 0.3);
}

.delete-btn:hover {
  background: #e74c3c;
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
}

/* Price Styling */
td:nth-child(5) {
  font-weight: 600;
  color: #27ae60;
}

/* Duration Styling */
td:nth-child(6) {
  font-weight: 500;
  color: #4b2a6e;
}

/* Responsive Design */
@media (max-width: 992px) {
  .table-container {
    border-radius: 8px;
  }
  
  th, td {
    padding: 12px 10px;
  }
  
  .action-btn {
    padding: 6px 12px;
    min-width: 70px;
  }
  
  td img {
    width: 70px;
    height: 50px;
  }
}

@media (max-width: 768px) {
  th, td {
    padding: 10px 8px;
    font-size: 0.9rem;
  }
  
  .action-btn {
    padding: 6px 10px;
    font-size: 0.8rem;
    min-width: 60px;
  }
  
  td img {
    width: 60px;
    height: 45px;
  }
}

@media (max-width: 576px) {
  .table-container {
    border-radius: 6px;
  }
  
  th, td {
    padding: 8px 6px;
  }
  
  .action-btn {
    padding: 5px 8px;
    min-width: 50px;
  }
  
  td img {
    width: 50px;
    height: 40px;
  }
}
  </style>
  
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
                    <li><a href="add_package.php"><i class="fas fa-plus-circle"></i> Add Package</a></li>
                    <li><a href="crud.php" class="active"><i class="fas fa-eye"></i> Tour Packages</a></li>
                    <li><a href="bookings.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
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
                            <td>ETB<?php echo number_format($row['price'], 2); ?></td>
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
                                   href="package.php?id=<?php echo $row['id']; ?>"
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