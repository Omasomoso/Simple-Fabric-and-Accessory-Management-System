<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $fabricType = $_POST['fabric_type'];
  $actionType = $_POST['action_type'];
  $amount = $_POST['amount'];

  // Get the user ID from the username
  $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $userId = $stmt->fetchColumn();

  // Get the fabric ID from the fabric type
  $stmt = $pdo->prepare("SELECT id FROM fabrics WHERE fabric_type = ?");
  $stmt->execute([$fabricType]);
  $fabricId = $stmt->fetchColumn();

  // Record the action
  $stmt = $pdo->prepare("INSERT INTO user_actions (user_id, fabric_id, action_type, amount) VALUES (?, ?, ?, ?)");
  $stmt->execute([$userId, $fabricId, $actionType, $amount]);

  // Update fabric quantity
  if ($actionType == 'cut' && $fabricId) {
    // Update fabric length
    $stmt = $pdo->prepare("UPDATE fabrics SET total_length_inches = total_length_inches - ? WHERE id = ?");
    $stmt->execute([$amount, $fabricId]);
  }

  echo "Action recorded successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Record User Action</title>
<link rel="stylesheet" type="text/css" href="style22.css">
<a href="index.php" class="button">Go Back To Home</a>
<script>
const usernameInput = document.getElementById('username');
const fabricNameInput = document.getElementById('fabric_name');
const usernameSuggestionsDiv = document.getElementById('username-suggestions');
const fabricSuggestionsDiv = document.getElementById('fabric-suggestions');
const fabricThumbnailImg = document.getElementById('fabric-thumbnail');

usernameInput.addEventListener('input', async () => {
const username = usernameInput.value.trim();
if (username) {
const response = await fetch(suggest_usernames.php?username=${username});
const suggestions = await response.json();
usernameSuggestionsDiv.innerHTML = '';
suggestions.forEach(suggestion => {
const div = document.createElement('div');
div.textContent = suggestion;
div.addEventListener('click', () => {
usernameInput.value = suggestion;
usernameSuggestionsDiv.innerHTML = '';
});
usernameSuggestionsDiv.appendChild(div);
});
} else {
usernameSuggestionsDiv.innerHTML = '';
}
});

fabricNameInput.addEventListener('input', async () => {
const fabricName = fabricNameInput.value.trim();
if (fabricName) {
const response = await fetch(suggest_fabric_names.php?fabric_name=${fabricName});
const suggestions = await response.json();
fabricSuggestionsDiv.innerHTML = '';
suggestions.forEach(suggestion => {
const div = document.createElement('div');
div.textContent = suggestion;
div.addEventListener('click', async () => {
fabricNameInput.value = suggestion;
fabricSuggestionsDiv.innerHTML = '';
const response = await fetch(get_fabric_thumbnail.php?fabric_name=${suggestion});
const thumbnail = await response.json();
fabricThumbnailImg.src = thumbnail;
});
fabricSuggestionsDiv.appendChild(div);
});
} else {
fabricSuggestionsDiv.innerHTML = '';
}
});
</script></head>
<body>
<h1>Record User Action</h1>
<form action="record_fabric_action.php" method="post">
<label for="username">Username:</label>
<input type="text" name="username" required><br>
<label for="fabric_type">Fabric Type:</label>
<input type="text" name="fabric_type"><br>
<label for="action_type">Action Type:</label>
<select name="action_type" required>
<option value="cut">Cut Fabric</option>
</select><br>
<label for="amount">Amount:</label>
<input type="number" name="amount" required><br>
<input type="submit" value="Record Action">
</form>
</body>
</html>
