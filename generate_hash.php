<?php
$plain_password = 'admin123'; // Change this to your desired password
$hash = password_hash($plain_password, PASSWORD_BCRYPT);
echo "Generated Hash: " . $hash;
