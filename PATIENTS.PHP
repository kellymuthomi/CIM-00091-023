<?php
// patients.php
header('Content-Type: application/json');
require 'db.php';

// require login for modifying actions
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $gender = $_POST['gender'] ?? 'O';
    $illness = trim($_POST['illness'] ?? '');
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';

    if (!$name || !$age || !$date || !$time) {
        echo json_encode(['status'=>'error','message'=>'Missing fields']);
        exit;
    }
    $appointment = $date . ' ' . $time;
    $stmt = $pdo->prepare("INSERT INTO patients (name,age,gender,illness,appointment) VALUES (?,?,?,?,?)");
    $stmt->execute([$name,$age,$gender,$illness,$appointment]);
    echo json_encode(['status'=>'success']);
    exit;
} elseif ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM patients ORDER BY created_at DESC");
    $rows = $stmt->fetchAll();
    echo json_encode(['status'=>'success','data'=>$rows]);
    exit;
} elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) { echo json_encode(['status'=>'error','message'=>'Missing id']); exit; }
    $stmt = $pdo->prepare("DELETE FROM patients WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['status'=>'success']);
    exit;
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid action']);
    exit;
}
