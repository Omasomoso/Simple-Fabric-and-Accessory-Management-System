<?php 
include 'db.php'; 
$stmt = $pdo->query("SELECT * FROM users"); 
$users = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>User Profiles</title> 
<link rel="stylesheet" type="text/css" href="style222.css"> 
<a href="index.php" class="button">Go Back To Home</a>

</head> 
<body> 
<h1>User Profiles</h1> 
<table border="1"> 
<tr> 
<th>User ID</th> 
<th>User Name</th> 
<th>Actions</th> 
</tr> 
<?php foreach ($users as $user): ?> 
<tr> 
<td><?php echo htmlspecialchars($user['id']); ?></td> 
<td><?php echo htmlspecialchars($user['username']); ?></td> 
<td> 
<a href="view_user_actions.php?user_id=<?php echo $user['id']; ?>">View Actions</a> 
<a href="delete_user.php?user_id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a> 
</td> 
</tr> 
<?php endforeach; ?> 
</table>
</body> 
</html>