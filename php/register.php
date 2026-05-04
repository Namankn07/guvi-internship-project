<?php
require '../vendor/autoload.php';

// MySQL Connection
$mysql = new mysqli("localhost", "root", "", "guvi_db");

// MongoDB Connection
$mongo = (new MongoDB\Client("mongodb://localhost:27017"))->guvi_db->profiles;

$user = $_POST['username'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

// 1. MySQL: Prepared Statement use karna compulsory hai
$stmt = $mysql->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $user, $pass);

if($stmt->execute()) {
    // 2. MongoDB: Empty profile create karna
    $mongo->insertOne([
        'user_id' => (int)$stmt->insert_id, 
        'age' => '', 
        'dob' => '', 
        'contact' => ''
    ]);
    echo "success";
} else {
    echo "error";
}
?>