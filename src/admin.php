<?php
session_start();
include 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create a new user
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;
        $query = $db->prepare("INSERT INTO user_table (name, mail, password, is_admin) VALUES (?, ?, ?, ?)");
        $query->bind_param('sssi', $name, $mail, $password, $is_admin);
        $query->execute();
    }
    // Update an existing user
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;
        $query = $db->prepare("UPDATE user_table SET name = ?, mail = ?, password = ?, is_admin = ? WHERE id = ?");
        $query->bind_param('sssii', $name, $mail, $password, $is_admin, $id);
        $query->execute();
    }
    // Delete a user
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = $db->prepare("DELETE FROM user_table WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();
    }
}

$searchResults = [];
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = $db->prepare("SELECT * FROM user_table WHERE name LIKE ? OR mail LIKE ?");
    $likeSearch = "%$search%";
    $query->bind_param('ss', $likeSearch, $likeSearch);
    $query->execute();
    $result = $query->get_result();
    while ($user = $result->fetch_assoc()) {
        $searchResults[] = $user;
    }
}

// Fetch all user records
$query = $db->prepare("SELECT * FROM user_table");
$query->execute();
$result = $query->get_result();
$users = [];
while ($user = $result->fetch_assoc()) {
    $users[] = $user;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<h1>Admin Panel</h1>
<h2>Create New User</h2>
<form method="POST" action="admin.php">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="mail" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <label for="is_admin">Is Admin:</label>
    <input type="checkbox" name="is_admin" id="is_admin">
    <button type="submit" name="create">Create</button>
</form>

<h2>Update User</h2>
<form method="POST" action="admin.php">
    <input type="number" name="id" placeholder="User ID" required>
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="mail" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <label for="is_admin_update">Is Admin:</label>
    <input type="checkbox" name="is_admin" id="is_admin_update">
    <button type="submit" name="update">Update</button>
</form>


<h2>Delete User</h2>
<form method="POST" action="admin.php">
    <input type="number" name="id" placeholder="User ID" required>
    <button type="submit" name="delete">Delete</button>
</form>

<h2>Search Users</h2>
<form method="GET" action="admin.php">
    <input type="text" name="search" placeholder="Search by Name or Email">
    <button type="submit">Search</button>
</form>

<h2>Search Results</h2>
<?php if (isset($_GET['search'])): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <?php if (empty($searchResults)): ?>
            <tr>
                <td colspan="3">No results found</td>
            </tr>
        <?php else: ?>
            <?php foreach ($searchResults as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['mail']); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
<?php endif; ?>

<h2>All Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo htmlspecialchars($user['id']); ?></td>
        <td><?php echo htmlspecialchars($user['name']); ?></td>
        <td><?php echo htmlspecialchars($user['mail']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="logout.php">Logout</a>
</body>
</html>