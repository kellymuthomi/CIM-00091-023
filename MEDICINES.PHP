<?php
// medicines.php
header('Content-Type: application/json');
require 'db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    $expiry = $_POST['expiry'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    if (!$name || !$expiry || $quantity < 0) { echo json_encode(['status'=>'error','message'=>'Missing fields']); exit; }
    // update if exists
    $stmt = $pdo->prepare("SELECT id FROM medicines WHERE name = ?");
    $stmt->execute([$name]);
    $exists = $stmt->fetch();
    if ($exists) {
        $stmt = $pdo->prepare("UPDATE medicines SET expiry = ?, quantity = ? WHERE id = ?");
        $stmt->execute([$expiry,$quantity,$exists['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO medicines (name,expiry,quantity) VALUES (?,?,?)");
        $stmt->execute([$name,$expiry,$quantity]);
    }
    echo json_encode(['status'=>'success']);
    exit;
} elseif ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM medicines ORDER BY name ASC");
    $rows = $stmt->fetchAll();
    echo json_encode(['status'=>'success','data'=>$rows]);
    exit;
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid action']);
    exit;
}
