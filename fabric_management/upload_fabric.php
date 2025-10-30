<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fabricType = $_POST['fabric_type'];
    $purchaseDate = $_POST['purchase_date'];
    $totalLengthInches = $_POST['total_length_inches'];
    $totalLengthYards = $_POST['total_length_yards'];

    // Handle file upload
    $targetDir = "images/fabrics/";
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Generate thumbnail (you can use GD or ImageMagick here)
        $thumbnailPath = createThumbnail($targetFile);

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO fabrics (fabric_type, purchase_date, total_length_inches, total_length_yards, image_path, thumbnail_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$fabricType, $purchaseDate, $totalLengthInches, $totalLengthYards, $targetFile, $thumbnailPath]);

        echo "Fabric uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }
}

function createThumbnail($filePath) {
    // Implement thumbnail creation logic here
    // For example, using GD library
    $thumbnailPath = "images/fabrics/thumbnails/" . basename($filePath);
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
<title>Fabric Management</title>
<link rel="stylesheet" type="text/css" href="style22.css">
<a href="index.php" class="button">Go Back To Home</a>
</head>
<body>
<h1>Upload Fabric</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
<label for="fabric_type">Fabric Type:</label>
<input type="text" name="fabric_type" required><br>

<label for="purchase_date">Purchase Date:</label>
<input type="date" name="purchase_date" required><br>

<label for="total_length_inches">Total Length (in inches):</label>
<input type="number" name="total_length_inches" required><br>

<label for="total_length_yards">Total Length (in yards):</label>
<input type="number" step="0.01" name="total_length_yards" required><br>

<label for="image">Upload Image:</label>
<input type="file" name="image" accept="image/*" required><br>

<input type="submit" value="Upload Fabric">
</form>

</body>
</html>