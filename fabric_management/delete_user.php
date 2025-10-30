<?php 
include 'db.php'; 

if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];

  $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
  $stmt->execute([$user_id]);

  $stmt = $pdo->prepare("DELETE FROM user_actions WHERE user_id = ?");
  $stmt->execute([$user_id]);

  header('Location: view_user_profiles.php');
  exit;
} else {
  header('Location: view_user_profiles.php');
  exit;
}
?>