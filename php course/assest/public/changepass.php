<?php
include __DIR__ . "/../vendor/config.php"; 
$new_password_plain = '1234'; 

$new_hash = password_hash($new_password_plain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin' LIMIT 1");
$stmt->bind_param("s", $new_hash);

if ($stmt->execute()) {
    echo " Password for 'admin' updated successfully. New plain password: " . htmlspecialchars($new_password_plain);
} else {
    echo " Failed to update password: " . $stmt->error;
}
