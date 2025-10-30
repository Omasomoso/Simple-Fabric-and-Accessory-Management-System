<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accessoryType = $_POST['accessory_type'];
    $purchaseDate = $_POST['purchase_date'];
    $quantity = $_POST['quantity'];
	 $quantity_bought = $_POST['quantity_bought'];

    // Handle file upload
    $targetDir = "images/accessories/";
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Generate thumbnail
        $thumbnailPath = createThumbnail($targetFile);

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO accessories (accessory_type, purchase_date, quantity, quantity_bought, image_path, thumbnail_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$accessoryType, $purchaseDate, $quantity, $quantity_bought, $targetFile, $thumbnailPath]);

        echo "Accessory uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }
}
function createThumbnail($filePath) {
    // Implement thumbnail creation logic here
    // For example, using GD library
    $thumbnailPath = "images/accessories/thumbnails/" . basename($filePath);
    list($width, $height) = getimagesize($filePath);
    $newWidth = 150; // Thumbnail width
    $newHeight = ($height / $width) * $newWidth;

    $src = imagecreatefromjpeg($filePath);
    $dst = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($dst, $thumbnailPath);
    return $thumbnailPath;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Accessory</title>
<link rel="stylesheet" type="text/css" href="style22.css">
<a href="index.php" class="button">Go Back To Home</a>
</head>
<body>
<h1>Upload Accessory</h1>
<form action="upload_accessory.php" method="post" enctype="multipart/form-data">
<label for="accessory_type">Accessory Type:</label>
<input type="text" name="accessory_type" required><br>

<label for="purchase_date">Purchase Date:</label>
<input type="date" name="purchase_date" required><br>

<label for="quantity">Quantity:</label>
<input type="number" name="quantity" required><br>

<label for="quantity_bought">Quantity Bought:</label>
<input type="number" name="quantity_bought" required><br>

<label for="image">Upload Image:</label>
<input type="file" name="image" accept="image/*" required><br>

<input type="submit" value="Upload Accessory">
</form>
</body>
</html>
