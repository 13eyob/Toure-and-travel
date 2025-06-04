<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$host = 'localhost';
$dbname = 'travel';
$username_db = 'root';
$password_db = '';

$conn = new mysqli($host, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
$success = '';

// Registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $fullname = htmlspecialchars(trim($_POST["fullname"]));
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"] ?? '';
    $usertype = 'user';

    // Validation rules
    $errors = [];
    
    // Fullname validation (letters, spaces, and certain special characters)
    if (empty($fullname)) {
        $errors[] = "Full name is required";
    } elseif (!preg_match("/^[a-zA-Z \-']+$/", $fullname)) {
        $errors[] = "Full name contains invalid characters";
    } elseif (strlen($fullname) < 3) {
        $errors[] = "Full name must be at least 3 characters";
    }
    
    // Username validation (alphanumeric with underscores)
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errors[] = "Username can only contain letters, numbers, and underscores";
    } elseif (strlen($username) < 4) {
        $errors[] = "Username must be at least 4 characters";
    }
    
    // Email validation
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Password validation (only length requirement)
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        // Check if username/email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or Email already taken.";
        } else {
            // Hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, usertype) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $username, $email, $password_hash, $usertype);

            if ($stmt->execute()) {
                $success = "Registration successful! Please log in.";
                // Clear form on success
                $_POST = array();
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        $error = implode("<br>", $errors);
    }
}

// Login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, usertype FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['usertype'];

                if ($user['usertype'] == 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: package.php");
                }
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "Username not found!";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login/Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <?php if ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <div class="form" id="loginForm">
        <h1>Login</h1>
        <form action="" method="POST">
            <div class="input">
                <input type="text" name="username" placeholder="Username" required 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="input">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input">
                <input type="submit" name="login" value="Login">
            </div>
            <div class="toggle-btn">
                <button type="button" onclick="showRegister()">Don't have an account? Sign Up</button>
            </div>
        </form>
    </div>

    <!-- Register Form -->
    <div class="form" id="registerForm" style="display:none;">
        <h1>Sign Up</h1>
        <form action="" method="POST">
            <div class="input">
                <input type="text" name="fullname" placeholder="Full Name" required 
                       value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
            </div>
            <div class="input">
                <input type="text" name="username" placeholder="Username" required 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="input">
                <input type="email" name="email" placeholder="Email" required 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="input">
                <input type="password" name="password" placeholder="Password " required>
            </div>
            <div class="input">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <div class="input">
                <input type="submit" name="register" value="Sign Up">
            </div>
            <div class="toggle-btn">
                <button type="button" onclick="showLogin()">Already have an account? Login</button>
            </div>
        </form>
    </div>

    <script>
        function showRegister() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
            // Clear any existing messages when switching forms
            document.querySelector('.message')?.remove();
        }

        function showLogin() {
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
            // Clear any existing messages when switching forms
            document.querySelector('.message')?.remove();
        }

        // Show register form if there was a registration error
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])): ?>
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        <?php endif; ?>
    </script>

</body>
</html>