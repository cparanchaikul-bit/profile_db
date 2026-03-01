<?php
header("Access-Control-Allow-Origin: *");
include 'condb.php';
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM employees WHERE emp_id = ?");
echo json_encode(["success" => $stmt->execute([$id])]);
?>