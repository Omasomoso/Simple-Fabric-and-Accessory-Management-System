<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $accessoryName = $_POST['accessory_name'];
  $actionType = $_POST['action_type'];
  $amount = $_POST['amount'];

  // Get user ID from username
  $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $userId = $stmt->fetchColumn();

  // Get accessory ID from accessory name
  if ($accessoryName) {
    $stmt = $pdo->prepare("SELECT id FROM accessories WHERE accessory_type = ?");
    $stmt->execute([$accessoryName]);
    $accessoryId = $stmt->fetchColumn();
  } else {
    $accessoryId = null;
  }

  // Record the action
  $stmt = $pdo->prepare("INSERT INTO user_actions (user_id, accessory_id, action_type, amount) VALUES (?, ?, ?, ?)");
  $stmt->execute([$userId, $accessoryId, $actionType, $amount]);

  if ($actionType == 'take_out'&& $accessoryId) {
    // Update accessory quantity
    $stmt = $pdo->prepare("UPDATE accessories SET quantity = quantity - ? WHERE id = ?");
    $stmt->execute([$amount, $accessoryId]);
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
const accessoryNameInput = document.getElementById('accessory_name');
const usernameSuggestionsDiv = document.getElementById('username-suggestions');
const accessorySuggestionsDiv = document.getElementById('accessory-suggestions');
const accessoryThumbnailImg = document.getElementById('accessory-thumbnail');

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

accessoryNameInput.addEventListener('input', async () => {
  const accessoryName = accessoryNameInput.value.trim();
  if (accessoryName) {
    const response = await fetch('suggest_accessory_names.php?accessory_name=' + accessoryName);
    const suggestions = await response.json();
    accessorySuggestionsDiv.innerHTML = '';
    suggestions.forEach(suggestion => {
      const div = document.createElement('div');
      div.textContent = suggestion;
      div.addEventListener('click', async () => {
        accessoryNameInput.value = suggestion;
        accessorySuggestionsDiv.innerHTML = '';
        const response = await fetch('get_accessory_thumbnail.php?accessory_name=' + suggestion);
        const thumbnail = await response.json();
        document.getElementById('accessory-thumbnail').src = thumbnail;
      });
      accessorySuggestionsDiv.appendChild(div);
    });
  } else {
    accessorySuggestionsDiv.innerHTML = '';
  }
});
</script>

</head>
<body>
<h1>Record User Action</h1>


<form action="record_accessory_action.php" method="post">
  <label for="username">Username:</label>
  <input type="text" name="username" id="username" required>
  <div id="username-suggestions"></div>

  <label for="accessory_name">Accessory Name (if applicable):</label>
  <input type="text" name="accessory_name" id="accessory_name" required>
  <div id="accessory-suggestions"></div>

  <label for="action_type">Action Type:</label>
  <select name="action_type" required>
    <option value="take_out">Take Out Accessory</option>
  </select>

  <label for="amount">Amount:</label>
  <input type="number" name="amount" required>

  <input type="submit" value="Record Action">
</form>
</body>
</html>
