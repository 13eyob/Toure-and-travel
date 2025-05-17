<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";

// Delete message
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM contact WHERE id = $id");
    $success = "Message deleted successfully.";
}

// Reply to message (simulation)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_id'])) {
    $to = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['reply_message']);

    // Simulated email sending
    // In real implementation, use: mail($to, $subject, $message);
    $success = "Reply sent to <strong>$to</strong> (simulated).";
}

// Fetch messages
$messages = $conn->query("SELECT * FROM contact ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Manage Contact Messages</title>
      <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/messages.css"> 
</head>
<body>

<h1>Manage Contact Messages</h1>

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


<?php if ($success): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Submitted At</th>
        <th>Actions</th>
    </tr>

    <?php if ($messages && $messages->num_rows > 0): ?>
        <?php while ($row = $messages->fetch_assoc()): ?>
            <tr class="message-row">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                <td>
                    <a href="?delete_id=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                </td>
            </tr>
            <tr class="reply-row">
                <td colspan="6">
                    <form method="POST" class="reply-form">
                        <input type="hidden" name="reply_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                        <label>Reply to <?= htmlspecialchars($row['email']) ?>:</label>
                        <textarea name="reply_message" placeholder="Type your reply..." required></textarea>
                        <button type="submit" class="btn reply-btn">Send Reply</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6">No contact messages found.</td></tr>
    <?php endif; ?>
</table>

<?php $conn->close(); ?>

</body>
</html>
