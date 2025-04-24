<?php
// generar_hash.php
require_once __DIR__ . '/config/Database.php'; 

$password = "1234";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Hash generado: " . $hash;