<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'condb.php';

$image = "";
if (isset($_FILES['image'])) {
    $image = "uploads/" . time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $image);
}

$sql = "INSERT INTO employees (first_name, last_name, address, phone, image) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$res = $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['phone'], $image]);
echo json_encode(["success" => $res]);
?>