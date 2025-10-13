<?php
// auth.php
header('Content-Type: application/json');
require 'db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'login') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (!$username || !$password) {
        echo json_encode(['status'=>'error','message'=>'Missing credentials']);
        exit;
    }
    $stmt = $pdo->prepare("SELECT id, password_hash, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        echo json_encode(['status'=>'success']);
        exit;
    } else {
        echo json_encode(['status'=>'error','message'=>'Invalid username or password']);
        exit;
    }
} elseif ($action === 'register') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');

    if (!$username || !$password || !$email) {
        echo json_encode(['status'=>'error','message'=>'All fields required']);
        exit;
    }
    // check exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo json_encode(['status'=>'error','message'=>'Username exists']);
        exit;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username,password_hash,email,phone,role) VALUES (?,?,?,?,?)");
    $stmt->execute([$username,$hash,$email,$phone,'staff']);
    echo json_encode(['status'=>'success']);
    exit;
} elseif ($action === 'logout') {
    session_destroy();
    echo json_encode(['status'=>'success']);
    exit;
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid action']);
    exit;
}
