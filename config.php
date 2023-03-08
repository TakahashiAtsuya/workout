<?php
$host = "***";
$username = "***";
$password = "***";
$dbname = "***";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "接続に失敗しました" . $e->getMessage();
}
?>