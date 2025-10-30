<?php
include 'db.php';

_GET['accessory_name'];

$stmt = $pdo->prepare("SELECT thumbnail_path FROM accessories WHERE accessory_type = ?");
$stmt->execute([$accessoryName]);
$thumbnail = $stmt->fetchColumn();

echo json_encode($thumbnail);
?>