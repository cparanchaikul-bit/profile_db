<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'condb.php';

$emp_id = $_POST['emp_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];

$sql = "UPDATE employees SET first_name=?, last_name=?, address=?, phone=? WHERE emp_id=?";
$params = [$first_name, $last_name, $address, $phone, $emp_id];

if (isset($_FILES['image'])) {
    $image_path = "uploads/" . time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    $sql = "UPDATE employees SET first_name=?, last_name=?, address=?, phone=?, image=? WHERE emp_id=?";
    $params = [$first_name, $last_name, $address, $phone, $image_path, $emp_id];
}

$stmt = $conn->prepare($sql);
echo json_encode(["success" => $stmt->execute($params)]);
?>