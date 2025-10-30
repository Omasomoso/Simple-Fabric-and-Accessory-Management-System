<?php
include 'db.php';

_GET['accessory_name'];

$stmt = $pdo->prepare("SELECT accessory_type FROM accessories WHERE accessory_type LIKE ?");
$stmt->execute([$accessoryName . '%']);
$accessoryNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($accessoryNames);
?>