<?php
include 'db.php';

_GET['fabric_name'];

$stmt = $pdo->prepare("SELECT thumbnail_path FROM fabrics WHERE fabric_type = ?");
$stmt->execute([$fabricName]);
$thumbnail = $stmt->fetchColumn();

echo json_encode($thumbnail);
?>