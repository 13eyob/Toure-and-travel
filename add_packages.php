<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$dbname = 'travel'; // Changed to tourism database
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_packages'])) {
    $title = trim($conn->real_escape_string($_POST['title']));
    $description = trim($conn->real_escape_string($_POST['description']));
    $location = trim($conn->real_escape_string($_POST['location']));
    $duration = intval($_POST['duration']);
    $price = floatval($_POST['price']);
    $discount_price = !empty($_POST['discount_price']) ? floatval($_POST['discount_price']) : null;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Validate numeric fields
    if (!is_numeric($price) || !is_numeric($duration) || ($discount_price !== null && !is_numeric($discount_price))) {
        $message = 'Price and duration must be valid numbers';
    }

    $image_path = '';
    if (isset($_FILES['image_path'])) {
        if ($_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $check = getimagesize($_FILES['image_path']['tmp_name']);
            if ($check !== false) {
                $fileExt = strtolower(pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($fileExt, $allowedExts)) {
                    $fileName = 'package_' . uniqid() . '.' . $fileExt;
                    $targetPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image_path']['tmp_name'], $targetPath)) {
                        $image_path = $targetPath;
                    } else {
                        $message = 'Error uploading file';
                    }
                } else {
                    $message = 'Invalid file type. Allowed: JPG, JPEG, PNG, GIF';
                }
            } else {
                $message = 'File is not a valid image';
            }
        } else {
            $message = 'Error in file upload: ' . $_FILES['image_path']['error'];
        }
    } else {
        $message = 'Package image is required';
    }

    if (empty($message)) {
        $stmt = $conn->prepare("INSERT INTO packages (title, description, location, duration, price, discount_price, image_path, is_featured) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            die("SQL Error: " . $conn->error);
        }
        
        $stmt->bind_param("sssidssi", $title, $description, $location, $duration, $price, $discount_price, $image_path, $is_featured);
        
        if ($stmt->execute()) {
            $message = 'Package added successfully!';
        } else {
            $message = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tour Package</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   
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
                    <li><a href="#" class="active"><i class="fas fa-plus-circle"></i> Add Package</a></li>
                    <li><a href="crud.php"><i class="fas fa-eye"></i> View Packages</a></li>
                    <li><a href="booking.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
                    <li><a href="messages.php"><i class="fas fa-envelope"></i> messages</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="logout">
        <div class="login_header">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="info">
            <h1>Add Tour Package</h1>
            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            <div>
                <form action="add_packages.php" method="POST" enctype="multipart/form-data">

                    <div class="products">
                        <label for="title">Package Title</label>
                        <input type="text" name="title" id="title" required>
                    </div>
                    <div class="products">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" required></textarea>
                    </div>
                    <div class="products">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" required>
                    </div>
                    <div class="products">
                        <label for="duration">Duration (days)</label>
                        <input type="number" name="duration" id="duration" min="1" required>
                    </div>
                    <div class="products">
                        <label for="price">Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" required>
                    </div>
                    <div class="products">
                        <label for="discount_price">Discount Price ($) - Optional</label>
                        <input type="number" name="discount_price" id="discount_price" step="0.01" min="0">
                    </div>
                    <div class="products">
                        <label for="image_path">Package Image</label>
                        <input type="file" name="image_path" id="image_path" accept="image/*" required>
                        <small>Recommended size: 800x600px, JPG/PNG format</small>
                    </div>
                    <div class="products">
                        <label class="featured-label">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1">
                            Feature this package on packages
                        </label>
                    </div>
                    <div class="products">
                        <input type="submit" name="add_packages" value="Add Package" class="btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>