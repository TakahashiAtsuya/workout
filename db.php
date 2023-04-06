<?php
$host = "mysql1.php.xdomain.ne.jp";
$username = "workoutjp_user";
$password = "juju1201";
$dbname = "workoutjp_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "接続に失敗しました" . $e->getMessage();
}
?>