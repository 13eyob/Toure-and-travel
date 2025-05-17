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
    
    <style>
        :root {
            --primary: #4b2a6e; /* Ethiopian purple */
            --secondary: #f39c12; /* Orange */
            --accent: #27ae60; /* Green */
            --dark: #2c3e50;
            --light: #f8f9fa;
            --text: #333;
            --text-light: #777;
            --shadow: 0 5px 15px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            color: var(--text);
        }

        /* Admin Navigation */
        #check {
            display: none;
        }

        .checkbtn {
            font-size: 1.8rem;
            color: var(--primary);
            position: fixed;
            top: 20px;
            left: 20px;
            cursor: pointer;
            z-index: 1001;
            display: none;
        }

        nav {
            position: fixed;
            width: 250px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: var(--transition);
            z-index: 1000;
        }

        .admin {
            padding: 20px;
        }

        .admin h1 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light);
        }

        .admin ul {
            list-style: none;
        }

        .admin ul li {
            margin-bottom: 15px;
        }

        .admin ul li a {
            display: flex;
            align-items: center;
            color: var(--text);
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: var(--transition);
        }

        .admin ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .admin ul li a:hover,
        .admin ul li a.active {
            background-color: rgba(75, 42, 110, 0.1);
            color: var(--primary);
        }

        /* Main Content */
        .logout {
            margin-left: 250px;
            padding: 20px;
            transition: var(--transition);
        }

        .login_header {
            display: flex;
            justify-content: flex-end;
            padding: 15px 0;
        }

        .login_header a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .login_header a:hover {
            color: var(--secondary);
        }

        .info {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: var(--shadow);
        }

        .info h1 {
            color: var(--primary);
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light);
        }

        /* Form Styles */
        .update-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .products {
            margin-bottom: 20px;
        }

        .products label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        .products input[type="text"],
        .products input[type="number"],
        .products textarea,
        .products select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .products input[type="text"]:focus,
        .products input[type="number"]:focus,
        .products textarea:focus,
        .products select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(75, 42, 110, 0.2);
        }

        .products textarea {
            min-height: 120px;
            resize: vertical;
        }

        .image-preview {
            text-align: center;
        }

        .current-image {
            display: inline-block;
            position: relative;
            margin-top: 10px;
        }

        .current-image img {
            max-width: 300px;
            max-height: 200px;
            border-radius: 8px;
            border: 1px solid #eee;
            box-shadow: var(--shadow);
        }

        .image-text {
            display: block;
            margin-top: 8px;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .file-hint {
            display: block;
            margin-top: 5px;
            color: var(--text-light);
            font-size: 0.85rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .update-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .update-btn:hover {
            background: #5d3a8a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(75, 42, 110, 0.3);
        }

        .cancel-btn {
            background: #f1f1f1;
            color: var(--text);
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
        }

        .cancel-btn:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .featured-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .featured-checkbox input {
            width: auto;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            nav {
                left: -250px;
            }
            
            #check:checked ~ nav {
                left: 0;
            }
            
            #check:checked ~ .logout {
                margin-left: 250px;
            }
            
            .checkbtn {
                display: block;
            }
            
            .logout {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .current-image img {
                max-width: 250px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .update-btn, .cancel-btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .info {
                padding: 15px;
            }
            
            .current-image img {
                max-width: 200px;
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
                    <li><a href="add_packages.php"><i class="fas fa-plus-circle"></i> Add Package</a></li>
                    <li><a href="package.php" class="active"><i class="fas fa-eye"></i> View Packages</a></li>
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