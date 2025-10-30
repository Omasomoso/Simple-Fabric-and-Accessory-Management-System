<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Insert new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "User  added successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add User</title>
<link rel="stylesheet" type="text/css" href="style222.css">
<a href="index.php" class="button">Go Back To Home</a>
</head>
<body>
<h1>Add User</h1>
<form action="add_user.php" method="post">
<label for="username">Username:</label>
<input type="text" name="username" required><br>

<label for="password">Password:</label>
<input type="password" name="password" required><br>

<input type="submit" value="Add User">
</form>
</body>
</html>
