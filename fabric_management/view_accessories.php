<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM accessories");
$accessories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Accessories</title>
<link rel="stylesheet" type="text/css" href="style222.css">
<a href="index.php" class="button">Go Back To Home</a>
</head>
<body>
<h1>All Accessories</h1>
<table border="1">
<tr>
<th>Accessory Type</th>
<th>Purchase Date</th>
<th>Quantity Remaining</th>
<th>Quantity Bought</th>
<th>Image</th>
<th>Thumbnail</th>
</tr>
<?php foreach ($accessories as $accessory): ?>
<tr>
<td><?php echo htmlspecialchars($accessory['accessory_type']); ?></td>
<td><?php echo htmlspecialchars($accessory['purchase_date']); ?></td>
<td><?php echo htmlspecialchars($accessory['quantity']); ?></td>
<td><?php echo htmlspecialchars($accessory['quantity_bought']); ?></td>
<td><img src="<?php echo htmlspecialchars($accessory['image_path']); ?>" alt="Accessory Image" width="100"></td>
<td><img src="<?php echo htmlspecialchars($accessory['thumbnail_path']); ?>" alt="Thumbnail" width="50"></td>
</tr>
<?php endforeach; ?>
</table>
<a href="upload_accessory.php">Upload More Accessories</a>
</body>
</html>
