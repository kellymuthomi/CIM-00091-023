<?php
// setup_admin.php - run once to add default admin user
require 'db.php';

$username = 'kelly';
$password = 'admin123';
$email = 'muthomikelly009@gmail.com';
$phone = '0756651581';
$role = 'admin';

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    echo json_encode(['status'=>'error','message'=>'Admin exists']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO users (username,password_hash,email,phone,role) VALUES (?,?,?,?,?)");
$stmt->execute([$username, $hash, $email, $phone, $role]);

echo json_encode(['status'=>'success','message'=>'Admin created']);
