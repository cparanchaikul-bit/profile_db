<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$username = "root";
$password = "";
$dbname = "profile_db"; // ✅ แก้ไขจาก db_shop เป็น profile_db ตามชื่อฐานข้อมูลของคุณ

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // ⚠️ ข้อควรระวัง: ห้ามใส่คำสั่ง echo หรือแสดงข้อความใดๆ ออกมาที่นี่ 
    // เพราะจะทำให้ Vue.js อ่านค่า JSON ไม่ได้จนเกิด Error "is not valid JSON"
} catch (PDOException $e) {
    // ในขั้นตอนนี้แนะนำให้ส่ง Error เป็น JSON แทน die() เพื่อให้ Vue จัดการต่อได้ง่ายขึ้น
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
    exit;
}
?>