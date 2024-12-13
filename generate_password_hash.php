<?php
$password = "12345"; // Thay đổi thành mật khẩu bạn muốn mã hóa
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Original Password: $password<br>";
echo "Hashed Password: $hashed_password<br>";