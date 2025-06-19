<?php
// generate_hash.php
$password = 'pass';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
echo "Hashed password: " . $hashed_password;
?>
