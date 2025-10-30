<?php
include 'db.php';

_GET['fabric_name'];

$stmt = $pdo->prepare("SELECT fabric_type FROM fabrics WHERE fabric_type LIKE ?");
$stmt->execute([$fabricName . '%']);
$accessoryNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($fabricNames);
?>