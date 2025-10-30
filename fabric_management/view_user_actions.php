<?php
include 'db.php';

$userId = $_GET['user_id'];

// Update the SQL query to join with fabrics and accessories
$stmt = $pdo->prepare("
    SELECT ua.*, 
           f.fabric_type, 
           a.accessory_type 
    FROM user_actions ua
    LEFT JOIN fabrics f ON ua.fabric_id = f.id
    LEFT JOIN accessories a ON ua.accessory_id = a.id
    WHERE ua.user_id = ?
");
$stmt->execute([$userId]);
$actions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user details
$userStmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$userStmt->execute([$userId]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Actions</title>
<link rel="stylesheet" type="text/css" href="style222.css">
</head>
<body>
<h1>Actions for User: <?php echo htmlspecialchars($user['username']); ?></h1>
<table border="1">
<tr>
<th>Action Type</th>
<th>Fabric Type</th>
<th>Accessory Type</th>
<th>Amount</th>
<th>Action Date</th>
</tr>
<?php foreach ($actions as $action): ?>
<tr>
<td><?php echo htmlspecialchars($action['action_type']); ?></td>
<td><?php echo htmlspecialchars($action['fabric_type']); ?></td>
<td><?php echo htmlspecialchars($action['accessory_type']); ?></td>
<td><?php echo htmlspecialchars($action['amount']); ?></td>
<td><?php echo htmlspecialchars($action['action_date']); ?></td>
</tr>
<?php endforeach; ?>
</table>
<a href="view_user_profiles.php">Back to User Profiles</a>
</body>
</html>
