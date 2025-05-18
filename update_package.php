<?php
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
    die("Database connection failed");
}

$id = $_GET["id"];
$sql = "SELECT * FROM packages WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST["update_package"])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $discount_price = !empty($_POST['discount_price']) ? $_POST['discount_price'] : null;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    $image_path = $row['image_path'];
    
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === 0) {
        $uploadDir = 'images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExt = strtolower(pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExt, $allowedExts)) {
            $fileName = 'package_' . uniqid() . '.' . $fileExt;
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image_path']['tmp_name'], $targetPath)) {
                if (file_exists($row['image_path'])) {
                    unlink($row['image_path']);
                }
                $image_path = $targetPath;
            }
        }
    }

    $update_sql = "UPDATE packages SET 
                  title = '$title', 
                  description = '$description',
                  location = '$location',
                  price = '$price',
                  duration = '$duration',
                  discount_price = " . ($discount_price !== null ? "'$discount_price'" : "NULL") . ",
                  is_featured = '$is_featured',
                  image_path = '$image_path'
                  WHERE id = '$id'";
    
    if (mysqli_query($conn, $update_sql)) {
        header("Location: package.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tour Package</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="css/admin.css">
     <link rel="stylesheet" href="css/update_package.css">
    
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
                    <li><a href="package.php" class="active"><i class="fas fa-eye"></i> View Packages</a></li>
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
            <h1>Update Tour Package</h1>
            
            <form method="POST" enctype="multipart/form-data" class="update-form">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                
                <div class="products">
                    <label for="title">Package Title</label>
                    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                </div>
                
                <div class="products">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                </div>
                
                <div class="products">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($row['location']); ?>" required>
                </div>
                
                <div class="products">
                    <label for="price">Price (ETB)</label>
                    <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($row['price']); ?>" step="0.01" min="0" required>
                </div>
                
                <div class="products">
                    <label for="discount_price">Discount Price (ETB)</label>
                    <input type="number" name="discount_price" id="discount_price" value="<?php echo htmlspecialchars($row['discount_price']); ?>" step="0.01" min="0">
                </div>
                
                <div class="products">
                    <label for="duration">Duration (days)</label>
                    <input type="number" name="duration" id="duration" value="<?php echo htmlspecialchars($row['duration']); ?>" min="1" required>
                </div>
                
                <div class="products">
                    <label class="featured-checkbox">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo $row['is_featured'] ? 'checked' : ''; ?>>
                        Featured Package
                    </label>
                </div>
                
                <div class="products image-preview">
                    <label>Current Image</label>
                    <div class="current-image">
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Current Tour Package Image">
                        <span class="image-text">Current Image</span>
                    </div>
                </div>
                
                <div class="products">
                    <label for="new_image">Change Image (Optional)</label>
                    <input type="file" name="image_path" id="new_image" accept="image/*">
                    <small class="file-hint">Leave blank to keep current image</small>
                </div>
                
                <div class="form-actions">
                    <input type="submit" name="update_package" value="Update Package" class="update-btn">
                    <a href="packages.php" class="cancel-btn">Cancel</a>
                </div>
            </form> 
        </div>
    </div>
</body>
</html>