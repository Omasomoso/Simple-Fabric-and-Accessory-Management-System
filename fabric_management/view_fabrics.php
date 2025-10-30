<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM fabrics");
$fabrics = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Fabrics</title>
<link rel="stylesheet" type="text/css" href="style222.css">
<a href="index.php" class="button">Go Back To Home</a>
</head>
<body>
<h1>All Fabrics</h1>
<table border="1">
<tr>
<th>Fabric Type</th>
<th>Purchase Date</th>
<th>Total Length (inches remaining)</th>
<th>Total Length (yards purchased)</th>
<th>Image</th>
<th>Thumbnail</th>
</tr>
<?php foreach ($fabrics as $fabric): ?>
<tr>
<td><?php echo htmlspecialchars($fabric['fabric_type']); ?></td>
<td><?php echo htmlspecialchars($fabric['purchase_date']); ?></td>
<td><?php echo htmlspecialchars($fabric['total_length_inches']); ?></td>
<td><?php echo htmlspecialchars($fabric['total_length_yards']); ?></td>
<td><img src="<?php echo htmlspecialchars($fabric['image_path']); ?>" alt="Fabric Image" width="100"></td>
<td><img src="<?php echo htmlspecialchars($fabric['thumbnail_path']); ?>" alt="Thumbnail" width="50"></td>
</tr>
<?php endforeach; ?>
</table>
<a href="upload_fabric.php">Upload More Fabrics</a>
</body>
</html>
