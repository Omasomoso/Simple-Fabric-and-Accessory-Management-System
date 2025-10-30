<?php
include 'db.php';

_GET['username'];

$stmt = $pdo->prepare("SELECT username FROM users WHERE username LIKE ?");
$stmt->execute([$username . '%']);
$usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($usernames);
?>
