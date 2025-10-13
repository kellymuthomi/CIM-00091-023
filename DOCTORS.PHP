<?php
// doctors.php
header('Content-Type: application/json');
require 'db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    $specialty = trim($_POST['specialty'] ?? '');
    $illness = trim($_POST['illness'] ?? '');
    $days = trim($_POST['days'] ?? ''); // expect "Monday,Tuesday"
    if (!$name || !$specialty || !$days) { echo json_encode(['status'=>'error','message'=>'Missing fields']); exit; }
    $stmt = $pdo->prepare("INSERT INTO doctors (name,specialty,illness,days) VALUES (?,?,?,?)");
    $stmt->execute([$name,$specialty,$illness,$days]);
    echo json_encode(['status'=>'success']);
    exit;
} elseif ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM doctors ORDER BY name ASC");
    $rows = $stmt->fetchAll();
    echo json_encode(['status'=>'success','data'=>$rows]);
    exit;
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid action']);
    exit;
}
